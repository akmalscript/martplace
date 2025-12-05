<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Toko - MartPlace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }
        .icon-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-cyan-50 to-green-50">
    
    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-green-500 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-shopping-bag text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-cyan-600 to-green-600 bg-clip-text text-transparent">
                            MartPlace
                        </span>
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-xl mx-8">
                    <div class="relative w-full">
                        <input type="text" 
                               placeholder="Cari produk, toko, kategori, atau lokasi..."
                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                        <button class="absolute right-0 top-0 h-full px-4 text-gray-400 hover:text-cyan-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Right Side Buttons -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}" 
                       class="flex items-center px-5 py-2.5 text-gray-700 hover:text-cyan-600 font-semibold transition-all">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Masuk
                    </a>
                    <a href="{{ route('sellers.create') }}" 
                       class="flex items-center px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-green-500 text-white font-semibold rounded-lg hover:shadow-lg transition-all">
                        <i class="fas fa-store mr-2"></i>
                        Daftar Toko
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-cyan-500 via-green-500 to-emerald-500 py-16 relative overflow-hidden gradient-animate">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-yellow-300 opacity-10 rounded-full blur-3xl"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="inline-block bg-white bg-opacity-20 backdrop-blur-sm px-6 py-3 rounded-full mb-6">
                <span class="text-white font-bold text-lg flex items-center justify-center">
                    <i class="fas fa-store mr-2"></i>Registrasi Seller
                </span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight">Daftar Sebagai Seller</h1>
            <p class="text-xl text-white text-opacity-90">Bergabunglah dengan ribuan seller sukses di MartPlace dan mulai raih kesuksesan bersama kami!</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 -mt-16 relative z-10">
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10 border border-gray-100">
            <!-- Header -->
            <div class="mb-8 text-center">
                <div class="inline-block bg-gradient-to-r from-cyan-500 to-green-500 text-white px-5 py-2 rounded-full text-sm font-semibold shadow-lg mb-4">
                    <i class="fas fa-file-alt mr-2"></i>Formulir Pendaftaran
                </div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-cyan-600 to-green-600 bg-clip-text text-transparent mb-3">Formulir Registrasi Data Penjual</h2>
                <p class="text-gray-600 text-lg">Lengkapi data berikut untuk mendaftar sebagai seller</p>
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
                <div class="mb-8 p-6 bg-gradient-to-br from-cyan-50 to-green-50 rounded-2xl border-2 border-cyan-200">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-cyan-600 to-green-600 bg-clip-text text-transparent mb-6 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-green-500 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-store text-white"></i>
                        </div>
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
                <div class="mb-8 p-6 bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl border-2 border-purple-200">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-6 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-user text-white"></i>
                        </div>
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
                <div class="mb-8 p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border-2 border-blue-200">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-6 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-map-marker-alt text-white"></i>
                        </div>
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
                </div>

                <!-- Dokumen Identitas PIC Section -->
                <div class="mb-8 p-6 bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl border-2 border-orange-200">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-orange-600 to-amber-600 bg-clip-text text-transparent mb-6 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-id-card text-white"></i>
                        </div>
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
                <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4 pt-8 mt-8 border-t-2 border-gray-200">
                    <button type="submit" 
                            class="bg-gradient-to-r from-cyan-500 to-green-500 text-white px-12 py-4 rounded-xl font-bold hover:shadow-2xl transition-all shadow-lg flex items-center justify-center text-lg group">
                        <i class="fas fa-check-circle mr-2 text-xl group-hover:scale-110 transition-transform"></i>
                        Registrasi Penjual
                    </button>
                    <a href="{{ route('home') }}" 
                       class="bg-white text-gray-700 px-12 py-4 rounded-xl font-bold hover:bg-gray-50 transition-all border-2 border-gray-300 flex items-center justify-center text-lg group">
                        <i class="fas fa-times-circle mr-2 text-xl group-hover:scale-110 transition-transform"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-12 mt-20 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-64 h-64 bg-cyan-500 opacity-5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-green-500 opacity-5 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4 bg-gradient-to-r from-cyan-400 to-green-400 bg-clip-text text-transparent">MartPlace</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Marketplace terpercaya untuk belanja online dengan berbagai pilihan produk berkualitas dari seller terbaik.</p>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="bg-gradient-to-r from-cyan-500 to-green-500 text-white text-xs px-3 py-1 rounded-full font-semibold">Terpercaya</span>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-lg">Tentang</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-cyan-400 transition flex items-center"><i class="fas fa-angle-right mr-2"></i>Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-cyan-400 transition flex items-center"><i class="fas fa-angle-right mr-2"></i>Karir</a></li>
                        <li><a href="#" class="hover:text-cyan-400 transition flex items-center"><i class="fas fa-angle-right mr-2"></i>Blog</a></li>
                        <li><a href="{{ route('sellers.create') }}" class="hover:text-cyan-400 transition flex items-center"><i class="fas fa-angle-right mr-2"></i>Daftar Jadi Seller</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-lg">Bantuan</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-cyan-400 transition flex items-center"><i class="fas fa-angle-right mr-2"></i>Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-cyan-400 transition flex items-center"><i class="fas fa-angle-right mr-2"></i>Cara Belanja</a></li>
                        <li><a href="#" class="hover:text-cyan-400 transition flex items-center"><i class="fas fa-angle-right mr-2"></i>Pengiriman</a></li>
                        <li><a href="#" class="hover:text-cyan-400 transition flex items-center"><i class="fas fa-angle-right mr-2"></i>Pengembalian</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-lg">Ikuti Kami</h4>
                    <p class="text-gray-400 text-sm mb-4">Dapatkan update terbaru dan promo menarik</p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-gradient-to-br hover:from-cyan-500 hover:to-green-500 rounded-lg flex items-center justify-center text-gray-300 hover:text-white transition-all">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-gradient-to-br hover:from-cyan-500 hover:to-green-500 rounded-lg flex items-center justify-center text-gray-300 hover:text-white transition-all">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-gradient-to-br hover:from-cyan-500 hover:to-green-500 rounded-lg flex items-center justify-center text-gray-300 hover:text-white transition-all">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-gradient-to-br hover:from-cyan-500 hover:to-green-500 rounded-lg flex items-center justify-center text-gray-300 hover:text-white transition-all">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-sm text-gray-400">&copy; 2025 <span class="font-bold bg-gradient-to-r from-cyan-400 to-green-400 bg-clip-text text-transparent">MartPlace</span>. All rights reserved.</p>
                    <div class="flex items-center gap-4 text-sm text-gray-400">
                        <a href="#" class="hover:text-cyan-400 transition">Kebijakan Privasi</a>
                        <span>•</span>
                        <a href="#" class="hover:text-cyan-400 transition">Syarat & Ketentuan</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>