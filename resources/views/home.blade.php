<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MartPlace - Marketplace Terpercaya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.95); opacity: 1; }
            50% { transform: scale(1); opacity: 0.7; }
            100% { transform: scale(0.95); opacity: 1; }
        }

        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .icon-float {
            animation: float 3s ease-in-out infinite;
        }

        .pulse-ring {
            animation: pulse-ring 2s ease-in-out infinite;
        }

        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }

        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-8px);
        }

        .category-card {
            transition: all 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-5px) scale(1.02);
        }

        .btn-glow {
            position: relative;
            overflow: hidden;
        }

        .btn-glow::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: 0.5s;
        }

        .btn-glow:hover::before {
            left: 100%;
        }
    </style>
</head>

@php
    $isSeller =
        Auth::check() && Auth::user()->seller && Auth::user()->seller->status === \App\Enums\SellerStatus::ACTIVE;
@endphp

<body class="bg-gray-50" x-data="{ sidebarOpen: false }">
    @if ($isSeller)
        <!-- Seller Navbar -->
        <nav class="bg-gradient-to-r from-cyan-400 to-green-300 shadow-lg fixed top-0 left-0 right-0 z-50">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-white lg:hidden">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-white flex items-center">
                            <i class="fas fa-store mr-2"></i>MartPlace
                        </a>
                    </div>
                    <div class="flex items-center space-x-6">
                        <span class="text-white font-semibold hidden md:block">
                            <i class="fas fa-user mr-2"></i>{{ Auth::user()->seller->store_name }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-white hover:text-gray-100 transition">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Seller Sidebar -->
        <aside class="fixed top-16 left-0 h-full bg-white shadow-lg transition-transform duration-300 z-40 w-64"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
            <div class="p-6">
                <nav class="space-y-2">
                    <a href="{{ route('seller.dashboard') }}"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                        <i class="fas fa-chart-line mr-3 w-5"></i>Dashboard Seller
                    </a>
                    <a href="{{ route('seller.products') }}"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                        <i class="fas fa-box mr-3 w-5"></i>Kelola Produk
                    </a>
                    <a href="{{ route('seller.reports') }}"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                        <i class="fas fa-file-alt mr-3 w-5"></i>Laporan Seller
                    </a>
                    <hr class="my-4">
                    <a href="{{ route('home') }}"
                        class="flex items-center px-4 py-3 text-green-600 bg-green-50 rounded-lg font-semibold">
                        <i class="fas fa-globe mr-3 w-5"></i>Lihat Website
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content with Sidebar Offset -->
        <main class="lg:ml-64 pt-16">
        @else
            <!-- Regular Navbar -->
            <nav class="bg-white shadow-lg sticky top-0 z-50 border-b-2 border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-20">
                        <!-- Logo -->
                        <div class="flex items-center">
                            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                                <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-green-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <i class="fas fa-store text-white text-xl"></i>
                                </div>
                                <span class="text-2xl font-bold bg-gradient-to-r from-cyan-600 to-green-600 bg-clip-text text-transparent">MartPlace</span>
                            </a>
                        </div>

                        <!-- Search Bar -->
                        <div class="hidden md:flex flex-1 max-w-md mx-8" x-data="{
                            search: '',
                            products: [],
                            sellers: [],
                            categories: [],
                            locations: [],
                            activeTab: 'products',
                            showSuggestions: false,
                            loading: false,
                            getSuggestions() {
                                if (this.search.length < 2) {
                                    this.products = [];
                                    this.sellers = [];
                                    this.categories = [];
                                    this.locations = [];
                                    this.showSuggestions = false;
                                    return;
                                }

                                this.loading = true;
                                fetch(`/products/search?q=${encodeURIComponent(this.search)}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        this.products = data.products || [];
                                        this.sellers = data.sellers || [];
                                        this.categories = data.categories || [];
                                        this.locations = data.locations || [];
                                        this.showSuggestions = (this.products.length > 0 || this.sellers.length > 0 || this.categories.length > 0 || this.locations.length > 0);
                                        this.loading = false;
                                    });
                            },
                            selectProduct(productId) {
                                window.location.href = `/products/${productId}`;
                            },
                            selectSeller(sellerId) {
                                window.location.href = `/sellers/${sellerId}`;
                            },
                            selectCategory(categoryId) {
                                window.location.href = `/?category=${categoryId}`;
                            },
                            selectLocation(location) {
                                window.location.href = `/products?search=${encodeURIComponent(location)}`;
                            },
                            submitSearch() {
                                if (this.search.trim()) {
                                    window.location.href = `/products?search=${encodeURIComponent(this.search)}`;
                                }
                            },
                            formatPrice(price) {
                                return 'Rp' + Number(price).toLocaleString('id-ID');
                            }
                        }">
                            <form @submit.prevent="submitSearch" class="relative w-full"
                                @click.away="showSuggestions = false">
                                <input type="text" x-model="search" @input.debounce.300ms="getSuggestions"
                                    @focus="showSuggestions = (products.length > 0 || sellers.length > 0 || categories.length > 0 || locations.length > 0)"
                                    placeholder="Cari produk, toko, kategori, atau lokasi..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>

                                <!-- Search Suggestions Dropdown with Tabs -->
                                <div x-show="showSuggestions || loading" x-transition @click.stop
                                    class="absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-xl border border-gray-200 z-50 max-h-96 overflow-hidden">
                                    <template x-if="loading">
                                        <div class="p-6 text-center text-gray-500">
                                            <svg class="animate-spin h-5 w-5 mx-auto mb-2 text-green-600"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            Mencari...
                                        </div>
                                    </template>
                                    <template
                                        x-if="!loading && (products.length > 0 || sellers.length > 0 || categories.length > 0 || locations.length > 0)">
                                        <div>
                                            <!-- Tabs -->
                                            <div class="flex border-b bg-gray-50">
                                                <button type="button" @click="activeTab = 'products'"
                                                    :class="activeTab === 'products' ?
                                                        'border-b-2 border-green-600 text-green-600' :
                                                        'text-gray-600'"
                                                    class="flex-1 px-3 py-3 text-xs font-medium hover:text-green-600 transition">
                                                    Produk (<span x-text="products.length"></span>)
                                                </button>
                                                <button type="button" @click="activeTab = 'sellers'"
                                                    :class="activeTab === 'sellers' ?
                                                        'border-b-2 border-green-600 text-green-600' :
                                                        'text-gray-600'"
                                                    class="flex-1 px-3 py-3 text-xs font-medium hover:text-green-600 transition">
                                                    Toko (<span x-text="sellers.length"></span>)
                                                </button>
                                                <button type="button" @click="activeTab = 'categories'"
                                                    :class="activeTab === 'categories' ?
                                                        'border-b-2 border-green-600 text-green-600' :
                                                        'text-gray-600'"
                                                    class="flex-1 px-3 py-3 text-xs font-medium hover:text-green-600 transition">
                                                    Kategori (<span x-text="categories.length"></span>)
                                                </button>
                                                <button type="button" @click="activeTab = 'locations'"
                                                    :class="activeTab === 'locations' ?
                                                        'border-b-2 border-green-600 text-green-600' :
                                                        'text-gray-600'"
                                                    class="flex-1 px-3 py-3 text-xs font-medium hover:text-green-600 transition">
                                                    Lokasi (<span x-text="locations.length"></span>)
                                                </button>
                                            </div>

                                            <!-- Tab Content -->
                                            <div class="max-h-80 overflow-y-auto">
                                                <!-- Products Tab -->
                                                <div x-show="activeTab === 'products'" class="divide-y">
                                                    <template x-for="product in products" :key="product.id">
                                                        <button type="button" @click="selectProduct(product.id)"
                                                            class="w-full text-left px-4 py-3 hover:bg-gray-50 flex items-center gap-3 transition">
                                                            <img :src="product.image_url" :alt="product.name"
                                                                class="w-12 h-12 object-cover rounded">
                                                            <div class="flex-1 min-w-0">
                                                                <p class="text-sm font-medium text-gray-900 truncate"
                                                                    x-text="product.name"></p>
                                                                <p class="text-sm text-green-600 font-semibold"
                                                                    x-text="formatPrice(product.price)"></p>
                                                            </div>
                                                            <svg class="w-5 h-5 text-gray-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                            </svg>
                                                        </button>
                                                    </template>
                                                </div>

                                                <!-- Sellers Tab -->
                                                <div x-show="activeTab === 'sellers'" class="divide-y">
                                                    <template x-for="seller in sellers" :key="seller.id">
                                                        <button type="button" @click="selectSeller(seller.id)"
                                                            class="w-full text-left px-4 py-3 hover:bg-gray-50 flex items-center gap-3 transition">
                                                            <div
                                                                class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                                                <svg class="w-6 h-6 text-green-600"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd"
                                                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                            </div>
                                                            <div class="flex-1 min-w-0">
                                                                <p class="text-sm font-medium text-gray-900 truncate"
                                                                    x-text="seller.store_name"></p>
                                                                <p class="text-xs text-gray-500"
                                                                    x-text="`${seller.city}, ${seller.province}`"></p>
                                                                <div class="flex items-center gap-2 mt-1">
                                                                    <span class="text-xs text-yellow-600">★ <span
                                                                            x-text="seller.rating"></span></span>
                                                                    <span class="text-xs text-gray-400">•</span>
                                                                    <span class="text-xs text-gray-500"
                                                                        x-text="`${seller.total_products} produk`"></span>
                                                                </div>
                                                            </div>
                                                            <svg class="w-5 h-5 text-gray-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                            </svg>
                                                        </button>
                                                    </template>
                                                </div>

                                                <!-- Categories Tab -->
                                                <div x-show="activeTab === 'categories'" class="divide-y">
                                                    <template x-for="category in categories" :key="category.id">
                                                        <button type="button" @click="selectCategory(category.id)"
                                                            class="w-full text-left px-4 py-3 hover:bg-gray-50 flex items-center gap-3 transition">
                                                            <div
                                                                class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                                                <i
                                                                    :class="'fas ' + category.icon + ' text-purple-600'"></i>
                                                            </div>
                                                            <div class="flex-1">
                                                                <p class="text-sm font-medium text-gray-900"
                                                                    x-text="category.name"></p>
                                                                <p class="text-xs text-gray-500">Kategori Produk</p>
                                                            </div>
                                                            <svg class="w-5 h-5 text-gray-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                            </svg>
                                                        </button>
                                                    </template>
                                                </div>

                                                <!-- Locations Tab -->
                                                <div x-show="activeTab === 'locations'" class="divide-y">
                                                    <template x-for="location in locations" :key="location.name">
                                                        <button type="button" @click="selectLocation(location.name)"
                                                            class="w-full text-left px-4 py-3 hover:bg-gray-50 flex items-center gap-3 transition">
                                                            <div
                                                                class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                                                <svg class="w-6 h-6 text-blue-600" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd"
                                                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                            </div>
                                                            <div class="flex-1">
                                                                <p class="text-sm font-medium text-gray-900"
                                                                    x-text="location.name"></p>
                                                                <p class="text-xs text-gray-500"
                                                                    x-text="location.type === 'city' ? 'Kota/Kabupaten' : 'Provinsi'">
                                                                </p>
                                                            </div>
                                                            <svg class="w-5 h-5 text-gray-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                            </svg>
                                                        </button>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </form>
                        </div>

                        <!-- Right Side Buttons -->
                        <div class="flex items-center space-x-4">

                            @guest
                                <!-- Login Button -->
                                <a href="{{ route('login') }}" class="btn-glow text-gray-700 hover:text-cyan-600 transition font-semibold flex items-center">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                                </a>

                                <!-- Register Seller Button -->
                                <a href="{{ route('sellers.create') }}"
                                    class="btn-glow bg-gradient-to-r from-cyan-500 to-green-500 text-white px-6 py-3 rounded-xl hover:shadow-xl transition-all font-bold">
                                    <i class="fas fa-store mr-2"></i>Daftar Toko
                                </a>
                            @else
                                <!-- User Dropdown -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open"
                                        class="flex items-center space-x-2 text-gray-700 hover:text-green-600 transition">
                                        <span>Hai, {{ Auth::user()->name }}</span>
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    <div x-show="open" @click.away="open = false" x-transition
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                                        <a href="{{ route('dashboard') }}"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                        <a href="{{ route('profile.edit') }}"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profil</a>
                                        <hr class="my-2">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                                Keluar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </nav>

            <main>
    @endif

    <!-- Hero Banner -->
    <section class="bg-gradient-to-r from-cyan-400 via-cyan-500 to-green-400 py-20 relative overflow-hidden gradient-animate">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-12">
                <div class="md:w-1/2 text-white mb-8 md:mb-0">
                    <div class="inline-block bg-white bg-opacity-20 backdrop-blur-sm px-4 py-2 rounded-full mb-6 animate-pulse">
                        <span class="text-sm font-semibold">🎉 Platform Terpercaya</span>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                        Belanja <span class="text-yellow-300">Hemat</span><br>
                        & Terpercaya
                    </h1>
                    <p class="text-xl mb-8 text-white text-opacity-90">Temukan ribuan produk berkualitas dari seller terbaik dengan harga yang kompetitif!</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#products"
                            class="btn-glow inline-flex items-center bg-white text-cyan-600 px-8 py-4 rounded-xl font-bold hover:shadow-2xl transition-all shadow-lg">
                            <i class="fas fa-shopping-bag mr-2"></i>Mulai Belanja
                        </a>
                        <a href="{{ route('sellers.create') }}"
                            class="btn-glow inline-flex items-center bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-bold hover:bg-white hover:text-cyan-600 transition-all">
                            <i class="fas fa-store mr-2"></i>Daftar Toko
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12">
                        <div class="text-center">
                            <div class="text-3xl font-bold mb-1">{{ number_format($products->count()) }}+</div>
                            <div class="text-sm text-white text-opacity-80">Produk</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold mb-1">{{ $categories->count() }}+</div>
                            <div class="text-sm text-white text-opacity-80">Kategori</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold mb-1">100%</div>
                            <div class="text-sm text-white text-opacity-80">Terpercaya</div>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-cyan-400 opacity-20 rounded-full blur-3xl pulse-ring"></div>
                        <div class="relative bg-gradient-to-br from-white/30 to-white/10 backdrop-blur-xl rounded-3xl p-8 border-2 border-white/40 shadow-2xl">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gradient-to-br from-white/40 to-white/20 backdrop-blur-md rounded-2xl p-6 icon-float shadow-lg border border-white/30">
                                    <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center mb-3 shadow-lg">
                                        <i class="fas fa-truck text-3xl text-cyan-600"></i>
                                    </div>
                                    <p class="text-white text-sm font-bold drop-shadow-lg">Pengiriman Cepat</p>
                                </div>
                                <div class="bg-gradient-to-br from-white/40 to-white/20 backdrop-blur-md rounded-2xl p-6 icon-float shadow-lg border border-white/30" style="animation-delay: 0.5s">
                                    <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center mb-3 shadow-lg">
                                        <i class="fas fa-shield-alt text-3xl text-green-600"></i>
                                    </div>
                                    <p class="text-white text-sm font-bold drop-shadow-lg">Pembayaran Aman</p>
                                </div>
                                <div class="bg-gradient-to-br from-white/40 to-white/20 backdrop-blur-md rounded-2xl p-6 icon-float shadow-lg border border-white/30" style="animation-delay: 1s">
                                    <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center mb-3 shadow-lg">
                                        <i class="fas fa-star text-3xl text-yellow-500"></i>
                                    </div>
                                    <p class="text-white text-sm font-bold drop-shadow-lg">Produk Berkualitas</p>
                                </div>
                                <div class="bg-gradient-to-br from-white/40 to-white/20 backdrop-blur-md rounded-2xl p-6 icon-float shadow-lg border border-white/30" style="animation-delay: 1.5s">
                                    <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center mb-3 shadow-lg">
                                        <i class="fas fa-headset text-3xl text-purple-600"></i>
                                    </div>
                                    <p class="text-white text-sm font-bold drop-shadow-lg">Support 24/7</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Section - Horizontal Scroll -->
    <section class="py-20 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 left-0 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float"></div>
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30" style="animation: float 4s ease-in-out infinite;"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="mb-12">
                <div class="inline-block mb-3">
                    <span class="bg-gradient-to-r from-purple-500 to-pink-500 text-white px-4 py-1.5 rounded-full text-sm font-semibold shadow-lg">
                        <i class="fas fa-tags mr-2"></i>Jelajahi Kategori
                    </span>
                </div>
                <h2 class="text-3xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 via-pink-600 to-rose-600 bg-clip-text text-transparent mb-3 leading-tight">Kategori Pilihan</h2>
                <p class="text-gray-700 text-lg">Temukan produk berdasarkan kategori favorit Anda</p>
            </div>
        </div>

        <div class="relative px-5 max-w-7xl mx-auto" x-data="{
            scrollContainer: null,
            canScrollLeft: false,
            canScrollRight: true,
            init() {
                this.scrollContainer = this.$refs.categoryScroll;
                this.checkScroll();
                this.scrollContainer.addEventListener('scroll', () => this.checkScroll());
                window.addEventListener('resize', () => this.checkScroll());
            },
            checkScroll() {
                if (!this.scrollContainer) return;
                this.canScrollLeft = this.scrollContainer.scrollLeft > 0;
                this.canScrollRight = this.scrollContainer.scrollLeft < (this.scrollContainer.scrollWidth - this.scrollContainer.clientWidth - 10);
            },
            scrollTo(direction) {
                const scrollAmount = 320;
                const currentScroll = this.scrollContainer.scrollLeft;
                const targetScroll = direction === 'left' ? currentScroll - scrollAmount : currentScroll + scrollAmount;
                this.scrollContainer.scrollTo({
                    left: targetScroll,
                    behavior: 'smooth'
                });
            }
        }">
            <!-- Left Arrow Button -->
            <button x-show="canScrollLeft" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-2"
                @click="scrollTo('left')"
                class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 md:w-12 md:h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-700 hover:bg-gray-50 hover:shadow-xl hover:scale-105 active:scale-95 transition-all duration-200 border border-gray-100">
                <i class="fas fa-chevron-left text-sm md:text-base"></i>
            </button>

            <!-- Right Arrow Button -->
            <button x-show="canScrollRight" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-x-2" x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-2"
                @click="scrollTo('right')"
                class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 md:w-12 md:h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-700 hover:bg-gray-50 hover:shadow-xl hover:scale-105 active:scale-95 transition-all duration-200 border border-gray-100">
                <i class="fas fa-chevron-right text-sm md:text-base"></i>
            </button>

            <!-- Left Fade Gradient -->
            <div x-show="canScrollLeft" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                class="absolute left-0 top-0 bottom-0 w-16 md:w-24 bg-gradient-to-r from-purple-50 to-transparent z-10 pointer-events-none">
            </div>

            <!-- Right Fade Gradient -->
            <div x-show="canScrollRight" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                class="absolute right-0 top-0 bottom-0 w-16 md:w-24 bg-gradient-to-l from-purple-50 to-transparent z-10 pointer-events-none">
            </div>

            <!-- Scrollable Category Container -->
            <div x-ref="categoryScroll"
                class="flex gap-4 md:gap-5 overflow-x-auto scroll-smooth px-4 md:px-8 lg:px-16 pt-2 pb-4 scrollbar-hide"
                style="scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scrollbar-width: none; -ms-overflow-style: none;">

                @forelse($categories as $category)
                    <a href="{{ route('home', ['category' => $category->id]) }}"
                        class="flex-shrink-0 scroll-snap-start group" style="scroll-snap-align: start;">
                        <div
                            class="category-card w-36 md:w-40 h-36 md:h-40 bg-white bg-opacity-60 backdrop-blur-sm rounded-2xl p-5 md:p-6 transition-all duration-300 border-2 {{ isset($selectedCategory) && $selectedCategory == $category->id ? 'border-purple-500 bg-gradient-to-br from-purple-50 to-pink-50' : 'border-transparent hover:border-purple-300' }} flex flex-col relative overflow-hidden">
                            <!-- Glow Effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-purple-100 to-pink-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div class="flex flex-col items-center justify-center h-full relative z-10">
                                <div
                                    class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-purple-100 via-pink-100 to-rose-100 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 flex-shrink-0">
                                    <i
                                        class="fas {{ $category->icon ?? 'fa-tag' }} text-xl md:text-2xl bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent"></i>
                                </div>
                                <span
                                    class="text-sm font-bold text-gray-800 text-center line-clamp-2 group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:from-purple-600 group-hover:to-pink-600 group-hover:bg-clip-text transition-all duration-200 h-10 flex items-center">{{ $category->name }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="flex-1 text-center py-8 text-gray-500 min-w-full">
                        <i class="fas fa-tags text-4xl mb-2"></i>
                        <p>Belum ada kategori</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="bg-gradient-to-br from-white via-cyan-50 to-green-50 py-24 relative overflow-hidden">
        <!-- Decorative Grid Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle, #0891b2 1px, transparent 1px); background-size: 50px 50px;"></div>
        </div>
        
        <!-- Decorative Shapes -->
        <div class="absolute top-10 right-10 w-64 h-64 bg-cyan-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="absolute bottom-10 left-10 w-64 h-64 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <div class="inline-block mb-4">
                <span class="bg-gradient-to-r from-cyan-500 to-green-500 text-white px-5 py-2 rounded-full text-sm font-semibold shadow-lg">
                    <i class="fas fa-fire mr-2"></i>Produk Terpopuler
                </span>
            </div>
            <h2 class="text-3xl md:text-5xl font-bold bg-gradient-to-r from-cyan-600 to-green-600 bg-clip-text text-transparent mb-4 leading-tight px-2">
                @if(isset($showAll) && $showAll)
                    Katalog Semua Produk
                @else
                    Katalog Produk
                @endif
            </h2>
            <p class="text-gray-700 text-lg max-w-2xl mx-auto px-2">
                @if(isset($showAll) && $showAll)
                    Menampilkan semua {{ $products->count() }} produk yang tersedia
                @else
                    Menampilkan produk terbaik dengan rating tertinggi dari {{ $totalProducts ?? 0 }} produk
                @endif
            </p>
        </div>

        @if ($products->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-20 bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl border-2 border-gray-200">
                <div class="w-32 h-32 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-box-open text-5xl text-gray-400"></i>
                </div>
                @if (isset($selectedCategory))
                    <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-700 to-gray-900 bg-clip-text text-transparent mb-3">Belum ada produk di kategori {{ $selectedCategory }}</h3>
                    <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">Silakan pilih kategori lain atau lihat semua produk yang tersedia.</p>
                    <div class="mt-6">
                        <a href="{{ route('home') }}"
                            class="btn-glow inline-flex items-center bg-gradient-to-r from-cyan-500 to-green-500 text-white px-8 py-4 rounded-xl hover:shadow-xl transition-all font-bold">
                            <i class="fas fa-th mr-2"></i>Lihat Semua Kategori
                        </a>
                    </div>
                @else
                    <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-700 to-gray-900 bg-clip-text text-transparent mb-3">Belum ada produk</h3>
                    <p class="text-gray-600 text-lg">Produk akan segera tersedia.</p>
                @endif
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @foreach ($products as $product)
                    <a href="{{ route('products.show', $product->id) }}"
                        class="product-card bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all overflow-hidden border-2 border-transparent hover:border-cyan-200 group">
                        <div class="relative bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500"
                                onerror="this.onerror=null; this.src='https://placehold.co/200x200/E5E5E5/999999?text=No+Image'"
                                loading="lazy">
                        </div>
                        <div class="p-4">
                            <h3 class="text-sm font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:from-cyan-600 group-hover:to-green-600 group-hover:bg-clip-text transition-all">{{ $product->name }}</h3>
                            <div class="flex items-baseline space-x-2 mb-3">
                                <span class="text-lg font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">{{ $product->formatted_price }}</span>
                            </div>
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    <span class="ml-1 text-xs font-semibold text-gray-700">{{ number_format($product->average_rating, 1) }}</span>
                                </div>
                                <span class="text-gray-300">|</span>
                                <span class="text-xs text-gray-600">{{ $product->total_reviews }} ulasan</span>
                            </div>
                            <div class="flex items-center text-xs text-gray-500">
                                <i class="fas fa-map-marker-alt mr-1 text-cyan-500"></i>
                                <span class="truncate">{{ $product->city }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Load More Button -->
        <div class="text-center mt-12">
            <div class="space-y-4">
                <div class="inline-block bg-gradient-to-r from-cyan-50 to-green-50 px-8 py-4 rounded-2xl border-2 border-cyan-200 mb-6">
                    <p class="text-gray-700 font-semibold">
                        <i class="fas fa-box mr-2 text-cyan-600"></i>
                        Menampilkan <span class="text-cyan-600 font-bold">{{ $products->count() }}</span> dari <span class="text-green-600 font-bold">{{ $totalProducts ?? 0 }}</span> produk
                    </p>
                </div>
                <a href="{{ route('products.index') }}" 
                   class="btn-glow inline-flex items-center bg-gradient-to-r from-cyan-500 to-green-500 text-white px-10 py-5 rounded-xl hover:shadow-2xl transition-all font-bold text-lg group">
                    <i class="fas fa-th mr-3 group-hover:scale-110 transition-transform"></i>
                    Lihat Semua Produk
                    <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>
    </section>

    <!-- Stats Section -->
    <section class="py-24 bg-gradient-to-br from-cyan-600 via-green-600 to-emerald-600 relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_120%,rgba(120,119,198,0.3),rgba(255,255,255,0))]"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-white opacity-10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-yellow-300 opacity-10 rounded-full blur-3xl" style="animation: float 3s ease-in-out infinite 1.5s;"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <div class="inline-block mb-4">
                    <span class="bg-white bg-opacity-20 text-white px-6 py-2 rounded-full text-sm font-semibold backdrop-blur-sm">
                        <i class="fas fa-chart-line mr-2"></i>Platform Terpercaya
                    </span>
                </div>
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-4 drop-shadow-lg">Dipercaya Oleh Ribuan Pengguna</h2>
                <p class="text-white text-opacity-90 text-lg max-w-2xl mx-auto">Statistik platform kami yang terus berkembang dan dipercaya oleh komunitas</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-3xl p-8 text-center border-2 border-white border-opacity-20 hover:scale-105 hover:bg-opacity-20 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-box-open text-4xl text-white"></i>
                    </div>
                    <div class="text-5xl md:text-6xl font-bold text-white mb-2">{{ number_format($products->count()) }}+</div>
                    <div class="text-white text-opacity-90 font-semibold text-lg">Produk Tersedia</div>
                </div>
                
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-3xl p-8 text-center border-2 border-white border-opacity-20 hover:scale-105 hover:bg-opacity-20 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-th-large text-4xl text-white"></i>
                    </div>
                    <div class="text-5xl md:text-6xl font-bold text-white mb-2">{{ $categories->count() }}+</div>
                    <div class="text-white text-opacity-90 font-semibold text-lg">Kategori Lengkap</div>
                </div>
                
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-3xl p-8 text-center border-2 border-white border-opacity-20 hover:scale-105 hover:bg-opacity-20 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-store text-4xl text-white"></i>
                    </div>
                    <div class="text-5xl md:text-6xl font-bold text-white mb-2">500+</div>
                    <div class="text-white text-opacity-90 font-semibold text-lg">Seller Terpercaya</div>
                </div>
                
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-3xl p-8 text-center border-2 border-white border-opacity-20 hover:scale-105 hover:bg-opacity-20 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-users text-4xl text-white"></i>
                    </div>
                    <div class="text-5xl md:text-6xl font-bold text-white mb-2">10K+</div>
                    <div class="text-white text-opacity-90 font-semibold text-lg">Pembeli Aktif</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-gradient-to-br from-gray-100 via-gray-50 to-white relative overflow-hidden">
        <!-- Decorative Wave Pattern -->
        <div class="absolute top-0 left-0 right-0 opacity-5">
            <svg viewBox="0 0 1440 120" class="w-full h-24">
                <path fill="currentColor" class="text-gray-300" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
            </svg>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-cyan-600 to-green-600 bg-clip-text text-transparent mb-3">Apa Kata Mereka?</h2>
                <p class="text-gray-600 text-lg">Testimoni dari pelanggan setia MartPlace</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-gray-100 hover:border-cyan-200">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400 text-lg">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed italic">"Belanja di MartPlace sangat menyenangkan! Produknya lengkap, harga kompetitif, dan pengiriman cepat. Highly recommended!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            A
                        </div>
                        <div class="ml-4">
                            <div class="font-bold text-gray-800">Aditya Pratama</div>
                            <div class="text-sm text-gray-500">Jakarta</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-gray-100 hover:border-green-200">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400 text-lg">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed italic">"Sebagai seller, saya sangat puas dengan platform ini. Mudah digunakan dan customer support sangat responsif!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            S
                        </div>
                        <div class="ml-4">
                            <div class="font-bold text-gray-800">Siti Nurhaliza</div>
                            <div class="text-sm text-gray-500">Bandung</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-gray-100 hover:border-purple-200">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400 text-lg">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed italic">"Sistem pembayaran sangat aman dan proses checkout-nya mudah. Tidak perlu khawatir saat berbelanja online!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            B
                        </div>
                        <div class="ml-4">
                            <div class="font-bold text-gray-800">Budi Santoso</div>
                            <div class="text-sm text-gray-500">Surabaya</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- CTA Section -->
    <section class="py-24 bg-gradient-to-br from-cyan-500 via-green-500 to-emerald-500 relative overflow-hidden">
        <!-- Diagonal Stripe Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.1) 35px, rgba(255,255,255,.1) 70px);"></div>
        </div>
        
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-yellow-300 opacity-20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-blue-300 opacity-20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="mb-8">
                <div class="inline-block bg-white bg-opacity-20 backdrop-blur-sm px-6 py-3 rounded-full mb-6">
                    <span class="text-white font-bold text-lg">🚀 Mulai Sekarang!</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">Ingin Mulai Jualan Online?</h2>
                <p class="text-xl text-white text-opacity-90 mb-10 leading-relaxed">Bergabunglah dengan ribuan seller sukses di MartPlace. Daftar gratis dan mulai berjualan dalam hitungan menit!</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('sellers.create') }}"
                    class="btn-glow inline-flex items-center bg-white text-cyan-600 px-10 py-5 rounded-xl font-bold hover:shadow-2xl transition-all shadow-lg text-lg">
                    <i class="fas fa-store mr-3"></i>Daftar Sebagai Seller
                </a>
                <a href="#products"
                    class="btn-glow inline-flex items-center bg-transparent border-3 border-white text-white px-10 py-5 rounded-xl font-bold hover:bg-white hover:text-cyan-600 transition-all text-lg">
                    <i class="fas fa-shopping-cart mr-3"></i>Mulai Belanja
                </a>
            </div>
            
            <div class="mt-12 flex flex-wrap justify-center items-center gap-8 text-white text-opacity-90">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-2xl mr-2"></i>
                    <span class="font-semibold">Gratis Pendaftaran</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-2xl mr-2"></i>
                    <span class="font-semibold">Mudah Digunakan</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-2xl mr-2"></i>
                    <span class="font-semibold">Support 24/7</span>
                </div>
            </div>
        </div>
    </section>

    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-12 mt-20 @if ($isSeller) lg:ml-64 @endif relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute top-0 left-0 w-64 h-64 bg-cyan-500 opacity-5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-green-500 opacity-5 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4 bg-gradient-to-r from-cyan-400 to-green-400 bg-clip-text text-transparent">MartPlace</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Marketplace terpercaya untuk belanja online dengan berbagai
                        pilihan produk berkualitas dari seller terbaik.</p>
                    <div class="mt-4 flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-r from-cyan-500 to-green-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shield-alt text-white text-sm"></i>
                        </div>
                        <span class="text-sm text-gray-300 font-semibold">100% Aman & Terpercaya</span>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-lg">Tentang</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-cyan-400 transition-colors flex items-center group"><i class="fas fa-angle-right mr-2 group-hover:translate-x-1 transition-transform"></i>Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-cyan-400 transition-colors flex items-center group"><i class="fas fa-angle-right mr-2 group-hover:translate-x-1 transition-transform"></i>Karir</a></li>
                        <li><a href="#" class="hover:text-cyan-400 transition-colors flex items-center group"><i class="fas fa-angle-right mr-2 group-hover:translate-x-1 transition-transform"></i>Blog</a></li>
                        <li><a href="{{ route('sellers.create') }}" class="hover:text-cyan-400 transition-colors flex items-center group"><i class="fas fa-angle-right mr-2 group-hover:translate-x-1 transition-transform"></i>Daftar Jadi Seller</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-lg">Bantuan</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-cyan-400 transition-colors flex items-center group"><i class="fas fa-angle-right mr-2 group-hover:translate-x-1 transition-transform"></i>Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-cyan-400 transition-colors flex items-center group"><i class="fas fa-angle-right mr-2 group-hover:translate-x-1 transition-transform"></i>Cara Belanja</a></li>
                        <li><a href="#" class="hover:text-cyan-400 transition-colors flex items-center group"><i class="fas fa-angle-right mr-2 group-hover:translate-x-1 transition-transform"></i>Pengiriman</a></li>
                        <li><a href="#" class="hover:text-cyan-400 transition-colors flex items-center group"><i class="fas fa-angle-right mr-2 group-hover:translate-x-1 transition-transform"></i>Pengembalian</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-lg">Ikuti Kami</h4>
                    <p class="text-gray-400 text-sm mb-4">Dapatkan update terbaru dan promo menarik</p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center hover:scale-110 hover:shadow-lg transition-all">
                            <i class="fab fa-facebook-f text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl flex items-center justify-center hover:scale-110 hover:shadow-lg transition-all">
                            <i class="fab fa-twitter text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gradient-to-br from-pink-600 to-orange-600 rounded-xl flex items-center justify-center hover:scale-110 hover:shadow-lg transition-all">
                            <i class="fab fa-instagram text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gradient-to-br from-green-600 to-green-700 rounded-xl flex items-center justify-center hover:scale-110 hover:shadow-lg transition-all">
                            <i class="fab fa-whatsapp text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-sm text-gray-400">&copy; 2025 <span class="font-bold bg-gradient-to-r from-cyan-400 to-green-400 bg-clip-text text-transparent">MartPlace</span>. All rights reserved.</p>
                    <div class="flex items-center gap-4 text-sm text-gray-400">
                        <a href="#" class="hover:text-cyan-400 transition-colors">Kebijakan Privasi</a>
                        <span>•</span>
                        <a href="#" class="hover:text-cyan-400 transition-colors">Syarat & Ketentuan</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
