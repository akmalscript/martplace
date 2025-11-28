<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SellerCredentials;

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
     * Display the specified seller.
     */
    public function show(string $id)
    {
        $seller = Seller::findOrFail($id);
        return view('sellers.show', compact('seller'));
    }

    /**
     * Display all sellers (public directory).
     */
    public function index(Request $request)
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

        // Get unique cities and provinces for filters
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
     * Approve seller (admin only).
     */
    public function approve(string $id)
    {
        $seller = Seller::findOrFail($id);

        if ($seller->approve()) {
            return redirect()->back()
                ->with('success', 'Seller berhasil disetujui.');
        }

        return redirect()->back()
            ->with('error', 'Gagal menyetujui seller.');
    }

    /**
     * Reject seller (admin only).
     */
    public function reject(string $id)
    {
        $seller = Seller::findOrFail($id);

        if ($seller->batal()) {
            return redirect()->back()
                ->with('success', 'Seller berhasil ditolak.');
        }

        return redirect()->back()
            ->with('error', 'Gagal menolak seller.');
    }

    /**
     * Display success page after registration.
     */
    public function success()
    {
        return view('sellers.success');
    }
}
