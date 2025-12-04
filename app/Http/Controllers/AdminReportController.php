<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AdminReportController extends Controller
{
    /**
     * Display reports page with statistics.
     */
    public function index()
    {
        // Statistics for the reports page
        $totalSellers = Seller::count();
        $activeSellers = Seller::where('status', \App\Enums\SellerStatus::ACTIVE)->count();
        $inactiveSellers = Seller::whereIn('status', [
            \App\Enums\SellerStatus::PENDING,
            \App\Enums\SellerStatus::REJECTED
        ])->count();
        
        $totalProducts = Product::count();
        
        $totalProvinces = Seller::select('pic_province')
            ->whereNotNull('pic_province')
            ->distinct()
            ->count();

        return view('admin.reports', compact(
            'totalSellers',
            'activeSellers',
            'inactiveSellers',
            'totalProducts',
            'totalProvinces'
        ));
    }

    /**
     * Generate PDF report for sellers (active and inactive).
     */
    public function sellersReport()
    {
        // Get all sellers ordered by status (active first, then inactive)
        $sellers = Seller::with('user')
            ->orderByRaw("CASE 
                WHEN status = 'active' THEN 1 
                ELSE 2 
            END")
            ->orderBy('created_at', 'asc')
            ->get();

        // Prepare data for PDF
        $tanggalDibuat = Carbon::now()->locale('id')->isoFormat('DD-MM-YYYY');
        $namaAkunPemroses = Auth::user()->name;

        // Generate PDF
        $pdf = Pdf::loadView('admin.pdf.sellers-report', compact(
            'sellers',
            'tanggalDibuat',
            'namaAkunPemroses'
        ));

        // Set paper size to A4
        $pdf->setPaper('A4', 'portrait');

        // Download PDF
        return $pdf->download('Laporan_Daftar_Akun_Penjual_' . date('YmdHis') . '.pdf');
    }

    /**
     * Generate PDF report for sellers grouped by province.
     */
    public function sellersByProvinceReport()
    {
        // Get all sellers ordered by province
        $sellers = Seller::whereNotNull('pic_province')
            ->orderBy('pic_province', 'asc')
            ->orderBy('store_name', 'asc')
            ->get();

        // Prepare data for PDF
        $tanggalDibuat = Carbon::now()->locale('id')->isoFormat('DD-MM-YYYY');
        $namaAkunPemroses = Auth::user()->name;

        // Generate PDF
        $pdf = Pdf::loadView('admin.pdf.sellers-by-province-report', compact(
            'sellers',
            'tanggalDibuat',
            'namaAkunPemroses'
        ));

        // Set paper size to A4
        $pdf->setPaper('A4', 'portrait');

        // Download PDF
        return $pdf->download('Laporan_Daftar_Toko_Berdasarkan_Provinsi_' . date('YmdHis') . '.pdf');
    }

    /**
     * Generate PDF report for products sorted by rating.
     */
    public function productsByRatingReport()
    {
        // Get all products with reviews, including visitor province
        $products = DB::table('products')
            ->leftJoin('product_reviews', 'products.id', '=', 'product_reviews.product_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('sellers', 'products.seller_id', '=', 'sellers.id')
            ->select(
                'products.id',
                'products.name as product_name',
                'categories.name as category_name',
                'products.price',
                'sellers.store_name',
                DB::raw('COALESCE(AVG(product_reviews.rating), 0) as avg_rating'),
                DB::raw('GROUP_CONCAT(DISTINCT product_reviews.visitor_province SEPARATOR ", ") as provinces')
            )
            ->groupBy(
                'products.id',
                'products.name',
                'categories.name',
                'products.price',
                'sellers.store_name'
            )
            ->orderByRaw('COALESCE(AVG(product_reviews.rating), 0) DESC')
            ->orderBy('products.name', 'asc')
            ->get();

        // Prepare data for PDF
        $tanggalDibuat = Carbon::now()->locale('id')->isoFormat('DD-MM-YYYY');
        $namaAkunPemroses = Auth::user()->name;

        // Generate PDF
        $pdf = Pdf::loadView('admin.pdf.products-by-rating-report', compact(
            'products',
            'tanggalDibuat',
            'namaAkunPemroses'
        ));

        // Set paper size to A4
        $pdf->setPaper('A4', 'landscape'); // Landscape karena banyak kolom

        // Download PDF
        return $pdf->download('Laporan_Produk_Berdasarkan_Rating_' . date('YmdHis') . '.pdf');
    }
}
