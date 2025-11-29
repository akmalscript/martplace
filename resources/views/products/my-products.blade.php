@extends('layouts.master')

@section('title', 'Produk Saya')

@section('content')
<div class="min-h-screen bg-cream py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-forest">Produk Saya</h1>
                <p class="text-forest/60 mt-1">Kelola semua produk yang Anda upload</p>
            </div>
            <a href="{{ route('my-products.create') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-sage to-forest text-cream rounded-xl font-semibold hover:shadow-lg hover:shadow-sage/30 transition transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Upload Produk Baru
            </a>
        </div>

        <!-- Products Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl p-4 border border-olive/20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-sage/20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-forest">{{ $products->total() }}</p>
                        <p class="text-xs text-forest/60">Total Produk</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-olive/20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-forest">{{ $products->where('is_active', true)->count() }}</p>
                        <p class="text-xs text-forest/60">Produk Aktif</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-olive/20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-forest">{{ $products->where('stock', '<', 5)->where('stock', '>', 0)->count() }}</p>
                        <p class="text-xs text-forest/60">Stok Menipis</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-olive/20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-forest">{{ $products->where('stock', '<=', 0)->count() }}</p>
                        <p class="text-xs text-forest/60">Stok Habis</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl overflow-hidden border border-olive/20 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <!-- Product Image -->
                        <div class="relative aspect-square overflow-hidden bg-olive/5">
                            @if(count($product->all_photos) > 1)
                                <span class="absolute top-3 right-3 bg-forest/80 text-cream px-2 py-1 rounded-lg text-xs font-medium z-10">
                                    {{ count($product->all_photos) }} foto
                                </span>
                            @endif
                            @if(!$product->is_active)
                                <div class="absolute inset-0 bg-black/50 flex items-center justify-center z-10">
                                    <span class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm font-medium">Nonaktif</span>
                                </div>
                            @endif
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 onerror="this.src='https://placehold.co/300x300/D2DCB6/778873?text=No+Image'">
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-4">
                            <h3 class="font-medium text-forest mb-2 line-clamp-2 min-h-[48px]">{{ $product->name }}</h3>
                            
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-lg font-bold text-sage">{{ $product->formatted_price }}</span>
                                <span class="text-sm text-forest/60">Stok: {{ $product->stock }}</span>
                            </div>
                            
                            <div class="flex items-center gap-2 text-xs text-forest/60 mb-4">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    {{ number_format($product->rating / 10, 1) }}
                                </div>
                                <span class="text-forest/30">|</span>
                                <span>{{ $product->sold_count }} terjual</span>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <a href="{{ route('products.show', $product->id) }}" 
                                   class="flex-1 py-2 text-center text-sm font-medium text-forest/70 bg-olive/10 rounded-lg hover:bg-olive/20 transition"
                                   target="_blank">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat
                                </a>
                                <a href="{{ route('my-products.edit', $product->id) }}" 
                                   class="flex-1 py-2 text-center text-sm font-medium text-sage bg-sage/10 rounded-lg hover:bg-sage/20 transition">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('my-products.delete', $product->id) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16 bg-white rounded-2xl border border-olive/20">
                <div class="w-24 h-24 bg-olive/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-forest/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-forest mb-2">Belum Ada Produk</h3>
                <p class="text-forest/60 mb-6">Mulai upload produk pertama Anda sekarang</p>
                <a href="{{ route('my-products.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-sage to-forest text-cream rounded-xl font-semibold hover:shadow-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Upload Produk Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
