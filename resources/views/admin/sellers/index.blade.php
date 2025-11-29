<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-forest leading-tight">
                Kelola Penjual
            </h2>
            <a href="{{ route('admin.reports.seller-status') }}" 
               class="inline-flex items-center px-4 py-2 bg-forest text-white rounded-lg hover:bg-sage transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download Laporan PDF
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filter Tabs -->
            <div class="bg-white rounded-xl shadow-soft mb-6 p-2 inline-flex">
                <a href="{{ route('admin.sellers', ['status' => 'all']) }}" 
                   class="px-6 py-2 rounded-lg text-sm font-medium transition {{ $status === 'all' ? 'bg-forest text-white' : 'text-forest hover:bg-olive/30' }}">
                    Semua
                </a>
                <a href="{{ route('admin.sellers', ['status' => 'pending']) }}" 
                   class="px-6 py-2 rounded-lg text-sm font-medium transition {{ $status === 'pending' ? 'bg-yellow-500 text-white' : 'text-forest hover:bg-olive/30' }}">
                    Menunggu Verifikasi
                </a>
                <a href="{{ route('admin.sellers', ['status' => 'active']) }}" 
                   class="px-6 py-2 rounded-lg text-sm font-medium transition {{ $status === 'active' ? 'bg-sage text-white' : 'text-forest hover:bg-olive/30' }}">
                    Aktif
                </a>
                <a href="{{ route('admin.sellers', ['status' => 'rejected']) }}" 
                   class="px-6 py-2 rounded-lg text-sm font-medium transition {{ $status === 'rejected' ? 'bg-red-500 text-white' : 'text-forest hover:bg-olive/30' }}">
                    Ditolak
                </a>
            </div>

            <!-- Sellers Table -->
            <div class="bg-white rounded-xl shadow-soft overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-olive/20">
                        <thead class="bg-olive/20">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-forest uppercase tracking-wider">Toko</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-forest uppercase tracking-wider">PIC</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-forest uppercase tracking-wider">Lokasi</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-forest uppercase tracking-wider">Tanggal Daftar</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-forest uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-forest uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-olive/10">
                            @forelse($sellers as $seller)
                                <tr class="hover:bg-cream/50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-sage/20 rounded-lg flex items-center justify-center">
                                                <span class="text-forest font-bold">{{ strtoupper(substr($seller->store_name, 0, 1)) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-forest">{{ $seller->store_name }}</div>
                                                <div class="text-xs text-forest/60">{{ $seller->pic_email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-forest">{{ $seller->pic_name }}</div>
                                        <div class="text-xs text-forest/60">{{ $seller->pic_phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-forest">{{ $seller->pic_city }}</div>
                                        <div class="text-xs text-forest/60">{{ $seller->pic_province }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-forest/60">
                                        {{ $seller->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($seller->status->value === 'ACTIVE')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-sage/20 text-forest">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Aktif
                                            </span>
                                        @elseif($seller->status->value === 'PENDING')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                                Menunggu
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.sellers.show', $seller->id) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-olive/30 text-forest rounded-lg hover:bg-olive/50 transition text-xs font-medium">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Detail
                                            </a>
                                            
                                            @if($seller->status->value === 'PENDING')
                                                <form action="{{ route('admin.sellers.approve', $seller->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-sage text-white rounded-lg hover:bg-forest transition text-xs font-medium">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                        Setujui
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.sellers.reject', $seller->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-xs font-medium">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                        Tolak
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <h3 class="mt-4 text-lg font-medium text-forest">Tidak ada penjual</h3>
                                        <p class="mt-1 text-forest/60">Belum ada penjual dengan status ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($sellers->hasPages())
                    <div class="px-6 py-4 border-t border-olive/20">
                        {{ $sellers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
