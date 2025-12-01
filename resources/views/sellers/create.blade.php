<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Menjadi Penjual - MartPlace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-b from-cream to-white min-h-screen">
    
    <div class="py-16 sm:py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-2xl font-bold text-forest hover:text-sage transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    MartPlace
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-olive/10 overflow-hidden">
                <div class="px-6 sm:px-10 py-12 sm:py-14">
                    
                    <!-- Header -->
                    <header class="text-center mb-10">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-sage to-forest rounded-2xl mb-4 shadow-lg">
                            <svg class="w-8 h-8 text-cream" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-forest">Formulir Registrasi Penjual</h1>
                        <div class="mt-3 w-20 h-1 bg-gradient-to-r from-sage to-forest mx-auto rounded-full"></div>
                        <p class="mt-4 text-sm text-forest/60">
                            Sudah memiliki akun?
                            <a href="{{ route('login') }}" class="font-semibold text-sage hover:text-forest transition-colors">Masuk sekarang</a>
                        </p>
                    </header>

                    @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                        <div class="flex gap-3">
                            <svg class="h-5 w-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-red-800">Terdapat kesalahan:</p>
                                <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('sellers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                        @csrf

                        <!-- Section: Data Toko -->
                        <div class="space-y-5">
                            <h2 class="flex items-center gap-2 text-base font-bold text-forest pb-3 border-b border-olive/20">
                                <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Data Toko
                            </h2>
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="store_name" class="block text-sm font-medium text-forest mb-1.5">Nama Toko <span class="text-red-500">*</span></label>
                                    <input id="store_name" type="text" name="store_name" value="{{ old('store_name') }}" required
                                        placeholder="Contoh: Toko Elektronik Jaya"
                                        class="w-full px-4 py-2.5 text-sm text-forest bg-cream/50 border border-olive/30 rounded-lg focus:ring-2 focus:ring-sage/30 focus:border-sage transition-colors">
                                </div>
                                <div>
                                    <label for="store_description" class="block text-sm font-medium text-forest mb-1.5">Deskripsi Singkat</label>
                                    <input id="store_description" type="text" name="store_description" value="{{ old('store_description') }}"
                                        placeholder="Deskripsi singkat toko Anda"
                                        class="w-full px-4 py-2.5 text-sm text-forest bg-cream/50 border border-olive/30 rounded-lg focus:ring-2 focus:ring-sage/30 focus:border-sage transition-colors">
                                </div>
                            </div>
                        </div>

                        <!-- Section: Data PIC -->
                        <div class="space-y-5">
                            <h2 class="flex items-center gap-2 text-base font-bold text-forest pb-3 border-b border-olive/20">
                                <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Data PIC (Penanggung Jawab)
                            </h2>
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="pic_name" class="block text-sm font-medium text-forest mb-1.5">Nama PIC <span class="text-red-500">*</span></label>
                                    <input id="pic_name" type="text" name="pic_name" value="{{ old('pic_name') }}" required
                                        placeholder="Nama lengkap"
                                        class="w-full px-4 py-2.5 text-sm text-forest bg-cream/50 border border-olive/30 rounded-lg focus:ring-2 focus:ring-sage/30 focus:border-sage transition-colors">
                                </div>
                                <div>
                                    <label for="pic_phone" class="block text-sm font-medium text-forest mb-1.5">No HP PIC <span class="text-red-500">*</span></label>
                                    <input id="pic_phone" type="text" name="pic_phone" value="{{ old('pic_phone') }}" required
                                        placeholder="08123456789"
                                        class="w-full px-4 py-2.5 text-sm text-forest bg-cream/50 border border-olive/30 rounded-lg focus:ring-2 focus:ring-sage/30 focus:border-sage transition-colors">
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="pic_email" class="block text-sm font-medium text-forest mb-1.5">Email PIC <span class="text-red-500">*</span></label>
                                    <input id="pic_email" type="email" name="pic_email" value="{{ old('pic_email') }}" required
                                        placeholder="email@example.com"
                                        class="w-full px-4 py-2.5 text-sm text-forest bg-cream/50 border border-olive/30 rounded-lg focus:ring-2 focus:ring-sage/30 focus:border-sage transition-colors">
                                </div>
                                <div class="sm:col-span-2" x-data="{ password: '', show: false }">
                                    <label for="password" class="block text-sm font-medium text-forest mb-1.5">Password <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input :type="show ? 'text' : 'password'" id="password" name="password" x-model="password" required minlength="8"
                                            placeholder="Min. 8 karakter dengan 1 angka"
                                            class="w-full px-4 py-2.5 pr-10 text-sm text-forest bg-cream/50 border border-olive/30 rounded-lg focus:ring-2 focus:ring-sage/30 focus:border-sage transition-colors">
                                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-forest/50 hover:text-forest">
                                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                        </button>
                                    </div>
                                    <div x-show="password.length > 0" x-transition class="mt-2 flex gap-4 text-xs">
                                        <span :class="password.length >= 8 ? 'text-sage' : 'text-amber-600'">
                                            <span x-text="password.length >= 8 ? '✓' : '○'"></span> Min 8 karakter
                                        </span>
                                        <span :class="/[0-9]/.test(password) ? 'text-sage' : 'text-amber-600'">
                                            <span x-text="/[0-9]/.test(password) ? '✓' : '○'"></span> Min 1 angka
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Alamat PIC -->
                        <div class="space-y-5" x-data="{
                            provinces: [], cities: [], districts: [], villages: [],
                            selectedProvince: '{{ old('pic_province') }}', selectedProvinceCode: '',
                            selectedCity: '{{ old('pic_city') }}', selectedCityCode: '',
                            selectedDistrict: '{{ old('pic_district') }}', selectedDistrictCode: '',
                            selectedVillage: '{{ old('pic_village') }}',
                            openP: false, openC: false, openD: false, openV: false,
                            searchP: '{{ old('pic_province') }}', searchC: '{{ old('pic_city') }}', searchD: '{{ old('pic_district') }}', searchV: '{{ old('pic_village') }}',
                            async init() { const r = await fetch('/api/wilayah/provinces'); const d = await r.json(); this.provinces = d.data || []; },
                            async loadCities(code) { const r = await fetch('/api/wilayah/regencies/' + code); const d = await r.json(); this.cities = d.data || []; },
                            async loadDistricts(code) { const r = await fetch('/api/wilayah/districts/' + code); const d = await r.json(); this.districts = d.data || []; },
                            async loadVillages(code) { const r = await fetch('/api/wilayah/villages/' + code); const d = await r.json(); this.villages = d.data || []; },
                            get fP() { return this.provinces.filter(p => p.name?.toLowerCase().includes(this.searchP.toLowerCase())); },
                            get fC() { return this.cities.filter(c => c.name?.toLowerCase().includes(this.searchC.toLowerCase())); },
                            get fD() { return this.districts.filter(d => d.name?.toLowerCase().includes(this.searchD.toLowerCase())); },
                            get fV() { return this.villages.filter(v => v.name?.toLowerCase().includes(this.searchV.toLowerCase())); },
                            async pickP(p) { this.selectedProvince = p.name; this.selectedProvinceCode = p.code; this.searchP = p.name; this.openP = false; this.selectedCity = ''; this.searchC = ''; this.cities = []; this.selectedDistrict = ''; this.searchD = ''; this.districts = []; this.selectedVillage = ''; this.searchV = ''; this.villages = []; await this.loadCities(p.code); },
                            async pickC(c) { this.selectedCity = c.name; this.selectedCityCode = c.code; this.searchC = c.name; this.openC = false; this.selectedDistrict = ''; this.searchD = ''; this.districts = []; this.selectedVillage = ''; this.searchV = ''; this.villages = []; await this.loadDistricts(c.code); },
                            async pickD(d) { this.selectedDistrict = d.name; this.selectedDistrictCode = d.code; this.searchD = d.name; this.openD = false; this.selectedVillage = ''; this.searchV = ''; this.villages = []; await this.loadVillages(d.code); },
                            pickV(v) { this.selectedVillage = v.name; this.searchV = v.name; this.openV = false; }
                        }">
                            <h2 class="flex items-center gap-2 text-base font-bold text-forest pb-3 border-b border-olive/20">
                                <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Alamat PIC
                            </h2>
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="pic_street" class="block text-sm font-medium text-forest mb-1.5">Jalan <span class="text-red-500">*</span></label>
                                    <input id="pic_street" type="text" name="pic_street" value="{{ old('pic_street') }}" required
                                        placeholder="Nama jalan dan nomor rumah"
                                        class="w-full px-4 py-2.5 text-sm text-forest bg-cream/50 border border-olive/30 rounded-lg focus:ring-2 focus:ring-sage/30 focus:border-sage transition-colors">
                                </div>

                                <!-- Provinsi -->
                                <div class="relative" @click.away="openP = false">
                                    <label class="block text-sm font-medium text-forest mb-1.5">Provinsi <span class="text-red-500">*</span></label>
                                    <input type="hidden" name="pic_province" :value="selectedProvince">
                                    <div class="relative">
                                        <input type="text" x-model="searchP" @focus="openP = true" @input="openP = true" required autocomplete="off"
                                            placeholder="Pilih Provinsi"
                                            class="w-full px-4 py-2.5 pr-10 text-sm text-forest bg-cream/50 border border-olive/30 rounded-lg focus:ring-2 focus:ring-sage/30 focus:border-sage transition-colors">
                                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-forest/40 pointer-events-none" :class="{'rotate-180': openP}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                    <div x-show="openP" x-transition class="absolute z-30 w-full mt-1 bg-white border border-olive/20 rounded-lg shadow-lg max-h-48 overflow-auto">
                                        <template x-for="p in fP" :key="p.code">
                                            <div @click="pickP(p)" class="px-4 py-2.5 text-sm text-forest cursor-pointer hover:bg-sage/10" :class="{'bg-sage/20': selectedProvince === p.name}" x-text="p.name"></div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Kab/Kota -->
                                <div class="relative" @click.away="openC = false">
                                    <label class="block text-sm font-medium text-forest mb-1.5">Kab/Kota <span class="text-red-500">*</span></label>
                                    <input type="hidden" name="pic_city" :value="selectedCity">
                                    <div class="relative">
                                        <input type="text" x-model="searchC" @focus="openC = true" @input="openC = true" :disabled="!selectedProvinceCode" required autocomplete="off"
                                            placeholder="Pilih Provinsi dulu"
                                            class="w-full px-4 py-2.5 pr-10 text-sm text-forest bg-cream/50 border border-olive/30 rounded-lg focus:ring-2 focus:ring-sage/30 focus:border-sage transition-colors disabled:bg-olive/10 disabled:cursor-not-allowed">
                                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-forest/40 pointer-events-none" :class="{'rotate-180': openC}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                    <div x-show="openC" x-transition class="absolute z-30 w-full mt-1 bg-white border border-olive/20 rounded-lg shadow-lg max-h-48 overflow-auto">
                                        <template x-for="c in fC" :key="c.code">
                                            <div @click="pickC(c)" class="px-4 py-2.5 text-sm text-forest cursor-pointer hover:bg-sage/10" :class="{'bg-sage/20': selectedCity === c.name}" x-text="c.name"></div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Kecamatan -->
                                <div class="relative" @click.away="openD = false">
                                    <label class="block text-sm font-medium text-forest mb-1.5">Kecamatan <span class="text-red-500">*</span></label>
                                    <input type="hidden" name="pic_district" :value="selectedDistrict">
                                    <div class="relative">
                                        <input type="text" x-model="searchD" @focus="openD = true" @input="openD = true" :disabled="!selectedCityCode" required autocomplete="off"
                                            placeholder="Pilih Kab/Kota dulu"
                                            class="w-full px-4 py-2.5 pr-10 text-sm text-forest bg-cream/50 border border-olive/30 rounded-lg focus:ring-2 focus:ring-sage/30 focus:border-sage transition-colors disabled:bg-olive/10 disabled:cursor-not-allowed">
                                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-forest/40 pointer-events-none" :class="{'rotate-180': openD}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                    <div x-show="openD" x-transition class="absolute z-30 w-full mt-1 bg-white border border-olive/20 rounded-lg shadow-lg max-h-48 overflow-auto">
                                        <template x-for="d in fD" :key="d.code">
                                            <div @click="pickD(d)" class="px-4 py-2.5 text-sm text-forest cursor-pointer hover:bg-sage/10" :class="{'bg-sage/20': selectedDistrict === d.name}" x-text="d.name"></div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Kelurahan -->
                                <div class="relative" @click.away="openV = false">
                                    <label class="block text-sm font-medium text-forest mb-1.5">Kelurahan <span class="text-red-500">*</span></label>
                                    <input type="hidden" name="pic_village" :value="selectedVillage">
                                    <div class="relative">
                                        <input type="text" x-model="searchV" @focus="openV = true" @input="openV = true" :disabled="!selectedDistrictCode" required autocomplete="off"
                                            placeholder="Pilih Kecamatan dulu"
                                            class="w-full px-4 py-2.5 pr-10 text-sm text-forest bg-cream/50 border border-olive/30 rounded-lg focus:ring-2 focus:ring-sage/30 focus:border-sage transition-colors disabled:bg-olive/10 disabled:cursor-not-allowed">
                                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-forest/40 pointer-events-none" :class="{'rotate-180': openV}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                    <div x-show="openV" x-transition class="absolute z-30 w-full mt-1 bg-white border border-olive/20 rounded-lg shadow-lg max-h-48 overflow-auto">
                                        <template x-for="v in fV" :key="v.code">
                                            <div @click="pickV(v)" class="px-4 py-2.5 text-sm text-forest cursor-pointer hover:bg-sage/10" :class="{'bg-sage/20': selectedVillage === v.name}" x-text="v.name"></div>
                                        </template>
                                    </div>
                                </div>

                                <div>
                                    <label for="pic_rt" class="block text-sm font-medium text-forest mb-1.5">RT <span class="text-red-500">*</span></label>
                                    <input id="pic_rt" type="text" name="pic_rt" value="{{ old('pic_rt') }}" required placeholder="001"
                                        class="w-full px-4 py-2.5 text-sm text-forest bg-cream/50 border border-olive/30 rounded-lg focus:ring-2 focus:ring-sage/30 focus:border-sage transition-colors">
                                </div>
                                <div>
                                    <label for="pic_rw" class="block text-sm font-medium text-forest mb-1.5">RW <span class="text-red-500">*</span></label>
                                    <input id="pic_rw" type="text" name="pic_rw" value="{{ old('pic_rw') }}" required placeholder="002"
                                        class="w-full px-4 py-2.5 text-sm text-forest bg-cream/50 border border-olive/30 rounded-lg focus:ring-2 focus:ring-sage/30 focus:border-sage transition-colors">
                                </div>
                            </div>
                        </div>

                        <!-- Section: Dokumen Identitas -->
                        <div class="space-y-5">
                            <h2 class="flex items-center gap-2 text-base font-bold text-forest pb-3 border-b border-olive/20">
                                <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                </svg>
                                Dokumen Identitas
                            </h2>
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="pic_ktp_number" class="block text-sm font-medium text-forest mb-1.5">No. KTP <span class="text-red-500">*</span></label>
                                    <input id="pic_ktp_number" type="text" name="pic_ktp_number" value="{{ old('pic_ktp_number') }}" required maxlength="16"
                                        placeholder="16 digit nomor KTP"
                                        class="w-full px-4 py-2.5 text-sm text-forest bg-cream/50 border border-olive/30 rounded-lg focus:ring-2 focus:ring-sage/30 focus:border-sage transition-colors">
                                </div>
                                <div>
                                    <label for="pic_photo" class="block text-sm font-medium text-forest mb-1.5">Foto PIC</label>
                                    <input id="pic_photo" type="file" name="pic_photo" accept="image/jpeg,image/png"
                                        class="w-full px-3 py-2 text-sm text-forest bg-cream/50 border border-olive/30 rounded-lg file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-sage/20 file:text-forest hover:file:bg-sage/30 cursor-pointer">
                                    <p class="text-xs text-forest/50 mt-1">JPG, PNG. Maks 2MB</p>
                                </div>
                                <div>
                                    <label for="pic_ktp_file" class="block text-sm font-medium text-forest mb-1.5">File KTP</label>
                                    <input id="pic_ktp_file" type="file" name="pic_ktp_file" accept="image/jpeg,image/png,application/pdf"
                                        class="w-full px-3 py-2 text-sm text-forest bg-cream/50 border border-olive/30 rounded-lg file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-sage/20 file:text-forest hover:file:bg-sage/30 cursor-pointer">
                                    <p class="text-xs text-forest/50 mt-1">JPG, PNG, PDF. Maks 5MB</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-6">
                            <button type="submit"
                                class="flex-1 inline-flex justify-center items-center gap-2 px-6 py-3 text-sm font-semibold text-cream bg-gradient-to-r from-sage to-forest rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Daftar Sebagai Penjual
                            </button>
                            <a href="{{ route('home') }}"
                                class="flex-1 inline-flex justify-center items-center gap-2 px-6 py-3 text-sm font-semibold text-forest bg-white border border-olive/30 rounded-xl hover:bg-cream transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Footer link -->
            <p class="text-center text-sm text-forest/50 mt-8">
                &copy; {{ date('Y') }} MartPlace. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
