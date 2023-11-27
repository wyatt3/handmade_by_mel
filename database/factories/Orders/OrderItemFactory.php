<?php

namespace Database\Factories\Orders;

use App\Models\Orders\Order;
use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $basePrice = $this->faker->randomFloat(2, 1, 100);
        return [
            'order_id' => Order::factory(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'base_price' => $basePrice,
            'total' => $this->faker->randomFloat(2, 1, 100) + $basePrice,
            'product_id' => Product::factory(),
        ];
    }
}
