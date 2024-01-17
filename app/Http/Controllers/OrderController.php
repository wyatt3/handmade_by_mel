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
        $customer = $this->orderService->getCustomer(
            $validated['name'],
            $validated['email'],
        );
    }
}
