<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Direktori Toko - {{ config('app.name', 'MartPlace') }}</title>

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

    <!-- Header Section -->
    <section class="bg-gradient-to-r from-green-400 to-cyan-300 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center md:text-left">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-3">Direktori Toko</h1>
            <p class="text-white text-lg md:text-xl">Temukan toko terpercaya di seluruh Indonesia</p>
        </div>
    </section>

    <!-- Search & Filter Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form method="GET" action="{{ route('sellers.index') }}" class="space-y-4">
                <!-- Search Bar -->
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari Nama Toko</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Masukkan nama toko..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <div class="w-full md:w-48">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
                        <select name="province"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Semua Provinsi</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province }}"
                                    {{ request('province') == $province ? 'selected' : '' }}>
                                    {{ $province }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-48">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kota/Kabupaten</label>
                        <select name="city"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Semua Kota</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-40">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                        <select name="sort"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi
                            </option>
                            <option value="products" {{ request('sort') == 'products' ? 'selected' : '' }}>Produk
                                Terbanyak</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-medium">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari
                    </button>
                    <a href="{{ route('sellers.index') }}"
                        class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition font-medium">
                        Reset
                    </a>
                </div>

                <!-- Active Filters -->
                @if (request()->hasAny(['search', 'province', 'city']))
                    <div class="flex flex-wrap gap-2 pt-4 border-t">
                        <span class="text-sm text-gray-600">Filter aktif:</span>
                        @if (request('search'))
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                Pencarian: "{{ request('search') }}"
                                <a href="{{ route('sellers.index', array_merge(request()->except('search'), [])) }}"
                                    class="ml-2 text-green-600 hover:text-green-800">×</a>
                            </span>
                        @endif
                        @if (request('province'))
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                Provinsi: "{{ request('province') }}"
                                <a href="{{ route('sellers.index', array_merge(request()->except('province'), [])) }}"
                                    class="ml-2 text-blue-600 hover:text-blue-800">×</a>
                            </span>
                        @endif
                        @if (request('city'))
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                Kota: "{{ request('city') }}"
                                <a href="{{ route('sellers.index', array_merge(request()->except('city'), [])) }}"
                                    class="ml-2 text-blue-600 hover:text-blue-800">×</a>
                            </span>
                        @endif
                    </div>
                @endif
            </form>
        </div>
    </section>

    <!-- Results Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-6">
            <p class="text-gray-600">
                Menampilkan <span class="font-semibold text-gray-900">{{ $sellers->total() }}</span> toko
            </p>
        </div>

        @if ($sellers->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-16 bg-white rounded-lg shadow-md">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                <h3 class="mt-4 text-xl font-medium text-gray-900">Tidak ada toko ditemukan</h3>
                <p class="mt-2 text-gray-500">Coba ubah filter pencarian Anda atau reset filter</p>
                <div class="mt-6">
                    <a href="{{ route('sellers.index') }}"
                        class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
                        Reset Filter
                    </a>
                </div>
            </div>
        @else
            <!-- Sellers Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($sellers as $seller)
                    <a href="{{ route('sellers.show', $seller->id) }}"
                        class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 overflow-hidden group">
                        <div class="p-6">
                            <!-- Store Icon -->
                            <div
                                class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition">
                                <svg class="w-10 h-10 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>

                            <!-- Store Name -->
                            <h3
                                class="text-lg font-bold text-gray-900 text-center mb-2 group-hover:text-green-600 transition line-clamp-2">
                                {{ $seller->store_name }}
                            </h3>

                            <!-- Location -->
                            <div class="flex items-center justify-center text-sm text-gray-500 mb-3">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="line-clamp-1">{{ $seller->city ?? 'N/A' }}</span>
                            </div>

                            <!-- Stats -->
                            <div class="flex items-center justify-center gap-4 py-3 border-t border-gray-100">
                                <div class="flex items-center text-yellow-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-semibold">{{ number_format($seller->rating, 1) }}</span>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <span class="font-semibold">{{ $seller->total_products }}</span> produk
                                </div>
                            </div>

                            <!-- View Store Button -->
                            <div class="mt-4">
                                <span
                                    class="block w-full bg-green-600 text-white text-center py-2 rounded-lg group-hover:bg-green-700 transition font-medium">
                                    Lihat Toko
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $sellers->appends(request()->query())->links() }}
            </div>
        @endif
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
