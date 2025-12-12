<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Saya - Dashboard Seller</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        .product-card {
            transition: all 0.2s ease;
        }
        .product-card:hover {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.05) 0%, rgba(34, 197, 94, 0.05) 100%);
            transform: scale(1.01);
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
        .btn-glow {
            position: relative;
            overflow: hidden;
        }
        .btn-glow::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: 0.5s;
        }
        .btn-glow:hover::before {
            left: 100%;
        }

        #filterSection {
            transition: opacity 0.3s ease-out, max-height 0.3s ease-out;
            overflow: hidden;
            max-height: 0;
            opacity: 0;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: false }">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-cyan-400 to-green-300 shadow-lg fixed w-full top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-white lg:hidden">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                    <a href="{{ route('seller.dashboard') }}" class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-store mr-2"></i>Dashboard Seller
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white font-semibold">
                        <i class="fas fa-user mr-2"></i>{{ $seller->store_name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white hover:text-gray-200">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex pt-16">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg min-h-screen fixed lg:static transition-all duration-300"
               :class="sidebarOpen ? 'left-0' : '-left-64 lg:left-0'">
            <nav class="p-6 space-y-2">
                <a href="{{ route('seller.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-chart-line w-5"></i>
                    <span>Dashboard Seller</span>
                </a>
                <a href="{{ route('seller.products') }}" class="flex items-center space-x-3 p-3 rounded-lg bg-green-50 text-green-600 font-semibold">
                    <i class="fas fa-box w-5"></i>
                    <span>Kelola Produk</span>
                </a>
                <a href="{{ route('seller.reports') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-book w-5"></i>
                    <span>Laporan</span>
                </a>
                <hr class="my-4">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-globe w-5"></i>
                    <span>Lihat Website</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 lg:p-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center space-x-4 mb-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center shadow-xl">
                        <i class="fas fa-box text-white text-2xl icon-float"></i>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            Produk Saya
                        </h1>
                        <p class="text-gray-600 mt-1">Kelola semua produk yang Anda jual di marketplace</p>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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
                            {{ $totalProducts }}
                        </p>
                    </div>
                </div>

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

                <div class="stat-card bg-white rounded-2xl shadow-xl p-6 border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full opacity-10 -mr-8 -mt-8"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg pulse-ring">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 font-medium uppercase tracking-wide mb-1">Produk Aktif</p>
                        <p class="text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-700 bg-clip-text text-transparent">
                            {{ $activeProducts }}
                        </p>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-2xl shadow-xl p-6 border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-red-400 to-pink-600 rounded-full opacity-10 -mr-8 -mt-8"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg pulse-ring">
                                <i class="fas fa-times-circle text-white text-xl"></i>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 font-medium uppercase tracking-wide mb-1">Produk Nonaktif</p>
                        <p class="text-4xl font-bold bg-gradient-to-r from-red-600 to-pink-700 bg-clip-text text-transparent">
                            {{ $inactiveProducts }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-6 border border-gray-100">
                <form method="GET" action="{{ route('seller.products') }}" class="space-y-4">
                    <!-- Search Bar -->
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="flex-1 w-full md:w-auto">
                            <div class="relative">
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Cari produk berdasarkan nama atau kategori..." 
                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all bg-gray-50">
                                <i class="fas fa-search absolute left-4 top-4 text-gray-400"></i>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" 
                                    onclick="toggleFilter()"
                                    class="btn-glow bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 px-5 py-3 rounded-xl hover:from-gray-200 hover:to-gray-300 transition-all shadow-md hover:shadow-lg font-semibold">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                            <button type="submit" 
                                    class="btn-glow bg-gradient-to-r from-cyan-500 to-green-500 text-white px-5 py-3 rounded-xl hover:from-cyan-600 hover:to-green-600 transition-all shadow-md hover:shadow-lg font-semibold">
                                <i class="fas fa-search mr-2"></i>Cari
                            </button>
                            <a href="{{ route('seller.products.create') }}" class="btn-glow bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-6 py-3 rounded-xl hover:from-blue-600 hover:to-indigo-600 transition-all shadow-lg hover:shadow-xl font-semibold inline-flex items-center">
                                <i class="fas fa-plus mr-2"></i>Tambah Produk
                            </a>
                        </div>
                    </div>

                    <!-- Filter Section (Hidden by default) -->
                    <div id="filterSection" class="hidden border-t border-gray-200 pt-4 animate-slideDown">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Category Filter -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-tag mr-1 text-blue-500"></i>Kategori
                                </label>
                                <select name="category_id" 
                                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all bg-gray-50">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-toggle-on mr-1 text-green-500"></i>Status
                                </label>
                                <select name="status" 
                                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all bg-gray-50">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-end gap-2">
                                <button type="submit" 
                                        class="flex-1 bg-gradient-to-r from-cyan-500 to-green-500 text-white px-4 py-2.5 rounded-xl hover:from-cyan-600 hover:to-green-600 transition-all shadow-md hover:shadow-lg font-semibold">
                                    <i class="fas fa-check mr-2"></i>Terapkan
                                </button>
                                <a href="{{ route('seller.products') }}" 
                                   class="flex-1 bg-gradient-to-r from-red-500 to-pink-500 text-white px-4 py-2.5 rounded-xl hover:from-red-600 hover:to-pink-600 transition-all shadow-md hover:shadow-lg font-semibold text-center">
                                    <i class="fas fa-redo mr-2"></i>Reset
                                </a>
                            </div>
                        </div>

                        <!-- Active Filters Display -->
                        @if(request('search') || request('category_id') || request('status'))
                        <div class="mt-4 flex flex-wrap gap-2 items-center">
                            <span class="text-sm font-semibold text-gray-600">Filter Aktif:</span>
                            
                            @if(request('search'))
                            <span class="inline-flex items-center bg-gradient-to-r from-cyan-50 to-green-50 text-cyan-700 px-3 py-1 rounded-lg text-sm font-semibold border border-cyan-200">
                                <i class="fas fa-search mr-1"></i>
                                Pencarian: "{{ request('search') }}"
                            </span>
                            @endif

                            @if(request('category_id'))
                            <span class="inline-flex items-center bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 px-3 py-1 rounded-lg text-sm font-semibold border border-blue-200">
                                <i class="fas fa-tag mr-1"></i>
                                Kategori: {{ $categories->find(request('category_id'))->name ?? '' }}
                            </span>
                            @endif

                            @if(request('status'))
                            <span class="inline-flex items-center bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 px-3 py-1 rounded-lg text-sm font-semibold border border-green-200">
                                <i class="fas fa-toggle-on mr-1"></i>
                                Status: {{ request('status') == 'active' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                            @endif
                        </div>
                        @endif
                    </div>
                </form>
            </div>

            @if($products->isEmpty())
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-xl p-16 text-center border border-gray-100">
                    <div class="mb-8">
                        <div class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto">
                            <i class="fas fa-box-open text-gray-400 text-4xl"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-700 to-gray-900 bg-clip-text text-transparent mb-3">Belum Ada Produk</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">Mulai tambahkan produk untuk dijual di toko Anda dan tingkatkan penjualan</p>
                    <a href="{{ route('seller.products.create') }}" class="btn-glow inline-flex items-center bg-gradient-to-r from-cyan-500 to-green-500 text-white px-8 py-4 rounded-xl hover:from-cyan-600 hover:to-green-600 transition-all shadow-lg hover:shadow-xl font-semibold">
                        <i class="fas fa-plus mr-2"></i>Tambah Produk Pertama
                    </a>
                </div>
            @else
                <!-- Products Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                    <div class="product-card bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 group">
                        <!-- Product Image -->
                        <div class="relative aspect-square overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            
                            <!-- Status Badge -->
                            <div class="absolute top-3 right-3">
                                @if($product->is_active)
                                <span class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-lg">
                                    <i class="fas fa-check-circle mr-1"></i>Aktif
                                </span>
                                @else
                                <span class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-lg">
                                    <i class="fas fa-times-circle mr-1"></i>Nonaktif
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-5">
                            <h3 class="text-base font-bold text-gray-900 mb-3 line-clamp-2 h-12 group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:from-cyan-600 group-hover:to-green-600 group-hover:bg-clip-text transition-all">
                                {{ $product->name }}
                            </h3>

                            <!-- Category Badge -->
                            <div class="mb-3">
                                <span class="inline-block text-xs bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 px-3 py-1.5 rounded-lg font-semibold">
                                    <i class="fas fa-tag mr-1"></i>{{ $product->category->name }}
                                </span>
                            </div>

                            <!-- Price -->
                            <div class="mb-3">
                                <div class="text-xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                </div>
                            </div>

                            <div class="flex items-center bg-gradient-to-r from-yellow-50 to-orange-50 px-3 py-1.5 rounded-lg mb-3 w-fit">
                                <i class="fas fa-star text-yellow-500 mr-1"></i>
                                <span class="text-sm font-bold text-gray-800">{{ number_format($product->average_rating, 1) }}</span>
                            </div>

                            <!-- Stock -->
                            <div class="mb-4 pb-4 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600 font-medium"><i class="fas fa-box mr-1"></i>Stok</span>
                                    <span class="text-sm font-bold px-3 py-1 rounded-lg {{ $product->stock > 10 ? 'bg-gradient-to-r from-green-50 to-emerald-50 text-green-700' : 'bg-gradient-to-r from-red-50 to-pink-50 text-red-700' }}">
                                        {{ $product->stock }} unit
                                    </span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                <a href="{{ route('seller.products.edit', $product->id) }}" class="btn-glow flex-1 bg-gradient-to-r from-blue-500 to-indigo-500 text-white py-2.5 rounded-xl hover:from-blue-600 hover:to-indigo-600 transition-all shadow-md hover:shadow-lg text-sm font-bold text-center">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                                <button type="button" 
                                        onclick="confirmDelete('{{ $product->id }}', '{{ addslashes($product->name) }}')"
                                        class="btn-glow flex-1 bg-gradient-to-r from-red-500 to-pink-500 text-white py-2.5 rounded-xl hover:from-red-600 hover:to-pink-600 transition-all shadow-md hover:shadow-lg text-sm font-bold">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        </main>
    </div>

    <!-- Overlay untuk mobile -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
         x-cloak></div>

    <!-- Custom Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full transform transition-all" id="deleteModalContent">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-red-500 to-pink-500 rounded-t-3xl p-6 text-center">
                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                    <i class="fas fa-exclamation-triangle text-white text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white">Konfirmasi Hapus</h3>
            </div>
            
            <!-- Modal Body -->
            <div class="p-8">
                <p class="text-gray-700 text-center mb-2 text-lg">
                    Apakah Anda yakin ingin menghapus produk:
                </p>
                <p class="text-center font-bold text-xl bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent mb-6" id="productName">
                    <!-- Product name will be inserted here -->
                </p>
                <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 rounded-lg p-4 mb-6">
                    <p class="text-sm text-red-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Perhatian:</strong> Data produk yang dihapus tidak dapat dikembalikan!
                    </p>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex gap-3 px-8 pb-8">
                <button onclick="closeDeleteModal()" 
                        class="flex-1 bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700 py-3.5 rounded-xl hover:from-gray-300 hover:to-gray-400 transition-all shadow-md hover:shadow-lg font-bold">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button onclick="submitDelete()" 
                        class="flex-1 bg-gradient-to-r from-red-500 to-pink-500 text-white py-3.5 rounded-xl hover:from-red-600 hover:to-pink-600 transition-all shadow-lg hover:shadow-xl font-bold">
                    <i class="fas fa-trash mr-2"></i>Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Forms for Delete -->
    @foreach($products as $product)
    <form id="deleteForm{{ $product->id }}" action="{{ route('seller.products.delete', $product->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
    @endforeach

    <style>
        [x-cloak] { display: none !important; }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <script>
        let currentDeleteId = null;

        function confirmDelete(productId, productName) {
            currentDeleteId = productId;
            document.getElementById('productName').textContent = productName;
            
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('deleteModalContent');
            
            // Show modal with animation
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.style.transform = 'scale(1)';
                modalContent.style.opacity = '1';
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('deleteModalContent');
            
            // Hide modal with animation
            modalContent.style.transform = 'scale(0.9)';
            modalContent.style.opacity = '0';
            setTimeout(() => {
                modal.classList.add('hidden');
                currentDeleteId = null;
            }, 200);
        }

        function submitDelete() {
            if (currentDeleteId) {
                document.getElementById('deleteForm' + currentDeleteId).submit();
            }
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        // Set initial modal style
        document.addEventListener('DOMContentLoaded', function() {
            const modalContent = document.getElementById('deleteModalContent');
            modalContent.style.transform = 'scale(0.9)';
            modalContent.style.opacity = '0';
            modalContent.style.transition = 'all 0.2s ease-out';
        });

        // Toggle filter section
        function toggleFilter() {
            const filterSection = document.getElementById('filterSection');
            const isHidden = filterSection.classList.contains('hidden');
            
            if (isHidden) {
                filterSection.classList.remove('hidden');
                setTimeout(() => {
                    filterSection.style.opacity = '1';
                    filterSection.style.maxHeight = '500px';
                }, 10);
            } else {
                filterSection.style.opacity = '0';
                filterSection.style.maxHeight = '0';
                setTimeout(() => {
                    filterSection.classList.add('hidden');
                }, 300);
            }
        }

        // Auto-show filter if any filter is active
        document.addEventListener('DOMContentLoaded', function() {
            const hasActiveFilter = {{ (request('category_id') || request('status')) ? 'true' : 'false' }};
            if (hasActiveFilter) {
                const filterSection = document.getElementById('filterSection');
                filterSection.classList.remove('hidden');
                filterSection.style.opacity = '1';
                filterSection.style.maxHeight = '500px';
            }
        });
    </script>
</body>
</html>
