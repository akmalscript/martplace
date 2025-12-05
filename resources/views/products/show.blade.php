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
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-green-600 transition">Produk</a>
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

            <!-- Image -->
            <div>
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-auto"
                         onerror="this.src='https://via.placeholder.com/600x600/E5E5E5/999999?text=No+Image'">
                </div>
            </div>

            <!-- Product Info -->
            <div class="bg-white rounded-lg p-6 shadow-md">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                <!-- Rating -->
                <div class="flex items-center space-x-4 mb-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 
                            1.371 1.24.588 1.81l-2.8 2.034a1 1 0 
                            00-.364 1.118l1.07 3.292c.3.921-.755 
                            1.688-1.54 1.118l-2.8-2.034a1 1 0 
                            00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 
                            1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 
                            1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="ml-1 text-gray-700">{{ number_format($product->reviews->avg('rating'), 1) }}</span>
                    </div>
                    <span class="text-gray-400">|</span>
                    <span class="text-gray-700">{{ $product->reviews->count() }} ulasan</span>
                </div>

                <!-- Price -->
                <div class="text-4xl font-bold text-green-600 mb-6">
                    {{ $product->formatted_price }}
                </div>

                <!-- Location -->
                <div class="flex items-center text-gray-700 mb-6">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 
                              8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $product->location }}</span>
                </div>

                <!-- Description -->
                @if ($product->description)
                    <div class="mb-6">
                        <h3 class="font-semibold">Deskripsi Produk</h3>
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>
                @endif

            </div>
        </div>

        <!-- ============================= -->
        <!-- REVIEW FORM -->
        <!-- ============================= -->

        <div class="mt-10 bg-white p-6 rounded-lg shadow-sm"
             x-data="{
                rating: 0,
                provinces: [],
                selectedProvince: '',
                init() {
                    fetch('/api/wilayah/provinces')
                        .then(res => res.json())
                        .then(json => this.provinces = json.data);
                }
             }">

            <h2 class="text-xl font-semibold text-gray-800 mb-4">Tulis Ulasan</h2>

            <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                @csrf

                <!-- Name -->
                <label class="block font-medium">Nama</label>
                <input type="text" name="name" class="w-full border p-2 rounded mb-4" required>

                <!-- Email -->
                <label class="block font-medium">Email</label>
                <input type="email" name="email" class="w-full border p-2 rounded mb-4" required>

                <!-- Phone -->
                <label class="block font-medium">No. Telepon</label>
                <input type="text" name="phone" class="w-full border p-2 rounded mb-4">

                <!-- Province -->
                <label class="block font-medium">Provinsi</label>
                <select name="province" x-model="selectedProvince" class="w-full border p-2 rounded mb-4">
                    <option value="" selected disabled>Pilih provinsi...</option>

                    <template x-for="prov in provinces" :key="prov.code">
                        <option :value="prov.name" x-text="prov.name"></option>
                    </template>
                </select>

                <!-- Stars -->
                <label class="block font-medium mb-2">Rating</label>
                <div class="flex space-x-2 mb-4">
                    <template x-for="star in [1,2,3,4,5]" :key="star">
                        <svg @click="rating = star"
                             :class="rating >= star ? 'text-yellow-400' : 'text-gray-300'"
                             class="w-8 h-8 cursor-pointer transition"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 
                            3.292a1 1 0 00.95.69h3.462c.969 0 
                            1.371 1.24.588 1.81l-2.8 2.034a1 1 
                            0 00-.364 1.118l1.07 3.292c.3.921-.755 
                            1.688-1.54 1.118l-2.8-2.034a1 1 0 
                            00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 
                            1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 
                            1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </template>
                </div>

                <input type="hidden" name="rating" :value="rating">

                <!-- Comment -->
                <div x-show="rating > 0" x-transition>
                    <label class="block font-medium mb-2">Komentar</label>
                    <textarea name="comment" rows="4" class="w-full border p-3 rounded mb-4"
                              placeholder="Tulis pengalaman Anda..."></textarea>

                    <button class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">
                        Kirim Ulasan
                    </button>
                </div>

            </form>
        </div>

        <!-- ============================= -->
        <!-- DISPLAY REVIEWS -->
        <!-- ============================= -->
        <div class="mt-10 bg-white p-6 rounded-lg shadow-sm">
            <h2 class="text-xl font-semibold mb-4">Ulasan Pembeli</h2>

            @forelse ($product->reviews as $review)
                <div class="border-b pb-4 mb-4">

                    <div class="flex items-center mb-1">
                        <span class="font-semibold">
                            {{ $review->name }}
                        </span>

                        @if($review->province)
                            <span class="ml-2 text-sm text-gray-500">
                                ({{ $review->province }})
                            </span>
                        @endif

                        <span class="ml-2 text-sm text-gray-400">
                            {{ $review->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <!-- Stars -->
                    <div class="flex mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 . . ."/>
                            </svg>
                        @endfor
                    </div>

                    @if ($review->comment)
                        <p class="text-gray-700">{{ $review->comment }}</p>
                    @endif
                </div>

            @empty
                <p class="text-gray-500">Belum ada ulasan untuk produk ini.</p>
            @endforelse
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2025 MartPlace. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
