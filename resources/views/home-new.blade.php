<x-layouts.master title="Beranda">
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-olive via-sage to-forest py-20 lg:py-28">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-72 h-72 bg-cream rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-cream rounded-full translate-x-1/3 translate-y-1/3"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                <div class="lg:w-1/2 text-center lg:text-left animate-fade-in-up">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                        Temukan Produk <br>
                        <span class="text-cream">Berkualitas</span> di<br>
                        <span class="text-olive">mart</span>Place
                    </h1>
                    <p class="text-lg text-cream/90 mb-8 max-w-lg mx-auto lg:mx-0">
                        Marketplace terpercaya dengan ribuan produk dari penjual terverifikasi di seluruh Indonesia.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('products.index') }}" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-cream text-forest font-semibold rounded-xl hover:bg-white transition-all duration-300 transform hover:-translate-y-1 hover:shadow-large">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Lihat Katalog
                        </a>
                        <a href="{{ route('sellers.create') }}" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-cream text-cream font-semibold rounded-xl hover:bg-cream hover:text-forest transition-all duration-300 transform hover:-translate-y-1">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Daftar Sebagai Penjual
                        </a>
                    </div>
                </div>
                
                <div class="lg:w-1/2 relative animate-fade-in-up" style="animation-delay: 0.2s">
                    <div class="relative w-full max-w-md mx-auto">
                        <div class="absolute inset-0 bg-cream/20 rounded-3xl transform rotate-6"></div>
                        <div class="relative bg-white rounded-3xl shadow-large p-6">
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($products->take(4) as $index => $product)
                                    <div class="bg-olive/20 rounded-xl p-3 transform hover:scale-105 transition-transform duration-300 stagger-item">
                                        <img src="{{ $product->main_photo ? asset('storage/' . $product->main_photo) : ($product->image_url ?? 'https://via.placeholder.com/150/D2DCB6/778873?text=Produk') }}" 
                                             alt="{{ $product->name }}"
                                             class="w-full h-24 object-cover rounded-lg mb-2">
                                        <p class="text-xs text-forest font-medium truncate">{{ $product->name }}</p>
                                        <p class="text-sm text-sage font-bold">{{ $product->formatted_price }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-white border-b border-olive/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center scroll-reveal">
                    <div class="text-3xl md:text-4xl font-bold text-forest mb-2">{{ $stats['products'] ?? '1000+' }}</div>
                    <p class="text-forest/60 text-sm">Produk Tersedia</p>
                </div>
                <div class="text-center scroll-reveal">
                    <div class="text-3xl md:text-4xl font-bold text-forest mb-2">{{ $stats['sellers'] ?? '500+' }}</div>
                    <p class="text-forest/60 text-sm">Penjual Aktif</p>
                </div>
                <div class="text-center scroll-reveal">
                    <div class="text-3xl md:text-4xl font-bold text-forest mb-2">{{ $stats['cities'] ?? '34' }}</div>
                    <p class="text-forest/60 text-sm">Provinsi</p>
                </div>
                <div class="text-center scroll-reveal">
                    <div class="text-3xl md:text-4xl font-bold text-forest mb-2">{{ $stats['reviews'] ?? '10K+' }}</div>
                    <p class="text-forest/60 text-sm">Ulasan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-10 scroll-reveal">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-forest">Kategori Pilihan</h2>
                    <p class="text-forest/60 mt-1">Temukan produk sesuai kebutuhanmu</p>
                </div>
                <a href="{{ route('products.index') }}" class="hidden sm:flex items-center text-sage hover:text-forest font-medium transition">
                    Lihat Semua
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
                @php
                    $categories = [
                        ['name' => 'Elektronik', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'color' => 'bg-blue-100 text-blue-600'],
                        ['name' => 'Fashion', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z', 'color' => 'bg-pink-100 text-pink-600'],
                        ['name' => 'Makanan', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'color' => 'bg-orange-100 text-orange-600'],
                        ['name' => 'Kecantikan', 'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z', 'color' => 'bg-purple-100 text-purple-600'],
                        ['name' => 'Kesehatan', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'color' => 'bg-red-100 text-red-600'],
                        ['name' => 'Hobi', 'icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'bg-yellow-100 text-yellow-600'],
                        ['name' => 'Otomotif', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4', 'color' => 'bg-gray-100 text-gray-600'],
                        ['name' => 'Rumah', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'color' => 'bg-sage/30 text-forest'],
                    ];
                @endphp
                
                @foreach($categories as $index => $category)
                    <a href="{{ route('products.index', ['category' => $category['name']]) }}" 
                       class="flex flex-col items-center p-4 bg-white rounded-xl hover:shadow-medium transition-all duration-300 transform hover:-translate-y-1 group stagger-item">
                        <div class="w-14 h-14 {{ $category['color'] }} rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $category['icon'] }}"/>
                            </svg>
                        </div>
                        <span class="text-sm text-forest font-medium text-center">{{ $category['name'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-16 bg-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-10 scroll-reveal">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-forest">Produk Terbaru</h2>
                    <p class="text-forest/60 mt-1">Produk pilihan dari penjual terverifikasi</p>
                </div>
                <a href="{{ route('products.index') }}" class="hidden sm:flex items-center text-sage hover:text-forest font-medium transition">
                    Lihat Semua
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl">
                    <svg class="mx-auto h-20 w-20 text-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <h3 class="mt-6 text-xl font-semibold text-forest">Belum Ada Produk</h3>
                    <p class="mt-2 text-forest/60">Produk dari penjual terverifikasi akan muncul di sini.</p>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($products as $index => $product)
                        <a href="{{ route('products.show', $product->id) }}" 
                           class="bg-white rounded-xl overflow-hidden shadow-soft hover:shadow-medium transition-all duration-300 transform hover:-translate-y-2 group stagger-item">
                            <div class="relative aspect-square bg-olive/20">
                                @if($product->discount_percentage > 0)
                                    <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-lg font-semibold z-10">
                                        -{{ $product->discount_percentage }}%
                                    </span>
                                @endif
                                <img src="{{ $product->main_photo ? asset('storage/' . $product->main_photo) : ($product->image_url ?? 'https://via.placeholder.com/200/D2DCB6/778873?text=Produk') }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     loading="lazy">
                                @if($product->badge)
                                    <span class="absolute bottom-2 left-2 bg-sage text-white text-xs px-2 py-1 rounded-lg">
                                        {{ $product->badge }}
                                    </span>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-sm text-forest font-medium line-clamp-2 mb-2 group-hover:text-sage transition-colors">
                                    {{ $product->name }}
                                </h3>
                                <div class="flex items-baseline gap-2 mb-2">
                                    <span class="text-lg font-bold text-forest">{{ $product->formatted_price }}</span>
                                    @if($product->original_price)
                                        <span class="text-xs text-forest/40 line-through">{{ $product->formatted_original_price }}</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2 text-xs text-forest/60">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        {{ number_format($product->rating / 10, 1) }}
                                    </div>
                                    <span class="text-olive">|</span>
                                    <span>{{ $product->sold_count }}+ terjual</span>
                                </div>
                                @if($product->location || $product->seller)
                                    <p class="text-xs text-forest/40 mt-2 truncate">
                                        {{ $product->location ?? ($product->seller->pic_city ?? '') }}
                                    </p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="text-center mt-10">
                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center px-8 py-3 bg-forest text-cream rounded-xl font-semibold hover:bg-sage transition-all duration-300 transform hover:-translate-y-1">
                        Lihat Semua Produk
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-forest to-sage">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center scroll-reveal">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Mulai Berjualan di MartPlace
            </h2>
            <p class="text-cream/90 text-lg mb-8 max-w-2xl mx-auto">
                Daftarkan tokomu sekarang dan jangkau jutaan pembeli di seluruh Indonesia. Proses pendaftaran mudah dan cepat!
            </p>
            <a href="{{ route('sellers.create') }}" 
               class="inline-flex items-center px-10 py-4 bg-cream text-forest font-bold rounded-xl hover:bg-white transition-all duration-300 transform hover:-translate-y-1 hover:shadow-large">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Daftar Sekarang - Gratis!
            </a>
        </div>
    </section>
</x-layouts.master>
