<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
            $selectedCategory = Category::find($request->category)->name ?? null;
        } else {
            $selectedCategory = null;
        }

        // Show top 12 products with highest rating (default for home page)
        $products = $query->orderBy('average_rating', 'desc')
            ->orderBy('total_reviews', 'desc')
            ->limit(12)
            ->get();
        
        $selectedFilter = 'untuk_anda';

        // Get total count for display
        $totalProducts = Product::active()->count();

        // Fetch active categories for display
        $categories = Category::where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return view('home', compact('products', 'selectedCategory', 'selectedFilter', 'categories', 'totalProducts'));
    }
}
