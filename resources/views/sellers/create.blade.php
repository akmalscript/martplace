<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Toko - MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-cyan-400 to-green-300 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold text-white mb-3">Daftar Sebagai Seller</h1>
            <p class="text-lg text-white">Bergabunglah dengan ribuan seller sukses di MartPlace</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 mt-4">
        <div class="bg-white rounded-xl shadow-lg p-8 -mt-8 relative z-10">
            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Formulir Registrasi Data Penjual</h2>
                <p class="text-gray-600">Lengkapi data berikut untuk mendaftar sebagai seller</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
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
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('sellers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Data Toko Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-green-500 flex items-center">
                        <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Data Toko
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Toko <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="store_name" 
                                   value="{{ old('store_name') }}"
                                   placeholder="Contoh: Toko Elektronik Jaya"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Singkat
                            </label>
                            <input type="text" 
                                   name="store_description" 
                                   value="{{ old('store_description') }}"
                                   placeholder="Deskripsi toko Anda"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 transition">
                        </div>
                    </div>
                </div>

                <!-- Data PIC Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-green-500 flex items-center">
                        <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Data PIC
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama PIC <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="pic_name" 
                                   value="{{ old('pic_name') }}"
                                   placeholder="Nama lengkap penanggung jawab"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                No HP PIC <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="pic_phone" 
                                   value="{{ old('pic_phone') }}"
                                   placeholder="08123456789"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 transition">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email PIC <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   name="pic_email" 
                                   value="{{ old('pic_email') }}"
                                   placeholder="email@example.com"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 transition">
                        </div>

                        <div class="md:col-span-2" x-data="{
                            password: '{{ old('password') }}',
                            showPassword: false,
                            isTyping: false,
                            get hasMinLength() {
                                return this.password.length >= 8;
                            },
                            get hasNumber() {
                                return /[0-9]/.test(this.password);
                            },
                            get isValid() {
                                return this.hasMinLength && this.hasNumber;
                            },
                            showValidation() {
                                this.isTyping = true;
                            }
                        }">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" 
                                       name="password" 
                                       x-model="password"
                                       @input="showValidation"
                                       placeholder="Masukkan password (min. 8 karakter, minimal 1 angka)"
                                       required
                                       minlength="8"
                                       class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 transition"
                                       :class="{'border-red-300': isTyping && !isValid && password.length > 0, 'border-green-300': isTyping && isValid}">
                                <button type="button" 
                                        @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700 transition">
                                    <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Password Validation Indicator with Animation -->
                            <div x-show="isTyping && password.length > 0" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="mt-3 p-4 rounded-lg border"
                                 :class="isValid ? 'bg-green-50 border-green-200' : 'bg-amber-50 border-amber-200'"
                                 style="display: none;">
                                <div class="flex items-start space-x-2 mb-2">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" 
                                         :class="isValid ? 'text-green-500' : 'text-amber-500'"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-sm font-medium" 
                                       :class="isValid ? 'text-green-800' : 'text-amber-800'">
                                        <span x-show="!isValid">Password harus memenuhi kriteria berikut:</span>
                                        <span x-show="isValid">✓ Password sudah memenuhi semua kriteria!</span>
                                    </p>
                                </div>
                                <ul class="space-y-2 ml-7">
                                    <li class="flex items-center text-sm transition-all duration-300"
                                        :class="hasMinLength ? 'text-green-700' : 'text-amber-700'">
                                        <span class="inline-flex items-center justify-center w-5 h-5 mr-2 rounded-full transition-all duration-300"
                                              :class="hasMinLength ? 'bg-green-100' : 'bg-amber-100'">
                                            <svg x-show="hasMinLength" class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20" style="display: none;">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <svg x-show="!hasMinLength" class="w-3 h-3 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                        </span>
                                        <span x-text="hasMinLength ? '✓ Minimal 8 karakter' : '○ Minimal 8 karakter'"></span>
                                        <span class="ml-auto font-semibold" x-text="password.length + '/8'"></span>
                                    </li>
                                    <li class="flex items-center text-sm transition-all duration-300"
                                        :class="hasNumber ? 'text-green-700' : 'text-amber-700'">
                                        <span class="inline-flex items-center justify-center w-5 h-5 mr-2 rounded-full transition-all duration-300"
                                              :class="hasNumber ? 'bg-green-100' : 'bg-amber-100'">
                                            <svg x-show="hasNumber" class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20" style="display: none;">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <svg x-show="!hasNumber" class="w-3 h-3 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                        </span>
                                        <span x-text="hasNumber ? '✓ Minimal 1 angka' : '○ Minimal 1 angka'"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alamat PIC Section -->
                <div class="mb-8" x-data="{
                    openProvince: false,
                    openCity: false,
                    openDistrict: false,
                    openVillage: false,
                    searchProvince: '{{ old('pic_province') }}',
                    searchCity: '{{ old('pic_city') }}',
                    searchDistrict: '{{ old('pic_district') }}',
                    searchVillage: '{{ old('pic_village') }}',
                    selectedProvince: '{{ old('pic_province') }}',
                    selectedProvinceCode: '',
                    selectedCity: '{{ old('pic_city') }}',
                    selectedCityCode: '',
                    selectedDistrict: '{{ old('pic_district') }}',
                    selectedDistrictCode: '',
                    selectedVillage: '{{ old('pic_village') }}',
                    provinces: [],
                    cities: [],
                    districts: [],
                    villages: [],
                    loading: false,
                    init() {
                        this.loadProvinces();
                    },
                    async loadProvinces() {
                        try {
                            const response = await fetch('/api/wilayah/provinces');
                            const data = await response.json();
                            this.provinces = data.data || [];
                        } catch (error) {
                            console.error('Error loading provinces:', error);
                            this.provinces = [];
                        }
                    },
                    async loadCities(provinceCode) {
                        this.loading = true;
                        try {
                            const response = await fetch(`/api/wilayah/regencies/${provinceCode}`);
                            const data = await response.json();
                            this.cities = data.data || [];
                        } catch (error) {
                            console.error('Error loading cities:', error);
                            this.cities = [];
                        } finally {
                            this.loading = false;
                        }
                    },
                    async loadDistricts(cityCode) {
                        this.loading = true;
                        try {
                            const response = await fetch(`/api/wilayah/districts/${cityCode}`);
                            const data = await response.json();
                            this.districts = data.data || [];
                        } catch (error) {
                            console.error('Error loading districts:', error);
                            this.districts = [];
                        } finally {
                            this.loading = false;
                        }
                    },
                    async loadVillages(districtCode) {
                        this.loading = true;
                        try {
                            const response = await fetch(`/api/wilayah/villages/${districtCode}`);
                            const data = await response.json();
                            this.villages = data.data || [];
                        } catch (error) {
                            console.error('Error loading villages:', error);
                            this.villages = [];
                        } finally {
                            this.loading = false;
                        }
                    },
                    get filteredProvinces() {
                        if (!this.searchProvince) return this.provinces;
                        return this.provinces.filter(p => 
                            p.name && p.name.toLowerCase().includes(this.searchProvince.toLowerCase())
                        );
                    },
                    get filteredCities() {
                        if (!this.searchCity) return this.cities;
                        return this.cities.filter(c => 
                            c.name.toLowerCase().includes(this.searchCity.toLowerCase())
                        );
                    },
                    get filteredDistricts() {
                        if (!this.searchDistrict) return this.districts;
                        return this.districts.filter(d => 
                            d.name.toLowerCase().includes(this.searchDistrict.toLowerCase())
                        );
                    },
                    get filteredVillages() {
                        if (!this.searchVillage) return this.villages;
                        return this.villages.filter(v => 
                            v.name.toLowerCase().includes(this.searchVillage.toLowerCase())
                        );
                    },
                    async selectProvince(province) {
                        this.selectedProvince = province.name;
                        this.selectedProvinceCode = province.code;
                        this.searchProvince = province.name;
                        this.openProvince = false;
                        this.selectedCity = '';
                        this.searchCity = '';
                        this.cities = [];
                        this.selectedDistrict = '';
                        this.searchDistrict = '';
                        this.districts = [];
                        this.selectedVillage = '';
                        this.searchVillage = '';
                        this.villages = [];
                        await this.loadCities(province.code);
                    },
                    async selectCity(city) {
                        this.selectedCity = city.name;
                        this.selectedCityCode = city.code;
                        this.searchCity = city.name;
                        this.openCity = false;
                        this.selectedDistrict = '';
                        this.searchDistrict = '';
                        this.districts = [];
                        this.selectedVillage = '';
                        this.searchVillage = '';
                        this.villages = [];
                        await this.loadDistricts(city.code);
                    },
                    async selectDistrict(district) {
                        this.selectedDistrict = district.name;
                        this.selectedDistrictCode = district.code;
                        this.searchDistrict = district.name;
                        this.openDistrict = false;
                        this.selectedVillage = '';
                        this.searchVillage = '';
                        this.villages = [];
                        await this.loadVillages(district.code);
                    },
                    selectVillage(village) {
                        this.selectedVillage = village.name;
                        this.searchVillage = village.name;
                        this.openVillage = false;
                    }
                }" @click.away="openProvince = false; openCity = false; openDistrict = false; openVillage = false">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-green-500 flex items-center">
                        <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Alamat PIC
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jalan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="pic_street" 
                                   value="{{ old('pic_street') }}"
                                   placeholder="Nama jalan dan nomor rumah"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 transition">
                        </div>

                        <!-- Provinsi Dropdown -->
                        <div class="md:col-span-2 relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Provinsi <span class="text-red-500">*</span>
                            </label>
                            <input type="hidden" name="pic_province" :value="selectedProvince" required>
                            <div class="relative">
                                <input type="text" 
                                       x-model="searchProvince"
                                       @focus="openProvince = true"
                                       @input="openProvince = true"
                                       placeholder="Ketik atau pilih provinsi"
                                       autocomplete="off"
                                       autocorrect="off"
                                       autocapitalize="off"
                                       spellcheck="false"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 transition">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg x-show="!loading" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                    <svg x-show="loading" class="animate-spin h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" style="display: none;">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div x-show="openProvince" 
                                 x-transition
                                 class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-auto">
                                <div x-show="filteredProvinces.length === 0" class="px-4 py-3 text-sm text-gray-500">
                                    Provinsi tidak ditemukan
                                </div>
                                <template x-for="province in filteredProvinces" :key="province.code">
                                    <div @click="selectProvince(province)"
                                         class="px-4 py-3 cursor-pointer hover:bg-green-50 text-sm"
                                         :class="{'bg-green-100': selectedProvince === province.name}"
                                         x-text="province.name">
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Kab/Kota Dropdown -->
                        <div class="md:col-span-2 relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kab/Kota <span class="text-red-500">*</span>
                            </label>
                            <input type="hidden" name="pic_city" :value="selectedCity" required>
                            <div class="relative">
                                <input type="text" 
                                       x-model="searchCity"
                                       @focus="openCity = true"
                                       @input="openCity = true"
                                       placeholder="Pilih provinsi terlebih dahulu"
                                       :disabled="!selectedProvinceCode"
                                       autocomplete="off"
                                       autocorrect="off"
                                       autocapitalize="off"
                                       spellcheck="false"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 transition disabled:bg-gray-100 disabled:cursor-not-allowed">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg x-show="!loading" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                    <svg x-show="loading" class="animate-spin h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" style="display: none;">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div x-show="openCity" 
                                 x-transition
                                 class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-auto">
                                <div x-show="filteredCities.length === 0" class="px-4 py-3 text-sm text-gray-500">
                                    Kab/Kota tidak ditemukan
                                </div>
                                <template x-for="city in filteredCities" :key="city.code">
                                    <div @click="selectCity(city)"
                                         class="px-4 py-3 cursor-pointer hover:bg-green-50 text-sm"
                                         :class="{'bg-green-100': selectedCity === city.name}"
                                         x-text="city.name">
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Kecamatan Dropdown -->
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kecamatan <span class="text-red-500">*</span>
                            </label>
                            <input type="hidden" name="pic_district" :value="selectedDistrict" required>
                            <div class="relative">
                                <input type="text" 
                                       x-model="searchDistrict"
                                       @focus="openDistrict = true"
                                       @input="openDistrict = true"
                                       placeholder="Pilih kab/kota terlebih dahulu"
                                       :disabled="!selectedCityCode"
                                       autocomplete="off"
                                       autocorrect="off"
                                       autocapitalize="off"
                                       spellcheck="false"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 transition disabled:bg-gray-100 disabled:cursor-not-allowed">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg x-show="!loading" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                    <svg x-show="loading" class="animate-spin h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" style="display: none;">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div x-show="openDistrict" 
                                 x-transition
                                 class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-auto">
                                <div x-show="filteredDistricts.length === 0" class="px-4 py-3 text-sm text-gray-500">
                                    Kecamatan tidak ditemukan
                                </div>
                                <template x-for="district in filteredDistricts" :key="district.code">
                                    <div @click="selectDistrict(district)"
                                         class="px-4 py-3 cursor-pointer hover:bg-green-50 text-sm"
                                         :class="{'bg-green-100': selectedDistrict === district.name}"
                                         x-text="district.name">
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Kelurahan Dropdown -->
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kelurahan <span class="text-red-500">*</span>
                            </label>
                            <input type="hidden" name="pic_village" :value="selectedVillage" required>
                            <div class="relative">
                                <input type="text" 
                                       x-model="searchVillage"
                                       @focus="openVillage = true"
                                       @input="openVillage = true"
                                       placeholder="Pilih kecamatan terlebih dahulu"
                                       :disabled="!selectedDistrictCode"
                                       autocomplete="off"
                                       autocorrect="off"
                                       autocapitalize="off"
                                       spellcheck="false"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 transition disabled:bg-gray-100 disabled:cursor-not-allowed">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg x-show="!loading" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                    <svg x-show="loading" class="animate-spin h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" style="display: none;">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div x-show="openVillage" 
                                 x-transition
                                 class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-auto">
                                <div x-show="filteredVillages.length === 0" class="px-4 py-3 text-sm text-gray-500">
                                    Kelurahan tidak ditemukan
                                </div>
                                <template x-for="village in filteredVillages" :key="village.code">
                                    <div @click="selectVillage(village)"
                                         class="px-4 py-3 cursor-pointer hover:bg-green-50 text-sm"
                                         :class="{'bg-green-100': selectedVillage === village.name}"
                                         x-text="village.name">
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                RT <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="pic_rt" 
                                   value="{{ old('pic_rt') }}"
                                   placeholder="001"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                RW <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="pic_rw" 
                                   value="{{ old('pic_rw') }}"
                                   placeholder="002"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 transition">
                        </div>
                    </div>
                </div>

                <!-- Dokumen Identitas PIC Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-green-500 flex items-center">
                        <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                        Dokumen Identitas PIC
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                No. KTP PIC <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="pic_ktp_number" 
                                   value="{{ old('pic_ktp_number') }}"
                                   placeholder="16 digit nomor KTP"
                                   required
                                   maxlength="16"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Foto PIC (jpg/png, ≤2MB)
                            </label>
                            <input type="file" 
                                   name="pic_photo" 
                                   accept="image/jpeg,image/png"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            <p class="text-xs text-gray-500 mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Format: JPG, PNG. Maksimal 2MB
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                File KTP (jpg/png/pdf, ≤5MB)
                            </label>
                            <input type="file" 
                                   name="pic_ktp_file" 
                                   accept="image/jpeg,image/png,application/pdf"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            <p class="text-xs text-gray-500 mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Format: JPG, PNG, PDF. Maksimal 5MB
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="bg-gradient-to-r from-green-500 to-green-600 text-white px-10 py-3 rounded-lg font-semibold hover:from-green-600 hover:to-green-700 transition shadow-md hover:shadow-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Registrasi Penjual
                    </button>
                    <a href="{{ route('home') }}" 
                       class="bg-gray-100 text-gray-700 px-10 py-3 rounded-lg font-semibold hover:bg-gray-200 transition border border-gray-300 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">MartPlace</h3>
                    <p class="text-gray-400 text-sm">Marketplace terpercaya untuk belanja online dengan berbagai pilihan produk berkualitas.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Tentang</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white">Karir</a></li>
                        <li><a href="#" class="hover:text-white">Blog</a></li>
                        <li><a href="{{ route('sellers.create') }}" class="hover:text-white">Daftar Jadi Seller</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Bantuan</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-white">Cara Belanja</a></li>
                        <li><a href="#" class="hover:text-white">Pengiriman</a></li>
                        <li><a href="#" class="hover:text-white">Pengembalian</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; 2025 MartPlace. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
