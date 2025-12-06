<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktori Toko - MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .seller-card {
            transition: all 0.3s ease;
        }

        .seller-card:hover {
            transform: translateY(-5px);
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
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: 0.5s;
        }

        .btn-glow:hover::before {
            left: 100%;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Navigation Bar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50 border-b-2 border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-green-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-store text-white text-xl"></i>
                        </div>
                        <span
                            class="text-2xl font-bold bg-gradient-to-r from-cyan-600 to-green-600 bg-clip-text text-transparent">MartPlace</span>
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-md mx-8" x-data="{
                    search: '{{ request('search') }}',
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
                        window.location.href = `/?category=${categoryId}#products`;
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
                                                        <i :class="'fas ' + category.icon + ' text-purple-600'"></i>
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
                        <a href="{{ route('login') }}"
                            class="btn-glow text-gray-700 hover:text-cyan-600 transition font-semibold flex items-center">
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

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-cyan-500 to-green-500 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Direktori Toko</h1>
                <p class="text-cyan-50 text-lg">Temukan berbagai toko terpercaya di MartPlace</p>
            </div>
        </div>
    </section>

    <!-- Search Type Tabs -->
    @if (request('search'))
        <section class="bg-white border-b shadow-sm sticky top-20 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-8">
                    <a href="{{ route('products.index', ['search' => request('search')]) }}"
                        class="flex items-center gap-2 py-4 font-semibold transition-colors border-transparent text-gray-600 hover:text-cyan-600"
                        style="border-bottom-width: 3px;">
                        <i class="fas fa-box"></i>
                        <span>Produk</span>
                    </a>
                    <a href="{{ route('sellers.index', ['search' => request('search')]) }}"
                        class="flex items-center gap-2 py-4 font-semibold transition-colors border-cyan-500 text-cyan-600"
                        style="border-bottom-width: 3px;">
                        <i class="fas fa-store"></i>
                        <span>Toko</span>
                    </a>
                </div>
            </div>
        </section>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Search & Filter -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <form action="{{ route('sellers.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama toko..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- Province Filter -->
                    <div>
                        <select name="province"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            <option value="">Semua Provinsi</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province }}"
                                    {{ request('province') == $province ? 'selected' : '' }}>
                                    {{ $province }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- City Filter -->
                    <div>
                        <select name="city"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            <option value="">Semua Kota</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4 items-center">
                    <!-- Sort -->
                    <select name="sort"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi
                        </option>
                        <option value="products" {{ request('sort') == 'products' ? 'selected' : '' }}>Produk
                            Terbanyak</option>
                    </select>

                    <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>

                    @if (request()->hasAny(['search', 'province', 'city', 'sort']))
                        <a href="{{ route('sellers.index') }}"
                            class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                            <i class="fas fa-redo mr-2"></i>Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Sellers Grid -->
        @if ($sellers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($sellers as $seller)
                    <a href="{{ route('sellers.show', $seller->id) }}"
                        class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden">
                        <div class="p-6">
                            <!-- Store Photo -->
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden bg-gray-100">
                                @if ($seller->store_photo)
                                    <img src="{{ Storage::url($seller->store_photo) }}"
                                        alt="{{ $seller->store_name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <i class="fas fa-store text-3xl"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Store Info -->
                            <div class="text-center">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $seller->store_name }}</h3>
                                <p class="text-sm text-gray-600 mb-3">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    {{ $seller->city }}, {{ $seller->province }}
                                </p>

                                <!-- Stats -->
                                <div class="grid grid-cols-3 gap-2 text-center border-t pt-3">
                                    <div>
                                        <div class="text-lg font-bold text-green-600">{{ $seller->total_products }}
                                        </div>
                                        <div class="text-xs text-gray-500">Produk</div>
                                    </div>
                                    <div>
                                        <div class="text-lg font-bold text-yellow-500">
                                            <i class="fas fa-star"></i> {{ number_format($seller->rating, 1) }}
                                        </div>
                                        <div class="text-xs text-gray-500">Rating</div>
                                    </div>
                                    <div>
                                        <div class="text-lg font-bold text-blue-600">{{ $seller->total_reviews }}
                                        </div>
                                        <div class="text-xs text-gray-500">Ulasan</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $sellers->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <div
                    class="w-32 h-32 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mb-6 mx-auto">
                    <i class="fas fa-store text-gray-400 text-5xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Toko</h3>
                <p class="text-gray-500">Tidak ada toko yang ditemukan dengan kriteria pencarian Anda.</p>
            </div>
        @endif
    </div>

    @include('layouts.footer')
</body>

</html>
