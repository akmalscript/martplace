<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700">Edit Produk</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nama -->
                    <div class="mb-4">
                        <label class="font-semibold">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded p-2" required>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label class="font-semibold">Kategori</label>
                        <select name="category_id" class="w-full border rounded p-2" required>
                            <option value="">Pilih Kategori...</option>
                            @foreach(\App\Models\ProductCategory::all() as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id) == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Harga & Stok -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="font-semibold">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full border rounded p-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="font-semibold">Stok</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border rounded p-2" required>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label class="font-semibold">Deskripsi</label>
                        <textarea name="description" rows="5" class="w-full border rounded p-2" required>{{ old('description', $product->description) }}</textarea>
                    </div>

                    <!-- Berat & Kondisi -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="font-semibold">Berat (gram)</label>
                            <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" class="w-full border rounded p-2" required>
                        </div>

                        <div class="mb-4">
                            <label class="font-semibold">Kondisi</label>
                            <select name="condition" class="w-full border rounded p-2">
                                <option value="new" @selected(old('condition', $product->condition) == 'new')>Baru</option>
                                <option value="used" @selected(old('condition', $product->condition) == 'used')>Bekas</option>
                            </select>
                        </div>
                    </div>

                    <!-- Foto -->
                    <div class="mb-4">
                        <label class="font-semibold">Foto Utama (opsional ganti)</label>
                        <input type="file" name="main_photo" class="w-full border rounded p-2">
                        @if($product->main_photo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$product->main_photo) }}" alt="main" class="w-48 h-32 object-cover rounded">
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="font-semibold">Foto Tambahan (opsional)</label>
                        <input type="file" name="photos[]" multiple class="w-full border rounded p-2">
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">Simpan Perubahan</button>
                        <a href="{{ route('seller.products.index') }}" class="px-4 py-2 bg-slate-100 rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
