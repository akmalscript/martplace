<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Seller;
use App\Models\Comment;
use App\Services\ProductService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display the home page with featured products (SRS-MartPlace-04)
     */
    public function index(Request $request)
    {
        $selectedCategory = $request->get('category');
        $selectedFilter = $request->get('filter', 'untuk_anda');
        
        $query = Product::active()->with(['seller', 'category', 'comments']);

        // Filter by category name
        if ($selectedCategory) {
            $query->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('name', 'like', "%{$selectedCategory}%");
            });
        }

        // Apply sorting based on filter
        switch ($selectedFilter) {
            case 'terlaris':
                $query->withCount('comments')->orderBy('comments_count', 'desc');
                break;
            case 'terbaru':
                $query->latest();
                break;
            case 'rating':
                $query->withAvg('comments', 'rating')->orderByDesc('comments_avg_rating');
                break;
            default:
                $query->latest();
        }
        
        $products = $query->limit(24)->get();

        // Get categories for navigation
        $categories = ProductCategory::whereNull('parent_id')
            ->withCount('products')
            ->orderBy('name')
            ->get();

        // Statistics for hero section
        $stats = [
            'totalProducts' => Product::active()->count(),
            'totalSellers' => Seller::active()->count(),
            'totalProvinces' => Seller::active()->distinct('pic_province')->count('pic_province'),
            'totalReviews' => Comment::count(),
        ];

        return view('home-refactored', compact(
            'products', 
            'categories',
            'stats', 
            'selectedCategory', 
            'selectedFilter'
        ));
    }
}
