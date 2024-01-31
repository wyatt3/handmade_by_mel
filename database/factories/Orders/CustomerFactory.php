<?php

namespace Database\Factories\Orders;

use App\Enums\AddressType;
use App\Models\Orders\Address;
use App\Models\Orders\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Customer $customer) {
            Address::factory()->create([
                'customer_id' => $customer->getKey(),
                'address_type' => AddressType::Shipping,
            ]);
            Address::factory()->create([
                'customer_id' => $customer->getKey(),
                'address_type' => AddressType::Billing,
            ]);
        });
    }
}
