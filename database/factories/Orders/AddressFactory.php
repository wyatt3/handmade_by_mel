<?php

namespace Database\Factories\Orders;

use App\Enums\AddressType;
use App\Models\Orders\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'address_type' => $this->faker->randomElement(AddressType::cases())->value,
            'address_line_1' => $this->faker->streetAddress(),
            'address_line_2' => $this->faker->secondaryAddress(),
            'address_line_3' => $this->faker->optional()->secondaryAddress(),
            'address_line_4' => $this->faker->optional()->secondaryAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
        ];
    }
}
