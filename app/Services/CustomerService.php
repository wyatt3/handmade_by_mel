<?php

namespace App\Services;

use App\Enums\AddressType;
use App\Models\Orders\Address;
use App\Models\Orders\Customer;

class CustomerService
{
    /**
     * add addresses to a customer
     *
     * @param Customer $customer
     * @param array $shippingAddress
     * @param array $billingAddress
     * @return void
     */
    public function addAddresses(Customer $customer, array $shippingAddress, array $billingAddress): void
    {
        Address::updateOrCreate(
            ['customer_id' => $customer->getKey(), 'address_type' => AddressType::Shipping],
            $shippingAddress
        );
        Address::updateOrCreate(
            ['customer_id' => $customer->getKey(), 'address_type' => AddressType::Billing],
            $billingAddress
        );
    }
}
