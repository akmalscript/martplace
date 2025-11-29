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
                            Formulir Registrasi Data Penjual
                        </h1>
                        <div class="mt-4 w-32 sm:w-40 h-1.5 bg-slate-900 mx-auto rounded-full"></div>
                        <p class="mt-4 text-sm text-slate-500">
                            Sudah memiliki akun?
                            <a href="{{ route('login') }}"
                                class="font-semibold text-emerald-600 hover:text-emerald-500">
                                Masuk sekarang
                            </a>
                        </p>
                    </header>

                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-8">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Terdapat beberapa kesalahan:</h3>
                                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 mb-8">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('sellers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                        @csrf

                        <!-- Data Toko Section -->
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 mb-6 pb-3 border-b border-slate-200 flex items-center">
                                <svg class="w-5 h-5 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Data Toko
                            </h2>
                            
                            <div class="grid gap-6 sm:grid-cols-2">
                                <div class="space-y-2">
                                    <label for="store_name" class="block text-sm font-semibold text-slate-700">
                                        Nama Toko <span class="text-red-500">*</span>
                                    </label>
                                    <input id="store_name" type="text" name="store_name" value="{{ old('store_name') }}"
                                        placeholder="Contoh: Toko Elektronik Jaya" required
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>

                                <div class="space-y-2">
                                    <label for="store_description" class="block text-sm font-semibold text-slate-700">
                                        Deskripsi Singkat
                                    </label>
                                    <input id="store_description" type="text" name="store_description" value="{{ old('store_description') }}"
                                        placeholder="Deskripsi toko Anda"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                            </div>
                        </div>

                        <!-- Data PIC Section -->
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 mb-6 pb-3 border-b border-slate-200 flex items-center">
                                <svg class="w-5 h-5 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Data PIC
                            </h2>
                            
                            <div class="grid gap-6 sm:grid-cols-2">
                                <div class="space-y-2">
                                    <label for="pic_name" class="block text-sm font-semibold text-slate-700">
                                        Nama PIC <span class="text-red-500">*</span>
                                    </label>
                                    <input id="pic_name" type="text" name="pic_name" value="{{ old('pic_name') }}"
                                        placeholder="Nama lengkap penanggung jawab" required
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>

                                <div class="space-y-2">
                                    <label for="pic_phone" class="block text-sm font-semibold text-slate-700">
                                        No HP PIC <span class="text-red-500">*</span>
                                    </label>
                                    <input id="pic_phone" type="text" name="pic_phone" value="{{ old('pic_phone') }}"
                                        placeholder="08123456789" required
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>

                                <div class="sm:col-span-2 space-y-2">
                                    <label for="pic_email" class="block text-sm font-semibold text-slate-700">
                                        Email PIC <span class="text-red-500">*</span>
                                    </label>
                                    <input id="pic_email" type="email" name="pic_email" value="{{ old('pic_email') }}"
                                        placeholder="email@example.com" required
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>

                                <div class="sm:col-span-2 space-y-2" x-data="{
                                    password: '{{ old('password') }}',
                                    showPassword: false,
                                    isTyping: false,
                                    get hasMinLength() { return this.password.length >= 8; },
                                    get hasNumber() { return /[0-9]/.test(this.password); },
                                    get isValid() { return this.hasMinLength && this.hasNumber; },
                                    showValidation() { this.isTyping = true; }
                                }">
                                    <label for="password" class="block text-sm font-semibold text-slate-700">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input :type="showPassword ? 'text' : 'password'" 
                                               id="password" name="password" 
                                               x-model="password"
                                               @input="showValidation"
                                               placeholder="Masukkan password (min. 8 karakter, minimal 1 angka)"
                                               required minlength="8"
                                               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 pr-12 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                               :class="{'border-red-300': isTyping && !isValid && password.length > 0, 'border-emerald-300': isTyping && isValid}">
                                        <button type="button" @click="showPassword = !showPassword"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-500 hover:text-slate-700">
                                            <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <div x-show="isTyping && password.length > 0" 
                                         x-transition
                                         class="mt-3 p-4 rounded-xl border"
                                         :class="isValid ? 'bg-emerald-50 border-emerald-200' : 'bg-amber-50 border-amber-200'"
                                         style="display: none;">
                                        <p class="text-sm font-medium" :class="isValid ? 'text-emerald-800' : 'text-amber-800'">
                                            <span x-show="!isValid">Password harus memenuhi kriteria:</span>
                                            <span x-show="isValid">Password sudah memenuhi semua kriteria!</span>
                                        </p>
                                        <ul class="mt-2 space-y-1 text-sm">
                                            <li :class="hasMinLength ? 'text-emerald-700' : 'text-amber-700'" x-text="hasMinLength ? '✓ Minimal 8 karakter (' + password.length + '/8)' : '○ Minimal 8 karakter (' + password.length + '/8)'"></li>
                                            <li :class="hasNumber ? 'text-emerald-700' : 'text-amber-700'" x-text="hasNumber ? '✓ Minimal 1 angka' : '○ Minimal 1 angka'"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alamat PIC Section -->
                        <div x-data="{
                            openProvince: false, openCity: false, openDistrict: false, openVillage: false,
                            searchProvince: '{{ old('pic_province') }}', searchCity: '{{ old('pic_city') }}',
                            searchDistrict: '{{ old('pic_district') }}', searchVillage: '{{ old('pic_village') }}',
                            selectedProvince: '{{ old('pic_province') }}', selectedProvinceCode: '',
                            selectedCity: '{{ old('pic_city') }}', selectedCityCode: '',
                            selectedDistrict: '{{ old('pic_district') }}', selectedDistrictCode: '',
                            selectedVillage: '{{ old('pic_village') }}',
                            provinces: [], cities: [], districts: [], villages: [], loading: false,
                            init() { this.loadProvinces(); },
                            async loadProvinces() {
                                try { const r = await fetch('/api/wilayah/provinces'); const d = await r.json(); this.provinces = d.data || []; }
                                catch (e) { this.provinces = []; }
                            },
                            async loadCities(c) { this.loading = true; try { const r = await fetch(`/api/wilayah/regencies/${c}`); const d = await r.json(); this.cities = d.data || []; } catch (e) { this.cities = []; } finally { this.loading = false; } },
                            async loadDistricts(c) { this.loading = true; try { const r = await fetch(`/api/wilayah/districts/${c}`); const d = await r.json(); this.districts = d.data || []; } catch (e) { this.districts = []; } finally { this.loading = false; } },
                            async loadVillages(c) { this.loading = true; try { const r = await fetch(`/api/wilayah/villages/${c}`); const d = await r.json(); this.villages = d.data || []; } catch (e) { this.villages = []; } finally { this.loading = false; } },
                            get filteredProvinces() { if (!this.searchProvince) return this.provinces; return this.provinces.filter(p => p.name && p.name.toLowerCase().includes(this.searchProvince.toLowerCase())); },
                            get filteredCities() { if (!this.searchCity) return this.cities; return this.cities.filter(c => c.name.toLowerCase().includes(this.searchCity.toLowerCase())); },
                            get filteredDistricts() { if (!this.searchDistrict) return this.districts; return this.districts.filter(d => d.name.toLowerCase().includes(this.searchDistrict.toLowerCase())); },
                            get filteredVillages() { if (!this.searchVillage) return this.villages; return this.villages.filter(v => v.name.toLowerCase().includes(this.searchVillage.toLowerCase())); },
                            async selectProvince(p) { this.selectedProvince = p.name; this.selectedProvinceCode = p.code; this.searchProvince = p.name; this.openProvince = false; this.selectedCity = ''; this.searchCity = ''; this.cities = []; this.selectedDistrict = ''; this.searchDistrict = ''; this.districts = []; this.selectedVillage = ''; this.searchVillage = ''; this.villages = []; await this.loadCities(p.code); },
                            async selectCity(c) { this.selectedCity = c.name; this.selectedCityCode = c.code; this.searchCity = c.name; this.openCity = false; this.selectedDistrict = ''; this.searchDistrict = ''; this.districts = []; this.selectedVillage = ''; this.searchVillage = ''; this.villages = []; await this.loadDistricts(c.code); },
                            async selectDistrict(d) { this.selectedDistrict = d.name; this.selectedDistrictCode = d.code; this.searchDistrict = d.name; this.openDistrict = false; this.selectedVillage = ''; this.searchVillage = ''; this.villages = []; await this.loadVillages(d.code); },
                            selectVillage(v) { this.selectedVillage = v.name; this.searchVillage = v.name; this.openVillage = false; }
                        }" @click.away="openProvince = false; openCity = false; openDistrict = false; openVillage = false">
                            <h2 class="text-lg font-bold text-slate-900 mb-6 pb-3 border-b border-slate-200 flex items-center">
                                <svg class="w-5 h-5 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Alamat PIC
                            </h2>
                            
                            <div class="grid gap-6 sm:grid-cols-2">
                                <div class="sm:col-span-2 space-y-2">
                                    <label for="pic_street" class="block text-sm font-semibold text-slate-700">
                                        Jalan <span class="text-red-500">*</span>
                                    </label>
                                    <input id="pic_street" type="text" name="pic_street" value="{{ old('pic_street') }}"
                                        placeholder="Nama jalan dan nomor rumah" required
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>

                                <!-- Provinsi -->
                                <div class="sm:col-span-2 space-y-2 relative">
                                    <label class="block text-sm font-semibold text-slate-700">Provinsi <span class="text-red-500">*</span></label>
                                    <input type="hidden" name="pic_province" :value="selectedProvince" required>
                                    <div class="relative">
                                        <input type="text" x-model="searchProvince" @focus="openProvince = true" @input="openProvince = true"
                                            placeholder="Ketik atau pilih provinsi" autocomplete="off" required
                                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg x-show="!loading" class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            <svg x-show="loading" class="animate-spin h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" style="display: none;"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        </div>
                                    </div>
                                    <div x-show="openProvince" x-transition class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-60 overflow-auto">
                                        <div x-show="filteredProvinces.length === 0" class="px-4 py-3 text-sm text-slate-500">Provinsi tidak ditemukan</div>
                                        <template x-for="province in filteredProvinces" :key="province.code">
                                            <div @click="selectProvince(province)" class="px-4 py-3 cursor-pointer hover:bg-emerald-50 text-sm" :class="{'bg-emerald-100': selectedProvince === province.name}" x-text="province.name"></div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Kab/Kota -->
                                <div class="sm:col-span-2 space-y-2 relative">
                                    <label class="block text-sm font-semibold text-slate-700">Kab/Kota <span class="text-red-500">*</span></label>
                                    <input type="hidden" name="pic_city" :value="selectedCity" required>
                                    <div class="relative">
                                        <input type="text" x-model="searchCity" @focus="openCity = true" @input="openCity = true"
                                            placeholder="Pilih provinsi terlebih dahulu" :disabled="!selectedProvinceCode" autocomplete="off" required
                                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 disabled:bg-slate-100 disabled:cursor-not-allowed">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg x-show="!loading" class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                    <div x-show="openCity" x-transition class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-60 overflow-auto">
                                        <div x-show="filteredCities.length === 0" class="px-4 py-3 text-sm text-slate-500">Kab/Kota tidak ditemukan</div>
                                        <template x-for="city in filteredCities" :key="city.code">
                                            <div @click="selectCity(city)" class="px-4 py-3 cursor-pointer hover:bg-emerald-50 text-sm" :class="{'bg-emerald-100': selectedCity === city.name}" x-text="city.name"></div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Kecamatan -->
                                <div class="space-y-2 relative">
                                    <label class="block text-sm font-semibold text-slate-700">Kecamatan <span class="text-red-500">*</span></label>
                                    <input type="hidden" name="pic_district" :value="selectedDistrict" required>
                                    <div class="relative">
                                        <input type="text" x-model="searchDistrict" @focus="openDistrict = true" @input="openDistrict = true"
                                            placeholder="Pilih kab/kota terlebih dahulu" :disabled="!selectedCityCode" autocomplete="off" required
                                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 disabled:bg-slate-100 disabled:cursor-not-allowed">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                    <div x-show="openDistrict" x-transition class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-60 overflow-auto">
                                        <div x-show="filteredDistricts.length === 0" class="px-4 py-3 text-sm text-slate-500">Kecamatan tidak ditemukan</div>
                                        <template x-for="district in filteredDistricts" :key="district.code">
                                            <div @click="selectDistrict(district)" class="px-4 py-3 cursor-pointer hover:bg-emerald-50 text-sm" :class="{'bg-emerald-100': selectedDistrict === district.name}" x-text="district.name"></div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Kelurahan -->
                                <div class="space-y-2 relative">
                                    <label class="block text-sm font-semibold text-slate-700">Kelurahan <span class="text-red-500">*</span></label>
                                    <input type="hidden" name="pic_village" :value="selectedVillage" required>
                                    <div class="relative">
                                        <input type="text" x-model="searchVillage" @focus="openVillage = true" @input="openVillage = true"
                                            placeholder="Pilih kecamatan terlebih dahulu" :disabled="!selectedDistrictCode" autocomplete="off" required
                                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 disabled:bg-slate-100 disabled:cursor-not-allowed">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                    <div x-show="openVillage" x-transition class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-60 overflow-auto">
                                        <div x-show="filteredVillages.length === 0" class="px-4 py-3 text-sm text-slate-500">Kelurahan tidak ditemukan</div>
                                        <template x-for="village in filteredVillages" :key="village.code">
                                            <div @click="selectVillage(village)" class="px-4 py-3 cursor-pointer hover:bg-emerald-50 text-sm" :class="{'bg-emerald-100': selectedVillage === village.name}" x-text="village.name"></div>
                                        </template>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="pic_rt" class="block text-sm font-semibold text-slate-700">RT <span class="text-red-500">*</span></label>
                                    <input id="pic_rt" type="text" name="pic_rt" value="{{ old('pic_rt') }}" placeholder="001" required
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>

                                <div class="space-y-2">
                                    <label for="pic_rw" class="block text-sm font-semibold text-slate-700">RW <span class="text-red-500">*</span></label>
                                    <input id="pic_rw" type="text" name="pic_rw" value="{{ old('pic_rw') }}" placeholder="002" required
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                            </div>
                        </div>

                        <!-- Dokumen Identitas PIC Section -->
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 mb-6 pb-3 border-b border-slate-200 flex items-center">
                                <svg class="w-5 h-5 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                                Dokumen Identitas PIC
                            </h2>
                            
                            <div class="grid gap-6 sm:grid-cols-2">
                                <div class="sm:col-span-2 space-y-2">
                                    <label for="pic_ktp_number" class="block text-sm font-semibold text-slate-700">
                                        No. KTP PIC <span class="text-red-500">*</span>
                                    </label>
                                    <input id="pic_ktp_number" type="text" name="pic_ktp_number" value="{{ old('pic_ktp_number') }}"
                                        placeholder="16 digit nomor KTP" required maxlength="16"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>

                                <div class="space-y-2">
                                    <label for="pic_photo" class="block text-sm font-semibold text-slate-700">
                                        Foto PIC (jpg/png, ≤2MB)
                                    </label>
                                    <input id="pic_photo" type="file" name="pic_photo" accept="image/jpeg,image/png"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                    <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                                </div>

                                <div class="space-y-2">
                                    <label for="pic_ktp_file" class="block text-sm font-semibold text-slate-700">
                                        File KTP (jpg/png/pdf, ≤5MB)
                                    </label>
                                    <input id="pic_ktp_file" type="file" name="pic_ktp_file" accept="image/jpeg,image/png,application/pdf"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                    <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, PDF. Maksimal 5MB</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            <button type="submit"
                                class="flex-1 inline-flex justify-center items-center rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Registrasi Penjual
                            </button>
                            <a href="{{ route('home') }}"
                                class="flex-1 inline-flex justify-center items-center rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
