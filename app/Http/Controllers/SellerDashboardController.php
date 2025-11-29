<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerDashboardController extends Controller
{
    /**
     * Seller Dashboard (SRS-MartPlace-08)
     */
    public function index()
    {
        $seller = Auth::user()->seller;
        
        if (!$seller) {
            return redirect()->route('home')->with('error', 'Anda belum memiliki akun seller.');
        }

        $products = $seller->products;

        // Stock distribution per product
        $stockByProduct = $products->map(function($product) {
            return [
                'name' => $product->name,
                'stock' => $product->stock
            ];
        });

        // Rating distribution per product
        $ratingByProduct = $products->map(function($product) {
            return [
                'name' => $product->name,
                'rating' => $product->rating / 10 // Convert back to 1-5 scale
            ];
        });

        // Commenters by province
        $commentsByProvince = Comment::whereIn('product_id', $products->pluck('id'))
            ->select('email', \DB::raw('count(*) as total'))
            ->groupBy('email')
            ->get()
            ->groupBy(function($comment) {
                // This is simplified - you may want to track province in comments table
                return 'Various'; 
            })
            ->map(function($group) {
                return $group->count();
            });

        return view('seller.dashboard', compact(
            'seller',
            'products',
            'stockByProduct',
            'ratingByProduct',
            'commentsByProvince'
        ));
    }

    /**
     * Seller Products Management
     */
    public function products()
    {
        $seller = Auth::user()->seller;
        $products = $seller->products()->with('category')->latest()->paginate(12);
        
        return view('seller.products.index', compact('products'));
    }

    /**
     * Create Product Form (SRS-MartPlace-03)
     */
    public function createProduct()
    {
        $categories = \App\Models\ProductCategory::whereNull('parent_id')->with('children')->get();
        return view('seller.products.create', compact('categories'));
    }

    /**
     * Store Product (SRS-MartPlace-03)
     */
    public function storeProduct(Request $request)
    {
        $seller = Auth::user()->seller;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'weight' => 'nullable|numeric',
            'condition' => 'nullable|string',
            'main_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['seller_id'] = $seller->id;
        $validated['location'] = $seller->pic_city . ', ' . $seller->pic_province;
        $validated['is_active'] = true;

        // Handle main photo upload
        if ($request->hasFile('main_photo')) {
            $validated['main_photo'] = $request->file('main_photo')->store('products/main', 'public');
        }

        // Handle additional photos
        if ($request->hasFile('photos')) {
            $photos = [];
            foreach ($request->file('photos') as $photo) {
                $photos[] = $photo->store('products/gallery', 'public');
            }
            $validated['photos'] = $photos;
        }

        Product::create($validated);

        return redirect()->route('seller.products')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Edit Product
     */
    public function editProduct($id)
    {
        $seller = Auth::user()->seller;
        $product = Product::where('seller_id', $seller->id)->findOrFail($id);
        $categories = \App\Models\ProductCategory::whereNull('parent_id')->with('children')->get();
        
        return view('seller.products.edit', compact('product', 'categories'));
    }

    /**
     * Update Product
     */
    public function updateProduct(Request $request, $id)
    {
        $seller = Auth::user()->seller;
        $product = Product::where('seller_id', $seller->id)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'weight' => 'nullable|numeric',
            'condition' => 'nullable|string',
            'main_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle main photo upload
        if ($request->hasFile('main_photo')) {
            if ($product->main_photo) {
                \Storage::disk('public')->delete($product->main_photo);
            }
            $validated['main_photo'] = $request->file('main_photo')->store('products/main', 'public');
        }

        // Handle additional photos
        if ($request->hasFile('photos')) {
            $photos = $product->photos ?? [];
            foreach ($request->file('photos') as $photo) {
                $photos[] = $photo->store('products/gallery', 'public');
            }
            $validated['photos'] = $photos;
        }

        $product->update($validated);

        return redirect()->route('seller.products')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Delete Product
     */
    public function deleteProduct($id)
    {
        $seller = Auth::user()->seller;
        $product = Product::where('seller_id', $seller->id)->findOrFail($id);
        
        // Delete photos
        if ($product->main_photo) {
            \Storage::disk('public')->delete($product->main_photo);
        }
        
        if ($product->photos) {
            foreach ($product->photos as $photo) {
                \Storage::disk('public')->delete($photo);
            }
        }
        
        $product->delete();

        return redirect()->route('seller.products')->with('success', 'Produk berhasil dihapus!');
    }
}