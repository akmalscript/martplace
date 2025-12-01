<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with all products
     */
    public function index(Request $request)
    {
        $query = Product::active();

        // Filter by category if provided
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        // Filter by type (untuk_anda, mall, terlaris, semua)
        $filterType = $request->get('filter', 'untuk_anda'); // Default: untuk_anda

        if ($filterType === 'untuk_anda') {
            // Untuk Anda: Produk terbaru dengan rating tinggi, limit 12
            $products = $query->where('average_rating', '>=', 4.0)
                ->latest()
                ->limit(12)
                ->get();
        } elseif ($filterType === 'mall') {
            // Mall: Produk dengan badge Mall
            $products = $query->where('badge', 'Mall')
                ->latest()
                ->get();
        } elseif ($filterType === 'terlaris') {
            // Produk Terlaris: Urutkan berdasarkan sold_count, limit 12
            $products = $query->orderBy('sold_count', 'desc')->limit(12)->get();
        } elseif ($filterType === 'semua') {
            // Semua: Tampilkan semua produk, urutkan terbaru
            $products = $query->latest()->get();
        } else {
            $products = $query->get();
        }
        $selectedCategory = $request->get('category');
        $selectedFilter = $filterType;

        return view('home', compact('products', 'selectedCategory', 'selectedFilter'));
    }
}
