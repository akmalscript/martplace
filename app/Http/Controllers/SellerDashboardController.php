<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $seller = Auth::user()->seller;

        if (!$seller) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar sebagai seller.');
        }

        // 1. Sebaran jumlah stok setiap produk
        $stockDistribution = Product::where('seller_id', $seller->id)
            ->select('name', 'stock')
            ->orderBy('stock', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->name,
                    'stock' => $product->stock
                ];
            });

        // 2. Sebaran nilai rating per produk
        $ratingDistribution = Product::where('seller_id', $seller->id)
            ->select('name', 'rating', 'sold_count')
            ->orderBy('rating', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->name,
                    'rating' => (float) $product->rating,
                    'reviews' => $product->sold_count
                ];
            });

        // 3. Sebaran pemberi rating berdasarkan provinsi
        // Sementara menggunakan data dummy karena tabel reviews belum ada
        $ratingByProvince = collect([
            ['province' => 'Jawa Barat', 'total' => 25],
            ['province' => 'DKI Jakarta', 'total' => 20],
            ['province' => 'Jawa Tengah', 'total' => 15],
            ['province' => 'Jawa Timur', 'total' => 12],
            ['province' => 'Banten', 'total' => 10],
            ['province' => 'Sumatera Utara', 'total' => 8],
            ['province' => 'Sulawesi Selatan', 'total' => 6],
            ['province' => 'Bali', 'total' => 5],
        ]);

        // Summary statistics
        $totalProducts = Product::where('seller_id', $seller->id)->count();
        $totalStock = Product::where('seller_id', $seller->id)->sum('stock');
        $averageRating = Product::where('seller_id', $seller->id)->avg('rating');
        $totalReviews = Product::where('seller_id', $seller->id)->sum('sold_count');

        return view('seller.dashboard', compact(
            'seller',
            'stockDistribution',
            'ratingDistribution',
            'ratingByProvince',
            'totalProducts',
            'totalStock',
            'averageRating',
            'totalReviews'
        ));
    }
}
