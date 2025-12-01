<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - MartPlace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#F1F3E0',
                        olive: '#D2DCB6',
                        sage: '#A1BC98',
                        forest: '#778873',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', 'Poppins', sans-serif; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed { animation: float 6s ease-in-out infinite; animation-delay: 2s; }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="bg-cream text-forest antialiased">
    <div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-sage/20 rounded-full blur-3xl animate-float pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-olive/30 rounded-full blur-3xl animate-float-delayed pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/4 w-64 h-64 bg-sage/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="w-full max-w-5xl mx-auto relative z-10">
            <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl shadow-forest/10 overflow-hidden border border-olive/10">
                <div class="flex flex-col lg:flex-row">
                    <!-- Left Side - Branding -->
                    <div class="lg:w-1/2 p-8 lg:p-12 flex items-center justify-center bg-gradient-to-br from-sage/10 via-olive/5 to-cream relative overflow-hidden">
                        <div class="absolute top-10 right-10 w-20 h-20 border-2 border-sage/20 rounded-full pointer-events-none"></div>
                        <div class="absolute bottom-20 left-10 w-32 h-32 border-2 border-olive/20 rounded-full pointer-events-none"></div>
                        
                        <div class="text-center relative z-10">
                            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 mb-8 group">
                                <div class="w-14 h-14 bg-gradient-to-br from-sage to-forest rounded-2xl flex items-center justify-center transform group-hover:scale-105 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-sage/30">
                                    <span class="text-cream font-bold text-2xl">M</span>
                                </div>
                                <span class="text-3xl font-bold bg-gradient-to-r from-sage to-forest bg-clip-text text-transparent">MartPlace</span>
                            </a>

                            <div class="relative mb-8">
                                <svg viewBox="0 0 400 280" class="w-full max-w-sm mx-auto" xmlns="http://www.w3.org/2000/svg">
                                    <ellipse cx="200" cy="250" rx="150" ry="20" fill="#D2DCB6" opacity="0.5"/>
                                    <rect x="80" y="180" width="240" height="8" fill="#778873" rx="4"/>
                                    <rect x="90" y="188" width="220" height="60" fill="#A1BC98" rx="4"/>
                                    <rect x="130" y="145" width="90" height="45" fill="#F1F3E0" rx="4" stroke="#778873" stroke-width="2"/>
                                    <rect x="135" y="150" width="80" height="35" fill="#778873" rx="2"/>
                                    <rect x="140" y="155" width="70" height="25" fill="#A1BC98" rx="1"/>
                                    <rect x="120" y="190" width="110" height="6" fill="#D2DCB6" rx="3"/>
                                    <rect x="270" y="150" width="30" height="35" fill="#D2DCB6" rx="4"/>
                                    <ellipse cx="285" cy="145" rx="18" ry="20" fill="#A1BC98"/>
                                    <ellipse cx="280" cy="140" rx="10" ry="12" fill="#778873"/>
                                    <circle cx="200" cy="100" r="25" fill="#D2DCB6"/>
                                    <circle cx="200" cy="95" r="20" fill="#F1F3E0" stroke="#778873" stroke-width="2"/>
                                    <circle cx="193" cy="92" r="2" fill="#778873"/>
                                    <circle cx="207" cy="92" r="2" fill="#778873"/>
                                    <path d="M195 100 Q200 105 205 100" fill="none" stroke="#778873" stroke-width="2" stroke-linecap="round"/>
                                    <rect x="180" y="120" width="40" height="50" fill="#A1BC98" rx="4"/>
                                    <circle cx="320" cy="80" r="6" fill="#A1BC98" opacity="0.6"/>
                                    <circle cx="80" cy="100" r="4" fill="#D2DCB6" opacity="0.8"/>
                                </svg>
                            </div>
                            
                            <h2 class="text-xl font-semibold text-forest mb-2">Selamat Berbelanja!</h2>
                            <p class="text-forest/60 text-sm max-w-xs mx-auto">Temukan ribuan produk berkualitas dari penjual terpercaya</p>
                        </div>
                    </div>

                    <!-- Right Side - Login Form -->
                    <div class="lg:w-1/2 p-8 lg:p-12 flex items-center bg-white">
                        <div class="w-full max-w-md mx-auto">
                            <header class="mb-8">
                                <h1 class="text-3xl font-bold text-forest mb-2">Selamat Datang!</h1>
                                <p class="text-forest/60">Silakan masuk dengan akun Anda</p>
                            </header>

                            <form class="space-y-5" action="{{ route('login') }}" method="POST">
                                @csrf

                                <!-- Email Input -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-forest mb-2">Email</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-forest/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                            </svg>
                                        </div>
                                        <input id="email" name="email" type="email" autocomplete="email" required
                                            value="{{ old('email') }}"
                                            class="w-full pl-12 pr-4 py-3.5 bg-cream/50 border border-olive/30 rounded-xl text-forest placeholder-forest/40 focus:border-sage focus:bg-white focus:ring-2 focus:ring-sage/20 focus:outline-none transition-all duration-300 @error('email') border-red-300 bg-red-50/50 @enderror"
                                            placeholder="nama@email.com">
                                    </div>
                                    @error('email')
                                        <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>

                                <!-- Password Input -->
                                <div>
                                    <label for="password" class="block text-sm font-medium text-forest mb-2">Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-forest/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                        </div>
                                        <input id="password" name="password" type="password" autocomplete="current-password" required
                                            class="w-full pl-12 pr-4 py-3.5 bg-cream/50 border border-olive/30 rounded-xl text-forest placeholder-forest/40 focus:border-sage focus:bg-white focus:ring-2 focus:ring-sage/20 focus:outline-none transition-all duration-300"
                                            placeholder="Masukkan password">
                                    </div>
                                    @error('password')
                                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Remember & Forgot -->
                                <div class="flex items-center justify-between">
                                    <label for="remember_me" class="inline-flex items-center gap-2.5 cursor-pointer group">
                                        <input id="remember_me" name="remember" type="checkbox"
                                            class="h-4 w-4 rounded border-olive/30 text-sage focus:ring-sage/30 cursor-pointer transition">
                                        <span class="text-sm text-forest/70 group-hover:text-forest transition">Ingat saya</span>
                                    </label>

                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}"
                                            class="text-sm text-sage hover:text-forest font-medium transition-colors">
                                            Lupa Password?
                                        </a>
                                    @endif
                                </div>

                                <!-- Login Button -->
                                <button type="submit"
                                    class="w-full py-3.5 px-6 bg-gradient-to-r from-sage to-forest text-cream font-semibold rounded-xl shadow-lg shadow-sage/30 hover:shadow-xl hover:shadow-sage/40 hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-sage/30 transition-all duration-300">
                                    Masuk
                                </button>
                            </form>

                            <!-- Divider -->
                            <div class="relative my-8">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-olive/20"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-4 bg-white text-forest/50">atau</span>
                                </div>
                            </div>

                            <!-- Register Link -->
                            <div class="text-center">
                                <p class="text-forest/60">
                                    Belum punya akun?
                                    <a href="{{ route('register') }}" class="text-sage hover:text-forest font-semibold transition-colors">
                                        Daftar sekarang
                                    </a>
                                </p>
                            </div>
                            
                            <!-- Back to Home -->
                            <div class="mt-6 text-center">
                                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm text-forest/50 hover:text-forest transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
