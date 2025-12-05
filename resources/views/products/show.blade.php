<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - MartPlace</title>
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
        @keyframes pulse-ring {
            0% { transform: scale(0.95); opacity: 1; }
            50% { transform: scale(1); opacity: 0.7; }
            100% { transform: scale(0.95); opacity: 1; }
        }
        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }
        .icon-float {
            animation: float 3s ease-in-out infinite;
        }
        .pulse-ring {
            animation: pulse-ring 2s ease-in-out infinite;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 via-cyan-50 to-green-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50 border-b-2 border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-green-500 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all group-hover:scale-105">
                            <i class="fas fa-shopping-bag text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-cyan-600 to-green-600 bg-clip-text text-transparent">
                            MartPlace
                        </span>
                    </a>
                </div>

                <div class="flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="flex items-center text-gray-700 hover:text-cyan-600 font-semibold transition-all hover:scale-105">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                    <a href="{{ route('products.index') }}" class="flex items-center text-gray-700 hover:text-cyan-600 font-semibold transition-all hover:scale-105">
                        <i class="fas fa-box mr-2"></i>Produk
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Breadcrumb -->
        <nav class="flex items-center mb-8 text-sm">
            <a href="{{ route('home') }}" class="flex items-center text-gray-600 hover:text-cyan-600 transition-all">
                <i class="fas fa-home mr-1"></i>Beranda
            </a>
            <i class="fas fa-chevron-right mx-3 text-gray-400 text-xs"></i>
            <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-cyan-600 transition-all">Produk</a>
            <i class="fas fa-chevron-right mx-3 text-gray-400 text-xs"></i>
            <span class="font-semibold bg-gradient-to-r from-cyan-600 to-green-600 bg-clip-text text-transparent">{{ $product->name }}</span>
        </nav>

        <!-- Product Detail -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">

            <!-- Image Section -->
            <div class="relative">
                <!-- Main Image Display -->
                <div class="glass-effect rounded-2xl overflow-hidden shadow-2xl border-2 border-white relative group mb-4">
                    @if($product->images && $product->images->count() > 0)
                        <img id="mainProductImage" 
                             src="{{ $product->images->first()->image_url }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-auto"
                             onerror="this.src='https://via.placeholder.com/600x600/E5E5E5/999999?text=No+Image'">
                    @else
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-auto"
                             onerror="this.src='https://via.placeholder.com/600x600/E5E5E5/999999?text=No+Image'">
                    @endif
                    
                    <!-- Gradient Overlay on Hover -->
                    <div class="absolute inset-0 bg-gradient-to-t from-cyan-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                    
                    <!-- Navigation Arrows (if multiple images) -->
                    @if($product->images && $product->images->count() > 1)
                        <button onclick="navigateImage(-1)" 
                                class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-3 shadow-lg transition-all hover:scale-110 z-10">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button onclick="navigateImage(1)" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-3 shadow-lg transition-all hover:scale-110 z-10">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        
                        <!-- Image Counter -->
                        <div class="absolute bottom-3 right-3 bg-black/50 text-white px-3 py-1 rounded-full text-sm">
                            <span id="imageCounter">1</span> / {{ $product->images->count() }}
                        </div>
                    @endif
                </div>
                
                <!-- Thumbnail Gallery -->
                @if($product->images && $product->images->count() > 1)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($product->images as $index => $image)
                            <div onclick="changeImage({{ $index }}, '{{ $image->image_url }}')"
                                 id="thumbnail-{{ $index }}"
                                 class="cursor-pointer rounded-lg overflow-hidden transition-all hover:scale-105 hover:ring-4 hover:ring-cyan-400 {{ $index === 0 ? 'ring-4 ring-cyan-500 scale-105' : 'ring-2 ring-gray-200' }}">
                                <img src="{{ $image->image_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-20 object-cover"
                                     onerror="this.src='https://via.placeholder.com/100x100/E5E5E5/999999?text=No+Image'">
                            </div>
                        @endforeach
                    </div>
                    
                    <script>
                        let currentImageIndex = 0;
                        const images = @json($product->images->pluck('image_path')->values());
                        const totalImages = images.length;
                        
                        function changeImage(index, imageUrl) {
                            currentImageIndex = index;
                            document.getElementById('mainProductImage').src = imageUrl;
                            document.getElementById('imageCounter').textContent = index + 1;
                            
                            // Update thumbnail styles
                            for (let i = 0; i < totalImages; i++) {
                                const thumb = document.getElementById('thumbnail-' + i);
                                if (i === index) {
                                    thumb.className = 'cursor-pointer rounded-lg overflow-hidden transition-all hover:scale-105 hover:ring-4 hover:ring-cyan-400 ring-4 ring-cyan-500 scale-105';
                                } else {
                                    thumb.className = 'cursor-pointer rounded-lg overflow-hidden transition-all hover:scale-105 hover:ring-4 hover:ring-cyan-400 ring-2 ring-gray-200';
                                }
                            }
                        }
                        
                        function navigateImage(direction) {
                            currentImageIndex = (currentImageIndex + direction + totalImages) % totalImages;
                            changeImage(currentImageIndex, images[currentImageIndex]);
                        }
                    </script>
                @endif
            </div>

            <!-- Product Info Section -->
            <div class="glass-effect rounded-3xl p-6 shadow-2xl border-2 border-white relative overflow-hidden">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-cyan-200 to-green-200 rounded-full opacity-20 blur-3xl"></div>
                
                <div class="relative z-10">
                    <!-- Category Badge -->
                    @if($product->category)
                        <div class="inline-block mb-4">
                            <span class="bg-gradient-to-r from-cyan-500 to-green-500 text-white px-4 py-1.5 rounded-full text-sm font-semibold shadow-lg">
                                <i class="fas fa-tag mr-2"></i>{{ $product->category->name }}
                            </span>
                        </div>
                    @endif

                    <h1 class="text-2xl md:text-3xl font-bold mb-4 leading-tight">
                        <span class="bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">{{ $product->name }}</span>
                    </h1>

                    <!-- Rating & Reviews -->
                    <div class="flex items-center space-x-4 mb-4 p-3 bg-white rounded-xl shadow-md">
                        <div class="flex items-center">
                            <div class="flex mr-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= round($product->average_rating) ? 'text-yellow-400' : 'text-gray-300' }} text-lg"></i>
                                @endfor
                            </div>
                            <span class="text-xl font-bold bg-gradient-to-r from-cyan-600 to-green-600 bg-clip-text text-transparent">
                                {{ number_format($product->average_rating, 1) }}
                            </span>
                        </div>
                        <div class="h-6 w-px bg-gray-300"></div>
                        <div class="flex items-center">
                            <i class="fas fa-comments text-cyan-500 mr-2"></i>
                            <span class="text-gray-700 font-semibold">{{ $product->total_reviews }} ulasan</span>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="mb-4 p-4 bg-gradient-to-r from-cyan-500 to-green-500 rounded-xl shadow-xl">
                        <div class="text-xs text-white opacity-90 mb-1">Harga</div>
                        <div class="text-3xl font-bold text-white">
                            {{ $product->formatted_price }}
                        </div>
                    </div>

                    <!-- Seller Info -->
                    @if($product->seller)
                        <div class="mb-4 p-4 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl border-2 border-purple-200">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-store text-white"></i>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-600 mb-1">Dijual oleh</div>
                                    <div class="font-bold text-gray-800">{{ $product->seller->store_name }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Description -->
                    @if ($product->description)
                        <div class="p-4 bg-white rounded-xl shadow-md">
                            <h3 class="font-semibold text-gray-800 mb-2 flex items-center text-sm">
                                <i class="fas fa-info-circle text-cyan-500 mr-2"></i>Deskripsi Produk
                            </h3>
                            <p class="text-gray-700 leading-relaxed text-sm">{{ $product->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Review Form Section -->
        <div class="mt-12 glass-effect rounded-2xl p-6 shadow-2xl border-2 border-white relative overflow-hidden"
             x-data="reviewForm()">
             
            <!-- Decorative Background -->
            <div class="absolute top-0 left-0 w-64 h-64 bg-gradient-to-br from-purple-200 to-pink-200 rounded-full opacity-20 blur-3xl"></div>

            <div class="relative z-10">
                <div class="text-center mb-6">
                    <div class="inline-block bg-gradient-to-r from-purple-500 to-pink-500 text-white px-4 py-2 rounded-full text-xs font-semibold shadow-lg mb-3">
                        <i class="fas fa-star mr-2"></i>Beri Ulasan
                    </div>
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Bagikan Pengalaman Anda</h2>
                    <p class="text-gray-600 mt-1 text-sm">Ulasan Anda sangat berarti bagi pembeli lainnya</p>
                </div>

                <form @submit.prevent="validateForm" action="{{ route('reviews.store', $product->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1.5 flex items-center text-sm">
                                <i class="fas fa-user text-cyan-500 mr-2 text-xs"></i>Nama Lengkap
                            </label>
                            <input type="text" name="name"
                                   x-model="name"
                                   :class="errors.name ? 'border-red-500' : 'border-gray-300'"
                                   class="w-full border-2 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all text-sm"
                                   placeholder="Masukkan nama Anda">
                            <p class="text-red-500 text-xs mt-1" x-show="errors.name"><i class="fas fa-exclamation-circle mr-1"></i>Nama wajib diisi</p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1.5 flex items-center text-sm">
                                <i class="fas fa-envelope text-cyan-500 mr-2 text-xs"></i>Email
                            </label>
                            <input type="email" name="email"
                                   x-model="email"
                                   :class="errors.email ? 'border-red-500' : 'border-gray-300'"
                                   class="w-full border-2 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all text-sm"
                                   placeholder="contoh@email.com">
                            <p class="text-red-500 text-xs mt-1" x-show="errors.email"><i class="fas fa-exclamation-circle mr-1"></i>Email wajib diisi</p>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1.5 flex items-center text-sm">
                                <i class="fas fa-phone text-cyan-500 mr-2 text-xs"></i>No. Telepon
                            </label>
                            <input type="text" name="phone"
                                   x-model="phone"
                                   :class="errors.phone ? 'border-red-500' : 'border-gray-300'"
                                   class="w-full border-2 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all text-sm"
                                   placeholder="08123456789">
                            <p class="text-red-500 text-xs mt-1" x-show="errors.phone"><i class="fas fa-exclamation-circle mr-1"></i>Nomor telepon wajib diisi</p>
                        </div>

                        <!-- Province -->
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1.5 flex items-center text-sm">
                                <i class="fas fa-map-marker-alt text-cyan-500 mr-2 text-xs"></i>Provinsi
                            </label>
                            <select name="province"
                                    x-model="province"
                                    :class="errors.province ? 'border-red-500' : 'border-gray-300'"
                                    class="w-full border-2 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all text-sm">
                                <option value="" selected disabled>Pilih provinsi...</option>
                                <template x-for="prov in provinces" :key="prov.code">
                                    <option :value="prov.name" x-text="prov.name"></option>
                                </template>
                            </select>
                            <p class="text-red-500 text-xs mt-1" x-show="errors.province"><i class="fas fa-exclamation-circle mr-1"></i>Provinsi wajib dipilih</p>
                        </div>
                    </div>

                    <!-- Rating Stars -->
                    <div class="p-4 bg-white rounded-xl shadow-md">
                        <label class="block font-semibold text-gray-700 mb-3 flex items-center justify-center">
                            <i class="fas fa-star text-yellow-400 mr-2"></i>Berikan Rating
                        </label>
                        <div class="flex justify-center space-x-2 mb-2">
                            <template x-for="star in [1,2,3,4,5]" :key="star">
                                <button type="button" @click="rating = star"
                                     :class="rating >= star ? 'text-yellow-400 scale-110' : 'text-gray-300'"
                                     class="transform transition-all hover:scale-125">
                                    <i class="fas fa-star text-3xl"></i>
                                </button>
                            </template>
                        </div>
                        <p class="text-center text-gray-600 text-xs" x-show="rating > 0">
                            Anda memberikan <span class="font-bold text-cyan-600" x-text="rating"></span> bintang
                        </p>
                        <p class="text-red-500 text-xs text-center mt-2" x-show="errors.rating"><i class="fas fa-exclamation-circle mr-1"></i>Rating wajib dipilih</p>
                        <input type="hidden" name="rating" :value="rating">
                    </div>

                    <!-- Comment -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1.5 flex items-center text-sm">
                            <i class="fas fa-comment-dots text-cyan-500 mr-2 text-xs"></i>Komentar (opsional)
                        </label>
                        <textarea name="comment" rows="4"
                                  class="w-full border-2 border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all text-sm"
                                  placeholder="Ceritakan pengalaman Anda dengan produk ini..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-cyan-500 to-green-500 text-white px-6 py-3 rounded-lg font-bold hover:shadow-2xl transition-all flex items-center justify-center group">
                        <i class="fas fa-paper-plane mr-2 group-hover:translate-x-1 transition-transform"></i>
                        Kirim Ulasan
                    </button>
                </form>
            </div>
        </div>

        <!-- Reviews Display Section -->
        <div class="mt-12">
            @if ($product->reviews && $product->reviews->count() > 0)
                <div class="text-center mb-6">
                    <div class="inline-block bg-gradient-to-r from-cyan-500 to-green-500 text-white px-4 py-2 rounded-full text-xs font-semibold shadow-lg mb-3">
                        <i class="fas fa-comments mr-2"></i>{{ $product->reviews->count() }} Ulasan
                    </div>
                    <h3 class="text-2xl font-bold bg-gradient-to-r from-cyan-600 to-green-600 bg-clip-text text-transparent">Ulasan Pembeli</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($product->reviews as $review)
                        <div class="glass-effect rounded-xl p-4 shadow-xl border-2 border-white hover:shadow-2xl transition-all hover:-translate-y-1">
                            
                            <!-- User Avatar & Info -->
                            <div class="flex items-start gap-3 mb-3">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold shadow-lg">
                                        {{ strtoupper(substr($review->name, 0, 1)) }}
                                    </div>
                                </div>
                                
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-800">{{ $review->name }}</h4>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <i class="fas fa-map-marker-alt text-purple-500 text-xs"></i>
                                        <span class="text-xs text-gray-600">{{ $review->province ?? 'Indonesia' }}</span>
                                    </div>
                                </div>

                                <!-- Date Badge -->
                                <div class="text-right">
                                    <span class="inline-block bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold">
                                        <i class="far fa-calendar-alt mr-1"></i>{{ $review->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Rating Stars -->
                            <div class="flex items-center gap-1 mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-yellow-400"></i>
                                    @else
                                        <i class="fas fa-star text-gray-300"></i>
                                    @endif
                                @endfor
                                <span class="ml-2 font-bold text-gray-700 text-sm">{{ number_format($review->rating, 1) }}</span>
                            </div>

                            <!-- Comment -->
                            @if($review->comment)
                                <div class="bg-white rounded-lg p-3 shadow-inner">
                                    <p class="text-gray-700 leading-relaxed text-sm">
                                        <i class="fas fa-quote-left text-cyan-400 mr-1 text-xs"></i>{{ $review->comment }}<i class="fas fa-quote-right text-cyan-400 ml-1 text-xs"></i>
                                    </p>
                                </div>
                            @else
                                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-3 text-center">
                                    <p class="text-gray-500 italic text-xs">
                                        <i class="fas fa-check-circle text-green-500 mr-1"></i>Pembeli tidak memberikan komentar
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="glass-effect rounded-2xl p-8 text-center shadow-2xl border-2 border-white">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-comment-slash text-gray-500 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Ulasan</h3>
                    <p class="text-gray-600 max-w-md mx-auto">
                        Jadilah yang pertama memberikan ulasan untuk produk ini dan bantu pembeli lainnya membuat keputusan yang tepat!
                    </p>
                </div>
            @endif
        </div>

    </div>

    <!-- Footer -->
    <footer class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white mt-20 overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-cyan-500 opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-green-500 opacity-10 rounded-full blur-3xl"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                
                <!-- Brand Column -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-green-500 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-store text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold bg-gradient-to-r from-cyan-400 to-green-400 bg-clip-text text-transparent">
                            MartPlace
                        </h3>
                    </div>
                    <p class="text-gray-400 leading-relaxed">
                        Platform marketplace terpercaya untuk jual beli produk berkualitas dengan harga terbaik.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-gradient-to-br hover:from-cyan-500 hover:to-green-500 rounded-lg flex items-center justify-center transition-all">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-gradient-to-br hover:from-cyan-500 hover:to-green-500 rounded-lg flex items-center justify-center transition-all">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-gradient-to-br hover:from-cyan-500 hover:to-green-500 rounded-lg flex items-center justify-center transition-all">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-gradient-to-br hover:from-cyan-500 hover:to-green-500 rounded-lg flex items-center justify-center transition-all">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <!-- Layanan Column -->
                <div>
                    <h4 class="text-lg font-bold mb-6 bg-gradient-to-r from-cyan-400 to-green-400 bg-clip-text text-transparent">
                        Layanan
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors flex items-center gap-2">
                            <i class="fas fa-chevron-right text-xs"></i>Cara Berbelanja
                        </a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors flex items-center gap-2">
                            <i class="fas fa-chevron-right text-xs"></i>Cara Berjualan
                        </a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors flex items-center gap-2">
                            <i class="fas fa-chevron-right text-xs"></i>Lacak Pesanan
                        </a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors flex items-center gap-2">
                            <i class="fas fa-chevron-right text-xs"></i>Bantuan
                        </a></li>
                    </ul>
                </div>

                <!-- Tentang Column -->
                <div>
                    <h4 class="text-lg font-bold mb-6 bg-gradient-to-r from-cyan-400 to-green-400 bg-clip-text text-transparent">
                        Tentang Kami
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors flex items-center gap-2">
                            <i class="fas fa-chevron-right text-xs"></i>Tentang MartPlace
                        </a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors flex items-center gap-2">
                            <i class="fas fa-chevron-right text-xs"></i>Karir
                        </a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors flex items-center gap-2">
                            <i class="fas fa-chevron-right text-xs"></i>Blog
                        </a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors flex items-center gap-2">
                            <i class="fas fa-chevron-right text-xs"></i>Kebijakan Privasi
                        </a></li>
                    </ul>
                </div>

                <!-- Kontak Column -->
                <div>
                    <h4 class="text-lg font-bold mb-6 bg-gradient-to-r from-cyan-400 to-green-400 bg-clip-text text-transparent">
                        Hubungi Kami
                    </h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3 text-gray-400">
                            <i class="fas fa-map-marker-alt text-cyan-400 mt-1"></i>
                            <span>Jl. Contoh No. 123<br>Jakarta, Indonesia</span>
                        </li>
                        <li class="flex items-center gap-3 text-gray-400">
                            <i class="fas fa-phone text-cyan-400"></i>
                            <span>+62 812 3456 7890</span>
                        </li>
                        <li class="flex items-center gap-3 text-gray-400">
                            <i class="fas fa-envelope text-cyan-400"></i>
                            <span>info@martplace.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-700 pt-8 text-center">
                <p class="text-gray-400">
                    &copy; 2025 <span class="bg-gradient-to-r from-cyan-400 to-green-400 bg-clip-text text-transparent font-semibold">MartPlace</span>. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- ============================= -->
    <!-- ALPINE.JS VALIDATION SCRIPT -->
    <!-- ============================= -->
    <script>
        function reviewForm() {
            return {
                name: '',
                email: '',
                phone: '',
                province: '',
                rating: 0,
                provinces: [],
                errors: {},

                init() {
                    fetch('/api/wilayah/provinces')
                        .then(res => res.json())
                        .then(json => this.provinces = json.data);
                },

                validateForm(event) {
                    this.errors = {};

                    if (!this.name) this.errors.name = true;
                    if (!this.email) this.errors.email = true;
                    if (!this.phone) this.errors.phone = true;
                    if (!this.province) this.errors.province = true;
                    if (this.rating === 0) this.errors.rating = true;

                    if (Object.keys(this.errors).length === 0) {
                        event.target.submit();
                    }
                }
            }
        }
    </script>

</body>
</html>
