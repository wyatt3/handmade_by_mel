<?php

namespace Database\Factories\Products;

use App\Models\Products\Product;
use App\Models\Products\ProductVariationType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products\ProductVariation>
 */
class ProductVariationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'price_modifier' => $this->faker->randomFloat(2, 1, 10),
            'image' => $this->faker->imageUrl(),
            'active' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(1, 10),
            'product_id' => Product::factory(),
            'product_variation_type_id' => ProductVariationType::factory(),
        ];
    }
}
