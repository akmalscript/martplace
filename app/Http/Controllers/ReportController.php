<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Admin Report: Active/Inactive Sellers (SRS-MartPlace-09)
     */
    public function sellerStatus()
    {
        $pdf = $this->reportService->generateSellerStatusReport();
        $filename = $this->reportService->generateFilename('status-seller');
        
        return $pdf->download($filename);
    }

    /**
     * Admin Report: Sellers by Province (SRS-MartPlace-10)
     */
    public function sellersByProvince(Request $request)
    {
        $province = $request->get('province');
        
        if (!$province) {
            return redirect()->back()->with('error', 'Silakan pilih provinsi terlebih dahulu.');
        }

        $pdf = $this->reportService->generateSellersByProvinceReport($province);
        $filename = $this->reportService->generateFilenameWithProvince('seller', $province);
        
        return $pdf->download($filename);
    }

    /**
     * Admin Report: Products by Rating (SRS-MartPlace-11)
     */
    public function productsByRating()
    {
        $pdf = $this->reportService->generateProductsByRatingReport();
        $filename = $this->reportService->generateFilename('produk-rating');
        
        return $pdf->download($filename);
    }

    /**
     * Seller Report: Stock List (SRS-MartPlace-12)
     */
    public function sellerStockList()
    {
        $seller = auth()->user()->seller;
        
        if (!$seller) {
            return redirect()->back()->with('error', 'Akun seller tidak ditemukan.');
        }

        $pdf = $this->reportService->generateSellerStockListReport($seller);
        $filename = $this->reportService->generateFilename('stok-produk');
        
        return $pdf->download($filename);
    }

    /**
     * Seller Report: Products by Rating (SRS-MartPlace-13)
     */
    public function sellerProductsByRating()
    {
        $seller = auth()->user()->seller;
        
        if (!$seller) {
            return redirect()->back()->with('error', 'Akun seller tidak ditemukan.');
        }

        $pdf = $this->reportService->generateSellerProductsByRatingReport($seller);
        $filename = $this->reportService->generateFilename('produk-rating');
        
        return $pdf->download($filename);
    }

    /**
     * Seller Report: Low Stock Products (SRS-MartPlace-14)
     */
    public function sellerLowStock()
    {
        $seller = auth()->user()->seller;
        
        if (!$seller) {
            return redirect()->back()->with('error', 'Akun seller tidak ditemukan.');
        }

        $pdf = $this->reportService->generateSellerLowStockReport($seller);
        $filename = $this->reportService->generateFilename('stok-menipis');
        
        return $pdf->download($filename);
    }
}