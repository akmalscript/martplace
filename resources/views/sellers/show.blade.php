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
                    <a href="{{ route('sellers.index') }}" class="text-white hover:text-gray-100">
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
                        <form action="{{ route('sellers.approve', $seller->id) }}" method="POST" class="w-full">
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
                <form action="{{ route('sellers.reject', $seller->id) }}" method="POST">
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
</html>
