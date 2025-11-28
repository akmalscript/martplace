<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $seller->store_name }} - {{ config('app.name', 'MartPlace') }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    @include('layouts.navbar')

    <!-- Store Header -->
    <section class="bg-gradient-to-r from-green-400 to-cyan-300 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <!-- Store Icon -->
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                    <svg class="w-12 h-12 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>

                <!-- Store Info -->
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">{{ $seller->store_name }}</h1>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-white">
                        <div class="flex items-center bg-white bg-opacity-20 px-3 py-1 rounded-full">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ $seller->city }}, {{ $seller->province }}</span>
                        </div>
                        <div class="flex items-center bg-white bg-opacity-20 px-3 py-1 rounded-full">
                            <svg class="w-4 h-4 mr-1 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="text-sm font-semibold">{{ number_format($seller->rating, 1) }}</span>
                        </div>
                        <div class="bg-white bg-opacity-20 px-3 py-1 rounded-full">
                            <span class="text-sm"><span class="font-semibold">{{ $seller->total_products }}</span>
                                Produk</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Store Description -->
    @if ($seller->store_description)
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-3">Tentang Toko</h2>
                <p class="text-gray-700">{{ $seller->store_description }}</p>
            </div>
        </section>
    @endif

    <!-- Store Products -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Produk dari Toko Ini</h2>

        @if ($seller->products->isEmpty())
            <!-- No Products -->
            <div class="text-center py-16 bg-white rounded-lg shadow-md">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                    </path>
                </svg>
                <h3 class="mt-4 text-xl font-medium text-gray-900">Belum Ada Produk</h3>
                <p class="mt-2 text-gray-500">Toko ini belum menambahkan produk</p>
            </div>
        @else
            <!-- Products Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach ($seller->products as $product)
                    <a href="{{ route('products.show', $product->id) }}"
                        class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 overflow-hidden group">
                        <!-- Product Image -->
                        <div class="relative aspect-square overflow-hidden bg-gray-100">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-300">

                            @if ($product->discount_percentage > 0)
                                <div
                                    class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-bold">
                                    {{ $product->discount_percentage }}%
                                </div>
                            @endif

                            @if ($product->badge)
                                <div
                                    class="absolute top-2 right-2 px-2 py-1 rounded text-xs font-semibold text-white
                                    {{ $product->badge === 'Best Seller' ? 'bg-yellow-500' : '' }}
                                    {{ $product->badge === 'Ekslusif' ? 'bg-purple-500' : '' }}
                                    {{ $product->badge === 'Terkirim cepat' ? 'bg-orange-500' : '' }}
                                    {{ $product->badge === 'Mall' ? 'bg-green-500' : '' }}">
                                    {{ $product->badge }}
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-3">
                            <h3 class="text-sm text-gray-800 mb-2 line-clamp-2 group-hover:text-green-600 transition">
                                {{ $product->name }}
                            </h3>

                            <div class="mb-2">
                                <span class="text-lg font-bold text-gray-900">
                                    {{ $product->formatted_price }}
                                </span>
                                @if ($product->discount_percentage > 0)
                                    <span class="text-xs text-gray-400 line-through ml-1">
                                        Rp{{ number_format($product->original_price, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                    <span>{{ number_format($product->rating / 10, 1) }}</span>
                                </div>
                                <span>{{ number_format($product->sold_count) }} terjual</span>
                            </div>

                            <div class="mt-2 text-xs text-gray-500 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $product->location }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Contact Info -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Informasi Kontak</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-gray-400 mt-1" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                        </path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Telepon</p>
                        <p class="text-gray-900">{{ $seller->pic_phone }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-gray-400 mt-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Email</p>
                        <p class="text-gray-900">{{ $seller->pic_email }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 md:col-span-2">
                    <svg class="w-5 h-5 text-gray-400 mt-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Alamat</p>
                        <p class="text-gray-900">
                            {{ $seller->pic_street }}, RT {{ $seller->pic_rt }}/RW {{ $seller->pic_rw }}, <br>
                            {{ $seller->pic_village }}, {{ $seller->pic_district }}, <br>
                            {{ $seller->pic_city }}, {{ $seller->pic_province }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} MartPlace. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
