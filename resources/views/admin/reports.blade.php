<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-book mr-3 text-green-500"></i>Laporan MartPlace
                </h1>
                <p class="text-gray-600">Unduh dan kelola laporan platform marketplace</p>
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

            <!-- Reports Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-cyan-400 to-green-300 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-file-alt mr-3"></i>Daftar Laporan
                    </h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 w-20">No</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Jenis Laporan</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Deskripsi</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 w-48">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <!-- Laporan 1: Daftar Seller Aktif/Tidak Aktif -->
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-700 font-medium">1</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-users text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">Daftar Akun Penjual</p>
                                            <p class="text-xs text-gray-500">Format: PDF</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">
                                    Laporan daftar akun penjual aktif dan tidak aktif dengan detail informasi toko
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.reports.sellers') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md hover:shadow-lg">
                                        <i class="fas fa-download mr-2"></i>
                                        Download PDF
                                    </a>
                                </td>
                            </tr>

                            <!-- Laporan 2: Seller per Provinsi -->
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-700 font-medium">2</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-map-marker-alt text-green-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">Penjual per Provinsi</p>
                                            <p class="text-xs text-gray-500">Format: PDF</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">
                                    Laporan daftar penjual (toko) yang dikelompokkan berdasarkan lokasi provinsi
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.reports.sellers-by-province') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-md hover:shadow-lg">
                                        <i class="fas fa-download mr-2"></i>
                                        Download PDF
                                    </a>
                                </td>
                            </tr>

                            <!-- Laporan 3: Produk Berdasarkan Rating -->
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-700 font-medium">3</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-star text-yellow-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">Produk & Rating</p>
                                            <p class="text-xs text-gray-500">Format: PDF</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">
                                    Laporan daftar produk dengan rating, toko, kategori, harga, dan lokasi provinsi (diurutkan berdasarkan rating tertinggi)
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.reports.products-by-rating') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition shadow-md hover:shadow-lg">
                                        <i class="fas fa-download mr-2"></i>
                                        Download PDF
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Info Footer -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex items-start space-x-3 text-sm text-gray-600">
                        <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                        <div>
                            <p class="font-semibold text-gray-700 mb-1">Informasi Laporan:</p>
                            <ul class="list-disc list-inside space-y-1 ml-2">
                                <li>Semua laporan akan diunduh dalam format PDF</li>
                                <li>Data laporan diambil secara real-time dari database</li>
                                <li>Laporan dapat diunduh kapan saja sesuai kebutuhan</li>
                            </ul>
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
