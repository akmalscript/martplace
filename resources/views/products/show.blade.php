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
            <!-- Product Image -->
            <div>
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-auto"
                        onerror="this.src='https://via.placeholder.com/600x600/E5E5E5/999999?text=No+Image'">
                </div>
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
                        <span class="ml-1 text-gray-700">{{ number_format($product->rating / 10, 1) }}</span>
                    </div>
                    <span class="text-gray-400">|</span>
                    <span class="text-gray-700">{{ number_format($product->sold_count) }} terjual</span>
                </div>

                <!-- Price -->
                <div class="mb-6">
                    <div class="flex items-baseline space-x-3">
                        <span class="text-4xl font-bold text-green-600">{{ $product->formatted_price }}</span>
                        @if ($product->original_price)
                            <span
                                class="text-xl text-gray-400 line-through">{{ $product->formatted_original_price }}</span>
                            <span
                                class="bg-red-500 text-white text-sm px-2 py-1 rounded">{{ $product->discount_percentage }}%
                                OFF</span>
                        @endif
                    </div>
                </div>

                <!-- Badge -->
                @if ($product->badge)
                    <div class="mb-6">
                        <span
                            class="inline-block {{ $product->badge == 'Terkirim cepat' ? 'bg-orange-100 text-orange-600' : ($product->badge == 'Best Seller' ? 'bg-yellow-100 text-yellow-600' : 'bg-purple-100 text-purple-600') }} px-3 py-1 rounded-full text-sm font-medium">
                            {{ $product->badge }}
                        </span>
                    </div>
                @endif

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
                        <span>{{ $product->location }}</span>
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

                <!-- Action Buttons -->
                <div class="flex space-x-4">
                    <button
                        class="flex-1 bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                        Beli Sekarang
                    </button>
                    <button
                        class="flex-1 bg-white text-green-600 border-2 border-green-600 py-3 rounded-lg font-semibold hover:bg-green-50 transition">
                        + Keranjang
                    </button>
                </div>
            </div>
        </div>

        <!-- Review Section -->
        <div x-data="{ rating: 0 }" class="mt-10 bg-white p-6 rounded-lg shadow-sm">

            <h2 class="text-xl font-semibold text-gray-800 mb-4">Tulis Ulasan</h2>

            <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                @csrf

                <!-- Star Rating -->
                <div class="flex space-x-2 mb-4">
                    <template x-for="star in [1,2,3,4,5]" :key="star">
                        <svg @click="rating = star"
                            :class="rating >= star ? 'text-yellow-400' : 'text-gray-300'"
                            class="w-8 h-8 cursor-pointer transition"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                    </template>
                </div>

                <!-- Hidden rating input for backend -->
                <input type="hidden" name="rating" x-model="rating">
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <!-- Textarea appears only when user selects rating -->
                <div x-show="rating > 0" x-transition class="mt-4">
                    <label class="block text-gray-700 mb-2">Tambahkan komentar (opsional)</label>
                    <textarea name="comment" rows="4"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-green-500 focus:border-green-500"
                            placeholder="Tulis pengalaman Anda tentang produk ini..."></textarea>
                </div>

                <!-- Submit Button -->
                <div x-show="rating > 0" x-transition class="mt-4">
                    <button class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700">
                        Kirim Ulasan
                    </button>
                </div>

            </form>
        </div>

        <!-- Display Reviews -->
        <div class="mt-10 bg-white p-6 rounded-lg shadow-sm">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Ulasan Pembeli</h2>

            @forelse ($product->reviews as $review)
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <!-- Reviewer -->
                    <div class="flex items-center mb-1">
                        <span class="font-semibold">{{ $review->user->name ?? 'User' }}</span>
                        <span class="text-gray-500 text-sm ml-2">{{ $review->created_at->diffForHumans() }}</span>
                    </div>

                    <!-- Rating Stars -->
                    <div class="flex mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                        @endfor
                    </div>


                    <!-- Comment -->
                    @if ($review->comment)
                        <p class="text-gray-700">{{ $review->comment }}</p>
                    @endif
                </div>
            @empty
                <p class="text-gray-500">Belum ada ulasan untuk produk ini.</p>
            @endforelse
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
                                @if ($related->discount_percentage > 0)
                                    <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded">
                                        {{ $related->discount_percentage }}%
                                    </span>
                                @endif
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
