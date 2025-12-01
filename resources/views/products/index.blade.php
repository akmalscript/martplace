@extends('layouts.master')

@section('title', 'Produk')

@push('styles')
<style>
    .product-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .product-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(119, 136, 115, 0.25);
    }
    
    .product-card:hover .product-image {
        transform: scale(1.08);
    }
    
    .product-card:hover .product-overlay {
        opacity: 1;
    }
    
    .product-card:hover .quick-view-btn {
        transform: translateY(0);
        opacity: 1;
    }
    
    .product-image {
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .product-overlay {
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    
    .quick-view-btn {
        transform: translateY(10px);
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .filter-btn {
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .filter-btn::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #A1BC98, #778873);
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }
    
    .filter-btn:hover::after,
    .filter-btn.active::after {
        width: 80%;
    }
    
    .filter-btn:hover {
        transform: translateY(-2px);
    }
    
    .stagger-item {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.5s ease-out forwards;
    }
    
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .stagger-item:nth-child(1) { animation-delay: 0.05s; }
    .stagger-item:nth-child(2) { animation-delay: 0.1s; }
    .stagger-item:nth-child(3) { animation-delay: 0.15s; }
    .stagger-item:nth-child(4) { animation-delay: 0.2s; }
    .stagger-item:nth-child(5) { animation-delay: 0.25s; }
    .stagger-item:nth-child(6) { animation-delay: 0.3s; }
    .stagger-item:nth-child(7) { animation-delay: 0.35s; }
    .stagger-item:nth-child(8) { animation-delay: 0.4s; }
    .stagger-item:nth-child(9) { animation-delay: 0.45s; }
    .stagger-item:nth-child(10) { animation-delay: 0.5s; }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative py-12 lg:py-16 overflow-hidden bg-gradient-to-br from-cream via-olive/20 to-sage/10">
    <div class="absolute top-10 left-10 w-64 h-64 bg-sage/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 right-10 w-80 h-80 bg-olive/15 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            @if (request('search'))
                <div class="inline-flex items-center px-4 py-2 bg-sage/20 text-forest rounded-full text-sm font-medium mb-6">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Hasil Pencarian
                </div>
                <h1 class="text-3xl lg:text-5xl font-bold text-forest mb-4">
                    Hasil untuk "<span class="text-sage">{{ request('search') }}</span>"
                </h1>
                <p class="text-lg text-forest/70">Ditemukan <span class="font-semibold text-sage">{{ $products->total() }}</span> produk yang sesuai</p>
            @else
                <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-sage/20 to-olive/20 text-forest rounded-full text-sm font-medium mb-6">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                    Koleksi Terbaik
                </div>
                <h1 class="text-3xl lg:text-5xl font-bold text-forest mb-4">
                    Temukan Produk <span class="text-sage">Impianmu</span>
                </h1>
                <p class="text-lg text-forest/70">Jelajahi <span class="font-semibold text-sage">{{ $products->total() }}</span> produk berkualitas dengan harga terbaik</p>
            @endif
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Search Bar (Mobile) -->
    <div class="mb-6 lg:hidden">
        <form action="{{ route('products.index') }}" method="GET" class="relative">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari produk..."
                class="w-full pl-12 pr-4 py-3 bg-white border border-olive/30 rounded-xl focus:outline-none focus:ring-2 focus:ring-sage focus:border-sage transition">
            <div class="absolute left-4 top-1/2 -translate-y-1/2">
                <svg class="h-5 w-5 text-forest/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </form>
    </div>

    <!-- Filter & Sort Section -->
    <div class="mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-olive/10 p-4 lg:p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex flex-wrap gap-2 lg:gap-3">
                    <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'latest'])) }}"
                        class="filter-btn px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ request('sort', 'latest') == 'latest' ? 'bg-gradient-to-r from-sage to-forest text-cream shadow-lg active' : 'bg-olive/10 text-forest hover:bg-olive/20' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Terbaru
                        </span>
                    </a>
                    <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'popular'])) }}"
                        class="filter-btn px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ request('sort') == 'popular' ? 'bg-gradient-to-r from-sage to-forest text-cream shadow-lg active' : 'bg-olive/10 text-forest hover:bg-olive/20' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            Terpopuler
                        </span>
                    </a>
                    <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_asc'])) }}"
                        class="filter-btn px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ request('sort') == 'price_asc' ? 'bg-gradient-to-r from-sage to-forest text-cream shadow-lg active' : 'bg-olive/10 text-forest hover:bg-olive/20' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                            </svg>
                            Termurah
                        </span>
                    </a>
                    <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_desc'])) }}"
                        class="filter-btn px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ request('sort') == 'price_desc' ? 'bg-gradient-to-r from-sage to-forest text-cream shadow-lg active' : 'bg-olive/10 text-forest hover:bg-olive/20' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                            </svg>
                            Termahal
                        </span>
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-sm text-forest/60">{{ $products->total() }} produk</span>
                </div>
            </div>
        </div>
    </div>

    @if ($products->isEmpty())
        <div class="text-center py-20">
            <div class="w-24 h-24 bg-olive/10 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-forest/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-forest mb-2">Produk Tidak Ditemukan</h3>
            <p class="text-forest/60 mb-8 max-w-md mx-auto">Coba gunakan kata kunci lain atau jelajahi kategori produk kami yang lain.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-sage to-forest text-cream rounded-xl font-semibold hover:shadow-lg transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Lihat Semua Produk
            </a>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 lg:gap-6 mb-10">
            @foreach ($products as $index => $product)
                <a href="{{ route('products.show', $product->id) }}"
                    class="stagger-item product-card group bg-white rounded-2xl shadow-sm border border-olive/10 overflow-hidden hover:border-sage/50">
                    <div class="relative aspect-square overflow-hidden bg-olive/5">
                        @if ($product->discount_percentage > 0)
                            <div class="absolute top-3 left-3 z-20">
                                <span class="inline-flex items-center px-2.5 py-1 bg-gradient-to-r from-red-500 to-rose-500 text-white text-xs font-bold rounded-lg shadow-lg">
                                    -{{ $product->discount_percentage }}%
                                </span>
                            </div>
                        @endif

                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="product-image w-full h-full object-cover"
                            onerror="this.onerror=null; this.src='https://placehold.co/300x300/D2DCB6/778873?text=No+Image'"
                            loading="lazy">

                        <div class="product-overlay absolute inset-0 bg-gradient-to-t from-forest/60 via-transparent to-transparent flex items-end justify-center pb-4">
                            <span class="quick-view-btn px-4 py-2 bg-cream/95 text-forest text-sm font-semibold rounded-xl shadow-lg">
                                Lihat Detail
                            </span>
                        </div>

                        @if ($product->badge)
                            <div class="absolute bottom-3 left-3 z-10">
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-lg
                                    {{ $product->badge == 'Terkirim cepat' ? 'bg-gradient-to-r from-orange-400 to-amber-400 text-white' : 
                                       ($product->badge == 'Best Seller' ? 'bg-gradient-to-r from-amber-400 to-yellow-400 text-forest' : 
                                       'bg-gradient-to-r from-sage to-forest text-cream') }}">
                                    @if($product->badge == 'Best Seller')
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endif
                                    {{ $product->badge }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="p-4">
                        <h3 class="text-sm font-medium text-forest mb-2 line-clamp-2 group-hover:text-sage transition-colors min-h-[40px]">
                            {{ $product->name }}
                        </h3>

                        <div class="flex items-baseline gap-2 mb-3">
                            <span class="text-lg font-bold text-sage">
                                {{ $product->formatted_price }}
                            </span>
                            @if ($product->original_price)
                                <span class="text-xs text-forest/40 line-through">
                                    {{ $product->formatted_original_price }}
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center gap-3 mb-2">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="text-xs font-medium text-forest">{{ number_format($product->rating / 10, 1) }}</span>
                            </div>
                            <span class="text-olive/50">|</span>
                            <span class="text-xs text-forest/60">{{ number_format($product->sold_count) }} terjual</span>
                        </div>

                        <div class="flex items-center gap-1 text-xs text-forest/50">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="truncate">{{ $product->location }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            <div class="bg-white rounded-2xl shadow-sm border border-olive/10 px-6 py-4">
                {{ $products->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
