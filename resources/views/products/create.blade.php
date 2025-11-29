@extends('layouts.master')

@section('title', 'Upload Produk Baru')

@push('styles')
<style>
    .upload-zone {
        border: 2px dashed #D2DCB6;
        transition: all 0.3s ease;
    }
    .upload-zone:hover, .upload-zone.dragover {
        border-color: #A1BC98;
        background-color: rgba(161, 188, 152, 0.1);
    }
    .image-preview {
        position: relative;
    }
    .image-preview .remove-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        background: #ef4444;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.2s;
    }
    .image-preview:hover .remove-btn {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-cream py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex items-center gap-2 text-sm text-forest/60 mb-4">
                <a href="{{ route('my-products') }}" class="hover:text-sage">Produk Saya</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-forest">Upload Produk</span>
            </nav>
            <h1 class="text-2xl md:text-3xl font-bold text-forest">Upload Produk Baru</h1>
            <p class="text-forest/60 mt-1">Lengkapi informasi produk yang ingin Anda jual</p>
        </div>

        <!-- Form -->
        <form action="{{ route('my-products.store') }}" method="POST" enctype="multipart/form-data" 
              x-data="productForm()" class="space-y-6">
            @csrf

            <!-- Photo Upload Section -->
            <div class="bg-white rounded-2xl p-6 border border-olive/20 shadow-sm">
                <h2 class="text-lg font-semibold text-forest mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Foto Produk
                    <span class="text-sm font-normal text-forest/50">(Wajib 1-3 foto)</span>
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Main Photo -->
                    <div>
                        <label class="block text-sm font-medium text-forest mb-2">
                            Foto Utama <span class="text-red-500">*</span>
                        </label>
                        <div class="upload-zone rounded-xl p-4 text-center cursor-pointer relative"
                             @click="$refs.mainPhoto.click()"
                             @dragover.prevent="$event.target.classList.add('dragover')"
                             @dragleave.prevent="$event.target.classList.remove('dragover')"
                             @drop.prevent="handleMainPhotoDrop($event)">
                            <template x-if="!mainPhotoPreview">
                                <div class="py-6">
                                    <svg class="w-12 h-12 mx-auto text-olive mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    <p class="text-sm text-forest/60">Klik atau drag foto</p>
                                    <p class="text-xs text-forest/40 mt-1">JPG, PNG (max 2MB)</p>
                                </div>
                            </template>
                            <template x-if="mainPhotoPreview">
                                <div class="image-preview">
                                    <img :src="mainPhotoPreview" class="w-full h-40 object-cover rounded-lg">
                                    <button type="button" @click.stop="removeMainPhoto()" class="remove-btn">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                        <input type="file" name="main_photo" accept="image/jpeg,image/png,image/jpg" 
                               x-ref="mainPhoto" class="hidden" @change="previewMainPhoto($event)" required>
                        @error('main_photo')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Additional Photos -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-forest mb-2">
                            Foto Tambahan <span class="text-forest/50">(opsional, max 2)</span>
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <template x-for="(photo, index) in additionalPhotos" :key="index">
                                <div class="upload-zone rounded-xl p-4 text-center cursor-pointer relative"
                                     @click="$refs['additionalPhoto' + index].click()">
                                    <template x-if="!photo.preview">
                                        <div class="py-6">
                                            <svg class="w-10 h-10 mx-auto text-olive mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            <p class="text-xs text-forest/60">Foto <span x-text="index + 2"></span></p>
                                        </div>
                                    </template>
                                    <template x-if="photo.preview">
                                        <div class="image-preview">
                                            <img :src="photo.preview" class="w-full h-32 object-cover rounded-lg">
                                            <button type="button" @click.stop="removeAdditionalPhoto(index)" class="remove-btn">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                    <input type="file" :name="'photos[]'" accept="image/jpeg,image/png,image/jpg" 
                                           :x-ref="'additionalPhoto' + index" class="hidden" 
                                           @change="previewAdditionalPhoto($event, index)">
                                </div>
                            </template>
                        </div>
                        @error('photos.*')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="bg-white rounded-2xl p-6 border border-olive/20 shadow-sm">
                <h2 class="text-lg font-semibold text-forest mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Informasi Produk
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Product Name -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-forest mb-2">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition"
                               placeholder="Contoh: Sepatu Sneakers Pria Original">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-forest mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" required
                                class="w-full px-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition bg-white">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @if($category->children->count() > 0)
                                    @foreach($category->children as $child)
                                        <option value="{{ $child->id }}" {{ old('category_id') == $child->id ? 'selected' : '' }}>
                                            &nbsp;&nbsp;└ {{ $child->name }}
                                        </option>
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Condition -->
                    <div>
                        <label class="block text-sm font-medium text-forest mb-2">Kondisi</label>
                        <select name="condition"
                                class="w-full px-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition bg-white">
                            <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Baru</option>
                            <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Bekas</option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-medium text-forest mb-2">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-forest/60">Rp</span>
                            <input type="number" name="price" value="{{ old('price') }}" required min="0"
                                   class="w-full pl-12 pr-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition"
                                   placeholder="0">
                        </div>
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label class="block text-sm font-medium text-forest mb-2">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', 1) }}" required min="0"
                               class="w-full px-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition"
                               placeholder="0">
                        @error('stock')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-sm font-medium text-forest mb-2">
                            Lokasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="location" value="{{ old('location') }}" required
                               class="w-full px-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition"
                               placeholder="Contoh: Jakarta Selatan, DKI Jakarta">
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Weight -->
                    <div>
                        <label class="block text-sm font-medium text-forest mb-2">Berat (gram)</label>
                        <input type="number" name="weight" value="{{ old('weight') }}" min="0"
                               class="w-full px-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition"
                               placeholder="100">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-forest mb-2">
                            Deskripsi Produk <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" rows="5" required
                                  class="w-full px-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition resize-none"
                                  placeholder="Jelaskan detail produk Anda, seperti spesifikasi, keunggulan, cara penggunaan, dll.">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-end">
                <a href="{{ route('my-products') }}" 
                   class="px-6 py-3 border-2 border-olive text-forest rounded-xl font-medium hover:bg-olive/10 transition text-center">
                    Batal
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-sage to-forest text-cream rounded-xl font-semibold hover:shadow-lg hover:shadow-sage/30 transition transform hover:-translate-y-0.5">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Upload Produk
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function productForm() {
    return {
        mainPhotoPreview: null,
        additionalPhotos: [
            { preview: null, file: null },
            { preview: null, file: null }
        ],
        
        previewMainPhoto(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran foto maksimal 2MB');
                    event.target.value = '';
                    return;
                }
                this.mainPhotoPreview = URL.createObjectURL(file);
            }
        },
        
        removeMainPhoto() {
            this.mainPhotoPreview = null;
            this.$refs.mainPhoto.value = '';
        },
        
        handleMainPhotoDrop(event) {
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                this.$refs.mainPhoto.files = dataTransfer.files;
                this.mainPhotoPreview = URL.createObjectURL(file);
            }
            event.target.classList.remove('dragover');
        },
        
        previewAdditionalPhoto(event, index) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran foto maksimal 2MB');
                    event.target.value = '';
                    return;
                }
                this.additionalPhotos[index].preview = URL.createObjectURL(file);
                this.additionalPhotos[index].file = file;
            }
        },
        
        removeAdditionalPhoto(index) {
            this.additionalPhotos[index].preview = null;
            this.additionalPhotos[index].file = null;
            const ref = this.$refs['additionalPhoto' + index];
            if (ref) ref.value = '';
        }
    };
}
</script>
@endpush
