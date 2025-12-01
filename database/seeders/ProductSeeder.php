<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Seller;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Map category names to their IDs
        $categoryMap = [];
        $categories = ProductCategory::all();
        foreach ($categories as $category) {
            $categoryMap[$category->name] = $category->id;
        }

        $products = [
            [
                'name' => 'Premium Wireless Headphones with Noise Cancellation',
                'description' => 'Headphone wireless premium dengan noise cancellation aktif, baterai tahan hingga 30 jam',
                'price' => 899000,
                'original_price' => 2000000,
                'stock' => 50,
                'image_url' => 'https://placehold.co/200x200/FFD93D/000000?text=Headphone',
                'category_name' => 'Elektronik',
                'location' => 'Jakarta Pusat',
                'discount_percentage' => 16,
                'badge' => 'Best Seller',
                'is_active' => true,
            ],
            [
                'name' => 'Luxury Smart Watch Series 8 - GPS + Cellular',
                'description' => 'Smartwatch mewah dengan GPS dan Cellular, monitoring kesehatan lengkap',
                'price' => 2499000,
                'original_price' => 3500000,
                'stock' => 30,
                'image_url' => 'https://placehold.co/200x200/E5E5E5/000000?text=Smartwatch',
                'category_name' => 'Elektronik',
                'location' => 'Jakarta Selatan',
                'discount_percentage' => 30,
                'badge' => 'Terkirim cepat',
                'is_active' => true,
            ],
            [
                'name' => 'Designer Sunglasses UV Protection Premium Quality',
                'description' => 'Kacamata hitam designer dengan proteksi UV, lensa polarized',
                'price' => 349000,
                'original_price' => 500000,
                'stock' => 100,
                'image_url' => 'https://placehold.co/200x200/1A1A1A/FFFFFF?text=Sunglasses',
                'category_name' => 'Fashion Pria',
                'location' => 'Kab. Bandung',
                'discount_percentage' => 20,
                'badge' => 'Mall',
                'is_active' => true,
            ],
            [
                'name' => 'Premium Running Shoes Lightweight Sport Edition',
                'description' => 'Sepatu lari premium dengan teknologi cushioning terbaru',
                'price' => 799000,
                'original_price' => 1200000,
                'stock' => 75,
                'image_url' => 'https://placehold.co/200x200/2B2B2B/FFFFFF?text=Running+Shoes',
                'category_name' => 'Fashion Pria',
                'location' => 'Jakarta Pusat',
                'discount_percentage' => 40,
                'badge' => 'Mall',
                'is_active' => true,
            ],
            [
                'name' => 'Vintage Leather Backpack Premium Quality',
                'description' => 'Tas ransel kulit vintage berkualitas tinggi dengan banyak kompartemen',
                'price' => 599000,
                'original_price' => 850000,
                'stock' => 40,
                'image_url' => 'https://placehold.co/200x200/FFB6C1/000000?text=Backpack',
                'category_name' => 'Fashion Pria',
                'location' => 'Kota Surabaya',
                'discount_percentage' => 30,
                'badge' => 'Mall',
                'is_active' => true,
            ],
            [
                'name' => 'Professional Camera Lens 50mm f/1.8',
                'description' => 'Lensa kamera profesional dengan aperture besar untuk foto portrait',
                'price' => 1299000,
                'original_price' => 2000000,
                'stock' => 20,
                'image_url' => 'https://placehold.co/200x200/E8E8E8/000000?text=Camera',
                'category_name' => 'Elektronik',
                'location' => 'Jakarta Selatan',
                'discount_percentage' => 35,
                'badge' => 'Mall',
                'is_active' => true,
            ],
            [
                'name' => 'Wireless Gaming Mouse RGB LED',
                'description' => 'Mouse gaming wireless dengan RGB LED, DPI hingga 16000',
                'price' => 450000,
                'original_price' => 750000,
                'stock' => 80,
                'image_url' => 'https://placehold.co/200x200/FF6B6B/000000?text=Gaming+Mouse',
                'category_name' => 'Elektronik',
                'location' => 'Kota Bandung',
                'discount_percentage' => 40,
                'badge' => 'Mall',
                'is_active' => true,
            ],
            [
                'name' => 'Mechanical Keyboard RGB Backlight Cherry MX',
                'description' => 'Keyboard mechanical dengan switch Cherry MX dan RGB backlight',
                'price' => 1100000,
                'original_price' => 1500000,
                'stock' => 35,
                'image_url' => 'https://placehold.co/200x200/4ECDC4/000000?text=Keyboard',
                'category_name' => 'Elektronik',
                'location' => 'Jakarta Barat',
                'discount_percentage' => 27,
                'badge' => 'Terkirim cepat',
                'is_active' => true,
            ],
            [
                'name' => 'Korean Style Oversized Hoodie Premium',
                'description' => 'Hoodie oversized gaya Korea dengan bahan cotton premium',
                'price' => 175000,
                'original_price' => 300000,
                'stock' => 150,
                'image_url' => 'https://placehold.co/200x200/95E1D3/000000?text=Hoodie',
                'category_name' => 'Fashion Pria',
                'location' => 'Kota Surabaya',
                'discount_percentage' => 42,
                'badge' => 'Mall',
                'is_active' => true,
            ],
            [
                'name' => 'Minimalist Leather Wallet RFID Protection',
                'description' => 'Dompet kulit minimalis dengan proteksi RFID untuk keamanan kartu',
                'price' => 250000,
                'original_price' => 400000,
                'stock' => 90,
                'image_url' => 'https://placehold.co/200x200/F38181/000000?text=Wallet',
                'category_name' => 'Fashion Pria',
                'location' => 'Jakarta Selatan',
                'discount_percentage' => 38,
                'badge' => 'Terkirim cepat',
                'is_active' => true,
            ],
            [
                'name' => 'Flat Shoes Wanita Casual Comfortable',
                'description' => 'Sepatu flat wanita casual yang nyaman untuk aktivitas sehari-hari',
                'price' => 125000,
                'original_price' => 250000,
                'stock' => 200,
                'image_url' => 'https://placehold.co/200x200/AA96DA/FFFFFF?text=Flat+Shoes',
                'category_name' => 'Fashion Wanita',
                'location' => 'Kab. Tangerang',
                'discount_percentage' => 50,
                'badge' => 'Mall',
                'is_active' => true,
            ],
            [
                'name' => 'Makanan Kering Premium Snack Box 500gr',
                'description' => 'Paket snack makanan kering premium dengan berbagai pilihan rasa',
                'price' => 85000,
                'original_price' => 150000,
                'stock' => 300,
                'image_url' => 'https://placehold.co/200x200/FCBAD3/000000?text=Snack+Box',
                'category_name' => 'Makanan & Minuman',
                'location' => 'Jakarta Timur',
                'discount_percentage' => 43,
                'badge' => 'Terkirim cepat',
                'is_active' => true,
            ],
            [
                'name' => 'Skincare Set Kecantikan Complete Package',
                'description' => 'Paket lengkap skincare untuk perawatan wajah dengan bahan alami',
                'price' => 299000,
                'original_price' => 500000,
                'stock' => 120,
                'image_url' => 'https://placehold.co/200x200/FFFFD2/000000?text=Skincare',
                'category_name' => 'Kecantikan',
                'location' => 'Kota Bandung',
                'discount_percentage' => 40,
                'badge' => 'Best Seller',
                'is_active' => true,
            ],
            [
                'name' => 'Peralatan Rumah Tangga Set Kitchen Tools',
                'description' => 'Set lengkap peralatan dapur modern untuk memasak sehari-hari',
                'price' => 375000,
                'original_price' => 650000,
                'stock' => 60,
                'image_url' => 'https://placehold.co/200x200/FEC8D8/000000?text=Kitchen+Set',
                'category_name' => 'Perlengkapan Rumah',
                'location' => 'Kota Surabaya',
                'discount_percentage' => 42,
                'badge' => 'Terkirim cepat',
                'is_active' => true,
            ],
            [
                'name' => 'Baju Batik Modern Premium Pria',
                'description' => 'Batik modern dengan motif kontemporer yang elegan',
                'price' => 285000,
                'original_price' => 450000,
                'stock' => 85,
                'image_url' => 'https://placehold.co/200x200/8B4513/FFFFFF?text=Batik',
                'category_name' => 'Fashion Pria',
                'location' => 'Solo',
                'discount_percentage' => 37,
                'badge' => 'Mall',
                'is_active' => true,
            ],
            [
                'name' => 'Vitamin C 1000mg Suplemen Kesehatan',
                'description' => 'Suplemen vitamin C untuk menjaga daya tahan tubuh',
                'price' => 125000,
                'original_price' => 200000,
                'stock' => 300,
                'image_url' => 'https://placehold.co/200x200/FFA500/000000?text=Vitamin+C',
                'category_name' => 'Kesehatan',
                'location' => 'Jakarta',
                'discount_percentage' => 38,
                'badge' => 'Best Seller',
                'is_active' => true,
            ],
        ];

        // Get seller IDs
        $sellerIds = Seller::pluck('id')->toArray();
        if (empty($sellerIds)) {
            $this->command->warn('No sellers found. Skipping product seeding.');
            return;
        }

        foreach ($products as $index => $productData) {
            $categoryName = $productData['category_name'] ?? null;
            unset($productData['category_name']);
            unset($productData['image_url']);
            
            // Find category ID
            if ($categoryName && isset($categoryMap[$categoryName])) {
                $productData['category_id'] = $categoryMap[$categoryName];
            }
            
            // Assign seller_id (rotate through available sellers)
            $productData['seller_id'] = $sellerIds[$index % count($sellerIds)];
            
            // Add required fields with defaults
            $productData['weight'] = $productData['weight'] ?? rand(100, 2000);
            $productData['condition'] = $productData['condition'] ?? 'new';
            $productData['status'] = $productData['status'] ?? 'published';
            
            Product::create($productData);
        }
    }
}
