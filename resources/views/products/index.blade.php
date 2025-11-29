<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        html {
            scroll-behavior: smooth;
        }

        .navbar-blur {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            background-color: rgba(255, 255, 255, 0.85);
        }

        .navbar-solid {
            backdrop-filter: none;
            background-color: rgba(255, 255, 255, 1);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .animate-on-scroll.animated {
            opacity: 1;
            transform: translateY(0);
        }

        .stagger-item {
            opacity: 0;
            transform: translateY(40px) scale(0.95);
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
        }

        .stagger-item.animated {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .product-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
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

        .btn-elegant {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-elegant::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-elegant:hover::before {
            left: 100%;
        }

        .btn-elegant:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4);
        }

        .filter-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .filter-btn::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #10b981, #06b6d4);
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

        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.5;
            animation: float 6s ease-in-out infinite;
        }

        .search-input {
            transition: all 0.3s ease;
        }

        .search-input:focus {
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }

        .badge-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #10b981, #06b6d4);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #059669, #0891b2);
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-50 via-white to-cyan-50 min-h-screen" x-data="{
    scrolled: false,
    init() {
        window.addEventListener('scroll', () => {
            this.scrolled = window.scrollY > 20;
        });
        this.initScrollAnimations();
    },
    initScrollAnimations() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    if (entry.target.classList.contains('stagger-item')) {
                        const delay = entry.target.dataset.index * 100;
                        setTimeout(() => {
                            entry.target.classList.add('animated');
                        }, delay);
                    } else {
                        entry.target.classList.add('animated');
                    }
                }
            });
        }, { threshold: 0.1, rootMargin: '50px' });

        document.querySelectorAll('.animate-on-scroll, .stagger-item').forEach(el => {
            observer.observe(el);
        });
    }
}">
    <!-- Decorative Background Orbs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="gradient-orb w-96 h-96 bg-emerald-300 top-0 -right-48" style="animation-delay: 0s;"></div>
        <div class="gradient-orb w-80 h-80 bg-cyan-300 bottom-1/4 -left-40" style="animation-delay: 2s;"></div>
        <div class="gradient-orb w-64 h-64 bg-teal-200 top-1/2 right-1/4" style="animation-delay: 4s;"></div>
    </div>

    <!-- Navbar with Blur on Scroll -->
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-500"
         :class="scrolled ? 'navbar-blur shadow-lg shadow-emerald-500/5' : 'navbar-solid'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 lg:h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="group flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-cyan-500 rounded-xl flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300">
                            <span class="text-white font-bold text-lg">M</span>
                        </div>
                        <span class="text-2xl font-bold gradient-text hidden sm:block">MartPlace</span>
                    </a>
                </div>

                <div class="hidden md:flex flex-1 max-w-xl mx-8">
                    <form action="{{ route('products.index') }}" method="GET" class="relative w-full group">
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-cyan-500 rounded-2xl blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari produk impianmu..."
                            class="search-input relative w-full pl-12 pr-6 py-3.5 bg-white/80 backdrop-blur border border-slate-200 rounded-2xl focus:outline-none focus:border-emerald-400 text-slate-700 placeholder-slate-400 transition-all">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2">
                            <svg class="h-5 w-5 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white rounded-xl text-sm font-medium hover:shadow-lg hover:shadow-emerald-500/25 transition-all duration-300">
                            Cari
                        </button>
                    </form>
                </div>

                <div class="flex items-center space-x-3 lg:space-x-6">
                    <a href="{{ route('home') }}" class="hidden sm:flex items-center space-x-1 text-slate-600 hover:text-emerald-600 transition-colors group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="font-medium">Beranda</span>
                    </a>
                    
                    <a href="{{ route('sellers.index') }}" class="hidden sm:flex items-center space-x-1 text-slate-600 hover:text-emerald-600 transition-colors group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span class="font-medium">Toko</span>
                    </a>

                    <button class="relative p-2 text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-rose-500 to-pink-500 text-white text-xs rounded-full flex items-center justify-center font-medium">0</span>
                    </button>

                    @guest
                        <a href="{{ route('login') }}" class="btn-elegant px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white rounded-xl font-semibold text-sm">
                            Masuk
                        </a>
                    @else
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 p-2 hover:bg-slate-100 rounded-xl transition-colors">
                                <div class="w-9 h-9 bg-gradient-to-br from-emerald-400 to-cyan-400 rounded-xl flex items-center justify-center text-white font-semibold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                class="absolute right-0 mt-2 w-56 glass rounded-2xl shadow-xl py-2 z-50" style="display: none;">
                                <div class="px-4 py-3 border-b border-slate-100">
                                    <p class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                    </svg>
                                    Dashboard
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2.5 text-sm text-slate-700 hover:bg-rose-50 hover:text-rose-600 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
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

    <!-- Hero Section -->
    <section class="relative pt-24 lg:pt-32 pb-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="animate-on-scroll text-center max-w-3xl mx-auto">
                @if (request('search'))
                    <div class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-medium mb-6">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Hasil Pencarian
                    </div>
                    <h1 class="text-4xl lg:text-5xl font-bold text-slate-900 mb-4">
                        Hasil untuk "<span class="gradient-text">{{ request('search') }}</span>"
                    </h1>
                    <p class="text-lg text-slate-600">Ditemukan <span class="font-semibold text-emerald-600">{{ $products->total() }}</span> produk yang sesuai</p>
                @else
                    <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-100 to-cyan-100 text-emerald-700 rounded-full text-sm font-medium mb-6 badge-pulse">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                        Koleksi Terbaik
                    </div>
                    <h1 class="text-4xl lg:text-6xl font-bold text-slate-900 mb-4">
                        Temukan Produk <span class="gradient-text">Impianmu</span>
                    </h1>
                    <p class="text-lg lg:text-xl text-slate-600">Jelajahi <span class="font-semibold text-emerald-600">{{ $products->total() }}</span> produk berkualitas dengan harga terbaik</p>
                @endif
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 relative z-10">
        <!-- Filter & Sort Section -->
        <div class="animate-on-scroll mb-10">
            <div class="glass rounded-2xl p-4 lg:p-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex flex-wrap gap-2 lg:gap-3">
                        <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'latest'])) }}"
                            class="filter-btn px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ request('sort', 'latest') == 'latest' ? 'bg-gradient-to-r from-emerald-500 to-cyan-500 text-white shadow-lg shadow-emerald-500/25 active' : 'bg-white text-slate-600 hover:text-emerald-600 shadow-sm' }}">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Terbaru
                            </span>
                        </a>
                        <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'popular'])) }}"
                            class="filter-btn px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ request('sort') == 'popular' ? 'bg-gradient-to-r from-emerald-500 to-cyan-500 text-white shadow-lg shadow-emerald-500/25 active' : 'bg-white text-slate-600 hover:text-emerald-600 shadow-sm' }}">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                Terpopuler
                            </span>
                        </a>
                        <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_asc'])) }}"
                            class="filter-btn px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ request('sort') == 'price_asc' ? 'bg-gradient-to-r from-emerald-500 to-cyan-500 text-white shadow-lg shadow-emerald-500/25 active' : 'bg-white text-slate-600 hover:text-emerald-600 shadow-sm' }}">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                                </svg>
                                Termurah
                            </span>
                        </a>
                        <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_desc'])) }}"
                            class="filter-btn px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ request('sort') == 'price_desc' ? 'bg-gradient-to-r from-emerald-500 to-cyan-500 text-white shadow-lg shadow-emerald-500/25 active' : 'bg-white text-slate-600 hover:text-emerald-600 shadow-sm' }}">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                                </svg>
                                Termahal
                            </span>
                        </a>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="text-sm text-slate-500">Tampilan:</span>
                        <div class="flex bg-white rounded-xl p-1 shadow-sm">
                            <button class="p-2 rounded-lg bg-emerald-100 text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </button>
                            <button class="p-2 rounded-lg text-slate-400 hover:text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($products->isEmpty())
            <div class="animate-on-scroll text-center py-20">
                <div class="relative inline-block">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-cyan-400 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                    <div class="relative w-32 h-32 bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Oops! Produk Tidak Ditemukan</h3>
                <p class="text-slate-500 mb-8 max-w-md mx-auto">Coba gunakan kata kunci lain atau jelajahi kategori produk kami yang lain.</p>
                <a href="{{ route('products.index') }}" class="btn-elegant inline-flex items-center gap-2 px-8 py-3.5 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white rounded-xl font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Lihat Semua Produk
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 lg:gap-6 mb-12">
                @foreach ($products as $index => $product)
                    <a href="{{ route('products.show', $product->id) }}"
                        class="stagger-item product-card group bg-white rounded-2xl shadow-sm overflow-hidden"
                        data-index="{{ $index }}">
                        <div class="relative aspect-square overflow-hidden bg-gradient-to-br from-slate-100 to-slate-50">
                            @if ($product->discount_percentage > 0)
                                <div class="absolute top-3 left-3 z-20">
                                    <span class="inline-flex items-center px-2.5 py-1 bg-gradient-to-r from-rose-500 to-pink-500 text-white text-xs font-bold rounded-lg shadow-lg shadow-rose-500/25">
                                        -{{ $product->discount_percentage }}%
                                    </span>
                                </div>
                            @endif

                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="product-image w-full h-full object-cover"
                                onerror="this.onerror=null; this.src='https://placehold.co/300x300/f1f5f9/94a3b8?text=No+Image'"
                                loading="lazy">

                            <div class="product-overlay absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent flex items-end justify-center pb-4">
                                <span class="quick-view-btn px-4 py-2 bg-white/95 backdrop-blur text-slate-800 text-sm font-semibold rounded-xl shadow-lg">
                                    Lihat Detail
                                </span>
                            </div>

                            @if ($product->badge)
                                <div class="absolute bottom-3 left-3 z-10">
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-lg
                                        {{ $product->badge == 'Terkirim cepat' ? 'bg-gradient-to-r from-orange-400 to-amber-400 text-white' : 
                                           ($product->badge == 'Best Seller' ? 'bg-gradient-to-r from-yellow-400 to-orange-400 text-white' : 
                                           'bg-gradient-to-r from-violet-500 to-purple-500 text-white') }}">
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
                            <h3 class="text-sm font-medium text-slate-800 mb-2 line-clamp-2 group-hover:text-emerald-600 transition-colors">
                                {{ $product->name }}
                            </h3>

                            <div class="flex items-baseline gap-2 mb-3">
                                <span class="text-lg font-bold bg-gradient-to-r from-emerald-600 to-cyan-600 bg-clip-text text-transparent">
                                    {{ $product->formatted_price }}
                                </span>
                                @if ($product->original_price)
                                    <span class="text-xs text-slate-400 line-through">
                                        {{ $product->formatted_original_price }}
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center gap-3 mb-2">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <span class="text-xs font-medium text-slate-700">{{ number_format($product->rating / 10, 1) }}</span>
                                </div>
                                <span class="text-slate-300">|</span>
                                <span class="text-xs text-slate-500">{{ number_format($product->sold_count) }} terjual</span>
                            </div>

                            <div class="flex items-center gap-1 text-xs text-slate-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>{{ $product->location }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="animate-on-scroll flex justify-center">
                <div class="glass rounded-2xl px-6 py-4">
                    {{ $products->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white overflow-hidden">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-emerald-500 rounded-full filter blur-3xl opacity-10"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-cyan-500 rounded-full filter blur-3xl opacity-10"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <div class="md:col-span-1">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-cyan-400 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-lg">M</span>
                        </div>
                        <span class="text-xl font-bold">MartPlace</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Marketplace terpercaya untuk belanja online dengan berbagai pilihan produk berkualitas.
                    </p>
                </div>

                <div>
                    <h4 class="font-semibold mb-4 text-white">Tentang</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Karir</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Blog</a></li>
                        <li><a href="{{ route('sellers.create') }}" class="hover:text-emerald-400 transition-colors">Daftar Jadi Seller</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4 text-white">Bantuan</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Cara Belanja</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Pengiriman</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Pengembalian</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4 text-white">Ikuti Kami</h4>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-gradient-to-br hover:from-emerald-500 hover:to-cyan-500 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-gradient-to-br hover:from-emerald-500 hover:to-cyan-500 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-gradient-to-br hover:from-emerald-500 hover:to-cyan-500 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-700/50 mt-12 pt-8 text-center">
                <p class="text-slate-400 text-sm">&copy; 2025 MartPlace. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
