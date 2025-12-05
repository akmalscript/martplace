<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Produk - MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-8px);
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navigation Bar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50 border-b-2 border-cyan-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-400 to-green-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-store text-white text-2xl"></i>
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-cyan-600 to-green-600 bg-clip-text text-transparent">MartPlace</span>
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-2xl mx-8">
                    <form action="{{ route('products.index') }}" method="GET" class="w-full">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari produk yang Anda inginkan..." 
                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-full focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-200 transition-all duration-300">
                            <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-cyan-600 transition-colors">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-gradient-to-r from-cyan-500 to-green-500 text-white font-semibold rounded-full hover:shadow-xl hover:scale-105 transition-all duration-300">
                            <i class="fas fa-user mr-2"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2.5 text-gray-700 font-semibold hover:text-cyan-600 transition-colors duration-300">
                            <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-gradient-to-r from-cyan-500 to-green-500 text-white font-semibold rounded-full hover:shadow-xl hover:scale-105 transition-all duration-300">
                            <i class="fas fa-user-plus mr-2"></i>Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-cyan-500 to-green-500 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Semua Produk</h1>
                <p class="text-cyan-50 text-lg">Temukan produk terbaik untuk kebutuhan Anda</p>
            </div>
        </div>
    </section>

    <!-- Filters & Products Section -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Sidebar Filters -->
                <div class="lg:w-64 flex-shrink-0">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-filter text-cyan-600 mr-3"></i>Filter
                        </h3>

                        <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                            <!-- Search (mobile) -->
                            <div class="md:hidden mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Pencarian</label>
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Cari produk..." 
                                       class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-cyan-400">
                            </div>

                            <!-- Category Filter -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Kategori</label>
                                <div class="space-y-2">
                                    <label class="flex items-center cursor-pointer hover:bg-gray-50 p-2 rounded-lg transition-colors">
                                        <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} 
                                               onchange="document.getElementById('filterForm').submit()"
                                               class="w-4 h-4 text-cyan-600 focus:ring-cyan-500">
                                        <span class="ml-3 text-gray-700">Semua Kategori</span>
                                    </label>
                                    @foreach($categories as $category)
                                    <label class="flex items-center cursor-pointer hover:bg-gray-50 p-2 rounded-lg transition-colors">
                                        <input type="radio" name="category" value="{{ $category->id }}" 
                                               {{ request('category') == $category->id ? 'checked' : '' }}
                                               onchange="document.getElementById('filterForm').submit()"
                                               class="w-4 h-4 text-cyan-600 focus:ring-cyan-500">
                                        <span class="ml-3 text-gray-700">{{ $category->name }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Sort Filter -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Urutkan</label>
                                <select name="sort" 
                                        onchange="document.getElementById('filterForm').submit()"
                                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-cyan-400 cursor-pointer">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                                </select>
                            </div>

                            <!-- Reset Button -->
                            <a href="{{ route('products.index') }}" 
                               class="block w-full text-center px-4 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors duration-300">
                                <i class="fas fa-redo mr-2"></i>Reset Filter
                            </a>
                        </form>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="flex-1">
                    <!-- Results Info -->
                    <div class="mb-8 flex justify-between items-center">
                        <div>
                            <p class="text-gray-600">
                                Menampilkan 
                                <span class="font-bold text-cyan-600">{{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }}</span> 
                                dari 
                                <span class="font-bold text-cyan-600">{{ $products->total() }}</span> 
                                produk
                            </p>
                        </div>
                    </div>

                    @if($products->count() > 0)
                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                        @foreach($products as $product)
                        <a href="{{ route('products.show', $product->id) }}"
                            class="product-card bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all overflow-hidden border-2 border-transparent hover:border-cyan-200 group">
                            <div class="relative bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                    class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500"
                                    onerror="this.onerror=null; this.src='https://placehold.co/400x400/E5E5E5/999999?text=No+Image'"
                                    loading="lazy">
                            </div>
                            <div class="p-5">
                                <h3 class="text-base font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:from-cyan-600 group-hover:to-green-600 group-hover:bg-clip-text transition-all">{{ $product->name }}</h3>
                                <div class="flex items-baseline space-x-2 mb-4">
                                    <span class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">{{ $product->formatted_price }}</span>
                                </div>
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center bg-gradient-to-r from-yellow-50 to-orange-50 px-3 py-1.5 rounded-lg">
                                        <i class="fas fa-star text-yellow-500 text-sm mr-1"></i>
                                        <span class="text-sm font-bold text-gray-800">{{ number_format($product->average_rating, 1) }}</span>
                                    </div>
                                    <span class="text-sm text-gray-500">({{ $product->total_reviews }} ulasan)</span>
                                </div>
                                <div class="flex items-center text-gray-600 text-sm mb-2">
                                    <i class="fas fa-store mr-2 text-cyan-600"></i>
                                    <span class="truncate">{{ $product->seller->store_name ?? 'Toko' }}</span>
                                </div>
                                <div class="flex items-center text-gray-600 text-sm">
                                    <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>
                                    <span class="truncate">{{ $product->seller->city ?? 'Indonesia' }}</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $products->links('pagination::tailwind') }}
                    </div>
                    @else
                    <!-- No Products Found -->
                    <div class="text-center py-16">
                        <div class="inline-block w-32 h-32 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-box-open text-gray-400 text-5xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-3">Produk Tidak Ditemukan</h3>
                        <p class="text-gray-500 mb-6">Maaf, tidak ada produk yang sesuai dengan pencarian Anda</p>
                        <a href="{{ route('products.index') }}" 
                           class="inline-block px-8 py-3 bg-gradient-to-r from-cyan-500 to-green-500 text-white font-semibold rounded-full hover:shadow-xl hover:scale-105 transition-all duration-300">
                            <i class="fas fa-redo mr-2"></i>Lihat Semua Produk
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- About -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-cyan-400 to-green-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-store text-white text-lg"></i>
                        </div>
                        <span class="text-xl font-bold">MartPlace</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Platform marketplace terpercaya untuk pengalaman belanja online terbaik Anda.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-cyan-400 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-cyan-400 transition-colors">Produk</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors">Kategori</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors">Tentang Kami</a></li>
                    </ul>
                </div>

                <!-- Customer Service -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Layanan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors">Bantuan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <!-- Contact & Social -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3 mb-4">
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-envelope mr-3 text-cyan-400"></i>
                            <span class="text-sm">info@martplace.com</span>
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-phone mr-3 text-cyan-400"></i>
                            <span class="text-sm">+62 812-3456-7890</span>
                        </li>
                    </ul>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-gradient-to-r hover:from-cyan-500 hover:to-green-500 transition-all duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-gradient-to-r hover:from-cyan-500 hover:to-green-500 transition-all duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-gradient-to-r hover:from-cyan-500 hover:to-green-500 transition-all duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm mb-4 md:mb-0">
                    &copy; 2024 MartPlace. All rights reserved.
                </p>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-shield-check text-cyan-400"></i>
                    <span class="text-gray-400 text-sm">Platform Aman & Terpercaya</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
