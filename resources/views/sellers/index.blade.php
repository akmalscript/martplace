<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktori Toko - MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    @include('layouts.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-20">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Direktori Toko</h1>
            <p class="text-gray-600">Temukan berbagai toko terpercaya di MartPlace</p>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <form action="{{ route('sellers.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama toko..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- Province Filter -->
                    <div>
                        <select name="province"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
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
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                        <option value="products" {{ request('sort') == 'products' ? 'selected' : '' }}>Produk Terbanyak</option>
                    </select>

                    <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>

                    @if(request()->hasAny(['search', 'province', 'city', 'sort']))
                        <a href="{{ route('sellers.index') }}"
                            class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                            <i class="fas fa-redo mr-2"></i>Reset
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
                        class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden">
                        <div class="p-6">
                            <!-- Store Photo -->
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden bg-gray-100">
                                @if($seller->store_photo)
                                    <img src="{{ Storage::url($seller->store_photo) }}" 
                                        alt="{{ $seller->store_name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <i class="fas fa-store text-3xl"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Store Info -->
                            <div class="text-center">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $seller->store_name }}</h3>
                                <p class="text-sm text-gray-600 mb-3">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    {{ $seller->city }}, {{ $seller->province }}
                                </p>

                                <!-- Stats -->
                                <div class="grid grid-cols-3 gap-2 text-center border-t pt-3">
                                    <div>
                                        <div class="text-lg font-bold text-green-600">{{ $seller->total_products }}</div>
                                        <div class="text-xs text-gray-500">Produk</div>
                                    </div>
                                    <div>
                                        <div class="text-lg font-bold text-yellow-500">
                                            <i class="fas fa-star"></i> {{ number_format($seller->rating, 1) }}
                                        </div>
                                        <div class="text-xs text-gray-500">Rating</div>
                                    </div>
                                    <div>
                                        <div class="text-lg font-bold text-blue-600">{{ $seller->total_reviews }}</div>
                                        <div class="text-xs text-gray-500">Ulasan</div>
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
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <i class="fas fa-store text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Toko</h3>
                <p class="text-gray-500">Tidak ada toko yang ditemukan dengan kriteria pencarian Anda.</p>
            </div>
        @endif
    </div>

    @include('layouts.footer')
</body>
</html>
