@extends('layouts.master')

@section('title', 'Direktori Toko')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-forest mb-2">Direktori Toko</h1>
        <p class="text-forest/60">Temukan berbagai toko terpercaya di MartPlace</p>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-2xl shadow-sm border border-olive/20 p-6 mb-6">
        <form action="{{ route('sellers.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama toko..."
                        class="w-full px-4 py-2.5 border border-olive/30 rounded-xl focus:ring-2 focus:ring-sage focus:border-sage transition">
                </div>

                <!-- Province Filter -->
                <div>
                    <select name="province"
                        class="w-full px-4 py-2.5 border border-olive/30 rounded-xl focus:ring-2 focus:ring-sage focus:border-sage transition">
                        <option value="">Semua Provinsi</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province }}" {{ request('province') == $province ? 'selected' : '' }}>
                                {{ $province }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- City Filter -->
                <div>
                    <select name="city"
                        class="w-full px-4 py-2.5 border border-olive/30 rounded-xl focus:ring-2 focus:ring-sage focus:border-sage transition">
                        <option value="">Semua Kota</option>
                        @foreach($cities as $city)
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
                    class="px-4 py-2.5 border border-olive/30 rounded-xl focus:ring-2 focus:ring-sage focus:border-sage transition">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                    <option value="products" {{ request('sort') == 'products' ? 'selected' : '' }}>Produk Terbanyak</option>
                </select>

                <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-sage to-forest text-cream rounded-xl hover:shadow-lg transition-all duration-300 font-medium">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>

                @if(request()->hasAny(['search', 'province', 'city', 'sort']))
                    <a href="{{ route('sellers.index') }}"
                        class="px-6 py-2.5 bg-olive/20 text-forest rounded-xl hover:bg-olive/30 transition font-medium">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Sellers Grid -->
    @if($sellers->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($sellers as $seller)
                <a href="{{ route('sellers.show', $seller->id) }}"
                    class="bg-white rounded-2xl shadow-sm border border-olive/10 hover:shadow-lg hover:border-sage/50 transition-all duration-300 overflow-hidden group">
                    <div class="p-6">
                        <!-- Store Photo -->
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden bg-olive/10 ring-4 ring-olive/20 group-hover:ring-sage/30 transition-all duration-300">
                            @if($seller->pic_photo)
                                <img src="{{ Storage::url($seller->pic_photo) }}" 
                                    alt="{{ $seller->store_name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-forest/40">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Store Info -->
                        <div class="text-center">
                            <h3 class="text-lg font-bold text-forest mb-1 group-hover:text-sage transition-colors">{{ $seller->store_name }}</h3>
                            <p class="text-sm text-forest/60 mb-4 flex items-center justify-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $seller->pic_city }}, {{ $seller->pic_province }}
                            </p>

                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-2 text-center border-t border-olive/10 pt-4">
                                <div>
                                    <div class="text-lg font-bold text-sage">{{ $seller->products->count() }}</div>
                                    <div class="text-xs text-forest/50">Produk</div>
                                </div>
                                <div>
                                    <div class="text-lg font-bold text-amber-500 flex items-center justify-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        {{ number_format($seller->rating ?? 0, 1) }}
                                    </div>
                                    <div class="text-xs text-forest/50">Rating</div>
                                </div>
                                <div>
                                    <div class="text-lg font-bold text-blue-500">{{ $seller->total_reviews ?? 0 }}</div>
                                    <div class="text-xs text-forest/50">Ulasan</div>
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
        <div class="bg-white rounded-2xl shadow-sm border border-olive/10 p-12 text-center">
            <div class="w-20 h-20 bg-olive/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-forest/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-forest mb-2">Belum Ada Toko</h3>
            <p class="text-forest/60">Tidak ada toko yang ditemukan dengan kriteria pencarian Anda.</p>
        </div>
    @endif
</div>
@endsection
