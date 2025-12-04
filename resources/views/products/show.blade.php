<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-green-600">
                        MartPlace
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-600 transition">Beranda</a>
                    <a href="{{ route('products.index') }}"
                        class="text-gray-700 hover:text-green-600 transition">Produk</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-green-600">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('products.index') }}" class="hover:text-green-600">Produk</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">{{ $product->name }}</span>
        </nav>

        <!-- Product Detail -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Product Images Carousel -->
                <div x-data="{ 
                    activeImage: 0, 
                    images: @js($product->images->count() > 0 ? $product->images->pluck('image_path')->toArray() : [$product->image_url ?? 'https://via.placeholder.com/600x600/E5E5E5/999999?text=No+Image']) 
                }">
                <!-- Main Image -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md mb-4 relative">
                    <img :src="images[activeImage]" alt="{{ $product->name }}" class="w-full h-auto aspect-square object-cover"
                        onerror="this.src='https://via.placeholder.com/600x600/E5E5E5/999999?text=No+Image'">
                    
                    <!-- Navigation Arrows -->
                    <template x-if="images.length > 1">
                        <div>
                            <button @click="activeImage = activeImage === 0 ? images.length - 1 : activeImage - 1" 
                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition">
                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button @click="activeImage = activeImage === images.length - 1 ? 0 : activeImage + 1"
                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition">
                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </template>

                    <!-- Image Counter -->
                    <template x-if="images.length > 1">
                        <div class="absolute bottom-3 right-3 bg-black/60 text-white text-sm px-3 py-1 rounded-full">
                            <span x-text="activeImage + 1"></span> / <span x-text="images.length"></span>
                        </div>
                    </template>
                </div>

                <!-- Thumbnail Images -->
                <template x-if="images.length > 1">
                    <div class="flex gap-2 overflow-x-auto pb-2">
                        <template x-for="(image, index) in images" :key="index">
                            <button @click="activeImage = index" 
                                :class="activeImage === index ? 'ring-2 ring-green-500' : 'ring-1 ring-gray-200'"
                                class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden bg-white transition">
                                <img :src="image" alt="Thumbnail" class="w-full h-full object-cover"
                                    onerror="this.src='https://via.placeholder.com/80x80/E5E5E5/999999?text=No+Image'">
                            </button>
                        </template>
                    </div>
                </template>
            </div>

            <!-- Product Info -->
            <div class="bg-white rounded-lg p-6 shadow-md">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                <!-- Rating & Sold -->
                <div class="flex items-center space-x-4 mb-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <span class="ml-1 text-gray-700">{{ number_format($product->average_rating, 1) }}</span>
                    </div>
                    <span class="text-gray-400">|</span>
                    <span class="text-gray-700">{{ number_format($product->sold_count) }} terjual</span>
                </div>

                <!-- Price -->
                <div class="mb-6">
                    <div class="flex items-baseline space-x-3">
                        <span class="text-4xl font-bold text-green-600">{{ $product->formatted_price }}</span>
                    </div>
                </div>

                <!-- Location -->
                <div class="mb-6">
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ $product->city }}, {{ $product->province }}</span>
                    </div>
                </div>

                <!-- Stock -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <span class="text-gray-700 font-medium">Stok:</span>
                        <span class="ml-2 {{ $product->stock > 10 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $product->stock > 0 ? number_format($product->stock) . ' tersedia' : 'Stok habis' }}
                        </span>
                    </div>
                </div>

                <!-- Description -->
                @if ($product->description)
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-2">Deskripsi Produk</h3>
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Related Products -->
        @if ($relatedProducts->count() > 0)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Produk Terkait</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach ($relatedProducts as $related)
                        <a href="{{ route('products.show', $related->id) }}"
                            class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden">
                            <div class="relative">
                                <img src="{{ $related->image_url }}" alt="{{ $related->name }}"
                                    class="w-full h-48 object-cover"
                                    onerror="this.src='https://via.placeholder.com/200x200/E5E5E5/999999?text=No+Image'">
                            </div>
                            <div class="p-3">
                                <h3 class="text-sm text-gray-800 mb-2 line-clamp-2">{{ $related->name }}</h3>
                                <span class="text-lg font-bold text-gray-900">{{ $related->formatted_price }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2025 MartPlace. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
