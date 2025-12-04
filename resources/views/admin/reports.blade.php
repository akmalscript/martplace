<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .gradient-card {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.05) 0%, rgba(34, 197, 94, 0.05) 100%);
        }
        .report-row {
            transition: all 0.3s ease;
        }
        .report-row:hover {
            transform: translateX(5px);
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        }
        .glow-button {
            position: relative;
            overflow: hidden;
        }
        .glow-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: 0.5s;
        }
        .glow-button:hover::before {
            left: 100%;
        }
        .icon-float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
    </style>
</head>

<body class="bg-gray-50" x-data="{ sidebarOpen: false }">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-cyan-400 to-green-300 shadow-lg fixed top-0 left-0 right-0 z-50">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-white lg:hidden">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-chart-line mr-2"></i>Dashboard Admin
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    <span class="text-white font-semibold hidden md:block">
                        <i class="fas fa-user-shield mr-2"></i>Admin MartPlace
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-white hover:text-gray-100 transition">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="fixed top-16 left-0 h-full bg-white shadow-lg transition-transform duration-300 z-40 w-64"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
        <div class="p-6">
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    <i class="fas fa-chart-line mr-3 w-5"></i>Dashboard
                </a>
                <a href="{{ route('admin.sellers.index') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    <i class="fas fa-store mr-3 w-5"></i>Kelola Seller
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    <i class="fas fa-tags mr-3 w-5"></i>Kelola Kategori
                </a>
                <a href="{{ route('admin.reports.index') }}"
                    class="flex items-center px-4 py-3 text-green-600 bg-green-50 rounded-lg font-semibold">
                    <i class="fas fa-book mr-3 w-5"></i>Laporan
                </a>
                <a href="{{ route('home') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    <i class="fas fa-globe mr-3 w-5"></i>Lihat Website
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-64 pt-16">
        <div class="p-6 lg:p-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center space-x-4 mb-2">
                    <div class="w-12 h-12 bg-gradient-to-r from-cyan-400 to-green-400 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-book text-white text-xl icon-float"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Laporan Admin MartPlace</h1>
                        <p class="text-gray-600">Unduh dan kelola laporan platform marketplace</p>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                    <p class="font-semibold">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <!-- Download Reports Section -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mb-8">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-file-pdf text-white text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Download Laporan PDF</h2>
                                <p class="text-white text-opacity-80 text-sm">Unduh laporan platform dalam format PDF</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reports List -->
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Report 1: Daftar Akun Penjual -->
                        <div class="report-row gradient-card rounded-xl p-5 border border-gray-100">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <i class="fas fa-users text-white text-xl"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-full">01</span>
                                            <h3 class="font-bold text-gray-800 text-lg">Daftar Akun Penjual</h3>
                                        </div>
                                        <p class="text-gray-600 text-sm mb-2">
                                            Laporan daftar akun penjual aktif dan tidak aktif dengan detail informasi toko
                                        </p>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="inline-flex items-center text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">
                                                <i class="fas fa-store mr-1 text-blue-500"></i>Nama Toko
                                            </span>
                                            <span class="inline-flex items-center text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">
                                                <i class="fas fa-user mr-1 text-green-500"></i>Pemilik
                                            </span>
                                            <span class="inline-flex items-center text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">
                                                <i class="fas fa-toggle-on mr-1 text-emerald-500"></i>Status
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('admin.reports.sellers') }}" 
                                       class="glow-button inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold">
                                        <i class="fas fa-download mr-2"></i>
                                        Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Report 2: Penjual per Provinsi -->
                        <div class="report-row gradient-card rounded-xl p-5 border border-gray-100">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                                            <i class="fas fa-map-marker-alt text-white text-xl"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full">02</span>
                                            <h3 class="font-bold text-gray-800 text-lg">Penjual per Provinsi</h3>
                                        </div>
                                        <p class="text-gray-600 text-sm mb-2">
                                            Laporan daftar penjual (toko) yang dikelompokkan berdasarkan lokasi provinsi
                                        </p>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="inline-flex items-center text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">
                                                <i class="fas fa-map mr-1 text-green-500"></i>Provinsi
                                            </span>
                                            <span class="inline-flex items-center text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">
                                                <i class="fas fa-store mr-1 text-blue-500"></i>Nama Toko
                                            </span>
                                            <span class="inline-flex items-center text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">
                                                <i class="fas fa-phone mr-1 text-purple-500"></i>Kontak
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('admin.reports.sellers-by-province') }}" 
                                       class="glow-button inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-xl hover:from-green-600 hover:to-emerald-600 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold">
                                        <i class="fas fa-download mr-2"></i>
                                        Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Report 3: Produk & Rating -->
                        <div class="report-row gradient-card rounded-xl p-5 border border-gray-100">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                                            <i class="fas fa-star text-white text-xl"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-2.5 py-1 rounded-full">03</span>
                                            <h3 class="font-bold text-gray-800 text-lg">Produk & Rating</h3>
                                        </div>
                                        <p class="text-gray-600 text-sm mb-2">
                                            Laporan daftar produk dengan rating, toko, kategori, harga, dan lokasi provinsi
                                        </p>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="inline-flex items-center text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">
                                                <i class="fas fa-star mr-1 text-yellow-500"></i>Rating
                                            </span>
                                            <span class="inline-flex items-center text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">
                                                <i class="fas fa-tag mr-1 text-green-500"></i>Kategori
                                            </span>
                                            <span class="inline-flex items-center text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">
                                                <i class="fas fa-money-bill mr-1 text-emerald-500"></i>Harga
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('admin.reports.products-by-rating') }}" 
                                       class="glow-button inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-xl hover:from-yellow-600 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold">
                                        <i class="fas fa-download mr-2"></i>
                                        Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="bg-gray-50 px-8 py-4 border-t border-gray-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-start space-x-3 text-sm text-gray-600">
                            <div class="flex-shrink-0 w-8 h-8 bg-cyan-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-lightbulb text-cyan-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-700 mb-1">Informasi Laporan:</p>
                                <ul class="text-xs space-y-1 text-gray-500">
                                    <li>• Semua laporan diunduh dalam format PDF</li>
                                    <li>• Data laporan diambil real-time dari database</li>
                                </ul>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            Terakhir diperbarui: {{ now()->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Overlay untuk mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>
</body>

</html>
