@extends('layouts.master')

@section('title', $product->name)

@section('content')
<div class="bg-cream min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Breadcrumb --}}
        <nav class="flex mb-6 text-sm text-forest/60 scroll-reveal">
            <a href="{{ route('home') }}" class="hover:text-sage transition">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('products.index') }}" class="hover:text-sage transition">Produk</a>
            @if($product->category)
                <span class="mx-2">/</span>
                <a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="hover:text-sage transition">{{ $product->category->name }}</a>
            @endif
            <span class="mx-2">/</span>
            <span class="text-forest">{{ Str::limit($product->name, 30) }}</span>
        </nav>

        {{-- Product Detail --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            {{-- Product Images --}}
            <div class="scroll-reveal" x-data="{ mainImage: '{{ $product->main_photo ? asset('storage/' . $product->main_photo) : 'https://via.placeholder.com/600x600/D2DCB6/778873?text=No+Image' }}' }">
                <div class="bg-white rounded-2xl overflow-hidden border border-olive/20 shadow-md mb-4">
                    <img :src="mainImage" alt="{{ $product->name }}" class="w-full h-96 object-contain">
                </div>
                
                @if($product->photos && count($product->photos) > 0)
                <div class="grid grid-cols-5 gap-2">
                    <button @click="mainImage = '{{ $product->main_photo ? asset('storage/' . $product->main_photo) : '' }}'"
                            class="bg-white rounded-lg overflow-hidden border-2 border-olive/20 hover:border-sage transition-all">
                        <img src="{{ $product->main_photo ? asset('storage/' . $product->main_photo) : '' }}" 
                             class="w-full h-16 object-cover">
                    </button>
                    @foreach($product->photos as $photo)
                    <button @click="mainImage = '{{ asset('storage/' . $photo) }}'"
                            class="bg-white rounded-lg overflow-hidden border-2 border-olive/20 hover:border-sage transition-all">
                        <img src="{{ asset('storage/' . $photo) }}" class="w-full h-16 object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Product Info --}}
            <div class="scroll-reveal" style="animation-delay: 0.1s">
                <div class="bg-white rounded-2xl p-8 border border-olive/20 shadow-md">
                    <h1 class="text-2xl lg:text-3xl font-bold text-forest mb-4">{{ $product->name }}</h1>

                    {{-- Rating & Sold (SRS-MartPlace-04) --}}
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex items-center gap-1 bg-yellow-50 px-3 py-1.5 rounded-lg">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="font-semibold text-forest">{{ number_format($product->rating / 10, 1) }}</span>
                            <span class="text-forest/60">({{ $product->comments->count() }} ulasan)</span>
                        </div>
                        <span class="text-forest/60">{{ number_format($product->sold_count) }}+ terjual</span>
                    </div>

                    {{-- Price --}}
                    <div class="mb-6 pb-6 border-b border-olive/20">
                        <div class="flex items-baseline gap-3">
                            <span class="text-4xl font-bold bg-gradient-to-r from-sage to-forest bg-clip-text text-transparent">
                                {{ $product->formatted_price }}
                            </span>
                            @if($product->original_price)
                                <span class="text-lg text-forest/40 line-through">{{ $product->formatted_original_price }}</span>
                                <span class="bg-red-500 text-white text-sm px-2 py-1 rounded-lg font-medium">
                                    -{{ $product->discount_percentage }}%
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Seller Info --}}
                    @if($product->seller)
                    <div class="mb-6 pb-6 border-b border-olive/20">
                        <a href="{{ route('sellers.show', $product->seller->id) }}" 
                           class="flex items-center gap-4 p-4 bg-cream rounded-xl hover:bg-olive/20 transition-all duration-300">
                            <div class="w-14 h-14 bg-sage/20 rounded-full flex items-center justify-center">
                                @if($product->seller->pic_photo_path)
                                    <img src="{{ asset('storage/' . $product->seller->pic_photo_path) }}" class="w-full h-full rounded-full object-cover">
                                @else
                                    <span class="text-sage font-bold text-xl">{{ substr($product->seller->store_name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-forest">{{ $product->seller->store_name }}</p>
                                <p class="text-sm text-forest/60">{{ $product->seller->pic_city }}, {{ $product->seller->pic_province }}</p>
                            </div>
                            <svg class="w-5 h-5 text-forest/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    @endif

                    {{-- Product Details --}}
                    <div class="space-y-4 mb-6">
                        <div class="flex items-center gap-3 text-forest">
                            <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                            </svg>
                            <span class="font-medium">Stok:</span>
                            <span class="{{ $product->stock > 10 ? 'text-sage' : ($product->stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $product->stock > 0 ? number_format($product->stock) . ' tersedia' : 'Stok habis' }}
                            </span>
                        </div>
                        
                        @if($product->condition)
                        <div class="flex items-center gap-3 text-forest">
                            <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-medium">Kondisi:</span>
                            <span>{{ $product->condition == 'new' ? 'Baru' : 'Bekas' }}</span>
                        </div>
                        @endif
                        
                        @if($product->weight)
                        <div class="flex items-center gap-3 text-forest">
                            <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                            </svg>
                            <span class="font-medium">Berat:</span>
                            <span>{{ $product->weight }} kg</span>
                        </div>
                        @endif
                    </div>

                    {{-- Description --}}
                    @if($product->description)
                    <div class="mb-6">
                        <h3 class="font-semibold text-forest mb-2">Deskripsi Produk</h3>
                        <p class="text-forest/80 leading-relaxed">{{ $product->description }}</p>
                    </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="flex gap-4">
                        <button class="flex-1 bg-gradient-to-r from-sage to-forest text-cream py-4 rounded-xl font-semibold hover:shadow-lg hover:shadow-sage/30 transform hover:-translate-y-0.5 transition-all duration-300">
                            Beli Sekarang
                        </button>
                        <button class="flex-1 bg-white text-forest border-2 border-sage py-4 rounded-xl font-semibold hover:bg-cream transition-all duration-300">
                            + Keranjang
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Comments & Rating Section (SRS-MartPlace-04, 06) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            {{-- Comment Form --}}
            <div class="lg:col-span-1 scroll-reveal" style="animation-delay: 0.2s">
                <div class="bg-white rounded-2xl p-6 border border-olive/20 shadow-md sticky top-24">
                    <h3 class="text-xl font-bold text-forest mb-4">Beri Rating & Ulasan</h3>
                    <p class="text-sm text-forest/60 mb-6">Berikan rating dan komentar untuk produk ini</p>
                    
                    <form action="{{ route('products.comments.store', $product->id) }}" method="POST" 
                          x-data="{ rating: 5 }">
                        @csrf
                        
                        {{-- Rating Stars --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-forest mb-2">Rating *</label>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                <button type="button" 
                                        @click="rating = {{ $i }}"
                                        :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'"
                                        class="transition-all duration-200 hover:scale-110">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" x-model="rating">
                        </div>
                        
                        {{-- Name --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-forest mb-2">Nama *</label>
                            <input type="text" name="name" required
                                   class="w-full px-4 py-3 border-2 border-olive/30 rounded-xl focus:border-sage focus:ring-2 focus:ring-sage/20 transition-all duration-300"
                                   placeholder="Masukkan nama Anda">
                        </div>
                        
                        {{-- Phone --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-forest mb-2">No. HP *</label>
                            <input type="text" name="phone" required
                                   class="w-full px-4 py-3 border-2 border-olive/30 rounded-xl focus:border-sage focus:ring-2 focus:ring-sage/20 transition-all duration-300"
                                   placeholder="08xxxxxxxxxx">
                        </div>
                        
                        {{-- Email --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-forest mb-2">Email *</label>
                            <input type="email" name="email" required
                                   class="w-full px-4 py-3 border-2 border-olive/30 rounded-xl focus:border-sage focus:ring-2 focus:ring-sage/20 transition-all duration-300"
                                   placeholder="email@example.com">
                        </div>
                        
                        {{-- Comment --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-forest mb-2">Komentar *</label>
                            <textarea name="comment" rows="4" required
                                      class="w-full px-4 py-3 border-2 border-olive/30 rounded-xl focus:border-sage focus:ring-2 focus:ring-sage/20 transition-all duration-300 resize-none"
                                      placeholder="Tulis ulasan Anda tentang produk ini..."></textarea>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-sage to-forest text-cream py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300">
                            Kirim Ulasan
                        </button>
                    </form>
                </div>
            </div>
            
            {{-- Comments List --}}
            <div class="lg:col-span-2 scroll-reveal" style="animation-delay: 0.3s">
                <div class="bg-white rounded-2xl p-6 border border-olive/20 shadow-md">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-forest">Ulasan Pembeli</h3>
                        <span class="text-forest/60">{{ $product->comments->count() }} ulasan</span>
                    </div>
                    
                    @if($product->comments->count() > 0)
                        <div class="space-y-6">
                            @foreach($product->comments->sortByDesc('created_at') as $comment)
                            <div class="pb-6 border-b border-olive/20 last:border-0 last:pb-0">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-sage/20 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-sage font-semibold">{{ substr($comment->name, 0, 1) }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <p class="font-semibold text-forest">{{ $comment->name }}</p>
                                            <span class="text-sm text-forest/40">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex items-center gap-1 mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $comment->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <p class="text-forest/80">{{ $comment->comment }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-olive/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-forest/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <p class="text-forest/60">Belum ada ulasan untuk produk ini</p>
                            <p class="text-sm text-forest/40 mt-1">Jadilah yang pertama memberikan ulasan!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="scroll-reveal" style="animation-delay: 0.4s">
            <h2 class="text-2xl font-bold text-forest mb-6">Produk Terkait</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($relatedProducts as $related)
                <a href="{{ route('products.show', $related->id) }}" 
                   class="stagger-item group bg-white rounded-xl overflow-hidden border border-olive/20 hover:border-sage hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    <div class="aspect-square bg-cream overflow-hidden">
                        @if($related->discount_percentage > 0)
                            <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-lg font-medium z-10">
                                -{{ $related->discount_percentage }}%
                            </span>
                        @endif
                        <img src="{{ $related->main_photo ? asset('storage/' . $related->main_photo) : 'https://via.placeholder.com/200x200/D2DCB6/778873?text=No+Image' }}" 
                             alt="{{ $related->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-4">
                        <h3 class="text-sm text-forest font-medium mb-2 line-clamp-2 group-hover:text-sage transition-colors">
                            {{ $related->name }}
                        </h3>
                        <span class="text-lg font-bold text-forest">{{ $related->formatted_price }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
