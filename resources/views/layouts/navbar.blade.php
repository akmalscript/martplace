<!-- Navbar -->
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
                <form @submit.prevent="submitSearch" class="relative w-full" @click.away="showSuggestions = false">
                    <input type="text" x-model="search" @input.debounce.300ms="getSuggestions"
                        @focus="showSuggestions = (products.length > 0 || sellers.length > 0 || categories.length > 0 || locations.length > 0)"
                        placeholder="Cari produk, toko, kategori, atau lokasi..."
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
                            x-if="!loading && (products.length > 0 || sellers.length > 0 || categories.length > 0 || locations.length > 0)">
                            <div>
                                <!-- Tabs -->
                                <div class="flex border-b bg-gray-50">
                                    <button type="button" @click="activeTab = 'products'"
                                        :class="activeTab === 'products' ? 'border-b-2 border-green-600 text-green-600' :
                                            'text-gray-600'"
                                        class="flex-1 px-3 py-3 text-xs font-medium hover:text-green-600 transition">
                                        Produk (<span x-text="products.length"></span>)
                                    </button>
                                    <button type="button" @click="activeTab = 'sellers'"
                                        :class="activeTab === 'sellers' ? 'border-b-2 border-green-600 text-green-600' :
                                            'text-gray-600'"
                                        class="flex-1 px-3 py-3 text-xs font-medium hover:text-green-600 transition">
                                        Toko (<span x-text="sellers.length"></span>)
                                    </button>
                                    <button type="button" @click="activeTab = 'categories'"
                                        :class="activeTab === 'categories' ? 'border-b-2 border-green-600 text-green-600' :
                                            'text-gray-600'"
                                        class="flex-1 px-3 py-3 text-xs font-medium hover:text-green-600 transition">
                                        Kategori (<span x-text="categories.length"></span>)
                                    </button>
                                    <button type="button" @click="activeTab = 'locations'"
                                        :class="activeTab === 'locations' ? 'border-b-2 border-green-600 text-green-600' :
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
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
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

            <!-- Right Side Icons & Buttons -->
            <div class="flex items-center space-x-4">
                <!-- Direktori Toko Link -->
                <a href="{{ route('sellers.index') }}"
                    class="text-gray-700 hover:text-green-600 transition flex items-center gap-1">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium hidden lg:inline">Toko</span>
                </a>

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
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center text-gray-700 hover:text-green-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
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
