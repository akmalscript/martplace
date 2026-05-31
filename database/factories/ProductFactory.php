<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Seller;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(3, true);

        return [
            'seller_id'      => Seller::factory(),
            'category_id'    => Category::factory(),
            'name'           => $name,
            'slug'           => Str::slug($name) . '-' . fake()->unique()->randomNumber(5),
            'description'    => fake()->paragraph(),
            'price'          => fake()->randomFloat(2, 10000, 5000000),
            'stock'          => fake()->numberBetween(0, 100),
            'is_active'      => true,
            'has_variants'   => false,
            'min_order'      => 1,
            'max_order'      => null,
            'image_url'      => null,
            'average_rating' => 0,
            'total_reviews'  => 0,
            'province'       => fake()->state(),
            'city'           => fake()->city(),
        ];
    }
}
