<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        $imageKeywords = [
            'Gaming Laptop RTX 4060 16GB RAM 512GB SSD' => ['gaming-laptop', 'laptop-gaming', 'laptop-computer'],
            'iPhone 15 Pro Max 256GB Titanium Blue' => ['iphone', 'smartphone-apple', 'mobile-phone'],
            'Samsung Galaxy S24 Ultra 512GB Black' => ['samsung-phone', 'android-smartphone', 'smartphone'],
            'Smart TV 55 Inch 4K Android TV' => ['smart-tv', 'television', 'led-tv'],
            'Mechanical Gaming Keyboard RGB' => ['gaming-keyboard', 'mechanical-keyboard', 'rgb-keyboard'],
            'Wireless Earbuds ANC Premium' => ['wireless-earbuds', 'earbuds', 'bluetooth-earbuds'],
            'MacBook Air M3 8GB 256GB' => ['macbook', 'apple-laptop', 'macbook-air'],
            'Sony WH-1000XM5 Wireless ANC' => ['headphones', 'wireless-headphones', 'sony-headphones'],
            'iPad Pro M2 11 128GB WiFi' => ['ipad', 'tablet-apple', 'ipad-pro'],
            'Apple Watch Series 9 GPS 45mm' => ['apple-watch', 'smartwatch', 'smart-watch'],
            'Kemeja Batik Premium Pria Lengan Panjang' => ['batik-shirt', 'indonesian-batik', 'mens-shirt'],
            'Dress Casual Wanita Modern' => ['women-dress', 'casual-dress', 'fashion-dress'],
            'Sepatu Sneakers Sport Pria' => ['sneakers', 'sport-shoes', 'mens-sneakers'],
            'Tas Wanita Kulit Premium' => ['leather-bag', 'women-handbag', 'handbag'],
            'Jaket Hoodie Premium Pria' => ['hoodie', 'mens-hoodie', 'jacket-hoodie'],
            'Rice Cooker Digital 2 Liter' => ['rice-cooker', 'kitchen-appliance', 'electric-cooker'],
            'Blender 2 in 1 Multifungsi' => ['blender', 'kitchen-blender', 'food-blender'],
            'Set Panci Masak Stainless Steel 5 Pcs' => ['cooking-pots', 'stainless-cookware', 'kitchen-pots'],
            'Dispenser Air Galon Bottom Loading' => ['water-dispenser', 'dispenser', 'water-cooler'],
            'Vacuum Cleaner 2 in 1 Wireless' => ['vacuum-cleaner', 'cordless-vacuum', 'home-vacuum'],
            'Dumbbell Set 20kg Adjustable' => ['dumbbell', 'fitness-equipment', 'gym-weights'],
            'Matras Yoga Premium Anti Slip' => ['yoga-mat', 'exercise-mat', 'fitness-mat'],
            'Sepeda Lipat 20 Inch 7 Speed' => ['folding-bike', 'bicycle', 'city-bike'],
            'Treadmill Electric 3 HP Motor' => ['treadmill', 'gym-treadmill', 'fitness-treadmill'],
            'Resistance Band Set 5 Level' => ['resistance-bands', 'exercise-bands', 'fitness-bands'],
            'Kopi Arabica Premium 250gr' => ['coffee-beans', 'arabica-coffee', 'roasted-coffee'],
            'Paket Snack Box Sehat 10 Pcs' => ['snack-box', 'healthy-snacks', 'food-box'],
            'Madu Hutan Murni 500ml' => ['honey', 'natural-honey', 'bee-honey'],
            'Keripik Singkong Rasa Original 500gr' => ['cassava-chips', 'chips-snack', 'indonesian-snack'],
            'Teh Hijau Organik 100 Sachet' => ['green-tea', 'organic-tea', 'tea-bags'],
        ];

        foreach ($products as $product) {
            $keywords = $imageKeywords[$product->name] ?? ['product', 'shopping', 'ecommerce'];
            
            $numImages = rand(1, 3);
            
            for ($i = 0; $i < $numImages; $i++) {
                $keyword = $keywords[$i] ?? $keywords[0];
                $randomSeed = $product->id * 100 + $i;
                
                $imageUrl = "https://picsum.photos/seed/{$keyword}-{$randomSeed}/600/600";
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imageUrl,
                    'is_primary' => $i === 0,
                    'order' => $i,
                ]);
            }
        }

        $this->command->info('Product images seeded successfully!');
    }
}
