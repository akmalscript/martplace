<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seller->store_name }} - MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .tab-active {
            border-bottom: 3px solid #10B981;
            color: #10B981;
        }

        .btn-glow {
            position: relative;
            overflow: hidden;
        }

        .btn-glow::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: 0.5s;
        }

        .btn-glow:hover::before {
            left: 100%;
        }
    </style>
</head>

<body class="bg-gray-50">
    @include('layouts.navbar')

    <div class="mt-20">
        <!-- Store Header Section -->
        <div class="bg-gradient-to-r from-cyan-500 to-green-500 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                        <!-- Store Photo -->
                        <div
                            class="w-24 h-24 md:w-28 md:h-28 rounded-xl overflow-hidden bg-gradient-to-br from-cyan-100 to-green-100 flex-shrink-0 border-4 border-white shadow-lg">
                            @if ($seller->pic_photo_path)
                                <img src="{{ Storage::url($seller->pic_photo_path) }}" alt="{{ $seller->store_name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-cyan-600">
                                    <i class="fas fa-store text-4xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Store Info -->
                        <div class="flex-1 text-center md:text-left">
                            <div class="flex items-center justify-center md:justify-start gap-2 mb-2">
                                <span
                                    class="bg-gradient-to-r from-cyan-500 to-green-500 text-white text-xs px-2 py-1 rounded-full flex items-center gap-1">
                                    <i class="fas fa-check-circle"></i> Official Store
                                </span>
                            </div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ $seller->store_name }}</h1>
                            <p class="text-gray-600 mb-3">{{ $seller->pic_city ?? $seller->city }},
                                {{ $seller->pic_province ?? $seller->province }}</p>

                            <!-- Stats Row -->
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-6 text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-star text-yellow-500"></i>
                                    <span
                                        class="font-bold text-gray-900">{{ number_format($seller->rating ?? 4.8, 1) }}</span>
                                    <span
                                        class="text-gray-500">({{ number_format(($seller->total_reviews ?? 0) / 1000, 1) }}rb)</span>
                                </div>
                                <span class="text-gray-300">•</span>
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-600">{{ number_format($seller->products->count()) }}
                                        produk</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col gap-3 w-full md:w-auto">
                            <button
                                class="bg-gradient-to-r from-cyan-500 to-green-500 text-white px-8 py-3 rounded-lg font-semibold hover:from-cyan-600 hover:to-green-600 transition-all flex items-center justify-center gap-2">
                                <i class="fas fa-plus"></i> Follow
                            </button>
                            <button
                                class="border-2 border-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:border-green-500 hover:text-green-600 transition-all flex items-center justify-center gap-2">
                                <i class="fas fa-comment-dots"></i> Chat Penjual
                            </button>
                            <div class="flex justify-center gap-2">
                                <button
                                    class="w-12 h-12 border border-gray-300 rounded-lg flex items-center justify-center hover:border-green-500 hover:text-green-600 transition-all">
                                    <i class="fas fa-qrcode text-gray-600"></i>
                                </button>
                                <button
                                    class="w-12 h-12 border border-gray-300 rounded-lg flex items-center justify-center hover:border-green-500 hover:text-green-600 transition-all">
                                    <i class="fas fa-share-alt text-gray-600"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="bg-white border-b sticky top-20 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex gap-8" x-data="{ activeTab: 'beranda' }">
                    <button @click="activeTab = 'beranda'"
                        :class="activeTab === 'beranda' ? 'tab-active' : 'text-gray-600 hover:text-green-600'"
                        class="py-4 font-semibold transition-colors border-b-3 border-transparent">
                        Beranda
                    </button>
                    <button @click="activeTab = 'produk'"
                        :class="activeTab === 'produk' ? 'tab-active' : 'text-gray-600 hover:text-green-600'"
                        class="py-4 font-semibold transition-colors border-b-3 border-transparent">
                        Produk
                    </button>
                    <button @click="activeTab = 'ulasan'"
                        :class="activeTab === 'ulasan' ? 'tab-active' : 'text-gray-600 hover:text-green-600'"
                        class="py-4 font-semibold transition-colors border-b-3 border-transparent">
                        Ulasan
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Store Description -->
            @if ($seller->store_description)
                <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <i class="fas fa-info-circle text-cyan-500"></i> Tentang Toko
                    </h2>
                    <p class="text-gray-600 leading-relaxed">{{ $seller->store_description }}</p>
                </div>
            @endif

            <!-- Products Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-box text-cyan-500"></i> Semua Produk
                    </h2>
                    <span class="text-gray-500 text-sm">{{ $seller->products->count() }} produk</span>
                </div>

                @if ($seller->products->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
                        @foreach ($seller->products as $product)
                            <a href="{{ route('products.show', $product->id) }}"
                                class="product-card bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all overflow-hidden border-2 border-transparent hover:border-cyan-200 group">
                                <div class="relative bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                        class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500"
                                        onerror="this.onerror=null; this.src='https://placehold.co/200x200/E5E5E5/999999?text=No+Image'"
                                        loading="lazy">
                                </div>
                                <div class="p-4">
                                    <h3
                                        class="text-sm font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:from-cyan-600 group-hover:to-green-600 group-hover:bg-clip-text transition-all">
                                        {{ $product->name }}</h3>
                                    <div class="flex items-baseline space-x-2 mb-3">
                                        <span
                                            class="text-lg font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">{{ $product->formatted_price }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2 mb-2">
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                                            <span
                                                class="ml-1 text-xs font-semibold text-gray-700">{{ number_format($product->average_rating, 1) }}</span>
                                        </div>
                                        <span class="text-gray-300">|</span>
                                        <span class="text-xs text-gray-600">{{ $product->total_reviews }} ulasan</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-cyan-100 to-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-box-open text-3xl text-cyan-500"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Produk</h3>
                        <p class="text-gray-500">Toko ini belum memiliki produk untuk ditampilkan.</p>
                    </div>
                @endif
            </div>

            <!-- Store Info Cards -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <!-- Address Card -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-cyan-500"></i> Alamat Toko
                    </h3>
                    <div class="space-y-2 text-gray-600">
                        @if ($seller->pic_street)
                            <p>{{ $seller->pic_street }}</p>
                        @endif
                        @if ($seller->pic_village || $seller->pic_district)
                            <p>
                                @if ($seller->pic_village)
                                    Kel. {{ $seller->pic_village }}
                                @endif
                                @if ($seller->pic_district)
                                    - Kec. {{ $seller->pic_district }}
                                @endif
                            </p>
                        @endif
                        <p class="font-medium">{{ $seller->pic_city ?? $seller->city }},
                            {{ $seller->pic_province ?? $seller->province }}</p>
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-phone-alt text-cyan-500"></i> Kontak
                    </h3>
                    <div class="space-y-3">
                        @if ($seller->pic_phone)
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-cyan-100 to-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-phone text-cyan-600"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Telepon</p>
                                    <a href="tel:{{ $seller->pic_phone }}"
                                        class="text-green-600 font-medium hover:underline">{{ $seller->pic_phone }}</a>
                                </div>
                            </div>
                        @endif
                        @if ($seller->pic_email)
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-cyan-100 to-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-envelope text-cyan-600"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Email</p>
                                    <a href="mailto:{{ $seller->pic_email }}"
                                        class="text-green-600 font-medium hover:underline">{{ $seller->pic_email }}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')
</body>

</html>
