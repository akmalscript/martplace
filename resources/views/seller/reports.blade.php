<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Seller - MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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
                    <a href="{{ route('seller.dashboard') }}" class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-store mr-2"></i>Laporan Seller
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    <span class="text-white font-semibold hidden md:block">
                        <i class="fas fa-user mr-2"></i>{{ $seller->store_name }}
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
                <a href="{{ route('seller.dashboard') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    <i class="fas fa-chart-line mr-3 w-5"></i>Dashboard Seller
                </a>
                <a href="{{ route('seller.products') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    <i class="fas fa-box mr-3 w-5"></i>Kelola Produk
                </a>
                <a href="{{ route('seller.reports') }}"
                    class="flex items-center px-4 py-3 text-green-600 bg-green-50 rounded-lg font-semibold">
                    <i class="fas fa-book mr-3 w-5"></i>Laporan
                </a>
                <hr class="my-4">
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
                        <h1 class="text-3xl font-bold text-gray-800">Laporan {{ $seller->store_name }}</h1>
                        <p class="text-gray-600">Ringkasan dan analisis performa toko Anda</p>
                    </div>
                </div>
            </div>

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
                                <p class="text-white text-opacity-80 text-sm">Unduh laporan produk dalam format PDF</p>
                            </div>
                        </div>
                        <div class="hidden md:flex items-center space-x-2 text-white text-opacity-80">
                            <i class="fas fa-info-circle"></i>
                            <span class="text-sm">{{ $totalProducts ?? 0 }} produk tersedia</span>
                        </div>
                    </div>
                </div>

                <!-- Reports List -->
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Report 1: Stock by Quantity -->
                        <div class="report-row gradient-card rounded-xl p-5 border border-gray-100">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <i class="fas fa-boxes-stacked text-white text-xl"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-full">01</span>
                                            <h3 class="font-bold text-gray-800 text-lg">Laporan Stok Produk (Urut Stok)</h3>
                                        </div>
                                        <p class="text-gray-600 text-sm mb-2">
                                            Daftar stok produk diurutkan berdasarkan jumlah stok secara menurun
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
                                    <a href="{{ route('seller.reports.stock-by-quantity') }}" 
                                       class="glow-button inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold">
                                        <i class="fas fa-download mr-2"></i>
                                        Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Report 2: Stock by Rating -->
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
                                            <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-2.5 py-1 rounded-full">02</span>
                                            <h3 class="font-bold text-gray-800 text-lg">Laporan Stok Produk (Urut Rating)</h3>
                                        </div>
                                        <p class="text-gray-600 text-sm mb-2">
                                            Daftar stok produk diurutkan berdasarkan rating secara menurun
                                        </p>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="inline-flex items-center text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">
                                                <i class="fas fa-cubes mr-1 text-blue-500"></i>Stok
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
                                    <a href="{{ route('seller.reports.stock-by-rating') }}" 
                                       class="glow-button inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-xl hover:from-yellow-600 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold">
                                        <i class="fas fa-download mr-2"></i>
                                        Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Report 3: Low Stock Alert -->
                        <div class="report-row gradient-card rounded-xl p-5 border border-gray-100">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                                            <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span class="bg-red-100 text-red-700 text-xs font-bold px-2.5 py-1 rounded-full">03</span>
                                            <h3 class="font-bold text-gray-800 text-lg">Laporan Stok Hampir Habis</h3>
                                            @if(($lowStockProducts->count() ?? 0) > 0)
                                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full animate-pulse">
                                                {{ $lowStockProducts->count() }} produk
                                            </span>
                                            @endif
                                        </div>
                                        <p class="text-gray-600 text-sm mb-2">
                                            Daftar produk dengan stok &lt; 2 yang harus segera dipesan ulang
                                        </p>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="inline-flex items-center text-xs text-red-600 bg-red-50 px-2 py-1 rounded-lg font-medium">
                                                <i class="fas fa-warning mr-1"></i>Stok Kritis (< 2)
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
                                    <a href="{{ route('seller.reports.low-stock') }}" 
                                       class="glow-button inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-xl hover:from-red-600 hover:to-pink-600 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold">
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
                                <p class="font-semibold text-gray-700 mb-1">Tips Pengelolaan Stok:</p>
                                <ul class="text-xs space-y-1 text-gray-500">
                                    <li>• Periksa laporan stok hampir habis secara berkala</li>
                                    <li>• Perhatikan produk dengan rating tinggi untuk prioritas restock</li>
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
</body>

</html>
