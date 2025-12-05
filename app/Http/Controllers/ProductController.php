<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Product::active()->with(['seller:id,store_name,city,province', 'images']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'rating':
                $query->orderBy('average_rating', 'desc')->orderBy('total_reviews', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'popular':
                $query->orderBy('total_reviews', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(24);

        // Get all categories for filter
        $categories = Category::where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'products' => $products->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'total' => $products->total(),
                ]
            ]);
        }

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Search suggestions (API endpoint) - Enhanced with sellers, categories, and locations
     */
    public function search(Request $request)
    {
        $search = $request->input('q', '');

        if (strlen($search) < 2) {
            return response()->json([
                'products' => [],
                'sellers' => [],
                'categories' => [],
                'locations' => []
            ]);
        }

        // Search Products - get top 5 with related seller and category
        $products = Product::active()
            ->with(['seller:id,store_name,city,province', 'category:id,name'])
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->limit(5)
            ->get(['id', 'name', 'price', 'image_url', 'seller_id', 'category_id'])
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image_url' => $product->image_url,
                    'category' => $product->category ? $product->category->name : null,
                    'seller' => $product->seller ? $product->seller->store_name : null,
                ];
            });

        // Search Categories - get top 3 matching categories
        $categories = Category::where('is_active', true)
            ->where('name', 'like', "%{$search}%")
            ->limit(3)
            ->get(['id', 'name', 'icon'])
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'icon' => $category->icon ?? 'fa-tag',
                ];
            });

        // Search Sellers (Toko) - get top 3
        $sellers = Seller::active()
            ->where(function ($query) use ($search) {
                $query->where('store_name', 'like', "%{$search}%")
                      ->orWhere('city', 'like', "%{$search}%")
                      ->orWhere('province', 'like', "%{$search}%")
                      ->orWhere('district', 'like', "%{$search}%");
            })
            ->withCount(['products' => function ($query) {
                $query->where('is_active', true);
            }])
            ->limit(3)
            ->get(['id', 'store_name', 'city', 'province', 'rating'])
            ->map(function ($seller) {
                return [
                    'id' => $seller->id,
                    'store_name' => $seller->store_name,
                    'city' => $seller->city,
                    'province' => $seller->province,
                    'rating' => $seller->rating ?? 0,
                    'total_products' => $seller->products_count ?? 0,
                ];
            });

        // Search Locations - aggregate unique cities and provinces from sellers
        $locations = [];

        // Get unique provinces from sellers that match the search
        $provinces = Seller::active()
            ->where('province', 'like', "%{$search}%")
            ->select('province')
            ->distinct()
            ->limit(2)
            ->pluck('province');

        foreach ($provinces as $province) {
            $locations[] = [
                'name' => $province,
                'type' => 'province'
            ];
        }

        // Get unique cities from sellers that match the search
        $cities = Seller::active()
            ->where('city', 'like', "%{$search}%")
            ->select('city', 'province')
            ->distinct()
            ->limit(max(0, 3 - count($locations)))
            ->get();

        foreach ($cities as $city) {
            $locations[] = [
                'name' => $city->city,
                'province' => $city->province,
                'type' => 'city'
            ];
        }

        return response()->json([
            'products' => $products,
            'sellers' => $sellers,
            'categories' => $categories,
            'locations' => $locations
        ]);
    }

    /**
     * Display the specified product
     */
    public function show($id)
    {
        $product = Product::with('images')->active()->findOrFail($id);

        // Get related products
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(6)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
