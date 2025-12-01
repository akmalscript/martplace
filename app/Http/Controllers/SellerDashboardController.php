<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            ->select('name', 'rating', 'sold_count')
            ->orderBy('rating', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->name,
                    'rating' => (float) $product->rating,
                    'reviews' => $product->sold_count
                ];
            });

        // 3. Sebaran pemberi rating berdasarkan provinsi
        // Sementara menggunakan data dummy karena tabel reviews belum ada
        $ratingByProvince = collect([
            ['province' => 'Jawa Barat', 'total' => 25],
            ['province' => 'DKI Jakarta', 'total' => 20],
            ['province' => 'Jawa Tengah', 'total' => 15],
            ['province' => 'Jawa Timur', 'total' => 12],
            ['province' => 'Banten', 'total' => 10],
            ['province' => 'Sumatera Utara', 'total' => 8],
            ['province' => 'Sulawesi Selatan', 'total' => 6],
            ['province' => 'Bali', 'total' => 5],
        ]);

        // Summary statistics
        $totalProducts = Product::where('seller_id', $seller->id)->count();
        $totalStock = Product::where('seller_id', $seller->id)->sum('stock');
        $averageRating = Product::where('seller_id', $seller->id)->avg('rating');
        $totalReviews = Product::where('seller_id', $seller->id)->sum('sold_count');

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

    public function products()
    {
        $seller = Auth::user()->seller;

        if (!$seller) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar sebagai seller.');
        }

        // Get all products with pagination
        $products = Product::where('seller_id', $seller->id)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Summary statistics
        $totalProducts = Product::where('seller_id', $seller->id)->count();
        $totalStock = Product::where('seller_id', $seller->id)->sum('stock');
        $activeProducts = Product::where('seller_id', $seller->id)->where('is_active', true)->count();
        $inactiveProducts = Product::where('seller_id', $seller->id)->where('is_active', false)->count();

        return view('seller.products', compact(
            'seller',
            'products',
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

        $categories = [
            'Technology',
            'Fashion Pria',
            'Fashion Wanita',
            'Handphone',
            'Elektronik',
            'Otomotif',
            'Makanan & Minuman',
            'Kesehatan',
            'Olahraga',
            'Hobi & Koleksi',
        ];

        return view('seller.products-create', compact('seller', 'categories'));
    }

    public function storeProduct(Request $request)
    {
        $seller = Auth::user()->seller;

        if (!$seller) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar sebagai seller.');
        }

        $request->validate([
            'name' => 'required|string|max:200',
            'category' => 'required|string',
            'description' => 'required|string',
            'primary_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
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
            // Upload primary image
            $primaryImagePath = $request->file('primary_image')->store('products', 'public');

            // Create product
            $product = Product::create([
                'seller_id' => $seller->id,
                'name' => $request->name,
                'category' => $request->category,
                'description' => $request->description,
                'image_url' => asset('storage/' . $primaryImagePath),
                'has_variants' => $request->has_variants ?? false,
                'price' => $request->price ?? 0,
                'stock' => $request->stock ?? 0,
                'min_order' => $request->min_order ?? 1,
                'max_order' => $request->max_order,
                'location' => $seller->city . ', ' . $seller->province,
                'is_active' => $request->is_active ?? true,
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
                            'variant_type_1' => $variant['type_1'] ?? null,
                            'variant_value_1' => $variant['value_1'] ?? null,
                            'variant_type_2' => $variant['type_2'] ?? null,
                            'variant_value_2' => $variant['value_2'] ?? null,
                            'price' => $variant['price'],
                            'stock' => $variant['stock'],
                            'sku' => $variant['sku'] ?? null,
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
}
