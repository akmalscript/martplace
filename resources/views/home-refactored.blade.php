@extends('layouts.master')

@section('title', 'Beranda')

@section('content')
    {{-- Hero Section --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-olive via-sage/50 to-cream py-16 lg:py-24">
        {{-- Decorative Elements --}}
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-sage/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-olive/30 rounded-full blur-3xl"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                {{-- Hero Content --}}
                <div class="flex-1 text-center lg:text-left">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-forest mb-6 animate-fade-in-up">
                        Temukan Produk <br>
                        <span class="bg-gradient-to-r from-sage to-forest bg-clip-text text-transparent">Berkualitas</span>
                    </h1>
                    <p class="text-lg text-forest/70 mb-8 max-w-xl mx-auto lg:mx-0 animate-slide-up" style="animation-delay: 0.1s">
                        Marketplace terpercaya dengan ribuan penjual terverifikasi di seluruh Indonesia. 
                        Belanja aman, produk berkualitas, pengiriman cepat.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start animate-slide-up" style="animation-delay: 0.2s">
                        <a href="{{ route('sellers.create') }}" 
                           class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-sage to-forest text-cream px-8 py-4 rounded-xl font-semibold hover:shadow-xl hover:shadow-sage/30 transform hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Daftar Sebagai Penjual
                        </a>
                        <a href="{{ route('products.index') }}" 
                           class="inline-flex items-center justify-center gap-2 bg-white text-forest px-8 py-4 rounded-xl font-semibold border-2 border-olive hover:border-sage hover:bg-cream transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Lihat Katalog Produk
                        </a>
                    </div>
                    
                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-forest/10 animate-slide-up" style="animation-delay: 0.3s">
                        <div class="text-center lg:text-left">
                            <p class="text-3xl font-bold text-forest">1000+</p>
                            <p class="text-sm text-forest/60">Produk</p>
                        </div>
                        <div class="text-center lg:text-left">
                            <p class="text-3xl font-bold text-forest">500+</p>
                            <p class="text-sm text-forest/60">Penjual</p>
                        </div>
                        <div class="text-center lg:text-left">
                            <p class="text-3xl font-bold text-forest">34</p>
                            <p class="text-sm text-forest/60">Provinsi</p>
                        </div>
                    </div>
                </div>
                
                {{-- Hero Image --}}
                <div class="flex-1 relative animate-scale-in" style="animation-delay: 0.2s">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-sage to-forest rounded-3xl transform rotate-6 scale-95 opacity-20"></div>
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=500&fit=crop" 
                             alt="Marketplace" 
                             class="relative rounded-3xl shadow-2xl w-full max-w-lg mx-auto"
                             onerror="this.src='https://via.placeholder.com/600x500/A1BC98/FFFFFF?text=MartPlace'">
                    </div>
                    
                    {{-- Floating Cards --}}
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-xl p-4 animate-bounce-soft hidden lg:block">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-sage/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-forest">Penjual Terverifikasi</p>
                                <p class="text-sm text-forest/60">100% Aman & Terpercaya</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -top-6 -right-6 bg-white rounded-2xl shadow-xl p-4 animate-bounce-soft hidden lg:block" style="animation-delay: 0.2s">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-forest">Rating Terbaik</p>
                                <p class="text-sm text-forest/60">4.9/5.0 dari pengguna</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Category Section --}}
    <section class="py-16 bg-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8 scroll-reveal">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-forest">Kategori Pilihan</h2>
                    <p class="text-forest/60 mt-1">Temukan produk sesuai kebutuhanmu</p>
                </div>
                @if(isset($selectedCategory))
                    <a href="{{ route('home') }}" class="text-sage hover:text-forest font-medium flex items-center gap-1 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Semua Kategori
                    </a>
                @endif
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
                @php
                    $categories = [
                        ['name' => 'Elektronik', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'color' => 'blue'],
                        ['name' => 'Fashion', 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'color' => 'pink'],
                        ['name' => 'Makanan', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'orange'],
                        ['name' => 'Kecantikan', 'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z', 'color' => 'purple'],
                        ['name' => 'Kesehatan', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'color' => 'red'],
                        ['name' => 'Rumah', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'color' => 'green'],
                        ['name' => 'Olahraga', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'color' => 'yellow'],
                        ['name' => 'Lainnya', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z', 'color' => 'gray'],
                    ];
                    $colorClasses = [
                        'blue' => 'bg-blue-100 text-blue-600 group-hover:bg-blue-200',
                        'pink' => 'bg-pink-100 text-pink-600 group-hover:bg-pink-200',
                        'orange' => 'bg-orange-100 text-orange-600 group-hover:bg-orange-200',
                        'purple' => 'bg-purple-100 text-purple-600 group-hover:bg-purple-200',
                        'red' => 'bg-red-100 text-red-600 group-hover:bg-red-200',
                        'green' => 'bg-sage/20 text-sage group-hover:bg-sage/30',
                        'yellow' => 'bg-yellow-100 text-yellow-600 group-hover:bg-yellow-200',
                        'gray' => 'bg-olive/30 text-forest group-hover:bg-olive/50',
                    ];
                @endphp
                
                @foreach($categories as $index => $category)
                    <a href="{{ route('home', ['category' => $category['name']]) }}" 
                       class="stagger-item group flex flex-col items-center p-4 bg-white rounded-xl border border-olive/20 hover:border-sage hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 {{ isset($selectedCategory) && $selectedCategory == $category['name'] ? 'ring-2 ring-sage' : '' }}">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-3 transition-all duration-300 {{ $colorClasses[$category['color']] }}">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $category['icon'] }}"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-forest text-center">{{ $category['name'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Products Section --}}
    <section class="py-16 bg-olive/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 scroll-reveal">
                <div>
                    @if(isset($selectedCategory))
                        <h2 class="text-2xl md:text-3xl font-bold text-forest">Produk {{ $selectedCategory }}</h2>
                        <p class="text-forest/60 mt-1">Menampilkan {{ $products->count() }} produk</p>
                    @else
                        <h2 class="text-2xl md:text-3xl font-bold text-forest">Produk Populer</h2>
                        <p class="text-forest/60 mt-1">Produk terlaris dari penjual terpercaya</p>
                    @endif
                </div>
                
                {{-- Filter Tabs --}}
                @if(!isset($selectedCategory))
                    <div class="flex items-center gap-2 bg-white rounded-xl p-1 shadow-sm">
                        <a href="{{ route('home', ['filter' => 'untuk_anda']) }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 {{ !isset($selectedFilter) || $selectedFilter == 'untuk_anda' ? 'bg-sage text-cream' : 'text-forest/60 hover:text-forest' }}">
                            Untuk Anda
                        </a>
                        <a href="{{ route('home', ['filter' => 'terlaris']) }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 {{ isset($selectedFilter) && $selectedFilter == 'terlaris' ? 'bg-sage text-cream' : 'text-forest/60 hover:text-forest' }}">
                            Terlaris
                        </a>
                        <a href="{{ route('home', ['filter' => 'terbaru']) }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 {{ isset($selectedFilter) && $selectedFilter == 'terbaru' ? 'bg-sage text-cream' : 'text-forest/60 hover:text-forest' }}">
                            Terbaru
                        </a>
                    </div>
                @endif
            </div>

            {{-- Products Grid --}}
            @if($products->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl">
                    <div class="w-24 h-24 bg-olive/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-forest/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-forest mb-2">Belum ada produk</h3>
                    <p class="text-forest/60 mb-6">
                        @if(isset($selectedCategory))
                            Belum ada produk di kategori {{ $selectedCategory }}
                        @else
                            Produk akan segera tersedia
                        @endif
                    </p>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-sage text-cream px-6 py-3 rounded-xl font-medium hover:bg-forest transition-colors duration-300">
                        Lihat Semua Produk
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($products as $index => $product)
                        <a href="{{ route('products.show', $product->id) }}" 
                           class="stagger-item group bg-white rounded-xl overflow-hidden border border-olive/20 hover:border-sage hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            {{-- Product Image --}}
                            <div class="relative aspect-square bg-cream overflow-hidden">
                                @if($product->discount_percentage > 0)
                                    <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-lg font-medium z-10">
                                        -{{ $product->discount_percentage }}%
                                    </span>
                                @endif
                                <img src="{{ $product->main_photo ? asset('storage/' . $product->main_photo) : 'https://via.placeholder.com/200x200/D2DCB6/778873?text=No+Image' }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                     loading="lazy">
                                @if($product->badge)
                                    <span class="absolute bottom-2 left-2 bg-sage text-cream text-xs px-2 py-1 rounded-lg font-medium">
                                        {{ $product->badge }}
                                    </span>
                                @endif
                            </div>
                            
                            {{-- Product Info --}}
                            <div class="p-4">
                                <h3 class="text-sm text-forest font-medium mb-2 line-clamp-2 group-hover:text-sage transition-colors">
                                    {{ $product->name }}
                                </h3>
                                <div class="flex items-baseline gap-2 mb-2">
                                    <span class="text-lg font-bold text-forest">{{ $product->formatted_price }}</span>
                                    @if($product->original_price)
                                        <span class="text-xs text-forest/40 line-through">{{ $product->formatted_original_price }}</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2 text-xs text-forest/60">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span>{{ number_format($product->rating / 10, 1) }}</span>
                                    </div>
                                    <span>•</span>
                                    <span>{{ $product->sold_count }}+ terjual</span>
                                </div>
                                <p class="text-xs text-forest/50 mt-2 truncate">{{ $product->location ?? 'Indonesia' }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Load More --}}
                <div class="text-center mt-12">
                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center gap-2 bg-white text-forest px-8 py-3 rounded-xl font-medium border-2 border-olive hover:border-sage hover:bg-cream transition-all duration-300">
                        Lihat Semua Produk
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-gradient-to-br from-forest to-sage relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-64 h-64 bg-cream/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-cream/5 rounded-full translate-x-1/2 translate-y-1/2"></div>
        </div>
        
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center scroll-reveal">
            <h2 class="text-3xl md:text-4xl font-bold text-cream mb-6">
                Siap Menjadi Penjual di MartPlace?
            </h2>
            <p class="text-cream/80 text-lg mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan penjual sukses di MartPlace. Dapatkan akses ke jutaan pembeli 
                di seluruh Indonesia dan kembangkan bisnis Anda bersama kami.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('sellers.create') }}" 
                   class="inline-flex items-center justify-center gap-2 bg-cream text-forest px-8 py-4 rounded-xl font-semibold hover:bg-olive transform hover:-translate-y-1 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Daftar Sekarang
                </a>
                <a href="{{ route('sellers.index') }}" 
                   class="inline-flex items-center justify-center gap-2 bg-transparent text-cream px-8 py-4 rounded-xl font-semibold border-2 border-cream/30 hover:border-cream hover:bg-cream/10 transition-all duration-300">
                    Lihat Toko Lainnya
                </a>
            </div>
        </div>
    </section>
@endsection
