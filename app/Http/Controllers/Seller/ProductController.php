<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * List produk milik seller.
     */
    public function index()
    {
        $products = Product::where('seller_id', Auth::user()->id)->paginate(10);
        return view('seller.products.index', compact('products'));
    }

    /**
     * Form tambah produk.
     */
    public function create()
    {
        $categories = ProductCategory::all();
        return view('seller.products.create', compact('categories'));
    }

    /**
     * Simpan produk baru.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['seller_id'] = Auth::user()->id;

        // Upload foto utama
        if ($request->hasFile('main_photo')) {
            $data['main_photo'] = $request->file('main_photo')->store('products/main', 'public');
        }

        // Upload foto tambahan
        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->photos as $photo) {
                $photos[] = $photo->store('products/photos', 'public');
            }
        }
        $data['photos'] = $photos;

        Product::create($data);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail produk.
     */
    public function show(Product $product)
    {
        $this->authorizeOwner($product);
        return view('seller.products.show', compact('product'));
    }

    /**
     * Form edit produk.
     */
    public function edit(Product $product)
    {
        $this->authorizeOwner($product);
        $categories = ProductCategory::all();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    /**
     * Update produk.
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $this->authorizeOwner($product);

        $data = $request->validated();

        // Replace foto utama (jika diupload ulang)
        if ($request->hasFile('main_photo')) {
            if ($product->main_photo) {
                Storage::disk('public')->delete($product->main_photo);
            }

            $data['main_photo'] = $request->file('main_photo')->store('products/main', 'public');
        }

        // Replace foto tambahan (opsional)
        $photos = $product->photos ?? [];

        if ($request->hasFile('photos')) {
            // Hapus foto lama
            foreach ($photos as $oldPhoto) {
                Storage::disk('public')->delete($oldPhoto);
            }

            $photos = [];
            foreach ($request->photos as $photo) {
                $photos[] = $photo->store('products/photos', 'public');
            }
        }

        $data['photos'] = $photos;

        $product->update($data);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Hapus produk.
     */
    public function destroy(Product $product)
    {
        $this->authorizeOwner($product);

        // Hapus foto utama
        if ($product->main_photo) {
            Storage::disk('public')->delete($product->main_photo);
        }

        // Hapus foto tambahan
        if ($product->photos) {
            foreach ($product->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Cek apakah produk milik seller yang sedang login.
     */
    private function authorizeOwner(Product $product)
    {
        if ($product->seller_id !== Auth::user()->id) {
            abort(403, 'Akses ditolak.');
        }
    }
}
