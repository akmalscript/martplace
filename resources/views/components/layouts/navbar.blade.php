{{-- MartPlace Navbar Component with Glassmorphism --}}
<nav class="sticky top-0 z-50 transition-all duration-300"
     :class="scrolled ? 'bg-cream/95 backdrop-blur-lg shadow-md py-2' : 'bg-cream py-4'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="w-10 h-10 bg-gradient-to-br from-sage to-forest rounded-xl flex items-center justify-center transform group-hover:scale-105 transition-transform duration-300">
                    <span class="text-cream font-bold text-xl">M</span>
                </div>
                <span class="text-2xl font-bold bg-gradient-to-r from-sage to-forest bg-clip-text text-transparent">
                    MartPlace
                </span>
            </a>

            {{-- Search Bar (Desktop) --}}
            <div class="hidden md:flex flex-1 max-w-xl mx-8" x-data="searchComponent()">
                <form @submit.prevent="submitSearch" class="relative w-full" @click.away="showSuggestions = false">
                    <input type="text" 
                           x-model="search" 
                           @input.debounce.300ms="getSuggestions"
                           @focus="showSuggestions = (products.length > 0 || sellers.length > 0 || locations.length > 0)"
                           placeholder="Cari produk, toko, atau lokasi..."
                           class="w-full pl-12 pr-4 py-3 bg-white border-2 border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition-all duration-300 placeholder:text-forest/50">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2">
                        <svg class="w-5 h-5 text-forest/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    
                    {{-- Search Suggestions Dropdown --}}
                    <div x-show="showSuggestions || loading" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         @click.stop
                         class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-xl border border-olive/30 overflow-hidden z-50">
                        
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
                                {{-- Tabs --}}
                                <div class="flex border-b border-olive/20 bg-cream/50">
                                    <button type="button" @click="activeTab = 'products'"
                                            :class="activeTab === 'products' ? 'border-b-2 border-sage text-sage' : 'text-forest/60'"
                                            class="flex-1 px-4 py-3 text-sm font-medium hover:text-sage transition">
                                        Produk (<span x-text="products.length"></span>)
                                    </button>
                                    <button type="button" @click="activeTab = 'sellers'"
                                            :class="activeTab === 'sellers' ? 'border-b-2 border-sage text-sage' : 'text-forest/60'"
                                            class="flex-1 px-4 py-3 text-sm font-medium hover:text-sage transition">
                                        Toko (<span x-text="sellers.length"></span>)
                                    </button>
                                    <button type="button" @click="activeTab = 'locations'"
                                            :class="activeTab === 'locations' ? 'border-b-2 border-sage text-sage' : 'text-forest/60'"
                                            class="flex-1 px-4 py-3 text-sm font-medium hover:text-sage transition">
                                        Lokasi (<span x-text="locations.length"></span>)
                                    </button>
                                </div>
                                
                                {{-- Tab Content --}}
                                <div class="max-h-72 overflow-y-auto">
                                    {{-- Products Tab --}}
                                    <div x-show="activeTab === 'products'" class="divide-y divide-olive/10">
                                        <template x-for="product in products" :key="product.id">
                                            <button type="button" @click="selectProduct(product.id)"
                                                    class="w-full text-left px-4 py-3 hover:bg-olive/20 flex items-center gap-3 transition">
                                                <img :src="product.main_photo ? '/storage/' + product.main_photo : 'https://via.placeholder.com/48'" 
                                                     :alt="product.name"
                                                     class="w-12 h-12 object-cover rounded-lg">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-forest truncate" x-text="product.name"></p>
                                                    <p class="text-sm text-sage font-semibold" x-text="formatPrice(product.price)"></p>
                                                </div>
                                                <svg class="w-5 h-5 text-forest/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </button>
                                        </template>
                                    </div>
                                    
                                    {{-- Sellers Tab --}}
                                    <div x-show="activeTab === 'sellers'" class="divide-y divide-olive/10">
                                        <template x-for="seller in sellers" :key="seller.id">
                                            <button type="button" @click="selectSeller(seller.id)"
                                                    class="w-full text-left px-4 py-3 hover:bg-olive/20 flex items-center gap-3 transition">
                                                <div class="w-12 h-12 bg-sage/20 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-sage" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-forest truncate" x-text="seller.store_name"></p>
                                                    <p class="text-xs text-forest/60" x-text="seller.pic_city + ', ' + seller.pic_province"></p>
                                                </div>
                                                <svg class="w-5 h-5 text-forest/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </button>
                                        </template>
                                    </div>
                                    
                                    {{-- Locations Tab --}}
                                    <div x-show="activeTab === 'locations'" class="divide-y divide-olive/10">
                                        <template x-for="location in locations" :key="location.name">
                                            <button type="button" @click="selectLocation(location.name)"
                                                    class="w-full text-left px-4 py-3 hover:bg-olive/20 flex items-center gap-3 transition">
                                                <div class="w-12 h-12 bg-olive/30 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-forest" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-forest" x-text="location.name"></p>
                                                    <p class="text-xs text-forest/60" x-text="location.type === 'city' ? 'Kota/Kabupaten' : 'Provinsi'"></p>
                                                </div>
                                                <svg class="w-5 h-5 text-forest/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
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

            {{-- Right Side Menu --}}
            <div class="flex items-center gap-4">
                {{-- Sellers Directory Link --}}
                <a href="{{ route('sellers.index') }}" 
                   class="hidden sm:flex items-center gap-2 text-forest/70 hover:text-sage transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span class="text-sm font-medium">Toko</span>
                </a>
                
                {{-- Products Link --}}
                <a href="{{ route('products.index') }}" 
                   class="hidden sm:flex items-center gap-2 text-forest/70 hover:text-sage transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="text-sm font-medium">Produk</span>
                </a>

                @guest
                    {{-- Login Button --}}
                    <a href="{{ route('login') }}" 
                       class="text-forest/70 hover:text-sage transition-colors duration-300 font-medium">
                        Masuk
                    </a>
                    
                    {{-- Register Seller Button --}}
                    <a href="{{ route('sellers.create') }}" 
                       class="hidden sm:flex items-center gap-2 bg-gradient-to-r from-sage to-forest text-cream px-5 py-2.5 rounded-xl font-medium hover:shadow-lg hover:shadow-sage/30 transform hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Daftar Toko
                    </a>
                @else
                    {{-- User Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center gap-2 text-forest hover:text-sage transition-colors duration-300">
                            <div class="w-9 h-9 bg-sage/20 rounded-full flex items-center justify-center">
                                <span class="text-sage font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <span class="hidden sm:inline font-medium">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             @click.away="open = false"
                             class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-xl border border-olive/20 overflow-hidden z-50">
                            <div class="px-4 py-3 bg-cream/50 border-b border-olive/20">
                                <p class="text-sm font-semibold text-forest">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-forest/60">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <div class="py-2">
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-forest/80 hover:bg-olive/20 hover:text-forest transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                    </svg>
                                    Dashboard
                                </a>
                                <a href="{{ route('my-products') }}" class="flex items-center gap-3 px-4 py-2.5 text-forest/80 hover:bg-olive/20 hover:text-forest transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    Produk Saya
                                </a>
                                <a href="{{ route('my-products.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-forest/80 hover:bg-olive/20 hover:text-forest transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Upload Produk
                                </a>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-forest/80 hover:bg-olive/20 hover:text-forest transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Profil Saya
                                </a>
                            </div>
                            
                            <div class="border-t border-olive/20 py-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-red-600 hover:bg-red-50 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
                
                {{-- Mobile Menu Toggle --}}
                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-forest hover:text-sage transition">
                    <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
        {{-- Mobile Menu --}}
        <div x-show="mobileMenu" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="md:hidden mt-4 pb-4 border-t border-olive/20 pt-4">
            {{-- Mobile Search --}}
            <form action="{{ route('products.index') }}" method="GET" class="mb-4">
                <input type="text" name="search" placeholder="Cari produk..."
                       class="w-full px-4 py-3 bg-white border-2 border-olive rounded-xl focus:outline-none focus:border-sage">
            </form>
            
            <div class="space-y-2">
                <a href="{{ route('sellers.index') }}" class="flex items-center gap-3 px-4 py-3 text-forest hover:bg-olive/20 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Direktori Toko
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-3 text-forest hover:bg-olive/20 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Katalog Produk
                </a>
                @guest
                    <a href="{{ route('sellers.create') }}" class="flex items-center gap-3 px-4 py-3 bg-sage text-cream rounded-lg font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Daftar Sebagai Penjual
                    </a>
                @endguest
            </div>
        </div>
    </div>
</nav>

<script>
function searchComponent() {
    return {
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
                })
                .catch(() => {
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
    };
}
</script>
