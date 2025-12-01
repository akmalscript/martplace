<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard with statistics.
     */
    public function index()
    {
        // 1. Sebaran jumlah produk berdasarkan kategori
        $productsByCategory = Product::select('categories.name as category', DB::raw('count(products.id) as total'))
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereNotNull('products.category_id')
            ->groupBy('categories.name')
            ->orderBy('total', 'desc')
            ->get();

        // 2. Sebaran jumlah toko berdasarkan lokasi provinsi
        $sellersByProvince = Seller::select('pic_province as province', DB::raw('count(*) as total'))
            ->whereNotNull('pic_province')
            ->groupBy('pic_province')
            ->orderBy('total', 'desc')
            ->get();

        // 3. Jumlah user penjual aktif dan tidak aktif
        $activeSellers = Seller::where('status', \App\Enums\SellerStatus::ACTIVE)->count();
        $inactiveSellers = Seller::whereIn('status', [
            \App\Enums\SellerStatus::PENDING,
            \App\Enums\SellerStatus::REJECTED
        ])->count();

        // 4. Jumlah pengunjung yang memberikan komentar dan rating
        $totalReviews = DB::table('product_reviews')->count();
        $totalRatings = DB::table('product_reviews')->count();
        $uniqueReviewers = DB::table('product_reviews')->distinct('visitor_email')->count('visitor_email');

        // Additional useful statistics
        $totalProducts = Product::count();
        $totalSellers = Seller::count();
        $totalUsers = User::where('role', 'user')->count();
        $pendingSellers = Seller::where('status', \App\Enums\SellerStatus::PENDING)->count();

        return view('admin.dashboard', compact(
            'productsByCategory',
            'sellersByProvince',
            'activeSellers',
            'inactiveSellers',
            'totalReviews',
            'totalRatings',
            'uniqueReviewers',
            'totalProducts',
            'totalSellers',
            'totalUsers',
            'pendingSellers'
        ));
    }
}
