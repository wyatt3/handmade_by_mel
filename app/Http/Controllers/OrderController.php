<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Orders\Customer;
use App\Models\Orders\Order;
use App\Models\Orders\OrderStatus;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        public OrderService $orderService,
    ) {
    }

    /**
     * create order
     *
     * @param CreateOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateOrderRequest $request): \Illuminate\Http\JsonResponse
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

        $order = $this->orderService->createOrder($customer, $validated['items']);

        return response()->json($order, 201);
    }

    /**
     * mark order as shipped
     *
     * @param Order $order
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markShipped(Order $order, Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'carrier' => 'required|string',
            'tracking_number' => 'required|string',
        ]);

        $this->orderService->markShipped($order, $validated['carrier'], $validated['tracking_number']);

        return response()->json($order, 200);
    }

    /**
     * mark order as completed
     *
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function markCompleted(Order $order): \Illuminate\Http\JsonResponse
    {
        $this->orderService->markCompleted($order);

        return response()->json($order, 200);
    }

    /**
     * cancel order
     *
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelOrder(Order $order): \Illuminate\Http\JsonResponse
    {
        $this->orderService->cancelOrder($order);

        return response()->json($order, 200);
    }
}
