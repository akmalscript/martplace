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
        $productsByCategory = Product::select('category', DB::raw('count(*) as total'))
            ->whereNotNull('category')
            ->groupBy('category')
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
        // Note: Assuming you'll have reviews/comments table in the future
        $totalReviews = 0; // Placeholder - will be implemented when review system is added
        $totalRatings = 0; // Placeholder - will be implemented when review system is added

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
            'totalProducts',
            'totalSellers',
            'totalUsers',
            'pendingSellers'
        ));
    }
}
