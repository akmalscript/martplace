<?php

namespace Database\Factories;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seller>
 */
class SellerFactory extends Factory
{
    protected $model = Seller::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'          => User::factory(),
            'store_name'       => fake()->company(),
            'store_description'=> fake()->sentence(),
            'pic_name'         => fake()->name(),
            'pic_phone'        => fake()->phoneNumber(),
            'pic_email'        => fake()->unique()->safeEmail(),
            'password'         => bcrypt('password'),
            'pic_street'       => fake()->streetAddress(),
            'pic_rt'           => fake()->numerify('0##'),
            'pic_rw'           => fake()->numerify('0##'),
            'pic_village'      => fake()->citySuffix(),
            'pic_district'     => fake()->city(),
            'pic_city'         => fake()->city(),
            'pic_province'     => fake()->state(),
            'pic_ktp_number'   => fake()->unique()->numerify('################'),
            'status'           => 'ACTIVE',
            'city'             => fake()->city(),
            'province'         => fake()->state(),
            'district'         => fake()->city(),
            'rating'           => 0,
            'total_products'   => 0,
        ];
    }
}
