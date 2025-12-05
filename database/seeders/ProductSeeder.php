<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category IDs
        $elektronik = DB::table('categories')->where('slug', 'elektronik')->first()->id;
        $handphone = DB::table('categories')->where('slug', 'handphone-tablet')->first()->id;
        $komputer = DB::table('categories')->where('slug', 'komputer-laptop')->first()->id;
        $fashionPria = DB::table('categories')->where('slug', 'fashion-pria')->first()->id;
        $fashionWanita = DB::table('categories')->where('slug', 'fashion-wanita')->first()->id;
        $rumahTangga = DB::table('categories')->where('slug', 'rumah-tangga')->first()->id;
        $olahraga = DB::table('categories')->where('slug', 'olahraga')->first()->id;
        $makanan = DB::table('categories')->where('slug', 'makanan-minuman')->first()->id;

        $products = [
            // Seller 1 - Elektronik
            [
                'seller_id' => 1,
                'category_id' => $komputer,
                'name' => 'Gaming Laptop RTX 4060 16GB RAM 512GB SSD',
                'description' => 'Laptop gaming dengan prosesor Intel Core i7 Gen 13, RTX 4060 8GB, RAM 16GB DDR5, layar 15.6" 144Hz',
                'price' => 15999000,
                'stock' => 15,
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Pusat',
            ],
            [
                'seller_id' => 1,
                'category_id' => $handphone,
                'name' => 'iPhone 15 Pro Max 256GB Titanium Blue',
                'description' => 'iPhone terbaru dengan chip A17 Pro, kamera 48MP, USB-C, garansi resmi iBox 1 tahun',
                'price' => 21999000,
                'stock' => 25,
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Selatan',
            ],
            [
                'seller_id' => 1,
                'category_id' => $handphone,
                'name' => 'Samsung Galaxy S24 Ultra 512GB Black',
                'description' => 'Flagship Samsung dengan S-Pen, kamera 200MP, Snapdragon 8 Gen 3, garansi resmi SEIN',
                'price' => 18999000,
                'stock' => 1,
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Barat',
            ],
            [
                'seller_id' => 1,
                'category_id' => $elektronik,
                'name' => 'Smart TV 55 Inch 4K Android TV',
                'description' => 'Smart TV dengan teknologi QLED, HDR10+, Dolby Atmos, built-in Chromecast',
                'price' => 7999000,
                'stock' => 8,
                'province' => 'Jawa Barat',
                'city' => 'Bandung',
            ],
            [
                'seller_id' => 1,
                'category_id' => $komputer,
                'name' => 'Mechanical Gaming Keyboard RGB',
                'description' => 'Keyboard mekanik dengan switch Blue, RGB backlight, anti-ghosting',
                'price' => 899000,
                'stock' => 0,
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Timur',
            ],
            [
                'seller_id' => 1,
                'category_id' => $elektronik,
                'name' => 'Wireless Earbuds ANC Premium',
                'description' => 'TWS dengan Active Noise Cancellation, battery life 30 jam',
                'price' => 1299000,
                'stock' => 18,
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Pusat',
            ],
            [
                'seller_id' => 1,
                'category_id' => $komputer,
                'name' => 'MacBook Air M3 8GB 256GB',
                'description' => 'MacBook Air dengan chip M3 terbaru, layar Liquid Retina 13.6"',
                'price' => 17999000,
                'stock' => 20,
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Selatan',
            ],
            [
                'seller_id' => 1,
                'category_id' => $elektronik,
                'name' => 'Sony WH-1000XM5 Wireless ANC',
                'description' => 'Headphone premium dengan ANC terbaik, battery 30 jam',
                'price' => 4999000,
                'stock' => 12,
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Pusat',
            ],
            [
                'seller_id' => 1,
                'category_id' => $handphone,
                'name' => 'iPad Pro M2 11 128GB WiFi',
                'description' => 'iPad Pro dengan chip M2, layar Liquid Retina 11"',
                'price' => 13999000,
                'stock' => 10,
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Selatan',
            ],
            [
                'seller_id' => 1,
                'category_id' => $elektronik,
                'name' => 'Apple Watch Series 9 GPS 45mm',
                'description' => 'Smartwatch dengan chip S9, Always-On Retina display',
                'price' => 7999000,
                'stock' => 15,
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Pusat',
            ],

            // Seller 2 - Fashion
            [
                'seller_id' => 2,
                'category_id' => $fashionPria,
                'name' => 'Kemeja Batik Premium Pria Lengan Panjang',
                'description' => 'Kemeja batik tulis halus, bahan katun premium',
                'price' => 450000,
                'stock' => 30,
                'province' => 'Jawa Tengah',
                'city' => 'Solo',
                'has_variants' => true,
            ],
            [
                'seller_id' => 2,
                'category_id' => $fashionWanita,
                'name' => 'Dress Casual Wanita Modern',
                'description' => 'Dress casual dengan bahan adem, nyaman untuk sehari-hari',
                'price' => 350000,
                'stock' => 1,
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Selatan',
                'has_variants' => true,
            ],
            [
                'seller_id' => 2,
                'category_id' => $fashionPria,
                'name' => 'Sepatu Sneakers Sport Pria',
                'description' => 'Sepatu olahraga dengan teknologi air cushion',
                'price' => 550000,
                'stock' => 20,
                'province' => 'Jawa Barat',
                'city' => 'Bogor',
                'has_variants' => true,
            ],
            [
                'seller_id' => 2,
                'category_id' => $fashionWanita,
                'name' => 'Tas Wanita Kulit Premium',
                'description' => 'Tas kulit asli dengan design elegant',
                'price' => 850000,
                'stock' => 1,
                'province' => 'Jawa Barat',
                'city' => 'Bandung',
            ],
            [
                'seller_id' => 2,
                'category_id' => $fashionPria,
                'name' => 'Jaket Hoodie Premium Pria',
                'description' => 'Jaket hoodie dengan bahan fleece lembut',
                'price' => 320000,
                'stock' => 25,
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Timur',
                'has_variants' => true,
            ],

            // Seller 3 - Rumah Tangga
            [
                'seller_id' => 3,
                'category_id' => $rumahTangga,
                'name' => 'Rice Cooker Digital 2 Liter',
                'description' => 'Rice cooker dengan kontrol digital, 12 menu masak',
                'price' => 899000,
                'stock' => 12,
                'province' => 'Jawa Timur',
                'city' => 'Surabaya',
            ],
            [
                'seller_id' => 3,
                'category_id' => $rumahTangga,
                'name' => 'Blender 2 in 1 Multifungsi',
                'description' => 'Blender dengan chopper, pisau stainless steel',
                'price' => 350000,
                'stock' => 0,
                'province' => 'Jawa Barat',
                'city' => 'Depok',
            ],
            [
                'seller_id' => 3,
                'category_id' => $rumahTangga,
                'name' => 'Set Panci Masak Stainless Steel 5 Pcs',
                'description' => 'Set panci stainless steel premium, tahan karat',
                'price' => 1250000,
                'stock' => 5,
                'province' => 'Bali',
                'city' => 'Denpasar',
            ],
            [
                'seller_id' => 3,
                'category_id' => $rumahTangga,
                'name' => 'Dispenser Air Galon Bottom Loading',
                'description' => 'Dispenser dengan galon di bawah, panas-dingin',
                'price' => 1650000,
                'stock' => 6,
                'province' => 'Jawa Timur',
                'city' => 'Sidoarjo',
            ],
            [
                'seller_id' => 3,
                'category_id' => $rumahTangga,
                'name' => 'Vacuum Cleaner 2 in 1 Wireless',
                'description' => 'Vacuum cleaner tanpa kabel, 2 mode cleaning',
                'price' => 1899000,
                'stock' => 8,
                'province' => 'Bali',
                'city' => 'Badung',
            ],

            // Seller 4 - Olahraga
            [
                'seller_id' => 4,
                'category_id' => $olahraga,
                'name' => 'Dumbbell Set 20kg Adjustable',
                'description' => 'Set dumbbell adjustable dengan coating rubber',
                'price' => 550000,
                'stock' => 8,
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Utara',
            ],
            [
                'seller_id' => 4,
                'category_id' => $olahraga,
                'name' => 'Matras Yoga Premium Anti Slip',
                'description' => 'Matras yoga dengan ketebalan 8mm, anti slip',
                'price' => 250000,
                'stock' => 1,
                'province' => 'Bali',
                'city' => 'Badung',
            ],
            [
                'seller_id' => 4,
                'category_id' => $olahraga,
                'name' => 'Sepeda Lipat 20 Inch 7 Speed',
                'description' => 'Sepeda lipat aluminium alloy, ringan',
                'price' => 2850000,
                'stock' => 3,
                'province' => 'Jawa Barat',
                'city' => 'Bekasi',
            ],
            [
                'seller_id' => 4,
                'category_id' => $olahraga,
                'name' => 'Treadmill Electric 3 HP Motor',
                'description' => 'Treadmill elektrik dengan motor 3 HP, LCD display',
                'price' => 6500000,
                'stock' => 4,
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Selatan',
            ],
            [
                'seller_id' => 4,
                'category_id' => $olahraga,
                'name' => 'Resistance Band Set 5 Level',
                'description' => 'Set resistance band 5 tingkat resistensi',
                'price' => 150000,
                'stock' => 30,
                'province' => 'Bali',
                'city' => 'Denpasar',
            ],

            // Seller 5 - Makanan & Minuman
            [
                'seller_id' => 5,
                'category_id' => $makanan,
                'name' => 'Kopi Arabica Premium 250gr',
                'description' => 'Kopi arabica pilihan dari pegunungan Jawa',
                'price' => 85000,
                'stock' => 50,
                'province' => 'Jawa Tengah',
                'city' => 'Semarang',
            ],
            [
                'seller_id' => 5,
                'category_id' => $makanan,
                'name' => 'Paket Snack Box Sehat 10 Pcs',
                'description' => 'Paket snack sehat dengan kemasan higienis',
                'price' => 150000,
                'stock' => 20,
                'province' => 'Jawa Timur',
                'city' => 'Malang',
            ],
            [
                'seller_id' => 5,
                'category_id' => $makanan,
                'name' => 'Madu Hutan Murni 500ml',
                'description' => 'Madu hutan asli tanpa campuran, 100% natural',
                'price' => 175000,
                'stock' => 0,
                'province' => 'Jawa Tengah',
                'city' => 'Yogyakarta',
            ],
            [
                'seller_id' => 5,
                'category_id' => $makanan,
                'name' => 'Keripik Singkong Rasa Original 500gr',
                'description' => 'Keripik singkong renyah dengan bumbu pilihan',
                'price' => 45000,
                'stock' => 100,
                'province' => 'Jawa Timur',
                'city' => 'Malang',
            ],
            [
                'seller_id' => 5,
                'category_id' => $makanan,
                'name' => 'Teh Hijau Organik 100 Sachet',
                'description' => 'Teh hijau organik tanpa pengawet',
                'price' => 120000,
                'stock' => 40,
                'province' => 'Jawa Tengah',
                'city' => 'Semarang',
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'seller_id' => $product['seller_id'],
                'category_id' => $product['category_id'],
                'name' => $product['name'],
                'slug' => Str::slug($product['name']) . '-' . uniqid(),
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'province' => $product['province'],
                'city' => $product['city'],
                'has_variants' => $product['has_variants'] ?? false,
                'min_order' => 1,
                'max_order' => 100,
                'is_active' => true,
                'average_rating' => 0,
                'total_reviews' => 0,
            ]);
        }

        $this->command->info('30 products seeded successfully!');
    }
}
