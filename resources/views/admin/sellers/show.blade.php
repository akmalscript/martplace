<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.sellers') }}" class="text-forest/60 hover:text-forest transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-forest leading-tight">
                    Detail Penjual: {{ $seller->store_name }}
                </h2>
            </div>
            
            @if($seller->status->value === 'PENDING')
                <div class="flex gap-3">
                    <form action="{{ route('admin.sellers.approve', $seller->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-sage text-white rounded-lg hover:bg-forest transition font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Setujui Seller
                        </button>
                    </form>
                    <form action="{{ route('admin.sellers.reject', $seller->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Tolak Seller
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-8 bg-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Main Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Store Information -->
                    <div class="bg-white rounded-xl shadow-soft p-6">
                        <h3 class="text-lg font-semibold text-forest mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Informasi Toko
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-forest/60 uppercase tracking-wide">Nama Toko</label>
                                <p class="text-forest font-medium">{{ $seller->store_name }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-forest/60 uppercase tracking-wide">Status</label>
                                <p>
                                    @if($seller->status->value === 'ACTIVE')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-sage/20 text-forest">Aktif</span>
                                    @elseif($seller->status->value === 'PENDING')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Menunggu Verifikasi</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">Ditolak</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-span-2">
                                <label class="text-xs text-forest/60 uppercase tracking-wide">Deskripsi</label>
                                <p class="text-forest">{{ $seller->store_description ?: '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- PIC Information -->
                    <div class="bg-white rounded-xl shadow-soft p-6">
                        <h3 class="text-lg font-semibold text-forest mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Data PIC (Person In Charge)
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-forest/60 uppercase tracking-wide">Nama Lengkap</label>
                                <p class="text-forest font-medium">{{ $seller->pic_name }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-forest/60 uppercase tracking-wide">Email</label>
                                <p class="text-forest">{{ $seller->pic_email }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-forest/60 uppercase tracking-wide">No. Telepon</label>
                                <p class="text-forest">{{ $seller->pic_phone }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-forest/60 uppercase tracking-wide">No. KTP</label>
                                <p class="text-forest font-mono">{{ $seller->pic_ktp_number }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="bg-white rounded-xl shadow-soft p-6">
                        <h3 class="text-lg font-semibold text-forest mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Alamat PIC
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="text-xs text-forest/60 uppercase tracking-wide">Alamat Jalan</label>
                                <p class="text-forest">{{ $seller->pic_street }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-forest/60 uppercase tracking-wide">RT/RW</label>
                                <p class="text-forest">{{ $seller->pic_rt }}/{{ $seller->pic_rw }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-forest/60 uppercase tracking-wide">Kelurahan</label>
                                <p class="text-forest">{{ $seller->pic_village }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-forest/60 uppercase tracking-wide">Kecamatan</label>
                                <p class="text-forest">{{ $seller->pic_district }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-forest/60 uppercase tracking-wide">Kota/Kabupaten</label>
                                <p class="text-forest">{{ $seller->pic_city }}</p>
                            </div>
                            <div class="col-span-2">
                                <label class="text-xs text-forest/60 uppercase tracking-wide">Provinsi</label>
                                <p class="text-forest font-medium">{{ $seller->pic_province }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Photo & KTP -->
                    <div class="bg-white rounded-xl shadow-soft p-6">
                        <h3 class="text-lg font-semibold text-forest mb-4">Dokumen</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs text-forest/60 uppercase tracking-wide mb-2 block">Foto PIC</label>
                                @if($seller->pic_photo_path)
                                    <img src="{{ asset('storage/' . $seller->pic_photo_path) }}" 
                                         alt="Foto PIC" 
                                         class="w-full h-48 object-cover rounded-lg border border-olive/30">
                                @else
                                    <div class="w-full h-48 bg-olive/20 rounded-lg flex items-center justify-center">
                                        <span class="text-forest/40 text-sm">Tidak ada foto</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div>
                                <label class="text-xs text-forest/60 uppercase tracking-wide mb-2 block">Foto KTP</label>
                                @if($seller->pic_ktp_file_path)
                                    @if(str_contains($seller->pic_ktp_file_path, '.pdf'))
                                        <a href="{{ asset('storage/' . $seller->pic_ktp_file_path) }}" 
                                           target="_blank"
                                           class="flex items-center justify-center w-full h-48 bg-olive/20 rounded-lg border border-olive/30 hover:bg-olive/30 transition">
                                            <div class="text-center">
                                                <svg class="w-12 h-12 mx-auto text-forest/60" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                                </svg>
                                                <p class="mt-2 text-sm text-forest">Klik untuk melihat PDF</p>
                                            </div>
                                        </a>
                                    @else
                                        <img src="{{ asset('storage/' . $seller->pic_ktp_file_path) }}" 
                                             alt="Foto KTP" 
                                             class="w-full h-48 object-cover rounded-lg border border-olive/30">
                                    @endif
                                @else
                                    <div class="w-full h-48 bg-olive/20 rounded-lg flex items-center justify-center">
                                        <span class="text-forest/40 text-sm">Tidak ada file KTP</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="bg-white rounded-xl shadow-soft p-6">
                        <h3 class="text-lg font-semibold text-forest mb-4">Riwayat</h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-sage/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-sage" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-forest">Mendaftar</p>
                                    <p class="text-xs text-forest/60">{{ $seller->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            
                            @if($seller->verified_at)
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 bg-sage rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-forest">Disetujui</p>
                                        <p class="text-xs text-forest/60">{{ $seller->verified_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            @if($seller->rejected_at)
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-forest">Ditolak</p>
                                        <p class="text-xs text-forest/60">{{ $seller->rejected_at->format('d M Y, H:i') }}</p>
                                        @if($seller->rejection_reason)
                                            <p class="text-xs text-red-600 mt-1">Alasan: {{ $seller->rejection_reason }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
