<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Berhasil - MartPlace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream min-h-screen font-sans">
    {{-- Navbar --}}
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
            </div>
        </div>
    </nav>

    {{-- Success Message --}}
    <div class="flex items-center justify-center min-h-[calc(100vh-200px)] py-12">
        <div class="max-w-lg mx-auto px-4">
            <div class="bg-white rounded-3xl shadow-xl border border-olive/20 p-10 text-center relative overflow-hidden">
                {{-- Decorative --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-sage/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-olive/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                
                {{-- Success Icon --}}
                <div class="relative mx-auto w-24 h-24 bg-sage/20 rounded-3xl flex items-center justify-center mb-8">
                    <div class="w-16 h-16 bg-sage rounded-2xl flex items-center justify-center animate-bounce-soft">
                        <svg class="w-10 h-10 text-cream" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>

                <h1 class="text-3xl font-bold text-forest mb-4">Registrasi Berhasil!</h1>
                
                <p class="text-forest/70 mb-8 leading-relaxed">
                    Terima kasih telah mendaftar sebagai penjual di MartPlace. 
                    Pendaftaran Anda sedang dalam proses verifikasi oleh tim kami.
                </p>

                {{-- Info Box --}}
                <div class="bg-olive/10 rounded-2xl p-6 mb-8 text-left">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-sage/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-forest mb-1">Langkah Selanjutnya</h3>
                            <ul class="text-sm text-forest/70 space-y-2">
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-sage rounded-full"></span>
                                    Tim kami akan memverifikasi data Anda (1-3 hari kerja)
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-sage rounded-full"></span>
                                    Notifikasi akan dikirim via email yang terdaftar
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-sage rounded-full"></span>
                                    Setelah disetujui, Anda dapat login dan upload produk
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('home') }}" 
                       class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-sage to-forest text-cream px-6 py-4 rounded-xl font-semibold hover:shadow-lg transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Ke Beranda
                    </a>
                    <a href="{{ route('products.index') }}" 
                       class="flex-1 inline-flex items-center justify-center gap-2 bg-white text-forest px-6 py-4 rounded-xl font-semibold border-2 border-olive/30 hover:border-sage transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Lihat Katalog
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-forest text-cream py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-olive">&copy; {{ date('Y') }} MartPlace. All rights reserved.</p>
        </div>
    </footer>

    <style>
        @keyframes bounce-soft {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .animate-bounce-soft {
            animation: bounce-soft 2s ease-in-out infinite;
        }
    </style>
</body>
</html>
