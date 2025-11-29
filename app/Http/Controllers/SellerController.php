<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Services\SellerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{
    protected SellerService $sellerService;

    public function __construct(SellerService $sellerService)
    {
        $this->sellerService = $sellerService;
    }

    /**
     * Display the form to create a new seller (SRS-MartPlace-01)
     */
    public function create()
    {
        return view('sellers.create');
    }

    /**
     * Store a newly created seller in storage (SRS-MartPlace-01)
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            SellerService::validationRules(),
            SellerService::validationMessages()
        );

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

        $seller = $this->sellerService->register(
            $data,
            $request->file('pic_photo'),
            $request->file('pic_ktp_file')
        );

        if ($seller) {
            return redirect()->route('sellers.success')
                ->with('success', 'Pendaftaran seller berhasil! Silakan tunggu proses verifikasi.');
        }

        return redirect()->back()
            ->with('error', 'Gagal mendaftarkan seller. Silakan coba lagi.')
            ->withInput();
    }

    /**
     * Display the specified seller
     */
    public function show(string $id)
    {
        $seller = Seller::with(['products' => function ($query) {
            $query->active()->latest()->limit(12);
        }])->findOrFail($id);
        
        return view('sellers.show', compact('seller'));
    }

    /**
     * Display all sellers (public directory)
     */
    public function index(Request $request)
    {
        $sellers = $this->sellerService->getActiveSellers($request->all());
        $cities = $this->sellerService->getActiveCities();
        $provinces = $this->sellerService->getActiveProvinces();

        return view('sellers.index', compact('sellers', 'cities', 'provinces'));
    }

    /**
     * Approve seller (admin only) (SRS-MartPlace-02)
     */
    public function approve(string $id)
    {
        $seller = Seller::findOrFail($id);

        if ($this->sellerService->approve($seller)) {
            return redirect()->back()
                ->with('success', 'Seller berhasil disetujui. Email notifikasi telah dikirim.');
        }

        return redirect()->back()
            ->with('error', 'Gagal menyetujui seller.');
    }

    /**
     * Reject seller (admin only) (SRS-MartPlace-02)
     */
    public function reject(Request $request, string $id)
    {
        $seller = Seller::findOrFail($id);
        $reason = $request->input('reason', 'Dokumen tidak lengkap atau tidak valid.');

        if ($this->sellerService->reject($seller, $reason)) {
            return redirect()->back()
                ->with('success', 'Seller berhasil ditolak. Email notifikasi telah dikirim.');
        }

        return redirect()->back()
            ->with('error', 'Gagal menolak seller.');
    }

    /**
     * Display success page after registration
     */
    public function success()
    {
        return view('sellers.success');
    }
}
