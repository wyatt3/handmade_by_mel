<?php

namespace Database\Factories\Products;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products\ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'path' => $this->faker->imageUrl(),
            'order' => $this->faker->numberBetween(1, 10),
            'product_id' => Product::factory(),
        ];
    }
}
