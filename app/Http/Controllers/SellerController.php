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
            'pic_street',
            'pic_rt',
            'pic_rw',
            'pic_village',
            'pic_city',
            'pic_province',
            'pic_ktp_number',
        ]);

        // 1. Generate Password Otomatis (10 karakter)
        $generatedPassword = Str::password(10);

        // Masukkan password ke array data agar bisa diproses oleh Model Seller saat membuat User
        $data['password'] = $generatedPassword;

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
            // 2. Kirim Email Notifikasi berisi Password
            // Kita buat objek user sementara untuk passing data ke Mailable
            $userObj = (object) [
                'name' => $data['pic_name'],
                'email' => $data['pic_email']
            ];

            try {
                Mail::to($data['pic_email'])->send(new SellerCredentials($userObj, $generatedPassword));
            } catch (\Exception $e) {
                // Jika email gagal dikirim (misal koneksi internet mati),
                // kita biarkan proses lanjut agar user tetap terdaftar.
                // Anda bisa menambahkan log error di sini jika perlu: \Log::error($e->getMessage());
            }

            return redirect()->route('sellers.success')
                ->with('success', 'Pendaftaran seller berhasil! Silakan cek email Anda untuk informasi login.');
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
     * Display all sellers (admin only).
     */
    public function index()
    {
        $sellers = Seller::latest()->paginate(15);
        return view('sellers.index', compact('sellers'));
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
