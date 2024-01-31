<?php

namespace Tests\Unit;

use App\Models\Orders\Customer;
use App\Services\CustomerService;
use Tests\TestCase;

class CustomerServiceTest extends TestCase
{
    public function testAddAddresses()
    {
        $customer = Customer::factory()->create();
        $shipping = [
            'line_1' => $this->faker->streetAddress(),
            'line_2' => $this->faker->secondaryAddress(),
            'line_3' => $this->faker->secondaryAddress(),
            'line_4' => $this->faker->secondaryAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
        ];

        $billing = [
            'line_1' => $this->faker->streetAddress(),
            'line_2' => $this->faker->secondaryAddress(),
            'line_3' => $this->faker->secondaryAddress(),
            'line_4' => $this->faker->secondaryAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
        ];

        app()->make(CustomerService::class)->addAddresses($customer, $shipping, $billing);

        $this->assertEquals($shipping['line_1'], $customer->shippingAddress->line_1);
        $this->assertEquals($shipping['line_2'], $customer->shippingAddress->line_2);
        $this->assertEquals($shipping['line_3'], $customer->shippingAddress->line_3);
        $this->assertEquals($shipping['line_4'], $customer->shippingAddress->line_4);
        $this->assertEquals($shipping['city'], $customer->shippingAddress->city);
        $this->assertEquals($shipping['state'], $customer->shippingAddress->state);
        $this->assertEquals($shipping['postal_code'], $customer->shippingAddress->postal_code);

        $this->assertEquals($billing['line_1'], $customer->billingAddress->line_1);
        $this->assertEquals($billing['line_2'], $customer->billingAddress->line_2);
        $this->assertEquals($billing['line_3'], $customer->billingAddress->line_3);
        $this->assertEquals($billing['line_4'], $customer->billingAddress->line_4);
        $this->assertEquals($billing['city'], $customer->billingAddress->city);
        $this->assertEquals($billing['state'], $customer->billingAddress->state);
        $this->assertEquals($billing['postal_code'], $customer->billingAddress->postal_code);
    }
}
