<?php

namespace Database\Factories\Orders;

use App\Models\Orders\Customer;
use App\Models\Orders\Order;
use App\Models\Orders\OrderItem;
use App\Models\Orders\OrderStatus;
use App\Models\Products\Product;
use App\Models\Products\ProductVariation;
use App\Services\OrderService;
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
            'subtotal' => $this->faker->randomFloat(2, 1, 1000),
            'shipping_cost' => $this->faker->randomFloat(2, 1, 1000),
            'tax' => $this->faker->randomFloat(2, 1, 1000),
            'status_id' => OrderStatus::factory(),
            'customer_id' => Customer::factory(),
        ];
    }

    public function withItems(int $count): self
    {
        return $this->afterCreating(function (Order $order) use ($count) {
            for ($i = 0; $i < $count; $i++) {
                $product = Product::factory()->create();
                OrderItem::factory()
                    ->for($order)
                    ->for($product)
                    ->has(
                        ProductVariation::factory()
                            ->for($product)
                            ->count(3),
                        'variations'
                    )
                    ->create();
            }
            app()->make(OrderService::class)->recalculateTotals($order);
        });
    }
}
