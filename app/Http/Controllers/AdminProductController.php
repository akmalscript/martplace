<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    /**
     * Display a listing of all products with filters.
     */
    public function index(Request $request)
    {
        $query = Product::with(['seller', 'category']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'suspended') {
                $query->where('is_active', false);
            }
        }

        // Seller filter
        if ($request->filled('seller')) {
            $query->where('seller_id', $request->seller);
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortDir = $request->get('dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        $products = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        // Stats
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $suspendedProducts = Product::where('is_active', false)->count();

        return view('admin.products-index', compact(
            'products',
            'categories',
            'totalProducts',
            'activeProducts',
            'suspendedProducts'
        ));
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::with(['seller', 'category', 'images', 'variants', 'reviews'])
            ->findOrFail($id);

        return view('admin.products-show', compact('product'));
    }

    /**
     * Suspend a product (set is_active to false).
     */
    public function suspend($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => false]);

        return redirect()->back()->with('success', "Produk '{$product->name}' berhasil disuspend.");
    }

    /**
     * Activate a product (set is_active to true).
     */
    public function activate($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => true]);

        return redirect()->back()->with('success', "Produk '{$product->name}' berhasil diaktifkan.");
    }

    /**
     * Remove the specified product.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $productName = $product->name;
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', "Produk '{$productName}' berhasil dihapus.");
    }
}
