<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Comment;
use App\Models\VisitorLog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Admin Dashboard (SRS-MartPlace-07)
     */
    public function dashboard()
    {
        // Products by category
        $productsByCategory = Product::select('category_id', \DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(function($item) {
                return [
                    'category' => $item->category ? $item->category->name : 'Uncategorized',
                    'total' => $item->total
                ];
            });

        // Sellers by province
        $sellersByProvince = Seller::select('pic_province', \DB::raw('count(*) as total'))
            ->groupBy('pic_province')
            ->get()
            ->map(function($item) {
                return [
                    'province' => $item->pic_province,
                    'total' => $item->total
                ];
            });

        // Active vs Inactive sellers
        $activeSellers = Seller::where('status', 'ACTIVE')->count();
        $inactiveSellers = Seller::whereIn('status', ['PENDING', 'REJECTED'])->count();

        // Visitors who commented
        $commentersCount = Comment::select('email')->distinct()->count();

        return view('admin.dashboard', compact(
            'productsByCategory',
            'sellersByProvince',
            'activeSellers',
            'inactiveSellers',
            'commentersCount'
        ));
    }

    /**
     * Manage Sellers - List pending sellers for verification (SRS-MartPlace-02)
     */
    public function sellers(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Seller::with('user')->latest();
        
        if ($status !== 'all') {
            $query->where('status', strtoupper($status));
        }
        
        $sellers = $query->paginate(20);
        
        return view('admin.sellers.index', compact('sellers', 'status'));
    }

    /**
     * Show seller details for verification
     */
    public function showSeller($id)
    {
        $seller = Seller::with('user')->findOrFail($id);
        return view('admin.sellers.show', compact('seller'));
    }

    /**
     * Manage Products
     */
    public function products(Request $request)
    {
        $query = Product::with(['seller', 'category'])->latest();
        
        if ($request->has('search')) {
            $query->search($request->search);
        }
        
        $products = $query->paginate(24);
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Toggle product active status
     */
    public function toggleProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()->with('success', "Produk berhasil {$status}.");
    }
}