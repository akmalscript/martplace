<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SellerApproved;
use App\Mail\SellerRejected;

class SellerController extends Controller
{
    /**
     * Display the form to create a new seller.
     */
    public function create()
    {
        return view('sellers.create');
    }

    /**
     * Store a newly created seller in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Seller::validationRules());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only([
            'store_name',
            'store_description',
            'pic_name',
            'pic_phone',
            'pic_email',
            'password',
            'pic_street',
            'pic_rt',
            'pic_rw',
            'pic_village',
            'pic_district',
            'pic_city',
            'pic_province',
            'pic_ktp_number',
        ]);

        // Password already included from request

        // Handle photo upload
        if ($request->hasFile('pic_photo')) {
            $data['pic_photo_path'] = $request->file('pic_photo')->store('sellers/photos', 'public');
        }

        // Handle KTP file upload
        if ($request->hasFile('pic_ktp_file')) {
            $data['pic_ktp_file_path'] = $request->file('pic_ktp_file')->store('sellers/ktp', 'public');
        }

        // Proses registrasi di Model
        $registered = Seller::register($data);

        if ($registered) {
            return redirect()->route('sellers.success')
                ->with('success', 'Pendaftaran seller berhasil! Silakan simpan password Anda untuk login.');
        }

        return redirect()->back()
            ->with('error', 'Gagal mendaftarkan seller. Silakan coba lagi.')
            ->withInput();
    }

    /**
     * Display public seller directory.
     */
    public function publicIndex(Request $request)
    {
        $query = Seller::active()->with('products');

        // Search by store name
        if ($request->has('search') && !empty($request->search)) {
            $query->where('store_name', 'like', "%{$request->search}%");
        }

        // Filter by city
        if ($request->has('city') && !empty($request->city)) {
            $query->where('city', $request->city);
        }

        // Filter by province
        if ($request->has('province') && !empty($request->province)) {
            $query->where('province', $request->province);
        }

        // Sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'products':
                $query->orderBy('total_products', 'desc');
                break;
            default:
                $query->latest();
        }

        $sellers = $query->paginate(12);

        $cities = Seller::active()
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city')
            ->sort()
            ->values();

        $provinces = Seller::active()
            ->whereNotNull('province')
            ->distinct()
            ->pluck('province')
            ->sort()
            ->values();

        return view('sellers.index', compact('sellers', 'cities', 'provinces'));
    }

    /**
     * Display public seller detail.
     */
    public function publicShow(string $id)
    {
        $seller = Seller::active()
            ->with(['products.images'])
            ->findOrFail($id);
        return view('sellers.show', compact('seller'));
    }

    /**
     * Display the specified seller for admin review.
     */
    public function show(string $id)
    {
        $seller = Seller::findOrFail($id);
        return view('admin.sellers-show', compact('seller'));
    }

    /**
     * Display all sellers for admin management.
     */
    public function index()
    {
        $sellers = Seller::latest()->paginate(15);
        
        // Get counts for all sellers (not just paginated)
        $pendingCount = Seller::where('status', \App\Enums\SellerStatus::PENDING)->count();
        $activeCount = Seller::where('status', \App\Enums\SellerStatus::ACTIVE)->count();
        $rejectedCount = Seller::where('status', \App\Enums\SellerStatus::REJECTED)->count();
        
        return view('admin.sellers-index', compact('sellers', 'pendingCount', 'activeCount', 'rejectedCount'));
    }

    /**
     * Approve seller (admin only).
     */
    public function approve(string $id)
    {
        $seller = Seller::findOrFail($id);

        if ($seller->approve()) {
            try {
                Mail::to($seller->pic_email)->send(new SellerApproved($seller));

                return redirect()->back()
                    ->with('success', 'Seller berhasil disetujui dan email notifikasi telah dikirim.');
            } catch (\Exception $e) {
                Log::error('Failed to send approval email: ' . $e->getMessage());

                return redirect()->back()
                    ->with('warning', 'Seller berhasil disetujui, namun email notifikasi gagal dikirim.');
            }
        }

        return redirect()->back()
            ->with('error', 'Gagal menyetujui seller.');
    }

    /**
     * Reject seller (admin only).
     */
    public function reject(Request $request, string $id)
    {
        $seller = Seller::findOrFail($id);

        $request->validate([
            'reason' => 'nullable|string|max:1000'
        ]);

        $reason = $request->input('reason', 'Dokumen atau data yang Anda kirimkan tidak memenuhi persyaratan kami.');

        if ($seller->batal()) {
            try {
                Mail::to($seller->pic_email)->send(new SellerRejected($seller, $reason));

                return redirect()->back()
                    ->with('success', 'Seller berhasil ditolak dan email notifikasi telah dikirim.');
            } catch (\Exception $e) {
                Log::error('Failed to send rejection email: ' . $e->getMessage());

                return redirect()->back()
                    ->with('warning', 'Seller berhasil ditolak, namun email notifikasi gagal dikirim.');
            }
        }

        return redirect()->back()
            ->with('error', 'Gagal menolak seller.');
    }

    /**
     * Set seller status to pending (admin only).
     */
    public function setPending(string $id)
    {
        $seller = Seller::findOrFail($id);

        if ($seller->setPending()) {
            return redirect()->back()
                ->with('success', 'Status seller berhasil diubah menjadi Menunggu Verifikasi.');
        }

        return redirect()->back()
            ->with('error', 'Gagal mengubah status seller.');
    }

    /**
     * Display success page after registration.
     */
    public function success()
    {
        return view('sellers.success');
    }
}
