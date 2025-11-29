@extends('layouts.master')

@section('title', 'Edit Produk')

@push('styles')
<style>
    .upload-zone {
        border: 2px dashed #D2DCB6;
        transition: all 0.3s ease;
    }
    .upload-zone:hover {
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
                <span class="text-forest">Edit Produk</span>
            </nav>
            <h1 class="text-2xl md:text-3xl font-bold text-forest">Edit Produk</h1>
            <p class="text-forest/60 mt-1">Perbarui informasi produk Anda</p>
        </div>

        <!-- Form -->
        <form action="{{ route('my-products.update', $product->id) }}" method="POST" enctype="multipart/form-data" 
              x-data="editProductForm()" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Current Photos -->
            <div class="bg-white rounded-2xl p-6 border border-olive/20 shadow-sm">
                <h2 class="text-lg font-semibold text-forest mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Foto Produk Saat Ini
                </h2>
                
                @if($product->main_photo || ($product->photos && count($product->photos) > 0))
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4">
                        @if($product->main_photo)
                            <div class="relative">
                                <span class="absolute top-2 left-2 bg-sage text-cream px-2 py-1 rounded text-xs font-medium z-10">Utama</span>
                                <img src="{{ asset('storage/' . $product->main_photo) }}" 
                                     class="w-full aspect-square object-cover rounded-xl border-2 border-sage">
                            </div>
                        @endif
                        @if($product->photos)
                            @foreach($product->photos as $photo)
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $photo) }}" 
                                         class="w-full aspect-square object-cover rounded-xl border border-olive/20">
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- New Main Photo -->
                    <div>
                        <label class="block text-sm font-medium text-forest mb-2">
                            Ganti Foto Utama <span class="text-forest/50">(opsional)</span>
                        </label>
                        <div class="upload-zone rounded-xl p-4 text-center cursor-pointer"
                             @click="$refs.mainPhoto.click()">
                            <template x-if="!mainPhotoPreview">
                                <div class="py-4">
                                    <svg class="w-10 h-10 mx-auto text-olive mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    <p class="text-sm text-forest/60">Klik untuk upload foto baru</p>
                                </div>
                            </template>
                            <template x-if="mainPhotoPreview">
                                <div class="image-preview">
                                    <img :src="mainPhotoPreview" class="w-full h-32 object-cover rounded-lg">
                                    <button type="button" @click.stop="removeMainPhoto()" class="remove-btn">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                        <input type="file" name="main_photo" accept="image/jpeg,image/png,image/jpg" 
                               x-ref="mainPhoto" class="hidden" @change="previewMainPhoto($event)">
                    </div>

                    <!-- Additional Photos -->
                    <div>
                        <label class="block text-sm font-medium text-forest mb-2">
                            Tambah Foto Lainnya <span class="text-forest/50">(opsional)</span>
                        </label>
                        <div class="upload-zone rounded-xl p-4 text-center cursor-pointer"
                             @click="$refs.additionalPhotos.click()">
                            <div class="py-4">
                                <svg class="w-10 h-10 mx-auto text-olive mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <p class="text-sm text-forest/60">Tambah foto lainnya</p>
                            </div>
                        </div>
                        <input type="file" name="photos[]" accept="image/jpeg,image/png,image/jpg" multiple
                               x-ref="additionalPhotos" class="hidden">
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
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                               class="w-full px-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition">
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
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @if($category->children->count() > 0)
                                    @foreach($category->children as $child)
                                        <option value="{{ $child->id }}" {{ old('category_id', $product->category_id) == $child->id ? 'selected' : '' }}>
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
                            <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>Baru</option>
                            <option value="used" {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>Bekas</option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-medium text-forest mb-2">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-forest/60">Rp</span>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0"
                                   class="w-full pl-12 pr-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition">
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
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                               class="w-full px-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition">
                        @error('stock')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-sm font-medium text-forest mb-2">
                            Lokasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="location" value="{{ old('location', $product->location) }}" required
                               class="w-full px-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition">
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Weight -->
                    <div>
                        <label class="block text-sm font-medium text-forest mb-2">Berat (gram)</label>
                        <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" min="0"
                               class="w-full px-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-forest mb-2">
                            Deskripsi Produk <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" rows="5" required
                                  class="w-full px-4 py-3 border border-olive rounded-xl focus:outline-none focus:border-sage focus:ring-2 focus:ring-sage/20 transition resize-none">{{ old('description', $product->description) }}</textarea>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function editProductForm() {
    return {
        mainPhotoPreview: null,
        
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
        }
    };
}
</script>
@endpush
