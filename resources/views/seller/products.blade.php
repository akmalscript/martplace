<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Saya - Dashboard Seller</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: false }">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-cyan-400 to-green-300 shadow-lg fixed w-full top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-white lg:hidden">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                    <a href="{{ route('seller.dashboard') }}" class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-store mr-2"></i>Dashboard Seller
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white font-semibold">
                        <i class="fas fa-user mr-2"></i>{{ $seller->store_name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white hover:text-gray-200">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex pt-16">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg min-h-screen fixed lg:static transition-all duration-300"
               :class="sidebarOpen ? 'left-0' : '-left-64 lg:left-0'">
            <nav class="p-6 space-y-2">
                <a href="{{ route('seller.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-chart-line w-5"></i>
                    <span>Dashboard Seller</span>
                </a>
                <a href="{{ route('seller.products') }}" class="flex items-center space-x-3 p-3 rounded-lg bg-green-50 text-green-600 font-semibold">
                    <i class="fas fa-box w-5"></i>
                    <span>Kelola Produk</span>
                </a>
                <a href="{{ route('seller.reports') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-file-alt w-5"></i>
                    <span>Laporan Seller</span>
                </a>
                <hr class="my-4">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-globe w-5"></i>
                    <span>Lihat Website</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 lg:p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Produk Saya</h1>
                <p class="text-gray-600">Kelola semua produk yang Anda jual</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Total Produk</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalProducts }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-4">
                            <i class="fas fa-box text-blue-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Total Stok</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalStock) }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-4">
                            <i class="fas fa-warehouse text-purple-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Produk Aktif</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $activeProducts }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-4">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Produk Nonaktif</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $inactiveProducts }}</p>
                        </div>
                        <div class="bg-red-100 rounded-full p-4">
                            <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="bg-white rounded-xl shadow-md p-4 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex-1 w-full md:w-auto">
                    <div class="relative">
                        <input type="text" placeholder="Cari produk..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    <a href="{{ route('seller.products.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition inline-block">
                        <i class="fas fa-plus mr-2"></i>Tambah Produk
                    </a>
                </div>
            </div>

            @if($products->isEmpty())
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-md p-12 text-center">
                    <div class="mb-6">
                        <i class="fas fa-box-open text-gray-300 text-6xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Produk</h3>
                    <p class="text-gray-600 mb-6">Mulai tambahkan produk untuk dijual di toko Anda</p>
                    <a href="{{ route('seller.products.create') }}" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-plus mr-2"></i>Tambah Produk Pertama
                    </a>
                </div>
            @else
                <!-- Products Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                        <!-- Product Image -->
                        <div class="relative aspect-square overflow-hidden bg-gray-100">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover">
                            
                            <!-- Status Badge -->
                            <div class="absolute bottom-2 left-2">
                                @if($product->is_active)
                                <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i>Aktif
                                </span>
                                @else
                                <span class="bg-gray-500 text-white px-2 py-1 rounded text-xs font-semibold">
                                    <i class="fas fa-times-circle mr-1"></i>Nonaktif
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-4">
                            <h3 class="text-sm font-semibold text-gray-900 mb-2 line-clamp-2 h-10">
                                {{ $product->name }}
                            </h3>

                            <!-- Price -->
                            <div class="mb-3">
                                @if($product->has_variants && $product->variants->isNotEmpty())
                                    @php
                                        $minPrice = $product->variants->min('price');
                                        $maxPrice = $product->variants->max('price');
                                    @endphp
                                    <div class="text-lg font-bold text-green-600">
                                        @if($minPrice == $maxPrice)
                                            Rp{{ number_format($minPrice, 0, ',', '.') }}
                                        @else
                                            Rp{{ number_format($minPrice, 0, ',', '.') }} - Rp{{ number_format($maxPrice, 0, ',', '.') }}
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">{{ $product->variants->count() }} varian</p>
                                @else
                                    <div class="text-lg font-bold text-green-600">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center text-xs text-gray-600 mb-3">
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    <span>{{ number_format($product->average_rating, 1) }}</span>
                                </div>
                            </div>

                            <!-- Stock -->
                            <div class="mb-3 pb-3 border-b border-gray-200">
                                @if($product->has_variants && $product->variants->isNotEmpty())
                                    @php
                                        $totalStock = $product->variants->sum('stock');
                                    @endphp
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">Total Stok:</span>
                                        <span class="font-semibold {{ $totalStock > 10 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $totalStock }} unit
                                        </span>
                                    </div>
                                @else
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">Stok:</span>
                                        <span class="font-semibold {{ $product->stock > 10 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $product->stock }} unit
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <a href="{{ route('seller.products.edit', $product->id) }}" class="flex-1 bg-blue-50 text-blue-600 py-2 rounded-lg hover:bg-blue-100 transition text-sm font-semibold text-center">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                                <form action="{{ route('seller.products.delete', $product->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-50 text-red-600 py-2 rounded-lg hover:bg-red-100 transition text-sm font-semibold">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </main>
    </div>

    <!-- Overlay untuk mobile -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
         x-cloak></div>

    <style>
        [x-cloak] { display: none !important; }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</body>
</html>
