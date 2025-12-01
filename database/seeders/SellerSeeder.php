<?php

namespace Database\Seeders;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellers = [
            [
                'user' => [
                    'name' => 'Toko Elektronik Jakarta',
                    'email' => 'elektronik.jakarta@example.com',
                    'password' => Hash::make('password123'),
                    'role' => 'seller',
                ],
                'seller' => [
                    'store_name' => 'Toko Elektronik Jakarta',
                    'store_description' => 'Toko elektronik terlengkap di Jakarta dengan harga terjangkau',
                    'pic_name' => 'Ahmad Elektronik',
                    'pic_phone' => '081234567890',
                    'pic_email' => 'elektronik.jakarta@example.com',
                    'password' => Hash::make('password123'),
                    'pic_street' => 'Jl. Sudirman No. 123',
                    'pic_rt' => '001',
                    'pic_rw' => '005',
                    'pic_village' => 'Menteng',
                    'pic_district' => 'Menteng',
                    'pic_city' => 'Jakarta Pusat',
                    'pic_province' => 'DKI Jakarta',
                    'pic_ktp_number' => '3171012345670001',
                    'status' => 'ACTIVE',
                    'city' => 'Jakarta Pusat',
                    'province' => 'DKI Jakarta',
                    'district' => 'Menteng',
                    'rating' => 4.8,
                    'total_products' => 15,
                ],
            ],
            [
                'user' => [
                    'name' => 'Fashion Store Bandung',
                    'email' => 'fashion.bandung@example.com',
                    'password' => Hash::make('password123'),
                    'role' => 'seller',
                ],
                'seller' => [
                    'store_name' => 'Fashion Store Bandung',
                    'store_description' => 'Fashion terkini dengan kualitas premium',
                    'pic_name' => 'Siti Fashion',
                    'pic_phone' => '082345678901',
                    'pic_email' => 'fashion.bandung@example.com',
                    'password' => Hash::make('password123'),
                    'pic_street' => 'Jl. Dago No. 45',
                    'pic_rt' => '002',
                    'pic_rw' => '003',
                    'pic_village' => 'Dago',
                    'pic_district' => 'Coblong',
                    'pic_city' => 'Kota Bandung',
                    'pic_province' => 'Jawa Barat',
                    'pic_ktp_number' => '3273012345670002',
                    'status' => 'ACTIVE',
                    'city' => 'Bandung',
                    'province' => 'Jawa Barat',
                    'district' => 'Coblong',
                    'rating' => 4.9,
                    'total_products' => 20,
                ],
            ],
            [
                'user' => [
                    'name' => 'Kuliner Surabaya Mall',
                    'email' => 'kuliner.surabaya@example.com',
                    'password' => Hash::make('password123'),
                    'role' => 'seller',
                ],
                'seller' => [
                    'store_name' => 'Kuliner Surabaya Mall',
                    'store_description' => 'Aneka makanan kering dan snack khas Surabaya',
                    'pic_name' => 'Budi Kuliner',
                    'pic_phone' => '083456789012',
                    'pic_email' => 'kuliner.surabaya@example.com',
                    'password' => Hash::make('password123'),
                    'pic_street' => 'Jl. Tunjungan No. 67',
                    'pic_rt' => '003',
                    'pic_rw' => '007',
                    'pic_village' => 'Genteng',
                    'pic_district' => 'Genteng',
                    'pic_city' => 'Kota Surabaya',
                    'pic_province' => 'Jawa Timur',
                    'pic_ktp_number' => '3578012345670003',
                    'status' => 'ACTIVE',
                    'city' => 'Surabaya',
                    'province' => 'Jawa Timur',
                    'district' => 'Genteng',
                    'rating' => 4.7,
                    'total_products' => 12,
                ],
            ],
            [
                'user' => [
                    'name' => 'Gadget Corner Solo',
                    'email' => 'gadget.solo@example.com',
                    'password' => Hash::make('password123'),
                    'role' => 'seller',
                ],
                'seller' => [
                    'store_name' => 'Gadget Corner Solo',
                    'store_description' => 'Pusat gadget dan aksesoris terlengkap',
                    'pic_name' => 'Rina Gadget',
                    'pic_phone' => '084567890123',
                    'pic_email' => 'gadget.solo@example.com',
                    'password' => Hash::make('password123'),
                    'pic_street' => 'Jl. Slamet Riyadi No. 89',
                    'pic_rt' => '004',
                    'pic_rw' => '002',
                    'pic_village' => 'Laweyan',
                    'pic_district' => 'Laweyan',
                    'pic_city' => 'Kota Surakarta',
                    'pic_province' => 'Jawa Tengah',
                    'pic_ktp_number' => '3372012345670004',
                    'status' => 'ACTIVE',
                    'city' => 'Solo',
                    'province' => 'Jawa Tengah',
                    'district' => 'Laweyan',
                    'rating' => 4.6,
                    'total_products' => 18,
                ],
            ],
            [
                'user' => [
                    'name' => 'Kecantikan Store',
                    'email' => 'beauty.store@example.com',
                    'password' => Hash::make('password123'),
                    'role' => 'seller',
                ],
                'seller' => [
                    'store_name' => 'Kecantikan Store',
                    'store_description' => 'Produk kecantikan original dan terpercaya',
                    'pic_name' => 'Dewi Beauty',
                    'pic_phone' => '085678901234',
                    'pic_email' => 'beauty.store@example.com',
                    'password' => Hash::make('password123'),
                    'pic_street' => 'Jl. Malioboro No. 12',
                    'pic_rt' => '005',
                    'pic_rw' => '001',
                    'pic_village' => 'Gedongtengen',
                    'pic_district' => 'Gedongtengen',
                    'pic_city' => 'Kota Yogyakarta',
                    'pic_province' => 'DI Yogyakarta',
                    'pic_ktp_number' => '3471012345670005',
                    'status' => 'ACTIVE',
                    'city' => 'Yogyakarta',
                    'province' => 'DI Yogyakarta',
                    'district' => 'Gedongtengen',
                    'rating' => 4.9,
                    'total_products' => 10,
                ],
            ],
        ];

        foreach ($sellers as $data) {
            // Create user first
            $user = User::create($data['user']);

            // Create seller with user_id
            $data['seller']['user_id'] = $user->id;
            Seller::create($data['seller']);
        }
    }
}
