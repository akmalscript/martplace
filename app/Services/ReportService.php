<?php

namespace App\Services;

use App\Models\Seller;
use App\Models\Product;
use App\Models\Comment;
use App\Enums\SellerStatus;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class ReportService
{
    /**
     * Admin Report: Active/Inactive Sellers (SRS-MartPlace-09)
     */
    public function generateSellerStatusReport()
    {
        $activeSellers = Seller::where('status', SellerStatus::ACTIVE)
            ->with('user')
            ->orderBy('store_name')
            ->get();
            
        $inactiveSellers = Seller::whereIn('status', [SellerStatus::PENDING, SellerStatus::REJECTED])
            ->with('user')
            ->orderBy('store_name')
            ->get();

        $data = [
            'title' => 'Laporan Status Akun Penjual',
            'date' => now()->format('d F Y H:i'),
            'activeSellers' => $activeSellers,
            'inactiveSellers' => $inactiveSellers,
            'totalActive' => $activeSellers->count(),
            'totalInactive' => $inactiveSellers->count(),
        ];

        return Pdf::loadView('reports.seller-status', $data)
            ->setPaper('a4', 'portrait');
    }

    /**
     * Admin Report: Sellers by Province (SRS-MartPlace-10)
     */
    public function generateSellersByProvinceReport(string $province)
    {
        $sellers = Seller::where('pic_province', $province)
            ->with('user')
            ->orderBy('store_name')
            ->get();

        $data = [
            'title' => 'Laporan Daftar Penjual - ' . $province,
            'date' => now()->format('d F Y H:i'),
            'province' => $province,
            'sellers' => $sellers,
            'total' => $sellers->count(),
        ];

        return Pdf::loadView('reports.sellers-by-province', $data)
            ->setPaper('a4', 'portrait');
    }

    /**
     * Admin Report: Products by Rating (SRS-MartPlace-11)
     */
    public function generateProductsByRatingReport()
    {
        $products = Product::with(['seller', 'category', 'comments'])
            ->get()
            ->map(function ($product) {
                $product->average_rating = $product->comments->avg('rating') ?? 0;
                return $product;
            })
            ->sortByDesc('average_rating');

        $data = [
            'title' => 'Laporan Produk Berdasarkan Rating',
            'date' => now()->format('d F Y H:i'),
            'products' => $products,
            'total' => $products->count(),
        ];

        return Pdf::loadView('reports.products-by-rating', $data)
            ->setPaper('a4', 'landscape');
    }

    /**
     * Seller Report: Stock List sorted by stock descending (SRS-MartPlace-12)
     */
    public function generateSellerStockListReport(Seller $seller)
    {
        $products = $seller->products()
            ->with('category')
            ->orderBy('stock', 'desc')
            ->get()
            ->map(function ($product) {
                $product->average_rating = $product->comments->avg('rating') ?? 0;
                return $product;
            });

        $data = [
            'title' => 'Laporan Daftar Stok Produk',
            'date' => now()->format('d F Y H:i'),
            'seller' => $seller,
            'products' => $products,
            'total' => $products->count(),
            'totalStock' => $products->sum('stock'),
        ];

        return Pdf::loadView('reports.seller-stock-list', $data)
            ->setPaper('a4', 'portrait');
    }

    /**
     * Seller Report: Products by Rating (SRS-MartPlace-13)
     */
    public function generateSellerProductsByRatingReport(Seller $seller)
    {
        $products = $seller->products()
            ->with(['category', 'comments'])
            ->get()
            ->map(function ($product) {
                $product->average_rating = $product->comments->avg('rating') ?? 0;
                return $product;
            })
            ->sortByDesc('average_rating');

        $data = [
            'title' => 'Laporan Produk Berdasarkan Rating',
            'date' => now()->format('d F Y H:i'),
            'seller' => $seller,
            'products' => $products,
            'total' => $products->count(),
        ];

        return Pdf::loadView('reports.seller-products-by-rating', $data)
            ->setPaper('a4', 'portrait');
    }

    /**
     * Seller Report: Low Stock Products (stock < 2) (SRS-MartPlace-14)
     */
    public function generateSellerLowStockReport(Seller $seller)
    {
        $products = $seller->products()
            ->where('stock', '<', 2)
            ->with('category')
            ->orderBy('stock', 'asc')
            ->get()
            ->map(function ($product) {
                $product->average_rating = $product->comments->avg('rating') ?? 0;
                return $product;
            });

        $data = [
            'title' => 'Laporan Stok Produk Menipis',
            'date' => now()->format('d F Y H:i'),
            'seller' => $seller,
            'products' => $products,
            'total' => $products->count(),
            'note' => 'Produk dengan stok kurang dari 2 unit perlu segera dipesan ulang.',
        ];

        return Pdf::loadView('reports.seller-low-stock', $data)
            ->setPaper('a4', 'portrait');
    }

    /**
     * Generate filename for PDF download
     */
    public function generateFilename(string $reportType): string
    {
        $date = now()->format('Y-m-d');
        return "laporan-{$reportType}-{$date}.pdf";
    }

    /**
     * Generate filename with province
     */
    public function generateFilenameWithProvince(string $reportType, string $province): string
    {
        $date = now()->format('Y-m-d');
        $provinceSlug = Str::slug($province);
        return "laporan-{$reportType}-{$provinceSlug}-{$date}.pdf";
    }
}
