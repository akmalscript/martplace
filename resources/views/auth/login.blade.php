<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 right-0 w-1/2 h-64 bg-gradient-to-br from-green-300 to-green-400 opacity-20 rounded-bl-full transform translate-x-32 -translate-y-16"></div>
        <div class="absolute bottom-0 left-0 w-1/2 h-64 bg-gradient-to-tr from-green-300 to-green-400 opacity-20 rounded-tr-full transform -translate-x-32 translate-y-16"></div>

        <div class="w-full max-w-6xl mx-auto relative z-10">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    <!-- Left Side - Illustration -->
                    <div class="lg:w-1/2 p-12 flex items-center justify-center bg-gradient-to-br from-white to-gray-50">
                        <div class="text-center">
                            <!-- Logo -->
                            <div class="mb-8">
                                <a href="{{ url('/') }}" class="text-4xl font-bold text-green-600">MartPlace</a>
                            </div>

                            <!-- Illustration SVG -->
                            <div class="relative">
                                <svg viewBox="0 0 400 300" class="w-full max-w-md mx-auto" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Desk -->
                                    <rect x="80" y="180" width="240" height="8" fill="#10b981" rx="4"/>
                                    <rect x="80" y="188" width="240" height="80" fill="#34d399" rx="4"/>
                                    
                                    <!-- Laptop -->
                                    <rect x="120" y="140" width="80" height="50" fill="#e5e7eb" rx="2"/>
                                    <rect x="125" y="145" width="70" height="40" fill="#60a5fa" rx="1"/>
                                    <line x1="160" y1="190" x2="160" y2="180" stroke="#9ca3af" stroke-width="2"/>
                                    
                                    <!-- Plant Pot -->
                                    <ellipse cx="280" cy="268" rx="20" ry="8" fill="#fbbf24"/>
                                    <path d="M 260 268 Q 260 250 280 230 Q 300 250 300 268 Z" fill="#10b981"/>
                                    <ellipse cx="280" cy="240" rx="8" ry="6" fill="#059669"/>
                                    
                                    <!-- Person 1 -->
                                    <circle cx="90" cy="140" r="20" fill="#fbbf24"/>
                                    <path d="M 70 160 L 70 210 L 85 210 L 85 185 L 95 185 L 95 210 L 110 210 L 110 160 Z" fill="#fbbf24"/>
                                    <rect x="55" y="190" width="25" height="30" fill="#ef4444" rx="2"/>
                                    
                                    <!-- Person 2 -->
                                    <circle cx="240" cy="140" r="20" fill="#fbbf24"/>
                                    <path d="M 220 160 L 220 210 L 235 210 L 235 185 L 245 185 L 245 210 L 260 210 L 260 160 Z" fill="#8b5cf6"/>
                                    
                                    <!-- Shopping Bag -->
                                    <rect x="50" y="205" width="30" height="35" fill="#ef4444" rx="2"/>
                                    <path d="M 55 210 Q 65 200 75 210" fill="none" stroke="#dc2626" stroke-width="2"/>
                                    
                                    <!-- Decorative Dots -->
                                    <circle cx="320" cy="120" r="4" fill="#10b981" opacity="0.4"/>
                                    <circle cx="340" cy="140" r="3" fill="#10b981" opacity="0.4"/>
                                    <circle cx="60" cy="100" r="4" fill="#10b981" opacity="0.4"/>
                                    <circle cx="80" cy="120" r="3" fill="#10b981" opacity="0.4"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Login Form -->
                    <div class="lg:w-1/2 p-12 flex items-center">
                        <div class="w-full max-w-md mx-auto">
                            <header class="mb-10">
                                <h1 class="text-4xl font-bold text-gray-900 mb-3">Selamat Datang!</h1>
                                <p class="text-gray-600 text-base">Silakan masuk dengan email dan password Anda</p>
                            </header>

                            <form class="space-y-5" action="{{ route('login') }}" method="POST">
                                @csrf

                                <div class="space-y-5">
                                    <!-- Email Input -->
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                            </svg>
                                        </div>
                                        <input id="email" name="email" type="email" autocomplete="email" required
                                            value="{{ old('email') }}"
                                            class="w-full pl-14 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-xl text-base focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 transition"
                                            placeholder="Email Address">
                                        @error('email')
                                            <div class="absolute right-4 top-4">
                                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Password Input -->
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                        </div>
                                        <input id="password" name="password" type="password" autocomplete="current-password" required
                                            class="w-full pl-14 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-xl text-base focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 transition"
                                            placeholder="Password">
                                        @error('password')
                                            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Remember & Forgot -->
                                <div class="flex items-center justify-between">
                                    <label for="remember_me" class="inline-flex items-center gap-2.5 text-gray-700 cursor-pointer">
                                        <input id="remember_me" name="remember" type="checkbox"
                                            class="h-5 w-5 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer">
                                        <span class="text-base">Remember Me</span>
                                    </label>

                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}"
                                            class="text-green-600 hover:text-green-700 font-medium text-base">
                                            Forgot Password?
                                        </a>
                                    @endif
                                </div>

                                <!-- Login Button -->
                                <button type="submit"
                                    class="w-full rounded-lg bg-green-600 px-4 py-3.5 text-base font-semibold text-white shadow-lg hover:bg-green-700 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-green-200 transition transform hover:scale-[1.02] active:scale-[0.98]">
                                    Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
