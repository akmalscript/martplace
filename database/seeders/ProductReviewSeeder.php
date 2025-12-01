<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = ['DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 'Bali', 'Sumatera Utara', 'Sulawesi Selatan'];
        
        $comments = [
            'Produk sangat bagus, sesuai deskripsi. Pengiriman cepat!',
            'Kualitas premium, worth it banget dengan harganya.',
            'Seller responsif, packing rapi. Recommended!',
            'Barang ori, berfungsi dengan baik. Terima kasih!',
            'Sesuai ekspektasi, pengiriman aman. Puas!',
            'Mantap! Barang sampai dengan selamat.',
            'Bagus banget produknya, tidak mengecewakan.',
            'Recommended seller, fast response!',
            'Kualitas oke, harga pas. Puas belanja disini.',
            'Barang sesuai foto, packing aman. Thank you!',
        ];
        
        $names = [
            'Budi Santoso', 'Ani Wijaya', 'Dewi Kusuma', 'Eko Prasetyo',
            'Fitri Handayani', 'Gilang Ramadhan', 'Hana Pertiwi', 'Indra Gunawan',
            'Joko Widodo', 'Kartika Sari', 'Lestari Wulandari', 'Made Suarjana',
            'Nina Septiani', 'Oka Mahendra', 'Putu Ayu', 'Rini Susanti',
            'Siti Nurhaliza', 'Tono Sugiarto', 'Udin Setiawan', 'Vina Amalia'
        ];

        // Get random products (seeded products IDs 1-30)
        $productIds = range(1, 30);
        
        $reviews = [];
        $reviewCount = 0;
        
        // Create reviews for products (rata-rata 3-8 reviews per produk)
        foreach ($productIds as $productId) {
            $numReviews = rand(3, 8);
            
            for ($i = 0; $i < $numReviews; $i++) {
                $rating = rand(3, 5); // Rating 3-5 untuk realistis
                
                $reviews[] = [
                    'product_id' => $productId,
                    'visitor_name' => $names[array_rand($names)],
                    'visitor_phone' => '08' . rand(1000000000, 9999999999),
                    'visitor_email' => 'customer' . rand(100, 999) . '@example.com',
                    'visitor_province' => $provinces[array_rand($provinces)],
                    'rating' => $rating,
                    'comment' => $comments[array_rand($comments)],
                    'thank_you_email_sent' => true,
                    'email_sent_at' => now()->subDays(rand(1, 60)),
                    'is_visible' => true,
                    'created_at' => now()->subDays(rand(1, 60)),
                    'updated_at' => now()->subDays(rand(1, 60)),
                ];
                
                $reviewCount++;
            }
        }
        
        DB::table('product_reviews')->insert($reviews);
        
        // Update average_rating dan total_reviews untuk setiap product
        foreach ($productIds as $productId) {
            $productReviews = DB::table('product_reviews')
                ->where('product_id', $productId)
                ->get();
            
            $avgRating = $productReviews->avg('rating');
            $totalReviews = $productReviews->count();
            
            DB::table('products')
                ->where('id', $productId)
                ->update([
                    'average_rating' => round($avgRating, 2),
                    'total_reviews' => $totalReviews,
                ]);
        }
        
        $this->command->info("$reviewCount product reviews seeded successfully!");
        $this->command->info('Product ratings updated!');
    }
}
