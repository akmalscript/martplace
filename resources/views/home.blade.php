@extends('layouts.master')

@section('title', 'Beranda')

@push('styles')
<style>
    /* Hero Section Gradient */
    .hero-gradient {
        background: linear-gradient(135deg, #F1F3E0 0%, #D2DCB6 30%, #A1BC98 60%, #778873 100%);
    }
    
    /* Floating Animation */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    .animate-float-delayed {
        animation: float 6s ease-in-out infinite;
        animation-delay: 2s;
    }
    
    /* Pulse glow animation */
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(161, 188, 152, 0.3); }
        50% { box-shadow: 0 0 40px rgba(161, 188, 152, 0.6); }
    }
    
    .animate-pulse-glow {
        animation: pulse-glow 3s ease-in-out infinite;
    }
    
    /* Product Card Hover Effect */
    .product-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .product-card:hover {
        transform: scale(1.03) translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(119, 136, 115, 0.25);
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .product-card .product-image {
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Category Card Hover */
    .category-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -10px rgba(119, 136, 115, 0.2);
    }
    
    .category-card:hover .category-icon {
        transform: scale(1.1);
        animation: bounce-soft 0.5s ease-in-out;
    }
    
    .category-icon {
        transition: transform 0.3s ease;
    }
    
    @keyframes bounce-soft {
        0%, 100% { transform: scale(1.1) translateY(0); }
        50% { transform: scale(1.1) translateY(-5px); }
    }
    
    /* Button Gradient Hover */
    .btn-gradient {
        background: linear-gradient(135deg, #A1BC98 0%, #778873 100%);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .btn-gradient:hover {
        background: linear-gradient(135deg, #778873 0%, #A1BC98 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px -5px rgba(119, 136, 115, 0.4);
    }
    
    /* Stagger Animation with Custom Delays */
    .stagger-grid > *:nth-child(1) { animation-delay: 0s; }
    .stagger-grid > *:nth-child(2) { animation-delay: 0.1s; }
    .stagger-grid > *:nth-child(3) { animation-delay: 0.2s; }
    .stagger-grid > *:nth-child(4) { animation-delay: 0.3s; }
    .stagger-grid > *:nth-child(5) { animation-delay: 0.4s; }
    .stagger-grid > *:nth-child(6) { animation-delay: 0.5s; }
    .stagger-grid > *:nth-child(7) { animation-delay: 0.6s; }
    .stagger-grid > *:nth-child(8) { animation-delay: 0.7s; }
    .stagger-grid > *:nth-child(9) { animation-delay: 0.8s; }
    .stagger-grid > *:nth-child(10) { animation-delay: 0.9s; }
    .stagger-grid > *:nth-child(11) { animation-delay: 1.0s; }
    .stagger-grid > *:nth-child(12) { animation-delay: 1.1s; }
    .stagger-grid > *:nth-child(n+13) { animation-delay: 1.2s; }
    
    /* Filter Tab Active State */
    .filter-tab {
        position: relative;
        transition: all 0.3s ease;
    }
    
    .filter-tab::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 3px;
        background: linear-gradient(90deg, #A1BC98, #778873);
        border-radius: 2px;
        transition: width 0.3s ease;
    }
    
    .filter-tab:hover::after,
    .filter-tab.active::after {
        width: 100%;
    }
    
    /* Stats Counter Animation */
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .stat-card:hover {
        transform: translateY(-5px) scale(1.02);
    }
    
    .stat-card:hover .stat-icon {
        animation: bounce-soft 0.6s ease-in-out;
    }
    
    /* Badge Shimmer Effect */
    .badge-shimmer {
        position: relative;
        overflow: hidden;
    }
    
    .badge-shimmer::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shimmer 2s infinite;
    }
    
    @keyframes shimmer {
        100% { left: 100%; }
    }
    
    /* Section Reveal */
    .section-reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .section-reveal.revealed {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-cream via-olive/30 to-sage/20 py-16 lg:py-24">
        <!-- Decorative Elements -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-sage/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-olive/20 rounded-full blur-3xl animate-float-delayed"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gradient-radial from-sage/5 to-transparent rounded-full"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                <!-- Hero Content -->
                <div class="lg:w-1/2 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/70 backdrop-blur-sm rounded-full text-forest/80 text-sm font-medium mb-6 animate-fade-in-up">
                        <span class="w-2 h-2 bg-sage rounded-full animate-pulse"></span>
                        Marketplace Terpercaya #1 di Indonesia
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-forest leading-tight mb-6 animate-fade-in-up" style="animation-delay: 0.1s">
                        Temukan Produk
                        <span class="bg-gradient-to-r from-sage to-forest bg-clip-text text-transparent">
                            Berkualitas
                        </span>
                        Terbaik
                    </h1>
                    
                    <p class="text-lg text-forest/70 mb-8 max-w-xl mx-auto lg:mx-0 animate-fade-in-up" style="animation-delay: 0.2s">
                        Belanja lebih mudah, hemat, dan aman di MartPlace. Ribuan produk dari penjual terpercaya di seluruh Indonesia.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start animate-fade-in-up" style="animation-delay: 0.3s">
                        <a href="{{ route('products.index') }}" 
                           class="btn-gradient text-cream px-8 py-4 rounded-xl font-semibold text-center inline-flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Mulai Belanja
                        </a>
                        <a href="{{ route('sellers.create') }}" 
                           class="bg-white text-forest px-8 py-4 rounded-xl font-semibold border-2 border-olive hover:border-sage hover:bg-olive/10 transition-all duration-300 text-center inline-flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Buka Toko Gratis
                        </a>
                    </div>
                </div>
                
                <!-- Hero Stats -->
                <div class="lg:w-1/2">
                    <div class="grid grid-cols-2 gap-4 max-w-md mx-auto lg:max-w-none">
                        <div class="stat-card bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-olive/30 animate-fade-in-up" style="animation-delay: 0.2s">
                            <div class="stat-icon w-12 h-12 bg-sage/20 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <p class="text-3xl font-bold text-forest">{{ number_format($stats['totalProducts'] ?? 0) }}+</p>
                            <p class="text-forest/60 text-sm">Produk Tersedia</p>
                        </div>
                        
                        <div class="stat-card bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-olive/30 animate-fade-in-up" style="animation-delay: 0.3s">
                            <div class="stat-icon w-12 h-12 bg-olive/30 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <p class="text-3xl font-bold text-forest">{{ number_format($stats['totalSellers'] ?? 0) }}+</p>
                            <p class="text-forest/60 text-sm">Penjual Aktif</p>
                        </div>
                        
                        <div class="stat-card bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-olive/30 animate-fade-in-up" style="animation-delay: 0.4s">
                            <div class="stat-icon w-12 h-12 bg-forest/10 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <p class="text-3xl font-bold text-forest">{{ $stats['totalProvinces'] ?? 0 }}+</p>
                            <p class="text-forest/60 text-sm">Provinsi Terjangkau</p>
                        </div>
                        
                        <div class="stat-card bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-olive/30 animate-fade-in-up" style="animation-delay: 0.5s">
                            <div class="stat-icon w-12 h-12 bg-cream rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-sage" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <p class="text-3xl font-bold text-forest">{{ number_format($stats['totalReviews'] ?? 0) }}+</p>
                            <p class="text-forest/60 text-sm">Ulasan Pelanggan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Section -->
    <section class="py-16 bg-cream section-reveal" id="categories">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-10">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-forest mb-2">Kategori Pilihan</h2>
                    <p class="text-forest/60">Temukan produk berdasarkan kategori favoritmu</p>
                </div>
                @if (isset($selectedCategory))
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center gap-2 text-sage hover:text-forest font-medium transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Semua Kategori
                    </a>
                @endif
            </div>

            @if(isset($categories) && $categories->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-8 gap-4 stagger-grid">
                    @php
                        $categoryIcons = [
                            'bg-sage/20 text-sage',
                            'bg-olive/30 text-forest',
                            'bg-forest/10 text-forest',
                            'bg-cream text-sage',
                            'bg-sage/30 text-forest',
                            'bg-olive/20 text-forest',
                            'bg-forest/20 text-forest',
                            'bg-sage/10 text-sage',
                        ];
                    @endphp
                    @foreach($categories->take(8) as $index => $category)
                        @php
                            $colorClass = $categoryIcons[$index % count($categoryIcons)];
                        @endphp
                        <a href="{{ route('home', ['category' => $category->name]) }}"
                           class="category-card flex flex-col items-center p-5 bg-white rounded-2xl border border-olive/20 hover:border-sage group stagger-item {{ isset($selectedCategory) && $selectedCategory == $category->name ? 'ring-2 ring-sage bg-sage/5' : '' }}">
                            <div class="category-icon w-14 h-14 {{ $colorClass }} rounded-xl flex items-center justify-center mb-3">
                                @if($category->icon)
                                    <span class="text-2xl">{{ $category->icon }}</span>
                                @else
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>
                            <span class="text-sm font-medium text-forest text-center line-clamp-2 group-hover:text-sage transition-colors">
                                {{ $category->name }}
                            </span>
                            @if($category->products_count > 0)
                                <span class="text-xs text-forest/50 mt-1">{{ $category->products_count }} produk</span>
                            @endif
                        </a>
                    @endforeach
                </div>
                
                @if($categories->count() > 8)
                    <div class="text-center mt-8" x-data="{ showAll: false }">
                        <button type="button" 
                                @click="showAll = !showAll"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-olive hover:border-sage text-forest rounded-xl font-medium transition-all duration-300 hover:shadow-md">
                            <span x-text="showAll ? 'Sembunyikan' : 'Lihat Semua Kategori ({{ $categories->count() }})'"></span>
                            <svg class="w-4 h-4 transition-transform duration-300" :class="showAll ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="showAll" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform -translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="mt-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                            @foreach($categories->skip(8) as $index => $category)
                                @php
                                    $colorClass = $categoryIcons[($index + 8) % count($categoryIcons)];
                                @endphp
                                <a href="{{ route('home', ['category' => $category->name]) }}"
                                   class="category-card flex items-center gap-3 p-4 bg-white rounded-xl border border-olive/20 hover:border-sage group {{ isset($selectedCategory) && $selectedCategory == $category->name ? 'ring-2 ring-sage' : '' }}">
                                    <div class="category-icon w-10 h-10 {{ $colorClass }} rounded-lg flex items-center justify-center flex-shrink-0">
                                        @if($category->icon)
                                            <span class="text-lg">{{ $category->icon }}</span>
                                        @else
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-sm font-medium text-forest block truncate group-hover:text-sage transition-colors">
                                            {{ $category->name }}
                                        </span>
                                        @if($category->products_count > 0)
                                            <span class="text-xs text-forest/50">{{ $category->products_count }} produk</span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-12 bg-white rounded-2xl border border-olive/20">
                    <div class="w-16 h-16 bg-olive/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-forest/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <p class="text-forest/60">Belum ada kategori tersedia</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-16 bg-olive/10 section-reveal" id="products">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header with Filter Tabs -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
                <div>
                    @if (isset($selectedCategory))
                        <h2 class="text-2xl md:text-3xl font-bold text-forest mb-2">Produk {{ $selectedCategory }}</h2>
                        <p class="text-forest/60">Menampilkan {{ $products->count() }} produk dalam kategori ini</p>
                    @else
                        <h2 class="text-2xl md:text-3xl font-bold text-forest mb-2">Produk Pilihan</h2>
                        <p class="text-forest/60">Produk terbaik yang kami rekomendasikan untukmu</p>
                    @endif
                </div>
                
                @if (!isset($selectedCategory))
                    <div class="flex items-center gap-1 bg-white p-1.5 rounded-xl border border-olive/20">
                        <a href="{{ route('home', ['filter' => 'untuk_anda']) }}"
                           class="filter-tab px-5 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 {{ !isset($selectedFilter) || $selectedFilter == 'untuk_anda' ? 'active bg-sage text-cream' : 'text-forest/70 hover:text-forest hover:bg-olive/10' }}">
                            Untuk Anda
                        </a>
                        <a href="{{ route('home', ['filter' => 'terlaris']) }}"
                           class="filter-tab px-5 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 {{ isset($selectedFilter) && $selectedFilter == 'terlaris' ? 'active bg-sage text-cream' : 'text-forest/70 hover:text-forest hover:bg-olive/10' }}">
                            Terlaris
                        </a>
                        <a href="{{ route('home', ['filter' => 'terbaru']) }}"
                           class="filter-tab px-5 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 {{ isset($selectedFilter) && $selectedFilter == 'terbaru' ? 'active bg-sage text-cream' : 'text-forest/70 hover:text-forest hover:bg-olive/10' }}">
                            Terbaru
                        </a>
                    </div>
                @endif
            </div>

            @if ($products->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-16 bg-white rounded-3xl border border-olive/20">
                    <div class="w-24 h-24 bg-olive/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-forest/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    @if (isset($selectedCategory))
                        <h3 class="text-xl font-semibold text-forest mb-2">Belum ada produk di kategori {{ $selectedCategory }}</h3>
                        <p class="text-forest/60 mb-6">Silakan pilih kategori lain atau lihat semua produk.</p>
                        <a href="{{ route('home') }}" class="btn-gradient text-cream px-8 py-3 rounded-xl font-semibold inline-block">
                            Lihat Semua Kategori
                        </a>
                    @else
                        <h3 class="text-xl font-semibold text-forest mb-2">Belum ada produk</h3>
                        <p class="text-forest/60">Produk akan segera tersedia.</p>
                    @endif
                </div>
            @else
                <!-- Products Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-6 stagger-grid">
                    @foreach ($products as $product)
                        <a href="{{ route('products.show', $product->id) }}"
                           class="product-card bg-white rounded-2xl overflow-hidden border border-olive/10 stagger-item group">
                            <!-- Product Image -->
                            <div class="relative aspect-square overflow-hidden bg-olive/5">
                                @if ($product->discount_percentage > 0)
                                    <span class="badge-shimmer absolute top-3 left-3 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-semibold px-2.5 py-1 rounded-lg z-10">
                                        -{{ $product->discount_percentage }}%
                                    </span>
                                @endif
                                <img src="{{ $product->image_url }}" 
                                     alt="{{ $product->name }}"
                                     class="product-image w-full h-full object-cover"
                                     onerror="this.onerror=null; this.src='https://placehold.co/300x300/D2DCB6/778873?text=No+Image'"
                                     loading="lazy">
                                @if ($product->badge)
                                    <span class="absolute bottom-3 left-3 bg-forest/90 backdrop-blur-sm text-cream text-xs font-medium px-2.5 py-1 rounded-lg">
                                        {{ $product->badge }}
                                    </span>
                                @endif
                                
                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-forest/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-4">
                                    <span class="text-cream text-sm font-medium flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Lihat Detail
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="p-4">
                                <h3 class="text-sm font-medium text-forest mb-2 line-clamp-2 group-hover:text-sage transition-colors min-h-[40px]">
                                    {{ $product->name }}
                                </h3>
                                
                                <div class="flex items-baseline gap-2 mb-3">
                                    <span class="text-lg font-bold text-forest">{{ $product->formatted_price }}</span>
                                    @if ($product->original_price)
                                        <span class="text-xs text-forest/40 line-through">{{ $product->formatted_original_price }}</span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-1 text-forest/60">
                                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span>{{ number_format($product->rating / 10, 1) }}</span>
                                        <span class="text-forest/30">|</span>
                                        <span>{{ number_format($product->sold_count) }}+ terjual</span>
                                    </div>
                                </div>
                                
                                <div class="mt-3 pt-3 border-t border-olive/10">
                                    <p class="text-xs text-forest/50 flex items-center gap-1 truncate">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $product->location }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                
                <!-- View All Products -->
                <div class="text-center mt-12">
                    <p class="text-forest/60 mb-4">Menampilkan {{ $products->count() }} produk</p>
                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center gap-2 px-8 py-4 bg-white border-2 border-sage text-sage hover:bg-sage hover:text-cream rounded-xl font-semibold transition-all duration-300 hover:shadow-lg hover:shadow-sage/20">
                        Lihat Semua Produk
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-sage via-forest to-forest relative overflow-hidden section-reveal">
        <!-- Decorative Elements -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-olive/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-cream/90 text-sm font-medium mb-6">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Bergabung Bersama Ribuan Penjual Sukses
            </div>
            
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-cream mb-6">
                Mulai Jual Produkmu <br class="hidden sm:block"/>di MartPlace
            </h2>
            
            <p class="text-lg text-cream/80 mb-10 max-w-2xl mx-auto">
                Gratis daftar, mudah kelola, dan jangkau jutaan pelanggan di seluruh Indonesia. 
                Wujudkan impian bisnis onlinemu bersama MartPlace.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('sellers.create') }}" 
                   class="group bg-cream text-forest px-8 py-4 rounded-xl font-semibold hover:bg-white transition-all duration-300 inline-flex items-center justify-center gap-2 hover:shadow-xl">
                    Daftar Sekarang - Gratis!
                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                <a href="{{ route('sellers.index') }}" 
                   class="bg-transparent border-2 border-cream/50 text-cream px-8 py-4 rounded-xl font-semibold hover:bg-cream/10 hover:border-cream transition-all duration-300 inline-flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Lihat Direktori Toko
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for scroll reveal animations
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                
                // Trigger stagger animation for grid items
                if (entry.target.querySelector('.stagger-grid')) {
                    const items = entry.target.querySelectorAll('.stagger-item');
                    items.forEach((item, index) => {
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, index * 100);
                    });
                }
                
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe all sections with reveal animation
    document.querySelectorAll('.section-reveal').forEach(el => {
        observer.observe(el);
    });
    
    // Initialize stagger items
    document.querySelectorAll('.stagger-item').forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
    });
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
@endpush
