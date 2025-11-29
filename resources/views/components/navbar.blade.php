@props(['scrolled' => false])

<nav x-data="{ 
        mobileMenuOpen: false, 
        userMenuOpen: false,
        searchOpen: false,
        search: '',
        products: [],
        sellers: [],
        locations: [],
        activeTab: 'products',
        showSuggestions: false,
        loading: false
     }"
     :class="{ 
        'py-2': scrolled, 
        'py-4': !scrolled,
        'bg-cream/95 backdrop-blur-lg shadow-soft': scrolled,
        'bg-cream': !scrolled
     }"
     class="sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                <div class="w-10 h-10 bg-gradient-to-br from-sage to-forest rounded-xl flex items-center justify-center transform group-hover:scale-105 transition-transform duration-300">
                    <span class="text-white font-bold text-lg">M</span>
                </div>
                <span class="text-2xl font-bold text-forest hidden sm:block">
                    mart<span class="text-sage">Place</span>
                </span>
            </a>

            <!-- Search Bar (Desktop) -->
            <div class="hidden md:flex flex-1 max-w-xl mx-8" @click.away="showSuggestions = false">
                <form @submit.prevent="submitSearch" class="relative w-full">
                    <div class="relative">
                        <input type="text" 
                               x-model="search"
                               @input.debounce.300ms="getSuggestions()"
                               @focus="showSuggestions = (products.length > 0 || sellers.length > 0 || locations.length > 0)"
                               placeholder="Cari produk, toko, atau lokasi..."
                               class="w-full pl-12 pr-4 py-3 bg-white border border-olive rounded-xl focus:outline-none focus:ring-2 focus:ring-sage focus:border-sage transition-all duration-300 text-forest placeholder-forest/50">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    <!-- Search Suggestions -->
                    <div x-show="showSuggestions || loading" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-large border border-olive/30 overflow-hidden z-50">
                        
                        <template x-if="loading">
                            <div class="p-6 text-center text-forest/60">
                                <svg class="animate-spin h-6 w-6 mx-auto mb-2 text-sage" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Mencari...
                            </div>
                        </template>

                        <template x-if="!loading && (products.length > 0 || sellers.length > 0 || locations.length > 0)">
                            <div>
                                <!-- Tabs -->
                                <div class="flex border-b border-olive/20 bg-cream/50">
                                    <button type="button" @click="activeTab = 'products'"
                                            :class="activeTab === 'products' ? 'border-b-2 border-sage text-forest font-semibold' : 'text-forest/60'"
                                            class="flex-1 px-4 py-3 text-sm hover:text-forest transition">
                                        Produk (<span x-text="products.length"></span>)
                                    </button>
                                    <button type="button" @click="activeTab = 'sellers'"
                                            :class="activeTab === 'sellers' ? 'border-b-2 border-sage text-forest font-semibold' : 'text-forest/60'"
                                            class="flex-1 px-4 py-3 text-sm hover:text-forest transition">
                                        Toko (<span x-text="sellers.length"></span>)
                                    </button>
                                    <button type="button" @click="activeTab = 'locations'"
                                            :class="activeTab === 'locations' ? 'border-b-2 border-sage text-forest font-semibold' : 'text-forest/60'"
                                            class="flex-1 px-4 py-3 text-sm hover:text-forest transition">
                                        Lokasi (<span x-text="locations.length"></span>)
                                    </button>
                                </div>

                                <div class="max-h-80 overflow-y-auto">
                                    <!-- Products Tab -->
                                    <div x-show="activeTab === 'products'" class="divide-y divide-olive/10">
                                        <template x-for="product in products" :key="product.id">
                                            <a :href="`/products/${product.id}`"
                                               class="flex items-center gap-4 px-4 py-3 hover:bg-olive/20 transition group">
                                                <img :src="product.image_url || product.main_photo" :alt="product.name"
                                                     class="w-12 h-12 object-cover rounded-lg bg-olive/30">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-forest truncate" x-text="product.name"></p>
                                                    <p class="text-sm text-sage font-semibold" x-text="formatPrice(product.price)"></p>
                                                </div>
                                                <svg class="w-5 h-5 text-olive group-hover:text-sage transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </template>
                                    </div>

                                    <!-- Sellers Tab -->
                                    <div x-show="activeTab === 'sellers'" class="divide-y divide-olive/10">
                                        <template x-for="seller in sellers" :key="seller.id">
                                            <a :href="`/sellers/${seller.id}`"
                                               class="flex items-center gap-4 px-4 py-3 hover:bg-olive/20 transition group">
                                                <div class="w-12 h-12 bg-sage/20 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-sage" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-forest truncate" x-text="seller.store_name"></p>
                                                    <p class="text-xs text-forest/60" x-text="`${seller.pic_city || seller.city}, ${seller.pic_province || seller.province}`"></p>
                                                </div>
                                            </a>
                                        </template>
                                    </div>

                                    <!-- Locations Tab -->
                                    <div x-show="activeTab === 'locations'" class="divide-y divide-olive/10">
                                        <template x-for="location in locations" :key="location.name">
                                            <a :href="`/products?search=${encodeURIComponent(location.name)}`"
                                               class="flex items-center gap-4 px-4 py-3 hover:bg-olive/20 transition group">
                                                <div class="w-12 h-12 bg-olive/30 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-forest" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-forest" x-text="location.name"></p>
                                                    <p class="text-xs text-forest/60" x-text="location.type === 'city' ? 'Kota/Kabupaten' : 'Provinsi'"></p>
                                                </div>
                                            </a>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </form>
            </div>

            <!-- Right Side -->
            <div class="flex items-center space-x-4">
                <!-- Sellers Directory Link -->
                <a href="{{ route('sellers.index') }}" 
                   class="hidden md:flex items-center gap-2 text-forest/80 hover:text-forest transition group">
                    <svg class="h-5 w-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    <span class="text-sm font-medium">Toko</span>
                </a>

                @guest
                    <a href="{{ route('login') }}" 
                       class="hidden sm:inline-flex text-forest/80 hover:text-forest font-medium transition">
                        Masuk
                    </a>
                    <a href="{{ route('sellers.create') }}" 
                       class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-sage to-forest text-white rounded-xl font-semibold hover:shadow-medium transition-all duration-300 transform hover:-translate-y-0.5">
                        Daftar Toko
                    </a>
                @else
                    <!-- User Menu -->
                    <div class="relative" @click.away="userMenuOpen = false">
                        <button @click="userMenuOpen = !userMenuOpen" 
                                class="flex items-center space-x-2 text-forest hover:text-sage transition">
                            <div class="w-9 h-9 bg-olive rounded-full flex items-center justify-center">
                                <span class="text-forest font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <span class="hidden lg:inline text-sm font-medium">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': userMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="userMenuOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-large border border-olive/20 py-2 z-50">
                            <div class="px-4 py-3 border-b border-olive/20">
                                <p class="text-sm font-semibold text-forest">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-forest/60 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 text-sm text-forest hover:bg-olive/20 transition">
                                <svg class="w-4 h-4 mr-3 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm text-forest hover:bg-olive/20 transition">
                                <svg class="w-4 h-4 mr-3 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profil
                            </a>
                            
                            <div class="border-t border-olive/20 my-2"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-forest hover:text-sage transition">
                    <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             class="md:hidden mt-4 pb-4 border-t border-olive/20 pt-4" style="display: none;">
            
            <!-- Mobile Search -->
            <div class="mb-4">
                <input type="text" placeholder="Cari produk..." 
                       class="w-full px-4 py-3 bg-white border border-olive rounded-xl focus:ring-2 focus:ring-sage text-forest">
            </div>

            <div class="space-y-2">
                <a href="{{ route('sellers.index') }}" class="block px-4 py-2.5 text-forest hover:bg-olive/20 rounded-lg transition">
                    Direktori Toko
                </a>
                @guest
                    <a href="{{ route('login') }}" class="block px-4 py-2.5 text-forest hover:bg-olive/20 rounded-lg transition">
                        Masuk
                    </a>
                    <a href="{{ route('sellers.create') }}" class="block px-4 py-2.5 bg-sage text-white rounded-lg text-center font-semibold">
                        Daftar Toko
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 text-forest hover:bg-olive/20 rounded-lg transition">
                        Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </div>
</nav>

<script>
function getSuggestions() {
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
        })
        .catch(() => {
            this.loading = false;
        });
}

function formatPrice(price) {
    return 'Rp' + Number(price).toLocaleString('id-ID');
}

function submitSearch() {
    if (this.search.trim()) {
        window.location.href = `/products?search=${encodeURIComponent(this.search)}`;
    }
}
</script>
