<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - Admin MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50" x-data="{ showDeleteModal: false }">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-cyan-400 to-green-300 shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.products.index') }}" class="text-white hover:text-gray-100">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <span class="text-white">|</span>
                    <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-white">
                        <i class="fas fa-store mr-2"></i>MartPlace Admin
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white font-semibold">
                        <i class="fas fa-user-shield mr-2"></i>{{ Auth::user()->name }}
                    </span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mx-auto px-6 py-8">
        <!-- Header with Status -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
                    <p class="text-gray-600">ID Produk: {{ $product->id }} | Ditambahkan: {{ $product->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
                <div class="flex items-center gap-3">
                    @if($product->is_active)
                    <span class="px-6 py-3 inline-flex text-base leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-2"></i> Aktif
                    </span>
                    @else
                    <span class="px-6 py-3 inline-flex text-base leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        <i class="fas fa-ban mr-2"></i> Disuspend
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-xl"></i>
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Product Info -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-box mr-3"></i>Informasi Produk
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Produk</label>
                                <p class="text-gray-900 text-lg">{{ $product->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Slug</label>
                                <p class="text-gray-900">{{ $product->slug }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Deskripsi</label>
                            <p class="text-gray-900">{{ $product->description ?? 'Tidak ada deskripsi' }}</p>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Kategori</label>
                                <span class="px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded-full">
                                    {{ $product->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Harga</label>
                                <p class="text-gray-900 text-xl font-bold text-green-600">{{ $product->formatted_price }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Stok</label>
                                <p class="text-gray-900 text-lg">{{ number_format($product->stock) }} unit</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales & Rating Info -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-chart-bar mr-3"></i>Statistik Penjualan
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center p-4 bg-blue-50 rounded-lg">
                                <p class="text-2xl font-bold text-blue-600">{{ number_format($product->sold_count) }}</p>
                                <p class="text-sm text-gray-600">Terjual</p>
                            </div>
                            <div class="text-center p-4 bg-yellow-50 rounded-lg">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    <p class="text-2xl font-bold text-yellow-600">{{ number_format($product->average_rating, 1) }}</p>
                                </div>
                                <p class="text-sm text-gray-600">Rating</p>
                            </div>
                            <div class="text-center p-4 bg-green-50 rounded-lg">
                                <p class="text-2xl font-bold text-green-600">{{ number_format($product->total_reviews) }}</p>
                                <p class="text-sm text-gray-600">Ulasan</p>
                            </div>
                            <div class="text-center p-4 bg-purple-50 rounded-lg">
                                <p class="text-2xl font-bold text-purple-600">{{ $product->min_order ?? 1 }} - {{ $product->max_order ?? '∞' }}</p>
                                <p class="text-sm text-gray-600">Min/Max Order</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seller Info -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-store mr-3"></i>Informasi Toko
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        @if($product->seller)
                        <div class="flex items-center">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-cyan-400 to-green-300 flex items-center justify-center text-white font-bold text-xl">
                                {{ strtoupper(substr($product->seller->store_name, 0, 2)) }}
                            </div>
                            <div class="ml-4">
                                <p class="text-lg font-semibold text-gray-900">{{ $product->seller->store_name }}</p>
                                <p class="text-gray-600">{{ $product->seller->pic_email }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">PIC</label>
                                <p class="text-gray-900">{{ $product->seller->pic_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Telepon</label>
                                <p class="text-gray-900">{{ $product->seller->pic_phone }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Lokasi</label>
                            <p class="text-gray-900">{{ $product->seller->pic_city }}, {{ $product->seller->pic_province }}</p>
                        </div>
                        @else
                        <p class="text-gray-500">Informasi toko tidak tersedia</p>
                        @endif
                    </div>
                </div>

                <!-- Location Info -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-map-marker-alt mr-3"></i>Lokasi Produk
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Provinsi</label>
                                <p class="text-gray-900">{{ $product->province ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Kota</label>
                                <p class="text-gray-900">{{ $product->city ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Product Image -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">
                            <i class="fas fa-image mr-2"></i>Gambar Produk
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full rounded-lg shadow">
                        @else
                        <div class="bg-gray-100 rounded-lg h-64 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-6xl"></i>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Additional Images -->
                @if($product->images && $product->images->count() > 0)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">
                            <i class="fas fa-images mr-2"></i>Galeri ({{ $product->images->count() }})
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-3 gap-2">
                            @foreach($product->images as $image)
                            <img src="{{ $image->image_url }}" alt="Product image" class="w-full h-20 object-cover rounded">
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Variants -->
                @if($product->variants && $product->variants->count() > 0)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">
                            <i class="fas fa-layer-group mr-2"></i>Varian ({{ $product->variants->count() }})
                        </h3>
                    </div>
                    <div class="p-6 space-y-2">
                        @foreach($product->variants as $variant)
                        <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                            <span class="text-sm text-gray-700">{{ $variant->name }}</span>
                            <span class="text-sm font-semibold text-gray-900">Rp{{ number_format($variant->price, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6 space-y-3">
                        @if($product->is_active)
                        <form action="{{ route('admin.products.suspend', $product->id) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-lg flex items-center justify-center">
                                <i class="fas fa-pause-circle mr-2"></i>Suspend Produk
                            </button>
                        </form>
                        @else
                        <form action="{{ route('admin.products.activate', $product->id) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-lg flex items-center justify-center">
                                <i class="fas fa-play-circle mr-2"></i>Aktifkan Produk
                            </button>
                        </form>
                        @endif

                        <button @click="showDeleteModal = true" type="button" class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-lg flex items-center justify-center">
                            <i class="fas fa-trash mr-2"></i>Hapus Produk
                        </button>

                        <a href="{{ route('products.show', $product->id) }}" target="_blank" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-lg flex items-center justify-center">
                            <i class="fas fa-external-link-alt mr-2"></i>Lihat di Website
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="showDeleteModal" 
         x-cloak
         @keydown.escape.window="showDeleteModal = false"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="showDeleteModal = false"></div>
        
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full p-6" @click.away="showDeleteModal = false">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>Hapus Produk
                    </h3>
                    <button @click="showDeleteModal = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>

                <div class="mb-6">
                    <p class="text-gray-600 mb-4">
                        Apakah Anda yakin ingin menghapus produk <strong>{{ $product->name }}</strong>?
                    </p>
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Tindakan ini tidak dapat dibatalkan. Semua data produk akan dihapus secara permanen.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <button 
                        type="button" 
                        @click="showDeleteModal = false"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg transition">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit"
                            class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                            <i class="fas fa-trash mr-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>
