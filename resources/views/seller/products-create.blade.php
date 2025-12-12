<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Dashboard Seller</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50" x-data="productForm()">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-cyan-400 to-green-300 shadow-lg fixed w-full top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('seller.products') }}" class="text-white hover:text-gray-100">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <span class="text-white">|</span>
                    <a href="{{ route('seller.dashboard') }}" class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-store mr-2"></i>Dashboard Seller
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white font-semibold">
                        <i class="fas fa-user mr-2"></i>{{ $seller->store_name }}
                    </span>
                </div>
            </div>
        </div>
    </nav>

    <div class="pt-20 pb-8 px-4 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Tambah Produk Baru</h1>
                <p class="text-gray-600">Lengkapi semua informasi produk yang akan dijual</p>
            </div>

            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                    <p class="font-semibold">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- 1. Informasi Produk -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-info-circle mr-3"></i>1. Informasi Produk
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Nama Produk -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Produk <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" required maxlength="200"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                   placeholder="Contoh: Laptop Gaming ASUS ROG Strix G15">
                            <p class="text-xs text-gray-500 mt-1">Maksimal 200 karakter</p>
                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Kategori Produk <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('category_id') border-red-500 @enderror">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        <i class="fas {{ $category->icon }}"></i> {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- 2. Media (Visual) -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-camera mr-3"></i>2. Media (Visual)
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Foto Utama -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Foto Produk Utama <span class="text-red-500">*</span>
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-green-500 transition">
                                <input type="file" name="primary_image" required accept="image/jpeg,image/png,image/jpg"
                                       @change="previewImage($event, 'primary')"
                                       class="hidden" id="primary_image">
                                <label for="primary_image" class="cursor-pointer flex flex-col items-center">
                                    <div x-show="!primaryPreview" class="text-center">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                        <p class="text-sm text-gray-600">Klik untuk upload foto utama</p>
                                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Min 300x300px)</p>
                                    </div>
                                    <img x-show="primaryPreview" :src="primaryPreview" class="max-h-48 rounded-lg">
                                </label>
                            </div>
                            @error('primary_image')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Foto Tambahan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Foto Tambahan (Opsional)
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <template x-for="i in 4" :key="i">
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-green-500 transition aspect-square">
                                        <input type="file" :name="'additional_images[' + (i-1) + ']'" accept="image/jpeg,image/png,image/jpg"
                                               @change="previewImage($event, 'additional_' + i)"
                                               class="hidden" :id="'additional_image_' + i">
                                        <label :for="'additional_image_' + i" class="cursor-pointer flex flex-col items-center justify-center h-full">
                                            <div x-show="!additionalPreviews['additional_' + i]" class="text-center">
                                                <i class="fas fa-plus text-2xl text-gray-400 mb-1"></i>
                                                <p class="text-xs text-gray-600">Foto <span x-text="i"></span></p>
                                            </div>
                                            <img x-show="additionalPreviews['additional_' + i]" :src="additionalPreviews['additional_' + i]" class="max-h-full rounded">
                                        </label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Detail Produk -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-align-left mr-3"></i>3. Detail Produk
                        </h2>
                    </div>
                    <div class="p-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi Produk <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" required rows="8"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                  placeholder="Jelaskan detail produk, spesifikasi, kondisi, dan informasi penting lainnya...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- 4. Harga & Stok -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-tags mr-3"></i>4. Harga & Stok
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Harga -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Harga Satuan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3 text-gray-600">Rp</span>
                                    <input type="number" name="price" value="{{ old('price') }}" min="0"
                                           required
                                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                           placeholder="50000">
                                </div>
                            </div>

                            <!-- Stok -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Stok Awal <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="stock" value="{{ old('stock') }}" min="0"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                       placeholder="100">
                            </div>
                        </div>

                        <!-- Min/Max Order -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Minimum Pemesanan</label>
                                <input type="number" name="min_order" value="{{ old('min_order', 1) }}" min="1"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Maximum Pemesanan (Opsional)</label>
                                <input type="number" name="max_order" value="{{ old('max_order') }}" min="1"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5. Pengelolaan Stok -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-warehouse mr-3"></i>5. Pengelolaan Stok
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-semibold text-gray-900">Status Produk</p>
                                <p class="text-sm text-gray-600">Aktifkan produk agar dapat dilihat pembeli</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                                <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 justify-end">
                    <a href="{{ route('seller.products') }}" 
                       class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                        <i class="fas fa-save mr-2"></i>Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function productForm() {
            return {
                primaryPreview: null,
                additionalPreviews: {},

                previewImage(event, type) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            if (type === 'primary') {
                                this.primaryPreview = e.target.result;
                            } else {
                                this.additionalPreviews[type] = e.target.result;
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }
        }
    </script>
</body>
</html>
