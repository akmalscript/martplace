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
    </style>
</head>

@php
    $isSeller = Auth::check() && Auth::user()->seller && Auth::user()->seller->status === \App\Enums\SellerStatus::ACTIVE;
@endphp

<body class="bg-gray-50" x-data="{ sidebarOpen: false }">
    @if($isSeller)
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
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-green-600">
                        MartPlace
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-md mx-8" x-data="{
                    search: '',
                    products: [],
                    sellers: [],
                    locations: [],
                    activeTab: 'products',
                    showSuggestions: false,
                    loading: false,
                    getSuggestions() {
                        if (this.search.length < 2) {
                            this.products = [];
                            this.sellers = [];
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
                                this.locations = data.locations || [];
                                this.showSuggestions = (this.products.length > 0 || this.sellers.length > 0 || this.locations.length > 0);
                                this.loading = false;
                            });
                    },
                    selectProduct(productId) {
                        window.location.href = `/products/${productId}`;
                    },
                    selectSeller(sellerId) {
                        window.location.href = `/sellers/${sellerId}`;
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
                    <form @submit.prevent="submitSearch" class="relative w-full" @click.away="showSuggestions = false">
                        <input type="text" x-model="search" @input.debounce.300ms="getSuggestions"
                            @focus="showSuggestions = (products.length > 0 || sellers.length > 0 || locations.length > 0)"
                            placeholder="Cari produk, toko, atau lokasi..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
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
                                x-if="!loading && (products.length > 0 || sellers.length > 0 || locations.length > 0)">
                                <div>
                                    <!-- Tabs -->
                                    <div class="flex border-b bg-gray-50">
                                        <button type="button" @click="activeTab = 'products'"
                                            :class="activeTab === 'products' ? 'border-b-2 border-green-600 text-green-600' :
                                                'text-gray-600'"
                                            class="flex-1 px-4 py-3 text-sm font-medium hover:text-green-600 transition">
                                            Produk (<span x-text="products.length"></span>)
                                        </button>
                                        <button type="button" @click="activeTab = 'sellers'"
                                            :class="activeTab === 'sellers' ? 'border-b-2 border-green-600 text-green-600' :
                                                'text-gray-600'"
                                            class="flex-1 px-4 py-3 text-sm font-medium hover:text-green-600 transition">
                                            Toko (<span x-text="sellers.length"></span>)
                                        </button>
                                        <button type="button" @click="activeTab = 'locations'"
                                            :class="activeTab === 'locations' ? 'border-b-2 border-green-600 text-green-600' :
                                                'text-gray-600'"
                                            class="flex-1 px-4 py-3 text-sm font-medium hover:text-green-600 transition">
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
                                                        <svg class="w-6 h-6 text-green-600" fill="currentColor"
                                                            viewBox="0 0 20 20">
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

                <!-- Right Side Icons & Buttons -->
                <div class="flex items-center space-x-4">
                    <!-- Cart Icon -->
                    <a href="#" class="text-gray-700 hover:text-green-600 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </a>

                    <!-- Notification Icon -->
                    <a href="#" class="text-gray-700 hover:text-green-600 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </a>

                    @guest
                        <!-- Login Button -->
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600 transition">
                            Masuk
                        </a>

                        <!-- Register Seller Button -->
                        <a href="{{ route('sellers.create') }}"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            Daftar Toko
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
    <section class="bg-gradient-to-r from-cyan-400 to-green-300 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="md:w-1/2 text-white mb-8 md:mb-0">
                    <h1 class="text-4xl font-bold mb-4">Mau transaksi lebih hemat?</h1>
                    <p class="text-lg mb-6">Cek promo asyik MartPlace!</p>
                    <a href="#promo"
                        class="inline-block bg-white text-cyan-500 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Cek Sekarang
                    </a>
                </div>
                <div class="md:w-1/2">
                    <img src="{{ asset('images/hero-illustration.png') }}" alt="Hero Illustration"
                        class="w-full h-auto" onerror="this.style.display='none'">
                </div>
            </div>
        </div>
    </section>

    <!-- Category Section - Horizontal Scroll -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Kategori Pilihan</h2>
            </div>
        </div>

        <div class="relative" x-data="{
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
            <button x-show="canScrollLeft" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-2"
                    @click="scrollTo('left')"
                    class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 md:w-12 md:h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-700 hover:bg-gray-50 hover:shadow-xl hover:scale-105 active:scale-95 transition-all duration-200 border border-gray-100">
                <i class="fas fa-chevron-left text-sm md:text-base"></i>
            </button>

            <!-- Right Arrow Button -->
            <button x-show="canScrollRight"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-2"
                    @click="scrollTo('right')"
                    class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 md:w-12 md:h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-700 hover:bg-gray-50 hover:shadow-xl hover:scale-105 active:scale-95 transition-all duration-200 border border-gray-100">
                <i class="fas fa-chevron-right text-sm md:text-base"></i>
            </button>

            <!-- Left Fade Gradient -->
            <div x-show="canScrollLeft" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="absolute left-0 top-0 bottom-0 w-16 md:w-24 bg-gradient-to-r from-gray-50 to-transparent z-10 pointer-events-none"></div>

            <!-- Right Fade Gradient -->
            <div x-show="canScrollRight"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="absolute right-0 top-0 bottom-0 w-16 md:w-24 bg-gradient-to-l from-gray-50 to-transparent z-10 pointer-events-none"></div>

            <!-- Scrollable Category Container -->
            <div x-ref="categoryScroll" 
                 class="flex gap-4 md:gap-5 overflow-x-auto scroll-smooth px-4 md:px-8 lg:px-16 pt-2 pb-4 scrollbar-hide"
                 style="scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scrollbar-width: none; -ms-overflow-style: none;">
                
                @forelse($categories as $category)
                <a href="{{ route('home', ['category' => $category->id]) }}"
                   class="flex-shrink-0 scroll-snap-start group"
                   style="scroll-snap-align: start;">
                    <div class="w-36 md:w-40 h-36 md:h-40 bg-white rounded-2xl p-5 md:p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 hover:border-green-200 flex flex-col {{ isset($selectedCategory) && $selectedCategory == $category->id ? 'ring-2 ring-green-500 shadow-green-100' : '' }}">
                        <div class="flex flex-col items-center justify-center h-full">
                            <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-green-50 to-green-100 rounded-2xl flex items-center justify-center mb-3 group-hover:from-green-100 group-hover:to-green-200 group-hover:scale-105 transition-all duration-300 shadow-sm flex-shrink-0">
                                <i class="fas {{ $category->icon ?? 'fa-tag' }} text-xl md:text-2xl text-green-600"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700 text-center line-clamp-2 group-hover:text-green-700 transition-colors duration-200 h-10 flex items-center">{{ $category->name }}</span>
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
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-6">
            <div>
                @if (isset($selectedCategory))
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Produk {{ $selectedCategory }}</h2>
                    <p class="text-gray-600">Menampilkan {{ $products->count() }} produk</p>
                @else
                    <div class="flex space-x-6">
                        <a href="{{ route('home', ['filter' => 'untuk_anda']) }}"
                            class="pb-2 {{ !isset($selectedFilter) || $selectedFilter == 'untuk_anda' ? 'text-green-600 font-semibold border-b-2 border-green-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Untuk Anda
                        </a>
                        <a href="{{ route('home', ['filter' => 'mall']) }}"
                            class="pb-2 {{ isset($selectedFilter) && $selectedFilter == 'mall' ? 'text-green-600 font-semibold border-b-2 border-green-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Mall
                        </a>
                        <a href="{{ route('home', ['filter' => 'terlaris']) }}"
                            class="pb-2 {{ isset($selectedFilter) && $selectedFilter == 'terlaris' ? 'text-green-600 font-semibold border-b-2 border-green-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Produk Terlaris
                        </a>
                    </div>
                @endif
            </div>
            @if (isset($selectedCategory) || (isset($selectedFilter) && $selectedFilter != 'semua'))
                <a href="{{ route('home', ['filter' => 'semua']) }}"
                    class="text-green-600 hover:text-green-700 font-medium">Lihat Semua</a>
            @endif
        </div>

        @if ($products->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                    </path>
                </svg>
                @if (isset($selectedCategory))
                    <h3 class="mt-4 text-xl font-medium text-gray-900">Belum ada produk di kategori
                        {{ $selectedCategory }}</h3>
                    <p class="mt-2 text-gray-500">Silakan pilih kategori lain atau lihat semua produk.</p>
                    <div class="mt-6">
                        <a href="{{ route('home') }}"
                            class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
                            Lihat Semua Kategori
                        </a>
                    </div>
                @else
                    <h3 class="mt-4 text-xl font-medium text-gray-900">Belum ada produk</h3>
                    <p class="mt-2 text-gray-500">Produk akan segera tersedia.</p>
                @endif
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
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
                            </div>
                            <div class="flex items-center space-x-1 mb-2">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <span class="text-xs text-gray-600">{{ number_format($product->average_rating, 1) }} •
                                    {{ number_format($product->sold_count) }}+ terjual</span>
                            </div>
                            <p class="text-xs text-gray-500">{{ $product->city }}, {{ $product->province }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Load More -->
        <div class="text-center mt-8">
            <p class="text-gray-600">Menampilkan {{ $products->count() }} produk</p>
        </div>
    </section>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12 @if($isSeller) lg:ml-64 @endif">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">MartPlace</h3>
                    <p class="text-gray-400 text-sm">Marketplace terpercaya untuk belanja online dengan berbagai
                        pilihan produk berkualitas.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Tentang</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white">Karir</a></li>
                        <li><a href="#" class="hover:text-white">Blog</a></li>
                        <li><a href="{{ route('sellers.create') }}" class="hover:text-white">Daftar Jadi Seller</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Bantuan</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-white">Cara Belanja</a></li>
                        <li><a href="#" class="hover:text-white">Pengiriman</a></li>
                        <li><a href="#" class="hover:text-white">Pengembalian</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; 2025 MartPlace. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
