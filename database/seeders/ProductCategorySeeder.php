<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    /**
     * Seed product categories based on Tokopedia categories (SRS-MartPlace-03)
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik', 'icon' => 'laptop', 'children' => ['Handphone', 'Laptop', 'Komputer', 'Kamera', 'Audio', 'TV & Monitor']],
            ['name' => 'Fashion Pria', 'icon' => 'shirt', 'children' => ['Kaos', 'Kemeja', 'Celana', 'Jaket', 'Sepatu', 'Aksesoris']],
            ['name' => 'Fashion Wanita', 'icon' => 'dress', 'children' => ['Atasan', 'Bawahan', 'Dress', 'Sepatu', 'Tas', 'Aksesoris']],
            ['name' => 'Makanan & Minuman', 'icon' => 'food', 'children' => ['Makanan Kering', 'Makanan Ringan', 'Minuman', 'Bumbu Masak', 'Makanan Instan']],
            ['name' => 'Kecantikan', 'icon' => 'beauty', 'children' => ['Skincare', 'Makeup', 'Perawatan Rambut', 'Parfum', 'Perawatan Tubuh']],
            ['name' => 'Kesehatan', 'icon' => 'health', 'children' => ['Obat-obatan', 'Vitamin', 'Alat Kesehatan', 'Suplemen']],
            ['name' => 'Rumah Tangga', 'icon' => 'home', 'children' => ['Perabotan', 'Dekorasi', 'Dapur', 'Kamar Mandi', 'Kebersihan']],
            ['name' => 'Olahraga', 'icon' => 'sports', 'children' => ['Sepeda', 'Fitness', 'Outdoor', 'Pakaian Olahraga', 'Sepatu Olahraga']],
            ['name' => 'Hobi & Koleksi', 'icon' => 'hobby', 'children' => ['Figure', 'Mainan', 'Alat Musik', 'Buku', 'Game']],
            ['name' => 'Otomotif', 'icon' => 'car', 'children' => ['Aksesoris Mobil', 'Aksesoris Motor', 'Spare Part', 'Oli & Pelumas']],
        ];

        foreach ($categories as $index => $category) {
            $parent = ProductCategory::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'icon' => $category['icon'],
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );

            if (isset($category['children'])) {
                foreach ($category['children'] as $childIndex => $childName) {
                    ProductCategory::updateOrCreate(
                        ['slug' => Str::slug($childName)],
                        [
                            'name' => $childName,
                            'parent_id' => $parent->id,
                            'sort_order' => $childIndex,
                            'is_active' => true,
                        ]
                    );
                }
            }
        }
    }
}
