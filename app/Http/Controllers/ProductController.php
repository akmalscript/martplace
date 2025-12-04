<?php

namespace App\Http\Controllers;

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
        $query = Product::active();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        // Sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->popular();
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(24);

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

        return view('products.index', compact('products'));
    }

    /**
     * Search suggestions (API endpoint) - Enhanced with sellers and locations
     */
    public function search(Request $request)
    {
        $search = $request->input('q', '');

        if (strlen($search) < 2) {
            return response()->json([
                'products' => [],
                'sellers' => [],
                'locations' => []
            ]);
        }

        // Search Products - get top 5
        $products = Product::active()
            ->search($search)
            ->limit(5)
            ->get(['id', 'name', 'price', 'image_url', 'category', 'location']);

        // Search Sellers (Toko) - get top 3
        $sellers = Seller::active()
            ->search($search)
            ->limit(3)
            ->get(['id', 'store_name', 'city', 'province', 'rating', 'total_products']);

        // Search Locations - aggregate unique cities and provinces
        $locations = [];

        // Get unique provinces from sellers
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

        // Get unique cities from sellers
        $cities = Seller::active()
            ->where('city', 'like', "%{$search}%")
            ->select('city', 'province')
            ->distinct()
            ->limit(3 - count($locations))
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
