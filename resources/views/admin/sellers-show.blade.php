<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Seller - Admin MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50" x-data="{ showRejectModal: false, rejectReason: '' }">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-cyan-400 to-green-300 shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.sellers.index') }}" class="text-white hover:text-gray-100">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <span class="text-white">|</span>
                    <a href="/" class="text-2xl font-bold text-white">
                        <i class="fas fa-store mr-2"></i>MartPlace Admin
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white font-semibold">
                        <i class="fas fa-user-shield mr-2"></i>Admin
                    </span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mx-auto px-6 py-8">
        <!-- Header with Status -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $seller->store_name }}</h1>
                    <p class="text-gray-600">Pendaftaran: {{ $seller->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
                <div>
                    @if($seller->status === App\Enums\SellerStatus::PENDING)
                    <span class="px-6 py-3 inline-flex text-base leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        <i class="fas fa-clock mr-2"></i> Menunggu Verifikasi
                    </span>
                    @elseif($seller->status === App\Enums\SellerStatus::ACTIVE)
                    <span class="px-6 py-3 inline-flex text-base leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-2"></i> Disetujui
                    </span>
                    @else
                    <span class="px-6 py-3 inline-flex text-base leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        <i class="fas fa-times-circle mr-2"></i> Ditolak
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-xl"></i>
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('warning'))
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-3 text-xl"></i>
                <p class="font-semibold">{{ session('warning') }}</p>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Section 1: Data Toko -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-store mr-3"></i>Data Toko
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Toko</label>
                            <p class="text-gray-900 text-lg">{{ $seller->store_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Deskripsi Toko</label>
                            <p class="text-gray-900">{{ $seller->store_description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Data PIC -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-user-tie mr-3"></i>Data Penanggung Jawab
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                                <p class="text-gray-900">{{ $seller->pic_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Nomor Telepon</label>
                                <p class="text-gray-900">{{ $seller->pic_phone }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
                            <p class="text-gray-900">{{ $seller->pic_email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Alamat -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-map-marker-alt mr-3"></i>Alamat Penanggung Jawab
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Alamat Jalan</label>
                            <p class="text-gray-900">{{ $seller->pic_street }}</p>
                        </div>
                        <div class="grid grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">RT</label>
                                <p class="text-gray-900">{{ $seller->pic_rt }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">RW</label>
                                <p class="text-gray-900">{{ $seller->pic_rw }}</p>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Kelurahan/Desa</label>
                                <p class="text-gray-900">{{ $seller->pic_village }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Kecamatan</label>
                                <p class="text-gray-900">{{ $seller->pic_district }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Kabupaten/Kota</label>
                                <p class="text-gray-900">{{ $seller->pic_city }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Provinsi</label>
                                <p class="text-gray-900">{{ $seller->pic_province }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Dokumen Identitas -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-id-card mr-3"></i>Dokumen Identitas
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Nomor KTP</label>
                            <p class="text-gray-900 text-lg">{{ $seller->pic_ktp_number }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Photo Preview -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">
                            <i class="fas fa-camera mr-2"></i>Foto PIC
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($seller->pic_photo_path)
                        <img src="{{ Storage::url($seller->pic_photo_path) }}" alt="Foto PIC" class="w-full rounded-lg shadow">
                        @else
                        <div class="bg-gray-100 rounded-lg h-64 flex items-center justify-center">
                            <i class="fas fa-user text-gray-400 text-6xl"></i>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- KTP Preview -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">
                            <i class="fas fa-id-card mr-2"></i>Foto KTP
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($seller->pic_ktp_file_path)
                        <img src="{{ Storage::url($seller->pic_ktp_file_path) }}" alt="Foto KTP" class="w-full rounded-lg shadow">
                        <a href="{{ Storage::url($seller->pic_ktp_file_path) }}" target="_blank" class="mt-3 inline-block text-green-600 hover:text-green-800">
                            <i class="fas fa-external-link-alt mr-1"></i>Lihat Penuh
                        </a>
                        @else
                        <div class="bg-gray-100 rounded-lg h-48 flex items-center justify-center">
                            <i class="fas fa-id-card text-gray-400 text-6xl"></i>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                @if($seller->status === App\Enums\SellerStatus::PENDING)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6 space-y-3">
                        <form action="{{ route('admin.sellers.approve', $seller->id) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-lg flex items-center justify-center">
                                <i class="fas fa-check-circle mr-2"></i>Setujui Seller
                            </button>
                        </form>

                        <button @click="showRejectModal = true" type="button" class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-lg flex items-center justify-center">
                            <i class="fas fa-times-circle mr-2"></i>Tolak Seller
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div x-show="showRejectModal" 
         x-cloak
         @keydown.escape.window="showRejectModal = false"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="showRejectModal = false"></div>
        
        <!-- Modal -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full p-6" @click.away="showRejectModal = false">
                <!-- Header -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>Tolak Pendaftaran Seller
                    </h3>
                    <button @click="showRejectModal = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>

                <!-- Form -->
                <form action="{{ route('admin.sellers.reject', $seller->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Alasan Penolakan <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="reason" 
                            x-model="rejectReason"
                            rows="5" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            placeholder="Jelaskan alasan penolakan pendaftaran seller ini..."
                            required></textarea>
                        <p class="mt-1 text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>Alasan ini akan dikirim ke email seller
                        </p>
                    </div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Email notifikasi penolakan akan dikirim ke <strong>{{ $seller->pic_email }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex space-x-3">
                        <button 
                            type="button" 
                            @click="showRejectModal = false"
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg transition">
                            <i class="fas fa-times mr-2"></i>Batal
                        </button>
                        <button 
                            type="submit"
                            class="flex-1 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                            <i class="fas fa-paper-plane mr-2"></i>Kirim Penolakan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
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
                            </div>

                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                    <span>{{ number_format($product->average_rating, 1) }}</span>
                                </div>
                                <span>{{ number_format($product->sold_count) }} terjual</span>
                            </div>

                            <div class="mt-2 text-xs text-gray-500 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $product->city }}, {{ $product->province }}
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
