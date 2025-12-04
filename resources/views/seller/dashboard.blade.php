<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Seller - MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .stat-card {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,1) 100%);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .chart-container {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.03) 0%, rgba(34, 197, 94, 0.03) 100%);
        }
        .icon-float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .pulse-ring {
            animation: pulse-ring 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse-ring {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.5;
            }
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
                        <i class="fas fa-store mr-2"></i>Dashboard Seller
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
                    class="flex items-center px-4 py-3 text-green-600 bg-green-50 rounded-lg font-semibold">
                    <i class="fas fa-chart-line mr-3 w-5"></i>Dashboard Seller
                </a>
                <a href="{{ route('seller.products') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    <i class="fas fa-box mr-3 w-5"></i>Kelola Produk
                </a>
                <a href="{{ route('seller.reports') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
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
                    <div class="w-14 h-14 bg-gradient-to-br from-cyan-400 to-green-400 rounded-2xl flex items-center justify-center shadow-xl">
                        <i class="fas fa-chart-line text-white text-2xl icon-float"></i>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-cyan-600 to-green-600 bg-clip-text text-transparent">
                            Dashboard {{ $seller->store_name }}
                        </h1>
                        <p class="text-gray-600 mt-1">Statistik dan analisis performa toko real-time</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Products -->
                <div class="stat-card bg-white rounded-2xl shadow-xl p-6 border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full opacity-10 -mr-8 -mt-8"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg pulse-ring">
                                <i class="fas fa-box text-white text-xl"></i>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 font-medium uppercase tracking-wide mb-1">Total Produk</p>
                        <p class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
                            {{ number_format($totalProducts) }}
                        </p>
                    </div>
                </div>

                <!-- Total Stock -->
                <div class="stat-card bg-white rounded-2xl shadow-xl p-6 border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full opacity-10 -mr-8 -mt-8"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg pulse-ring">
                                <i class="fas fa-warehouse text-white text-xl"></i>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 font-medium uppercase tracking-wide mb-1">Total Stok</p>
                        <p class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-purple-700 bg-clip-text text-transparent">
                            {{ number_format($totalStock) }}
                        </p>
                    </div>
                </div>

                <!-- Average Rating -->
                <div class="stat-card bg-white rounded-2xl shadow-xl p-6 border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full opacity-10 -mr-8 -mt-8"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg pulse-ring">
                                <i class="fas fa-star text-white text-xl"></i>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 font-medium uppercase tracking-wide mb-1">Rating Rata-rata</p>
                        <p class="text-4xl font-bold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">
                            {{ number_format($averageRating ?? 0, 1) }}
                        </p>
                    </div>
                </div>

                <!-- Total Reviews -->
                <div class="stat-card bg-white rounded-2xl shadow-xl p-6 border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full opacity-10 -mr-8 -mt-8"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg pulse-ring">
                                <i class="fas fa-comment text-white text-xl"></i>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 font-medium uppercase tracking-wide mb-1">Total Ulasan</p>
                        <p class="text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-700 bg-clip-text text-transparent">
                            {{ number_format($totalReviews) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Stock Distribution Chart -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-boxes text-blue-600 mr-2"></i>Sebaran Stok Produk
                        </h2>
                    </div>
                    <div class="relative" style="height: 300px;">
                        <canvas id="stockChart"></canvas>
                    </div>
                </div>

                <!-- Rating Distribution Chart -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-star text-yellow-500 mr-2"></i>Sebaran Rating Produk
                        </h2>
                    </div>
                    <div class="relative" style="height: 300px;">
                        <canvas id="ratingChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Province Distribution Chart -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>Sebaran Pemberi Rating Berdasarkan Provinsi
                    </h2>
                </div>
                <div class="relative" style="height: 400px;">
                    <canvas id="provinceChart"></canvas>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Stock Distribution Chart (Bar Chart)
        const stockCtx = document.getElementById('stockChart').getContext('2d');
        const stockData = @json($stockDistribution);
        
        new Chart(stockCtx, {
            type: 'bar',
            data: {
                labels: stockData.map(item => item.name.length > 20 ? item.name.substring(0, 20) + '...' : item.name),
                datasets: [{
                    label: 'Jumlah Stok',
                    data: stockData.map(item => item.stock),
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                const index = context[0].dataIndex;
                                return stockData[index].name;
                            },
                            label: function(context) {
                                return 'Stok: ' + context.parsed.y.toLocaleString() + ' unit';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });

        // Rating Distribution Chart (Horizontal Bar Chart)
        const ratingCtx = document.getElementById('ratingChart').getContext('2d');
        const ratingData = @json($ratingDistribution);
        
        new Chart(ratingCtx, {
            type: 'bar',
            data: {
                labels: ratingData.map(item => item.name.length > 20 ? item.name.substring(0, 20) + '...' : item.name),
                datasets: [{
                    label: 'Rating',
                    data: ratingData.map(item => item.rating),
                    backgroundColor: 'rgba(234, 179, 8, 0.8)',
                    borderColor: 'rgba(234, 179, 8, 1)',
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
                            title: function(context) {
                                const index = context[0].dataIndex;
                                return ratingData[index].name;
                            },
                            label: function(context) {
                                const index = context.dataIndex;
                                return [
                                    'Rating: ' + context.parsed.x.toFixed(1) + '/5',
                                    'Total Ulasan: ' + ratingData[index].reviews
                                ];
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 5,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Province Distribution Chart (Doughnut Chart)
        const provinceCtx = document.getElementById('provinceChart').getContext('2d');
        const provinceData = @json($ratingByProvince);
        
        const colors = [
            'rgba(59, 130, 246, 0.8)',   // Blue
            'rgba(16, 185, 129, 0.8)',   // Green
            'rgba(234, 179, 8, 0.8)',    // Yellow
            'rgba(239, 68, 68, 0.8)',    // Red
            'rgba(168, 85, 247, 0.8)',   // Purple
            'rgba(236, 72, 153, 0.8)',   // Pink
            'rgba(249, 115, 22, 0.8)',   // Orange
            'rgba(20, 184, 166, 0.8)',   // Teal
            'rgba(99, 102, 241, 0.8)',   // Indigo
            'rgba(14, 165, 233, 0.8)'    // Sky
        ];

        new Chart(provinceCtx, {
            type: 'doughnut',
            data: {
                labels: provinceData.map(item => item.province),
                datasets: [{
                    data: provinceData.map(item => item.total),
                    backgroundColor: colors,
                    borderColor: colors.map(color => color.replace('0.8', '1')),
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
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
                                return label + ': ' + value + ' ulasan (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
