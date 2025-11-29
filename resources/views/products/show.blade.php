@extends('layouts.master')

@section('title', $product->name)

@push('styles')
<style>
    .image-slider {
        position: relative;
        overflow: hidden;
    }
    .slider-container {
        display: flex;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .slider-slide {
        min-width: 100%;
        aspect-ratio: 1;
    }
    .slider-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        z-index: 10;
    }
    .image-slider:hover .slider-nav-btn {
        opacity: 1;
    }
    .slider-nav-btn:hover {
        background: white;
        transform: translateY(-50%) scale(1.1);
    }
    .slider-nav-btn.prev { left: 12px; }
    .slider-nav-btn.next { right: 12px; }
    .thumbnail-list {
        display: flex;
        gap: 8px;
        margin-top: 12px;
    }
    .thumbnail {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }
    .thumbnail.active {
        border-color: #A1BC98;
    }
    .thumbnail:hover {
        transform: scale(1.05);
    }
    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    .star-rating input {
        display: none;
    }
    .star-rating label {
        cursor: pointer;
        font-size: 32px;
        color: #D2DCB6;
        transition: color 0.2s ease;
        padding: 0 2px;
    }
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label {
        color: #FFB800;
    }
    .rating-display {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .rating-display .star {
        color: #FFB800;
        font-size: 18px;
    }
    .rating-display .star.empty {
        color: #D2DCB6;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-cream py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex flex-wrap items-center gap-2 text-sm text-forest/60 mb-6">
            <a href="{{ route('home') }}" class="hover:text-sage transition">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('products.index') }}" class="hover:text-sage transition">Produk</a>
            @if($product->category)
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-forest">{{ $product->category->name }}</span>
            @endif
        </nav>

        <!-- Product Detail -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Product Images with Slider -->
            <div x-data="imageSlider({{ json_encode($product->all_photos) }})" class="space-y-4">
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-olive/20">
                    <div class="image-slider">
                        <div class="slider-container" :style="'transform: translateX(-' + (currentIndex * 100) + '%)'">
                            <template x-for="(photo, index) in photos" :key="index">
                                <div class="slider-slide">
                                    <img :src="photo" :alt="'{{ $product->name }} - Foto ' + (index + 1)" 
                                         class="w-full h-full object-cover"
                                         onerror="this.src='https://placehold.co/600x600/D2DCB6/778873?text=No+Image'">
                                </div>
                            </template>
                        </div>
                        <template x-if="photos.length > 1">
                            <div>
                                <button @click="prev()" class="slider-nav-btn prev">
                                    <svg class="w-5 h-5 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <button @click="next()" class="slider-nav-btn next">
                                    <svg class="w-5 h-5 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </template>
                        <template x-if="photos.length > 1">
                            <div class="absolute bottom-4 right-4 bg-forest/80 text-cream px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm">
                                <span x-text="(currentIndex + 1) + ' / ' + photos.length"></span>
                            </div>
                        </template>
                    </div>
                </div>
                <template x-if="photos.length > 1">
                    <div class="thumbnail-list justify-center">
                        <template x-for="(photo, index) in photos" :key="'thumb-' + index">
                            <div class="thumbnail" :class="currentIndex === index ? 'active' : ''" @click="goTo(index)">
                                <img :src="photo" :alt="'Thumbnail ' + (index + 1)">
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-olive/20">
                    <h1 class="text-2xl md:text-3xl font-bold text-forest mb-4">{{ $product->name }}</h1>

                    <!-- Average Rating Display -->
                    @php
                        $avgRating = $product->comments->count() > 0 ? $product->comments->avg('rating') : 0;
                        $totalReviews = $product->comments->count();
                    @endphp
                    <div class="flex flex-wrap items-center gap-4 mb-6 pb-6 border-b border-olive/20">
                        <div class="flex items-center gap-2">
                            <div class="rating-display">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= round($avgRating) ? '' : 'empty' }}">★</span>
                                @endfor
                            </div>
                            <span class="text-2xl font-bold text-forest">{{ number_format($avgRating, 1) }}</span>
                            <span class="text-forest/50">/5</span>
                        </div>
                        <span class="text-forest/30">|</span>
                        <span class="text-forest/70">{{ $totalReviews }} ulasan</span>
                        @if($product->badge)
                            <span class="text-forest/30">|</span>
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-sage/20 text-forest">
                                {{ $product->badge }}
                            </span>
                        @endif
                    </div>

                    <!-- Price -->
                    <div class="mb-6">
                        <div class="flex flex-wrap items-baseline gap-3">
                            <span class="text-3xl md:text-4xl font-bold text-sage">{{ $product->formatted_price }}</span>
                            @if ($product->original_price)
                                <span class="text-lg text-forest/40 line-through">{{ $product->formatted_original_price }}</span>
                                <span class="px-2 py-1 bg-red-500 text-white text-sm font-semibold rounded-lg">
                                    -{{ $product->discount_percentage }}%
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Location & Owner -->
                    <div class="flex flex-wrap items-center gap-4 mb-6 p-4 bg-cream/50 rounded-xl">
                        <div class="flex items-center gap-2 text-forest/70">
                            <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $product->location ?? 'Indonesia' }}</span>
                        </div>
                        @if($product->seller)
                            <span class="text-forest/30">|</span>
                            <a href="{{ route('sellers.show', $product->seller->id) }}" class="flex items-center gap-2 text-sage hover:text-forest transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span class="font-medium">{{ $product->seller->store_name }}</span>
                            </a>
                        @elseif($product->user)
                            <span class="text-forest/30">|</span>
                            <span class="flex items-center gap-2 text-forest/70">
                                <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="font-medium">{{ $product->user->name }}</span>
                            </span>
                        @endif
                    </div>

                    <!-- Stock Info -->
                    <div class="flex items-center gap-2 mb-6">
                        <span class="text-forest/70">Stok:</span>
                        <span class="font-semibold {{ $product->stock > 10 ? 'text-sage' : ($product->stock > 0 ? 'text-amber-600' : 'text-red-500') }}">
                            {{ $product->stock > 0 ? number_format($product->stock) . ' tersedia' : 'Stok habis' }}
                        </span>
                    </div>

                    <!-- Info Notice -->
                    <div class="p-4 bg-olive/10 rounded-xl border border-olive/20">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-sage flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-forest font-medium">Produk Katalog</p>
                                <p class="text-forest/70 text-sm">Produk ini hanya untuk ditampilkan. Anda dapat memberikan rating dan komentar di bawah.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($product->description)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-olive/20">
                        <h3 class="font-semibold text-forest mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Deskripsi Produk
                        </h3>
                        <div class="text-forest/80 leading-relaxed whitespace-pre-line">{{ $product->description }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Rating & Comment Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Rating Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-olive/20 sticky top-24">
                    <h3 class="font-semibold text-forest mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        Rating Produk
                    </h3>
                    
                    <div class="text-center mb-6">
                        <div class="text-5xl font-bold text-forest mb-2">{{ number_format($avgRating, 1) }}</div>
                        <div class="rating-display justify-center mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star text-2xl {{ $i <= round($avgRating) ? '' : 'empty' }}">★</span>
                            @endfor
                        </div>
                        <p class="text-forest/60">{{ $totalReviews }} ulasan</p>
                    </div>

                    <!-- Rating Breakdown -->
                    <div class="space-y-2">
                        @for($star = 5; $star >= 1; $star--)
                            @php
                                $count = $product->comments->where('rating', $star)->count();
                                $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                            @endphp
                            <div class="flex items-center gap-2 text-sm">
                                <span class="w-3 text-forest/70">{{ $star }}</span>
                                <span class="text-amber-400">★</span>
                                <div class="flex-1 h-2 bg-olive/20 rounded-full overflow-hidden">
                                    <div class="h-full bg-amber-400 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="w-8 text-right text-forest/60">{{ $count }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Comments List & Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Comment Form -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-olive/20">
                    <h3 class="font-semibold text-forest mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Berikan Rating & Komentar
                    </h3>

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-sage/20 border border-sage rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-forest">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('products.comments.store', $product->id) }}" method="POST" x-data="{ rating: 5 }">
                        @csrf
                        
                        <!-- Star Rating Input -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-forest mb-3">Rating Anda <span class="text-red-500">*</span></label>
                            <div class="star-rating">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" x-model="rating" {{ $i == 5 ? 'checked' : '' }}>
                                    <label for="star{{ $i }}" title="{{ $i }} bintang">★</label>
                                @endfor
                            </div>
                            <p class="text-sm text-forest/60 mt-2">Pilih <span x-text="rating"></span> dari 5 bintang</p>
                            @error('rating')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-forest mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       class="w-full px-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition"
                                       placeholder="Masukkan nama Anda">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-forest mb-2">Nomor HP <span class="text-red-500">*</span></label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required
                                       class="w-full px-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition"
                                       placeholder="08xxxxxxxxxx">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-forest mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition"
                                   placeholder="email@example.com">
                            <p class="text-xs text-forest/50 mt-1">Notifikasi akan dikirim ke email ini</p>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Comment -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-forest mb-2">Komentar <span class="text-red-500">*</span></label>
                            <textarea name="comment" rows="4" required
                                      class="w-full px-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition resize-none"
                                      placeholder="Bagikan pengalaman atau pendapat Anda tentang produk ini... (min. 10 karakter)">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" 
                                class="w-full py-4 bg-gradient-to-r from-sage to-forest text-cream rounded-xl font-semibold hover:shadow-lg hover:shadow-sage/30 transition transform hover:-translate-y-0.5">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Kirim Rating & Komentar
                            </span>
                        </button>
                    </form>
                </div>

                <!-- Comments List -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-olive/20">
                    <h3 class="font-semibold text-forest mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                        Semua Ulasan ({{ $totalReviews }})
                    </h3>

                    @if($product->comments->count() > 0)
                        <div class="space-y-6">
                            @foreach($product->comments->sortByDesc('created_at') as $comment)
                                <div class="pb-6 border-b border-olive/10 last:border-0 last:pb-0">
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 bg-sage/20 rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-sage font-semibold text-lg">{{ strtoupper(substr($comment->name, 0, 1)) }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                                <span class="font-semibold text-forest">{{ $comment->name }}</span>
                                                <span class="text-forest/40">•</span>
                                                <span class="text-sm text-forest/60">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="rating-display mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="star text-sm {{ $i <= $comment->rating ? '' : 'empty' }}">★</span>
                                                @endfor
                                                <span class="text-sm text-forest/60 ml-1">({{ $comment->rating }}/5)</span>
                                            </div>
                                            <p class="text-forest/80 leading-relaxed">{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-olive/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-forest/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <p class="text-forest/60">Belum ada ulasan untuk produk ini</p>
                            <p class="text-forest/40 text-sm mt-1">Jadilah yang pertama memberikan ulasan!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-forest mb-6">Produk Terkait</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('products.show', $related->id) }}"
                           class="bg-white rounded-xl overflow-hidden shadow-sm border border-olive/10 hover:shadow-md hover:-translate-y-1 transition-all duration-300 group">
                            <div class="aspect-square overflow-hidden bg-olive/5 relative">
                                @if($related->discount_percentage > 0)
                                    <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-lg z-10">
                                        -{{ $related->discount_percentage }}%
                                    </span>
                                @endif
                                <img src="{{ $related->image_url }}" alt="{{ $related->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                     onerror="this.src='https://placehold.co/200x200/D2DCB6/778873?text=No+Image'"
                                     loading="lazy">
                            </div>
                            <div class="p-3">
                                <h3 class="text-sm text-forest mb-2 line-clamp-2 group-hover:text-sage transition-colors">
                                    {{ $related->name }}
                                </h3>
                                <span class="text-base font-bold text-forest">{{ $related->formatted_price }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function imageSlider(photos) {
    return {
        photos: photos.length > 0 ? photos : ['https://placehold.co/600x600/D2DCB6/778873?text=No+Image'],
        currentIndex: 0,
        prev() {
            this.currentIndex = this.currentIndex > 0 ? this.currentIndex - 1 : this.photos.length - 1;
        },
        next() {
            this.currentIndex = this.currentIndex < this.photos.length - 1 ? this.currentIndex + 1 : 0;
        },
        goTo(index) {
            this.currentIndex = index;
        },
        init() {
            if (this.photos.length > 1) {
                let autoSlide = setInterval(() => this.next(), 5000);
                this.$el.addEventListener('mouseenter', () => clearInterval(autoSlide));
                this.$el.addEventListener('mouseleave', () => {
                    autoSlide = setInterval(() => this.next(), 5000);
                });
            }
            let touchStartX = 0;
            this.$el.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });
            this.$el.addEventListener('touchend', (e) => {
                const touchEndX = e.changedTouches[0].screenX;
                if (touchEndX < touchStartX - 50) this.next();
                if (touchEndX > touchStartX + 50) this.prev();
            }, { passive: true });
        }
    };
}
</script>
@endpush
