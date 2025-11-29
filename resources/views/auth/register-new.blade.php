<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - MartPlace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream min-h-screen font-sans">
    {{-- Navbar Simple --}}
    <nav class="bg-white/80 backdrop-blur-md border-b border-olive/20 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-sage to-forest rounded-xl flex items-center justify-center">
                        <span class="text-cream font-bold text-xl">M</span>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-sage to-forest bg-clip-text text-transparent">
                        MartPlace
                    </span>
                </a>
                <div class="flex items-center gap-4">
                    <a href="{{ route('products.index') }}" class="text-forest/70 hover:text-sage transition font-medium">
                        Katalog
                    </a>
                    <a href="{{ route('login') }}" 
                       class="bg-gradient-to-r from-sage to-forest text-cream px-5 py-2.5 rounded-xl font-medium hover:shadow-lg transition-all duration-300">
                        Masuk
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <div class="flex min-h-[calc(100vh-64px)]">
        {{-- Left Side - Illustration --}}
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-olive via-sage/30 to-cream items-center justify-center p-12 relative overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute top-20 left-20 w-64 h-64 bg-sage/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 right-20 w-80 h-80 bg-olive/30 rounded-full blur-3xl"></div>
            </div>
            <div class="relative z-10 max-w-lg text-center">
                <div class="w-32 h-32 bg-white rounded-3xl shadow-2xl flex items-center justify-center mx-auto mb-8">
                    <svg class="w-16 h-16 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-forest mb-4">Mulai Bisnis Anda!</h2>
                <p class="text-forest/70 leading-relaxed">
                    Bergabunglah dengan ribuan penjual sukses di MartPlace. Jual produk Anda ke seluruh Indonesia dengan mudah.
                </p>
                
                {{-- Registration Flow Steps --}}
                <div class="mt-12 text-left">
                    <h4 class="text-sm font-semibold text-forest/80 mb-4 text-center">Alur Pendaftaran Penjual</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 bg-white/60 backdrop-blur rounded-xl p-4">
                            <div class="w-10 h-10 bg-sage text-cream rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0">1</div>
                            <div>
                                <p class="font-semibold text-forest text-sm">Daftar Toko</p>
                                <p class="text-xs text-forest/60">Lengkapi data toko dan PIC</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 bg-white/60 backdrop-blur rounded-xl p-4">
                            <div class="w-10 h-10 bg-olive text-forest rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0">2</div>
                            <div>
                                <p class="font-semibold text-forest text-sm">Verifikasi Admin</p>
                                <p class="text-xs text-forest/60">Tim kami memverifikasi data Anda</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 bg-white/60 backdrop-blur rounded-xl p-4">
                            <div class="w-10 h-10 bg-olive text-forest rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0">3</div>
                            <div>
                                <p class="font-semibold text-forest text-sm">Aktivasi & Upload</p>
                                <p class="text-xs text-forest/60">Login dan mulai upload produk</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side - Registration Options --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-forest mb-2">Bergabung dengan MartPlace</h1>
                    <p class="text-forest/60">Pilih cara Anda untuk bergabung</p>
                </div>

                {{-- Option Cards --}}
                <div class="space-y-6">
                    {{-- Option 1: Seller Registration --}}
                    <div class="bg-white rounded-2xl p-6 border-2 border-sage shadow-lg relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                        <div class="absolute top-0 right-0 bg-sage text-cream text-xs font-bold px-3 py-1 rounded-bl-xl">
                            REKOMENDASI
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 bg-sage/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-forest mb-1">Daftar Sebagai Penjual</h3>
                                <p class="text-sm text-forest/60 mb-4">
                                    Buka toko online dan jual produk ke seluruh Indonesia
                                </p>
                                <ul class="space-y-2 mb-4">
                                    <li class="flex items-center gap-2 text-sm text-forest/70">
                                        <svg class="w-4 h-4 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Upload produk tanpa batas
                                    </li>
                                    <li class="flex items-center gap-2 text-sm text-forest/70">
                                        <svg class="w-4 h-4 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Dashboard & laporan bisnis
                                    </li>
                                    <li class="flex items-center gap-2 text-sm text-forest/70">
                                        <svg class="w-4 h-4 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Verifikasi oleh tim MartPlace
                                    </li>
                                </ul>
                                <a href="{{ route('sellers.create') }}" 
                                   class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-sage to-forest text-cream py-3 rounded-xl font-semibold hover:shadow-lg hover:shadow-sage/30 transform hover:-translate-y-0.5 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Daftar Toko Sekarang
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-olive/20"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-cream text-forest/50">atau</span>
                        </div>
                    </div>

                    {{-- Option 2: Browse as Visitor --}}
                    <div class="bg-white rounded-2xl p-6 border border-olive/20 shadow-md hover:shadow-lg transition-all duration-300">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 bg-olive/20 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-7 h-7 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-forest mb-1">Lihat Sebagai Pengunjung</h3>
                                <p class="text-sm text-forest/60 mb-4">
                                    Jelajahi katalog produk tanpa perlu membuat akun
                                </p>
                                <ul class="space-y-2 mb-4">
                                    <li class="flex items-center gap-2 text-sm text-forest/70">
                                        <svg class="w-4 h-4 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Lihat semua produk & toko
                                    </li>
                                    <li class="flex items-center gap-2 text-sm text-forest/70">
                                        <svg class="w-4 h-4 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Beri rating & komentar
                                    </li>
                                    <li class="flex items-center gap-2 text-sm text-forest/70">
                                        <svg class="w-4 h-4 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Tanpa perlu daftar akun
                                    </li>
                                </ul>
                                <a href="{{ route('products.index') }}" 
                                   class="w-full flex items-center justify-center gap-2 bg-white text-forest py-3 rounded-xl font-semibold border-2 border-olive/30 hover:border-sage hover:bg-cream transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Jelajahi Katalog
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Already have account --}}
                <div class="text-center mt-8">
                    <p class="text-forest/60">
                        Sudah punya akun penjual?
                        <a href="{{ route('login') }}" class="text-sage hover:text-forest font-semibold transition">
                            Masuk di sini
                        </a>
                    </p>
                </div>

                {{-- Info Note --}}
                <div class="mt-6 bg-olive/10 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-sage flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-forest/70">
                            <span class="font-semibold text-forest">Info:</span> Pengunjung dapat melihat katalog produk dan memberikan rating/komentar tanpa perlu membuat akun.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
