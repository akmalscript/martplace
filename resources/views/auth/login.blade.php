<x-app-layout :show-navigation="false" background-class="bg-[#f5f7fb]">
    <header class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col gap-4 lg:flex-row lg:items-center">
            <div class="flex items-center justify-between lg:justify-start w-full gap-6">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-emerald-600">MartPlace</a>

                <div class="flex items-center gap-3 lg:hidden">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600">Masuk</a>
                    <a href="{{ url('/sellers/register') }}"
                        class="inline-flex items-center gap-2 rounded-full bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-700">
                        Daftar Toko
                    </a>
                </div>
            </div>

            <div class="flex-1">
                <label for="auth_search" class="sr-only">Cari di MartPlace</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-4 flex items-center">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="m21 21-4.35-4.35M18 10.5a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                        </svg>
                    </span>
                    <input id="auth_search" type="text" placeholder="Cari di MartPlace"
                        class="w-full rounded-full border border-slate-200 bg-slate-50 py-3 pl-12 pr-4 text-sm text-slate-600 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                </div>
            </div>

            <div class="hidden lg:flex items-center gap-6">
                <div class="flex items-center gap-3">
                    <button type="button" class="text-slate-400 hover:text-emerald-600">
                        <span class="sr-only">Keranjang</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M2.25 3h1.386a1.5 1.5 0 0 1 1.473 1.248L5.97 7.5h12.78a.75.75 0 0 1 .736.902l-1.2 6a.75.75 0 0 1-.736.598H7.678a1.5 1.5 0 0 1-1.472-1.248L4.5 4.5M7.5 21a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm10.5 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                        </svg>
                    </button>
                    <button type="button" class="text-slate-400 hover:text-emerald-600">
                        <span class="sr-only">Notifikasi</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M14.857 17.081a4.505 4.505 0 0 1-5.714 0m9.357-5.581v-1.2a6 6 0 1 0-12 0v1.2a2.25 2.25 0 0 1-.659 1.591l-1.305 1.305a.75.75 0 0 0 .53 1.28h16.68a.75.75 0 0 0 .53-1.28l-1.305-1.305a2.25 2.25 0 0 1-.659-1.591Z" />
                        </svg>
                    </button>
                    <button type="button" class="text-slate-400 hover:text-emerald-600">
                        <span class="sr-only">Pesan</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 0 1-2.983-.457L3 20l1.047-3.14C3.383 15.65 3 13.869 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8Z" />
                        </svg>
                    </button>
                </div>

                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600">
                    Masuk
                </a>

                <a href="{{ url('/sellers/register') }}"
                    class="inline-flex items-center gap-2 rounded-full bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow hover:bg-emerald-700">
                    Daftar Toko
                </a>
            </div>
        </div>
    </header>

    <section class="py-16 sm:py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl border border-slate-100">
                <div class="px-8 sm:px-12 py-12">
                    <header class="text-center mb-10">
                        <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">
                            Formulir Masuk Akun MartPlace
                        </h1>
                        <div class="mt-4 w-32 sm:w-40 h-1.5 bg-slate-900 mx-auto rounded-full"></div>
                        <p class="mt-4 text-sm text-slate-500">
                            Belum memiliki akun?
                            <a href="{{ route('register') }}"
                                class="font-semibold text-emerald-600 hover:text-emerald-500">
                                Daftar sebagai pembeli baru
                            </a>
                        </p>
                    </header>

                    <form class="space-y-8" action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="sm:col-span-2 space-y-2">
                                <label for="email" class="block text-sm font-semibold text-slate-700">
                                    Alamat Email
                                </label>
                                <input id="email" name="email" type="email" autocomplete="email" required
                                    value="{{ old('email') }}"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                @error('email')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2 space-y-2">
                                <label for="password" class="block text-sm font-semibold text-slate-700">
                                    Password
                                </label>
                                <input id="password" name="password" type="password" autocomplete="current-password"
                                    required
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                @error('password')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
                                <input id="remember_me" name="remember" type="checkbox"
                                    class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                Ingat Saya
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-sm font-semibold text-emerald-600 hover:text-emerald-500">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            Masuk Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
