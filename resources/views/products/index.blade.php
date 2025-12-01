<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-green-600">
                        MartPlace
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-md mx-8">
                    <form action="{{ route('products.index') }}" method="GET" class="relative w-full">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari produk di MartPlace"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </form>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-600 transition">Beranda</a>
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600 transition">Masuk</a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="text-gray-700 hover:text-green-600 transition">Dashboard</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search Info & Filter -->
        <div class="mb-6">
            @if (request('search'))
                <h1 class="text-2xl font-bold text-gray-800 mb-2">
                    Hasil pencarian untuk "{{ request('search') }}"
                </h1>
                <p class="text-gray-600">Ditemukan {{ $products->total() }} produk</p>
            @else
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Semua Produk</h1>
                <p class="text-gray-600">{{ $products->total() }} produk tersedia</p>
            @endif
        </div>

        <!-- Filter & Sort -->
        <div class="flex flex-wrap items-center justify-between mb-6 gap-4">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'latest'])) }}"
                    class="px-4 py-2 rounded-lg {{ request('sort', 'latest') == 'latest' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    Terbaru
                </a>
                <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'popular'])) }}"
                    class="px-4 py-2 rounded-lg {{ request('sort') == 'popular' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    Terpopuler
                </a>
                <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_asc'])) }}"
                    class="px-4 py-2 rounded-lg {{ request('sort') == 'price_asc' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    Harga Terendah
                </a>
                <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_desc'])) }}"
                    class="px-4 py-2 rounded-lg {{ request('sort') == 'price_desc' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    Harga Tertinggi
                </a>
            </div>
        </div>

        @if ($products->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-4 text-xl font-medium text-gray-900">Produk tidak ditemukan</h3>
                <p class="mt-2 text-gray-500">Coba gunakan kata kunci lain untuk pencarian Anda.</p>
                <div class="mt-6">
                    <a href="{{ route('products.index') }}"
                        class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
                        Lihat Semua Produk
                    </a>
                </div>
            </div>
        @else
            <!-- Products Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
                @foreach ($products as $product)
                    <a href="{{ route('products.show', $product->id) }}"
                        class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden">
                        <div class="relative bg-gray-200">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="w-full h-48 object-cover"
                                onerror="this.onerror=null; this.src='https://placehold.co/200x200/E5E5E5/999999?text=No+Image'"
                                loading="lazy">
                        </div>
                        <div class="p-3">
                            <h3 class="text-sm text-gray-800 mb-2 line-clamp-2">{{ $product->name }}</h3>
                            <div class="flex items-baseline space-x-2 mb-2">
                                <span class="text-lg font-bold text-gray-900">{{ $product->formatted_price }}</span>
                                @if ($product->original_price)
                                    <span
                                        class="text-xs text-gray-400 line-through">{{ $product->formatted_original_price }}</span>
                                @endif
                            </div>
                            <div class="flex items-center space-x-1 mb-2">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <span class="text-xs text-gray-600">{{ number_format($product->average_rating, 1) }} •
                                    {{ number_format($product->sold_count) }} terjual</span>
                            </div>
                            <p class="text-xs text-gray-500">{{ $product->city }}, {{ $product->province }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2025 MartPlace. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
