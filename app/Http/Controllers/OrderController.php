<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Orders\Customer;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(
        public OrderService $orderService,
    ) {
    }

    public function store(CreateOrderRequest $request)
    {
        $validated = $request->validated();
        $customer = Customer::updateOrCreate(
            [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ],
            [
                'address_line_1' => $validated['billing_address']['line_1'],
                'address_line_2' => $validated['billing_address']['line_2'],
                'address_line_3' => $validated['billing_address']['line_3'],
                'address_line_4' => $validated['billing_address']['line_4'],
                'city' => $validated['billing_address']['city'],
                'state' => $validated['billing_address']['state'],
                'postal_code' => $validated['billing_address']['postal_code'],
            ],
        );
    }
}
