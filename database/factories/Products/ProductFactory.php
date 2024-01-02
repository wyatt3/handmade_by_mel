<?php

namespace Database\Factories\Products;

use App\Models\Products\ProductCategory;
use App\Models\Products\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->randomFloat(2, 1, 100);
        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'price' => $price,
            'sale_price' => $this->faker->optional()->randomFloat(2, 0.1, $price),
            'sku' => $this->faker->unique()->word(),
            'active' => $this->faker->boolean(75),
            'product_category_id' => ProductCategory::factory(),
        ];
    }

    /**
     * Indicate that the product should have images.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withImages(): Factory
    {
        return $this->has(
            ProductImage::factory()->count(3),
            'images'
        );
    }
}
