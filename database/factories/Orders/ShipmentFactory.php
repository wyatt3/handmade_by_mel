<?php

namespace Database\Factories\Orders;

use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders\Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'carrier' => $this->faker->word(),
            'tracking_number' => $this->faker->word(),
            'shipment_date' => $this->faker->dateTime(),
        ];
    }
}
