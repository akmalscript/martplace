<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            $query->where('category', $request->category);
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
     * Display the specified product with comments and rating (SRS-MartPlace-04)
     */
    public function show($id)
    {
        $product = Product::with(['seller', 'user', 'category', 'comments' => function($q) {
            $q->latest();
        }])->findOrFail($id);

        // Get related products by category
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('category')
            ->limit(6)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Display user's products
     */
    public function myProducts()
    {
        $products = Auth::user()->products()->with('category')->latest()->paginate(12);
        return view('products.my-products', compact('products'));
    }

    /**
     * Show product creation form
     */
    public function create()
    {
        $categories = ProductCategory::whereNull('parent_id')->with('children')->get();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a new product
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'weight' => 'nullable|numeric',
            'condition' => 'nullable|string',
            'location' => 'required|string|max:255',
            'main_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_active'] = true;

        // Handle main photo upload
        if ($request->hasFile('main_photo')) {
            $validated['main_photo'] = $request->file('main_photo')->store('products/main', 'public');
        }

        // Handle additional photos (max 2)
        if ($request->hasFile('photos')) {
            $photos = [];
            $photoFiles = array_slice($request->file('photos'), 0, 2); // Max 2 additional
            foreach ($photoFiles as $photo) {
                $photos[] = $photo->store('products/gallery', 'public');
            }
            $validated['photos'] = $photos;
        }

        Product::create($validated);

        return redirect()->route('my-products')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Show product edit form
     */
    public function edit($id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        $categories = ProductCategory::whereNull('parent_id')->with('children')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update product
     */
    public function update(Request $request, $id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'weight' => 'nullable|numeric',
            'condition' => 'nullable|string',
            'location' => 'required|string|max:255',
            'main_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle main photo upload
        if ($request->hasFile('main_photo')) {
            if ($product->main_photo) {
                Storage::disk('public')->delete($product->main_photo);
            }
            $validated['main_photo'] = $request->file('main_photo')->store('products/main', 'public');
        }

        // Handle additional photos
        if ($request->hasFile('photos')) {
            $photos = $product->photos ?? [];
            foreach ($request->file('photos') as $photo) {
                if (count($photos) < 2) { // Max 2 additional
                    $photos[] = $photo->store('products/gallery', 'public');
                }
            }
            $validated['photos'] = $photos;
        }

        $product->update($validated);

        return redirect()->route('my-products')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Delete product
     */
    public function destroy($id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        
        // Delete photos
        if ($product->main_photo) {
            Storage::disk('public')->delete($product->main_photo);
        }
        
        if ($product->photos) {
            foreach ($product->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }
        
        $product->delete();

        return redirect()->route('my-products')->with('success', 'Produk berhasil dihapus!');
    }
}
