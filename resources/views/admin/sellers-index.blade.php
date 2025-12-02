<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Seller - Admin MartPlace</title>
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
                        <i class="fas fa-store mr-2"></i>MartPlace Admin
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
                    class="flex items-center px-4 py-3 text-green-600 bg-green-50 rounded-lg font-semibold">
                    <i class="fas fa-store mr-3 w-5"></i>Kelola Seller
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    <i class="fas fa-tags mr-3 w-5"></i>Kelola Kategori
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
                    <i class="fas fa-users-cog mr-3 text-green-600"></i>Kelola Seller
                </h1>
                <p class="text-gray-600">Kelola status dan verifikasi seller</p>
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
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Menunggu Verifikasi</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $sellers->where('status', App\Enums\SellerStatus::PENDING)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Seller Aktif</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $sellers->where('status', App\Enums\SellerStatus::ACTIVE)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600">
                        <i class="fas fa-times-circle text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Ditolak</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $sellers->where('status', App\Enums\SellerStatus::REJECTED)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-cyan-400 to-green-300">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Nama Toko
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                PIC
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Tanggal Daftar
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
                        @forelse($sellers as $seller)
                        <tr class="hover:bg-gray-50 transition" x-data="{ 
                            showStatusChange: false, 
                            currentStatus: '{{ $seller->status->value }}',
                            newStatus: '{{ $seller->status->value }}',
                            showRejectReason: false,
                            rejectReason: ''
                        }">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-cyan-400 to-green-300 flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($seller->store_name, 0, 2)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $seller->store_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $seller->pic_province }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $seller->pic_name }}</div>
                                <div class="text-sm text-gray-500">{{ $seller->pic_phone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $seller->pic_email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $seller->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div x-show="!showStatusChange">
                                    @if($seller->status === App\Enums\SellerStatus::PENDING)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> Menunggu
                                    </span>
                                    @elseif($seller->status === App\Enums\SellerStatus::ACTIVE)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Aktif
                                    </span>
                                    @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Ditolak
                                    </span>
                                    @endif
                                </div>
                                
                                <!-- Status Change Dropdown -->
                                <div x-show="showStatusChange" x-cloak>
                                    <select x-model="newStatus" 
                                        class="text-sm border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-green-500">
                                        <option value="PENDING">Menunggu</option>
                                        <option value="ACTIVE">Aktif</option>
                                        <option value="REJECTED">Ditolak</option>
                                    </select>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div x-show="!showStatusChange" class="flex items-center space-x-2">
                                    <a href="{{ route('admin.sellers.show', $seller->id) }}" 
                                        class="text-blue-600 hover:text-blue-900" 
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button @click="showStatusChange = true" 
                                        class="text-green-600 hover:text-green-900" 
                                        title="Ubah Status">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                                
                                <!-- Action Buttons saat ubah status -->
                                <div x-show="showStatusChange" x-cloak class="flex items-center space-x-2">
                                    <button @click="
                                        if (newStatus === 'REJECTED') {
                                            showRejectReason = true;
                                        } else if (newStatus === 'ACTIVE') {
                                            document.getElementById('approve-form-{{ $seller->id }}').submit();
                                        } else {
                                            showStatusChange = false;
                                        }
                                    " 
                                        class="text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-xs"
                                        title="Simpan">
                                        <i class="fas fa-check mr-1"></i>Simpan
                                    </button>
                                    <button @click="showStatusChange = false; newStatus = currentStatus" 
                                        class="text-white bg-gray-500 hover:bg-gray-600 px-3 py-1 rounded text-xs"
                                        title="Batal">
                                        <i class="fas fa-times mr-1"></i>Batal
                                    </button>
                                </div>

                                <!-- Hidden Forms -->
                                <form id="approve-form-{{ $seller->id }}" 
                                    action="{{ route('admin.sellers.approve', $seller->id) }}" 
                                    method="POST" class="hidden">
                                    @csrf
                                </form>

                                <!-- Reject Reason Modal -->
                                <div x-show="showRejectReason" 
                                    x-cloak
                                    class="fixed inset-0 z-50 overflow-y-auto" 
                                    style="display: none;">
                                    <div class="fixed inset-0 bg-black bg-opacity-50" @click="showRejectReason = false"></div>
                                    
                                    <div class="flex items-center justify-center min-h-screen p-4">
                                        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                                            <h3 class="text-lg font-bold text-gray-900 mb-4">
                                                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>Alasan Penolakan
                                            </h3>
                                            
                                            <form action="{{ route('admin.sellers.reject', $seller->id) }}" method="POST">
                                                @csrf
                                                <textarea name="reason" 
                                                    x-model="rejectReason"
                                                    rows="4" 
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                                                    placeholder="Jelaskan alasan penolakan..."
                                                    required></textarea>
                                                
                                                <div class="flex space-x-3 mt-4">
                                                    <button type="button" 
                                                        @click="showRejectReason = false; showStatusChange = false; newStatus = currentStatus"
                                                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg">
                                                        Batal
                                                    </button>
                                                    <button type="submit"
                                                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg">
                                                        Tolak Seller
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <i class="fas fa-inbox text-6xl mb-4"></i>
                                    <p class="text-lg">Belum ada data seller</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $sellers->links() }}
            </div>
        </div>
    </main>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>