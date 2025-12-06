<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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
            ->select('name', 'average_rating', 'total_reviews')
            ->orderBy('average_rating', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->name,
                    'rating' => (float) $product->average_rating,
                    'reviews' => $product->total_reviews
                ];
            });

        // 3. Sebaran pemberi rating berdasarkan provinsi
        $ratingByProvince = DB::table('reviews')
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->where('products.seller_id', $seller->id)
            ->select('reviews.province', DB::raw('count(*) as total'))
            ->groupBy('reviews.province')
            ->orderBy('total', 'desc')
            ->get();

        // Summary statistics
        $totalProducts = Product::where('seller_id', $seller->id)->count();
        $totalStock = Product::where('seller_id', $seller->id)->sum('stock');
        $averageRating = Product::where('seller_id', $seller->id)->avg('average_rating');
        $totalReviews = Product::where('seller_id', $seller->id)->sum('total_reviews');

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

    public function products(Request $request)
    {
        $seller = Auth::user()->seller;

        if (!$seller) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar sebagai seller.');
        }

        // Get all categories for filter
        $categories = \App\Models\Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Build query with search and filter
        $query = Product::with(['category', 'variants', 'images'])
            ->where('seller_id', $seller->id);

        // Search by product name or category
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('category', function($q) use ($searchTerm) {
                      $q->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Get products with pagination
        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        // Summary statistics
        $totalProducts = Product::where('seller_id', $seller->id)->count();
        $totalStock = Product::where('seller_id', $seller->id)->sum('stock');
        $activeProducts = Product::where('seller_id', $seller->id)->where('is_active', true)->count();
        $inactiveProducts = Product::where('seller_id', $seller->id)->where('is_active', false)->count();

        return view('seller.products', compact(
            'seller',
            'products',
            'categories',
            'totalProducts',
            'totalStock',
            'activeProducts',
            'inactiveProducts'
        ));
    }

    public function createProduct()
    {
        $seller = Auth::user()->seller;

        if (!$seller) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar sebagai seller.');
        }

        $categories = \App\Models\Category::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('seller.products-create', compact('seller', 'categories'));
    }

    public function storeProduct(Request $request)
    {
        $seller = Auth::user()->seller;

        if (!$seller) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar sebagai seller.');
        }

        // Check if has_variants
        $hasVariants = $request->has('has_variants') && $request->has_variants;
        
        $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'primary_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'has_variants' => 'nullable|boolean',
            'price' => $hasVariants ? 'nullable|numeric|min:0' : 'required|numeric|min:0',
            'stock' => $hasVariants ? 'nullable|integer|min:0' : 'required|integer|min:0',
            'min_order' => 'nullable|integer|min:1',
            'max_order' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        
        try {
            // Upload primary image
            $primaryImagePath = $request->file('primary_image')->store('products', 'public');

            // Create product
            $product = Product::create([
                'seller_id' => $seller->id,
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . uniqid(),
                'description' => $request->description,
                'image_url' => asset('storage/' . $primaryImagePath),
                'has_variants' => $request->has_variants ?? false,
                'price' => $request->price ?? 0,
                'stock' => $request->stock ?? 0,
                'min_order' => $request->min_order ?? 1,
                'max_order' => $request->max_order,
                'province' => $seller->province ?? 'DKI Jakarta',
                'city' => $seller->city ?? 'Jakarta',
                'is_active' => $request->is_active == '1',
                'average_rating' => 0,
                'total_reviews' => 0,
            ]);

            // Save primary image to product_images
            \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $primaryImagePath,
                'is_primary' => true,
                'order' => 0,
            ]);

            // Upload additional images
            if ($request->hasFile('additional_images')) {
                foreach ($request->file('additional_images') as $index => $image) {
                    $imagePath = $image->store('products', 'public');
                    \App\Models\ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                        'is_primary' => false,
                        'order' => $index + 1,
                    ]);
                }
            }

            // Handle variants
            if ($request->has_variants && $request->variants) {
                foreach ($request->variants as $variant) {
                    if (isset($variant['price']) && isset($variant['stock'])) {
                        \App\Models\ProductVariant::create([
                            'product_id' => $product->id,
                            'variant_type_1' => $variant['variant_type_1'] ?? null,
                            'variant_value_1' => $variant['variant_value_1'] ?? null,
                            'variant_type_2' => $variant['variant_type_2'] ?? null,
                            'variant_value_2' => $variant['variant_value_2'] ?? null,
                            'price' => $variant['price'],
                            'stock' => $variant['stock'],
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('seller.products')
                ->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function editProduct($id)
    {
        $seller = Auth::user()->seller;

        if (!$seller) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar sebagai seller.');
        }

        $product = Product::with(['images', 'variants'])
            ->where('seller_id', $seller->id)
            ->findOrFail($id);
        $categories = \App\Models\Category::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('seller.products-edit', compact('seller', 'product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $seller = Auth::user()->seller;

        if (!$seller) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar sebagai seller.');
        }

        $product = Product::where('seller_id', $seller->id)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'primary_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'has_variants' => 'nullable|boolean',
            'price' => 'required_if:has_variants,false|nullable|numeric|min:0',
            'stock' => 'required_if:has_variants,false|nullable|integer|min:0',
            'min_order' => 'nullable|integer|min:1',
            'max_order' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        
        try {
            // Update basic info
            $updateData = [
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . $product->id,
                'description' => $request->description,
                'has_variants' => $request->has_variants ?? false,
                'price' => $request->price ?? 0,
                'stock' => $request->stock ?? 0,
                'min_order' => $request->min_order ?? 1,
                'max_order' => $request->max_order,
                'is_active' => $request->is_active == '1',
            ];

            // Update primary image if provided
            if ($request->hasFile('primary_image')) {
                $primaryImagePath = $request->file('primary_image')->store('products', 'public');
                $updateData['image_url'] = asset('storage/' . $primaryImagePath);
                
                // Update primary image in product_images table
                \App\Models\ProductImage::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'is_primary' => true
                    ],
                    [
                        'image_path' => $primaryImagePath,
                        'order' => 0,
                    ]
                );
            }

            $product->update($updateData);

            // Upload additional images if provided
            if ($request->hasFile('additional_images')) {
                // Get current max order
                $maxOrder = \App\Models\ProductImage::where('product_id', $product->id)
                    ->max('order') ?? 0;
                
                foreach ($request->file('additional_images') as $index => $image) {
                    $imagePath = $image->store('products', 'public');
                    \App\Models\ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                        'is_primary' => false,
                        'order' => $maxOrder + $index + 1,
                    ]);
                }
            }

            // Handle variants update
            if ($request->has_variants && $request->variants) {
                // Delete existing variants
                $product->variants()->delete();
                
                // Create new variants
                foreach ($request->variants as $variant) {
                    if (isset($variant['price']) && isset($variant['stock'])) {
                        \App\Models\ProductVariant::create([
                            'product_id' => $product->id,
                            'variant_type_1' => $variant['variant_type_1'] ?? null,
                            'variant_value_1' => $variant['variant_value_1'] ?? null,
                            'variant_type_2' => $variant['variant_type_2'] ?? null,
                            'variant_value_2' => $variant['variant_value_2'] ?? null,
                            'price' => $variant['price'],
                            'stock' => $variant['stock'],
                        ]);
                    }
                }
            } else {
                // If no variants, delete existing variants
                $product->variants()->delete();
            }

            DB::commit();

            return redirect()->route('seller.products')
                ->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function deleteProduct($id)
    {
        $seller = Auth::user()->seller;

        if (!$seller) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar sebagai seller.');
        }

        $product = Product::where('seller_id', $seller->id)->findOrFail($id);

        DB::beginTransaction();
        
        try {
            // Delete related data
            $product->images()->delete();
            $product->variants()->delete();
            $product->reviews()->delete();
            
            // Delete product
            $product->delete();

            DB::commit();

            return redirect()->route('seller.products')
                ->with('success', 'Produk berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    public function reports()
    {
        $seller = Auth::user()->seller;

        if (!$seller) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar sebagai seller.');
        }

        // Basic statistics for reports
        $totalProducts = Product::where('seller_id', $seller->id)->count();
        $activeProducts = Product::where('seller_id', $seller->id)->where('is_active', true)->count();
        $totalStock = Product::where('seller_id', $seller->id)->sum('stock');
        $averageRating = Product::where('seller_id', $seller->id)->avg('average_rating');
        $totalReviews = Product::where('seller_id', $seller->id)->sum('total_reviews');

        // Products by category
        $productsByCategory = Product::where('seller_id', $seller->id)
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name as category', DB::raw('count(*) as total'))
            ->groupBy('categories.name')
            ->orderBy('total', 'desc')
            ->get();

        // Low stock products (stock < 2)
        $lowStockProducts = Product::where('seller_id', $seller->id)
            ->where('stock', '<', 2)
            ->where('is_active', true)
            ->orderBy('stock', 'asc')
            ->get();

        return view('seller.reports', compact(
            'seller',
            'totalProducts',
            'activeProducts',
            'totalStock',
            'averageRating',
            'totalReviews',
            'productsByCategory',
            'lowStockProducts'
        ));
    }

    /**
     * Generate PDF report for stock products ordered by quantity (descending)
     */
    public function reportStockByQuantity()
    {
        $seller = Auth::user()->seller;

        if (!$seller) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar sebagai seller.');
        }

        // Get all products for this seller ordered by stock (descending)
        $products = Product::with('category')
            ->where('seller_id', $seller->id)
            ->orderBy('stock', 'desc')
            ->get();

        $data = [
            'products' => $products,
            'tanggalDibuat' => now()->locale('id')->isoFormat('D MMMM Y'),
            'namaAkunPemroses' => Auth::user()->name,
        ];

        $pdf = Pdf::loadView('seller.pdf.stock-by-quantity-report', $data);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'Laporan_Stok_Produk_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Generate PDF report for stock products ordered by rating (descending)
     */
    public function reportStockByRating()
    {
        $seller = Auth::user()->seller;

        if (!$seller) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar sebagai seller.');
        }

        // Get all products for this seller ordered by rating (descending)
        $products = Product::with('category')
            ->where('seller_id', $seller->id)
            ->orderBy('average_rating', 'desc')
            ->get();

        $data = [
            'products' => $products,
            'tanggalDibuat' => now()->locale('id')->isoFormat('D MMMM Y'),
            'namaAkunPemroses' => Auth::user()->name,
        ];

        $pdf = Pdf::loadView('seller.pdf.stock-by-rating-report', $data);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'Laporan_Stok_Rating_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Generate PDF report for low stock products (stock < 2)
     */
    public function reportLowStock()
    {
        $seller = Auth::user()->seller;

        if (!$seller) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar sebagai seller.');
        }

        // Get all products for this seller with stock < 2, ordered by category and product name
        $products = Product::with('category')
            ->where('seller_id', $seller->id)
            ->where('stock', '<', 2)
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->orderBy('categories.name', 'asc')
            ->orderBy('products.name', 'asc')
            ->select('products.*')
            ->get();

        $data = [
            'products' => $products,
            'tanggalDibuat' => now()->locale('id')->isoFormat('D MMMM Y'),
            'namaAkunPemroses' => Auth::user()->name,
        ];

        $pdf = Pdf::loadView('seller.pdf.low-stock-report', $data);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'Laporan_Stok_Hampir_Habis_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }
}
