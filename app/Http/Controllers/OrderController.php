<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Orders\Customer;
use App\Models\Orders\Order;
use App\Models\Orders\OrderStatus;
use App\Services\CustomerService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        public CustomerService $customerService,
        public OrderService $orderService,
    ) {
    }

    /**
     * get orders page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('admin.orders.index');
    }

    public function getOrders(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'status' => 'nullable|integer',
            'offset' => 'nullable|integer',
            'limit' => 'nullable|integer',
        ]);

        $orders = $this->orderService->getOrders(OrderStatus::find($request->input('status')), $request->input('offset'), $request->input('limit'));

        return response()->json($orders, 200);
    }

    /**
     * show order
     *
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Order $order): \Illuminate\Http\JsonResponse
    {
        return response()->json($order->load(['items', 'status', 'customer', 'shipments']), 200);
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
        $customer = Customer::firstOrCreate([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $this->customerService->addAddresses($customer, $validated['shipping_address'], $validated['billing_address']);

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
