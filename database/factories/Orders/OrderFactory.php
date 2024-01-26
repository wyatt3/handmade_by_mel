<?php

namespace Database\Factories\Orders;

use App\Models\Orders\Customer;
use App\Models\Orders\OrderItem;
use App\Models\Orders\OrderStatus;
use App\Models\Products\Product;
use App\Models\Products\ProductVariation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total' => $this->faker->randomFloat(2, 1, 1000),
            'status_id' => OrderStatus::factory(),
            'customer_id' => Customer::factory(),
        ];
    }

    public function withItems(int $count): self
    {
        $product = Product::factory()->create();
        return $this->has(
            OrderItem::factory()->for($product)->has(ProductVariation::factory()->for($product)->count(3), 'variations')->count($count),
            'items'
        );
    }
}
