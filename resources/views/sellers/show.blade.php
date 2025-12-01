<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seller->store_name }} - MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    @include('layouts.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-20">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('sellers.index') }}" class="text-green-600 hover:text-green-700 flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali ke Direktori Toko</span>
            </a>
        </div>

        <!-- Store Header -->
        <div class="bg-white rounded-lg shadow-sm p-8 mb-6">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <!-- Store Photo -->
                <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-100 flex-shrink-0">
                    @if($seller->store_photo)
                        <img src="{{ Storage::url($seller->store_photo) }}" 
                            alt="{{ $seller->store_name }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <i class="fas fa-store text-5xl"></i>
                        </div>
                    @endif
                </div>

                <!-- Store Info -->
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $seller->store_name }}</h1>
                    <p class="text-gray-600 mb-4">{{ $seller->store_description }}</p>

                    <div class="flex flex-wrap gap-4 justify-center md:justify-start text-sm">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-green-600"></i>
                            <span>{{ $seller->city }}, {{ $seller->province }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-phone text-green-600"></i>
                            <span>{{ $seller->pic_phone }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-envelope text-green-600"></i>
                            <span>{{ $seller->pic_email }}</span>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 mt-6 max-w-md mx-auto md:mx-0">
                        <div class="text-center md:text-left">
                            <div class="text-2xl font-bold text-green-600">{{ $seller->total_products }}</div>
                            <div class="text-sm text-gray-500">Produk</div>
                        </div>
                        <div class="text-center md:text-left">
                            <div class="text-2xl font-bold text-yellow-500">
                                <i class="fas fa-star"></i> {{ number_format($seller->rating, 1) }}
                            </div>
                            <div class="text-sm text-gray-500">Rating</div>
                        </div>
                        <div class="text-center md:text-left">
                            <div class="text-2xl font-bold text-blue-600">{{ $seller->total_reviews }}</div>
                            <div class="text-sm text-gray-500">Ulasan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Store Details -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Address -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>Alamat Lengkap
                </h2>
                <div class="space-y-2 text-gray-600">
                    <p>{{ $seller->address }}</p>
                    <p>Kelurahan: {{ $seller->village }}</p>
                    <p>Kecamatan: {{ $seller->district }}</p>
                    <p>Kota/Kabupaten: {{ $seller->city }}</p>
                    <p>Provinsi: {{ $seller->province }}</p>
                </div>
            </div>

            <!-- Contact Person -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-user text-green-600 mr-2"></i>Kontak Person
                </h2>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-user-circle text-gray-400 w-5"></i>
                        <span class="text-gray-600">{{ $seller->pic_name }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fas fa-phone text-gray-400 w-5"></i>
                        <a href="tel:{{ $seller->pic_phone }}" class="text-green-600 hover:text-green-700">
                            {{ $seller->pic_phone }}
                        </a>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fas fa-envelope text-gray-400 w-5"></i>
                        <a href="mailto:{{ $seller->pic_email }}" class="text-green-600 hover:text-green-700">
                            {{ $seller->pic_email }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section (Placeholder) -->
        <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">
                <i class="fas fa-box text-green-600 mr-2"></i>Produk dari Toko Ini
            </h2>
            <p class="text-gray-500 text-center py-8">Produk akan segera ditampilkan.</p>
        </div>
    </div>

    @include('layouts.footer')
</body>
</html>
