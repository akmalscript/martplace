<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'slug' => 'elektronik',
                'description' => 'Produk elektronik dan gadget',
                'icon' => 'fa-laptop',
                'order' => 1
            ],
            [
                'name' => 'Fashion Pria',
                'slug' => 'fashion-pria',
                'description' => 'Pakaian dan aksesoris pria',
                'icon' => 'fa-shirt',
                'order' => 2
            ],
            [
                'name' => 'Fashion Wanita',
                'slug' => 'fashion-wanita',
                'description' => 'Pakaian dan aksesoris wanita',
                'icon' => 'fa-person-dress',
                'order' => 3
            ],
            [
                'name' => 'Handphone & Tablet',
                'slug' => 'handphone-tablet',
                'description' => 'Smartphone, tablet, dan aksesorisnya',
                'icon' => 'fa-mobile-screen',
                'order' => 4
            ],
            [
                'name' => 'Komputer & Laptop',
                'slug' => 'komputer-laptop',
                'description' => 'Komputer, laptop, dan aksesorisnya',
                'icon' => 'fa-computer',
                'order' => 5
            ],
            [
                'name' => 'Kecantikan',
                'slug' => 'kecantikan',
                'description' => 'Produk kecantikan dan perawatan',
                'icon' => 'fa-spray-can-sparkles',
                'order' => 6
            ],
            [
                'name' => 'Kesehatan',
                'slug' => 'kesehatan',
                'description' => 'Produk kesehatan dan medis',
                'icon' => 'fa-heart-pulse',
                'order' => 7
            ],
            [
                'name' => 'Hobi & Koleksi',
                'slug' => 'hobi-koleksi',
                'description' => 'Barang hobi dan koleksi',
                'icon' => 'fa-gamepad',
                'order' => 8
            ],
            [
                'name' => 'Rumah Tangga',
                'slug' => 'rumah-tangga',
                'description' => 'Perlengkapan rumah tangga',
                'icon' => 'fa-house',
                'order' => 9
            ],
            [
                'name' => 'Olahraga',
                'slug' => 'olahraga',
                'description' => 'Peralatan dan perlengkapan olahraga',
                'icon' => 'fa-dumbbell',
                'order' => 10
            ],
            [
                'name' => 'Otomotif',
                'slug' => 'otomotif',
                'description' => 'Kendaraan dan aksesoris otomotif',
                'icon' => 'fa-car',
                'order' => 11
            ],
            [
                'name' => 'Makanan & Minuman',
                'slug' => 'makanan-minuman',
                'description' => 'Makanan, minuman, dan bahan makanan',
                'icon' => 'fa-utensils',
                'order' => 12
            ],
            [
                'name' => 'Buku & Alat Tulis',
                'slug' => 'buku-alat-tulis',
                'description' => 'Buku, alat tulis, dan perlengkapan kantor',
                'icon' => 'fa-book',
                'order' => 13
            ],
            [
                'name' => 'Mainan & Bayi',
                'slug' => 'mainan-bayi',
                'description' => 'Mainan anak dan perlengkapan bayi',
                'icon' => 'fa-baby-carriage',
                'order' => 14
            ],
            [
                'name' => 'Pertukangan',
                'slug' => 'pertukangan',
                'description' => 'Alat pertukangan dan konstruksi',
                'icon' => 'fa-hammer',
                'order' => 15
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => $category['description'],
                'icon' => $category['icon'],
                'order' => $category['order'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Categories seeded successfully!');
    }
}
