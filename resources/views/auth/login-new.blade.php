<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - MartPlace</title>
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
                    <a href="{{ route('sellers.create') }}" 
                       class="bg-gradient-to-r from-sage to-forest text-cream px-5 py-2.5 rounded-xl font-medium hover:shadow-lg transition-all duration-300">
                        Daftar Toko
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-forest mb-4">Selamat Datang Kembali!</h2>
                <p class="text-forest/70 leading-relaxed">
                    Masuk ke akun Anda untuk mengelola toko, melihat laporan, dan mengembangkan bisnis bersama MartPlace.
                </p>
                
                <div class="mt-12 grid grid-cols-3 gap-4">
                    <div class="bg-white/60 backdrop-blur rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-forest">500+</p>
                        <p class="text-sm text-forest/60">Penjual Aktif</p>
                    </div>
                    <div class="bg-white/60 backdrop-blur rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-forest">1000+</p>
                        <p class="text-sm text-forest/60">Produk</p>
                    </div>
                    <div class="bg-white/60 backdrop-blur rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-forest">34</p>
                        <p class="text-sm text-forest/60">Provinsi</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side - Login Form --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-forest mb-2">Masuk ke Akun</h1>
                    <p class="text-forest/60">Silakan masuk untuk melanjutkan</p>
                </div>

                {{-- Error Messages --}}
                @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-center gap-2 text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">Terjadi kesalahan:</span>
                    </div>
                    <ul class="mt-2 text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (session('status'))
                <div class="mb-6 bg-sage/20 border border-sage/30 rounded-xl p-4">
                    <p class="text-sage text-sm">{{ session('status') }}</p>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-forest mb-2">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-forest/40">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required 
                                   autofocus
                                   autocomplete="email"
                                   placeholder="email@example.com"
                                   class="w-full pl-12 pr-4 py-3.5 bg-white border-2 border-olive/30 rounded-xl text-forest placeholder:text-forest/40 focus:border-sage focus:ring-2 focus:ring-sage/20 transition-all duration-300">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div x-data="{ show: false }">
                        <label for="password" class="block text-sm font-semibold text-forest mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-forest/40">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input :type="show ? 'text' : 'password'" 
                                   id="password" 
                                   name="password" 
                                   required
                                   autocomplete="current-password"
                                   placeholder="Masukkan password"
                                   class="w-full pl-12 pr-12 py-3.5 bg-white border-2 border-olive/30 rounded-xl text-forest placeholder:text-forest/40 focus:border-sage focus:ring-2 focus:ring-sage/20 transition-all duration-300">
                            <button type="button" 
                                    @click="show = !show"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-forest/40 hover:text-forest transition">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" 
                                   name="remember" 
                                   class="w-4 h-4 rounded border-olive/30 text-sage focus:ring-sage/20">
                            <span class="text-sm text-forest/70">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-sage hover:text-forest font-medium transition">
                            Lupa password?
                        </a>
                        @endif
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-sage to-forest text-cream py-4 rounded-xl font-semibold hover:shadow-xl hover:shadow-sage/30 transform hover:-translate-y-0.5 transition-all duration-300">
                        Masuk
                    </button>
                </form>

                {{-- Divider --}}
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-olive/20"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-cream text-forest/50">Belum punya toko?</span>
                    </div>
                </div>

                {{-- Register Seller Link --}}
                <a href="{{ route('sellers.create') }}" 
                   class="w-full flex items-center justify-center gap-2 bg-white text-forest py-4 rounded-xl font-semibold border-2 border-olive/30 hover:border-sage hover:bg-cream transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Daftar Sebagai Penjual
                </a>

                {{-- Info --}}
                <p class="mt-6 text-center text-sm text-forest/50">
                    Pengunjung dapat melihat produk dan memberikan rating tanpa perlu login.
                    <a href="{{ route('products.index') }}" class="text-sage hover:underline">Lihat Katalog</a>
                </p>
            </div>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</body>
</html>
