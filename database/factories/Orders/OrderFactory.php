<?php

namespace Database\Factories\Orders;

use App\Models\Orders\Customer;
use App\Models\Orders\OrderStatus;
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
}
