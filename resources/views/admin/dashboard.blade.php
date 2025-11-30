<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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
                        <i class="fas fa-user-shield mr-2"></i>{{ Auth::user()->name }}
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
                    class="flex items-center px-4 py-3 text-green-600 bg-green-50 rounded-lg font-semibold">
                    <i class="fas fa-chart-line mr-3 w-5"></i>Dashboard
                </a>
                <a href="{{ route('admin.sellers.index') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    <i class="fas fa-store mr-3 w-5"></i>Kelola Seller
                </a>
                <a href="{{ route('products.index') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    <i class="fas fa-box mr-3 w-5"></i>Kelola Produk
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
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Admin MartPlace</h1>
                <p class="text-gray-600">Statistik dan analisis platform marketplace</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Products -->
                <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Total Produk</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalProducts) }}</p>
                        </div>
                        <div class="bg-blue-100 p-4 rounded-full">
                            <i class="fas fa-box text-blue-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Sellers -->
                <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Total Toko</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalSellers) }}</p>
                        </div>
                        <div class="bg-purple-100 p-4 rounded-full">
                            <i class="fas fa-store text-purple-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Active Sellers -->
                <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Seller Aktif</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($activeSellers) }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-full">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending Sellers -->
                <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Menunggu Verifikasi</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($pendingSellers) }}</p>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-full">
                            <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 1 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Produk per Kategori Chart -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-tags text-blue-600 mr-2"></i>Sebaran Produk per Kategori
                        </h2>
                    </div>
                    <div class="relative h-80">
                        <canvas id="categoryChart"></canvas>
                    </div>
                    <div class="mt-4 text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        Total: <strong>{{ number_format($totalProducts) }} produk</strong>
                    </div>
                </div>

                <!-- Seller Status Chart -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-user-check text-green-600 mr-2"></i>Status Seller
                        </h2>
                    </div>
                    <div class="relative h-80">
                        <canvas id="sellerStatusChart"></canvas>
                    </div>
                    <div class="mt-4 text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        Total: <strong>{{ number_format($totalSellers) }} seller</strong>
                    </div>
                </div>
            </div>

            <!-- Charts Row 2 -->
            <div class="grid grid-cols-1 gap-6 mb-6">
                <!-- Toko per Provinsi Chart -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-map-marked-alt text-purple-600 mr-2"></i>Sebaran Toko per Provinsi
                        </h2>
                    </div>
                    <div class="relative" style="height: 400px;">
                        <canvas id="provinceChart"></canvas>
                    </div>
                    <div class="mt-4 text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        Menampilkan sebaran toko berdasarkan lokasi provinsi di Indonesia
                    </div>
                </div>
            </div>

            <!-- Reviews & Ratings Info Card -->
            <div class="bg-gradient-to-r from-cyan-400 to-green-300 rounded-lg shadow-lg p-8 text-white">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="text-center">
                        <div class="bg-white bg-opacity-20 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-comments text-4xl"></i>
                        </div>
                        <p class="text-sm font-semibold mb-2">Total Komentar</p>
                        <p class="text-4xl font-bold">{{ number_format($totalReviews) }}</p>
                        <p class="text-sm mt-2 opacity-90">Dari pengunjung platform</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white bg-opacity-20 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-star text-4xl"></i>
                        </div>
                        <p class="text-sm font-semibold mb-2">Total Rating</p>
                        <p class="text-4xl font-bold">{{ number_format($totalRatings) }}</p>
                        <p class="text-sm mt-2 opacity-90">Rating yang diberikan user</p>
                    </div>
                </div>
                <div class="mt-6 bg-white bg-opacity-10 rounded-lg p-4">
                    <p class="text-sm">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Info:</strong> Fitur komentar dan rating akan aktif setelah sistem review diimplementasikan
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- Chart.js Scripts -->
    <script>
        // Data dari Laravel
        const categoryData = @json($productsByCategory);
        const provinceData = @json($sellersByProvince);
        const activeSellers = {{ $activeSellers }};
        const inactiveSellers = {{ $inactiveSellers }};

        // Chart Colors
        const chartColors = [
            'rgba(59, 130, 246, 0.8)',  // Blue
            'rgba(16, 185, 129, 0.8)',  // Green
            'rgba(249, 115, 22, 0.8)',  // Orange
            'rgba(236, 72, 153, 0.8)',  // Pink
            'rgba(139, 92, 246, 0.8)',  // Purple
            'rgba(234, 179, 8, 0.8)',   // Yellow
            'rgba(14, 165, 233, 0.8)',  // Cyan
            'rgba(239, 68, 68, 0.8)',   // Red
            'rgba(34, 197, 94, 0.8)',   // Emerald
            'rgba(168, 85, 247, 0.8)',  // Violet
        ];

        // 1. Category Chart (Doughnut)
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: categoryData.map(item => item.category || 'Tidak ada kategori'),
                datasets: [{
                    data: categoryData.map(item => item.total),
                    backgroundColor: chartColors,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} produk (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // 2. Seller Status Chart (Pie)
        const sellerStatusCtx = document.getElementById('sellerStatusChart').getContext('2d');
        new Chart(sellerStatusCtx, {
            type: 'pie',
            data: {
                labels: ['Aktif', 'Tidak Aktif'],
                datasets: [{
                    data: [activeSellers, inactiveSellers],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',  // Green for active
                        'rgba(239, 68, 68, 0.8)'     // Red for inactive
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} seller (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // 3. Province Chart (Bar - Horizontal)
        const provinceCtx = document.getElementById('provinceChart').getContext('2d');
        
        // Sort and take top 10 provinces
        const sortedProvinces = provinceData.sort((a, b) => b.total - a.total).slice(0, 10);
        
        new Chart(provinceCtx, {
            type: 'bar',
            data: {
                labels: sortedProvinces.map(item => item.province || 'Tidak diketahui'),
                datasets: [{
                    label: 'Jumlah Toko',
                    data: sortedProvinces.map(item => item.total),
                    backgroundColor: 'rgba(139, 92, 246, 0.8)',
                    borderColor: 'rgba(139, 92, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Jumlah toko: ${context.parsed.x}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
