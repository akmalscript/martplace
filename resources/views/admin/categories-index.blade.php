<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - Admin MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .category-card {
            transition: all 0.3s ease;
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .icon-float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
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
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: false, showDeleteModal: false, deleteCategoryId: null, deleteCategoryName: '' }">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-cyan-400 to-green-300 shadow-lg fixed top-0 left-0 right-0 z-50">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-white lg:hidden">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-box mr-2"></i>MartPlace Admin
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
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    <i class="fas fa-chart-line mr-3 w-5"></i>Dashboard
                </a>
                <a href="{{ route('admin.sellers.index') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    <i class="fas fa-store mr-3 w-5"></i>Kelola Seller
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center px-4 py-3 text-green-600 bg-green-50 rounded-lg font-semibold">
                    <i class="fas fa-tags mr-3 w-5"></i>Kelola Kategori
                </a>
                <a href="{{ route('admin.reports.index') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
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
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-2xl flex items-center justify-center shadow-xl">
                        <i class="fas fa-tags text-white text-2xl icon-float"></i>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">
                            Kelola Kategori
                        </h1>
                        <p class="text-gray-600 mt-1">Kelola kategori produk di platform marketplace</p>
                    </div>
                </div>
                <a href="{{ route('admin.categories.create') }}"
                    class="btn-glow bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-semibold py-3 px-8 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center">
                    <i class="fas fa-plus mr-2"></i>Tambah Kategori
                </a>
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

            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-times-circle mr-3 text-xl"></i>
                    <p class="font-semibold">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-tags text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 text-sm">Total Kategori</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalCategories) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 text-sm">Kategori Aktif</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($activeCategories) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600">
                            <i class="fas fa-ban text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 text-sm">Kategori Nonaktif</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($inactiveCategories) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <form action="{{ route('admin.categories.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Cari Kategori</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama atau deskripsi kategori..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                            <select name="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="submit"
                            class="bg-gradient-to-r from-cyan-400 to-green-300 hover:from-cyan-500 hover:to-green-400 text-white font-semibold py-2 px-6 rounded-lg transition">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                        <a href="{{ route('admin.categories.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-6 rounded-lg transition">
                            <i class="fas fa-undo mr-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Categories Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-cyan-400 to-green-300">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    Urutan
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    Kategori
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    Slug
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    Deskripsi
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    Jumlah Produk
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $category->order }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center">
                                                <i class="fas {{ $category->icon ?? 'fa-tag' }} text-green-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $category->name }}</div>
                                            <div class="text-xs text-gray-500">ID: {{ $category->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded">
                                        {{ $category->slug }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate">{{ $category->description ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                        {{ $category->products()->count() }} produk
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($category->is_active)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Aktif
                                    </span>
                                    @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-ban mr-1"></i> Nonaktif
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                            class="text-blue-600 hover:text-blue-900" 
                                            title="Edit Kategori">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                            @click="showDeleteModal = true; deleteCategoryId = {{ $category->id }}; deleteCategoryName = '{{ addslashes($category->name) }}'"
                                            class="text-red-600 hover:text-red-900" 
                                            title="Hapus Kategori">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="text-gray-400">
                                        <i class="fas fa-inbox text-6xl mb-4"></i>
                                        <p class="text-lg">Tidak ada kategori ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $categories->links() }}
            </div>
        </div>
    </main>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto" 
        style="display: none;">
        <div class="fixed inset-0 bg-black bg-opacity-50" @click="showDeleteModal = false"></div>
        
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>Konfirmasi Hapus
                </h3>
                
                <p class="text-gray-600 mb-6">
                    Apakah Anda yakin ingin menghapus kategori <strong x-text="deleteCategoryName"></strong>? Tindakan ini tidak dapat dibatalkan.
                </p>
                
                <div class="flex space-x-3">
                    <button type="button" 
                        @click="showDeleteModal = false"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg">
                        Batal
                    </button>
                    <form :action="'/admin/categories/' + deleteCategoryId" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>
