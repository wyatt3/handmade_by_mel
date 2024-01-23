<?php

namespace Tests\Unit;

use App\Models\Orders\Customer;
use App\Models\Orders\Order;
use App\Models\Orders\OrderItem;
use App\Models\Orders\OrderStatus;
use App\Models\Orders\Shipment;
use App\Models\Products\Product;
use App\Models\Products\ProductVariation;
use App\Services\OrderService;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    public $orderService;

    public function setUp(): void
    {
        parent::setUp();

        $this->orderService = $this->partialMock(OrderService::class);
    }

    public function testItCreatesAnOrder()
    {
        $this->orderService->shouldReceive('recalculateTotals')->once();

        config([
            'orders.statuses.created' => OrderStatus::factory()->create()->getKey()
        ]);

        $customer = Customer::factory()->create();
        $product = Product::factory()
            ->has(ProductVariation::factory(), 'variations')
            ->create();

        $items = [
            [
                'product' => [
                    'id' => $product->getKey(),
                ],
                'quantity' => $this->faker->numberBetween(1, 10),
                'variations' => [
                    [
                        'id' => $product->variations->first()->getKey(),
                    ],
                ],
            ],
        ];

        $order = $this->orderService->createOrder($customer, $items);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertDatabaseHas(Order::class, [
            'customer_id' => $customer->getKey(),
            'status_id' => OrderStatus::findOrFail(config('orders.statuses.created'))->getKey(),
        ]);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->getKey(),
            'product_id' => $product->getKey(),
            'quantity' => $items[0]['quantity'],
            'base_price' => $product->sale_price ?? $product->price,
        ]);
    }

    public function testItRecalculatesTotals()
    {
        $order = Order::factory()
            ->has(OrderItem::factory([
                'base_price' => 10,
                'quantity' => 2,
            ])->count(2), 'items')
            ->create();

        $this->orderService->recalculateTotals($order);

        $this->assertDatabaseHas(Order::class, [
            'id' => $order->getKey(),
            'total' => 40,
        ]);

        foreach ($order->items as $item) {
            $this->assertDatabaseHas(OrderItem::class, [
                'id' => $item->getKey(),
                'total' => 20,
            ]);
        }
    }

    public function testMarkShipped()
    {
        $order = Order::factory()->create();
        $shippedStatus = OrderStatus::factory()->create();
        config(['orders.statuses.shipped' => $shippedStatus->getKey()]);

        $carrier = $this->faker->company();
        $trackingNumber = $this->faker->uuid();

        $shipment = $this->orderService->markShipped($order, $carrier, $trackingNumber);

        $this->assertDatabaseHas(Order::class, [
            'id' => $order->getKey(),
            'status_id' => $shippedStatus->getKey(),
        ]);

        $this->assertInstanceOf(Shipment::class, $shipment);
        $this->assertEquals($carrier, $shipment->carrier);
        $this->assertEquals($trackingNumber, $shipment->tracking_number);
        $this->assertEquals($order->getKey(), $shipment->order_id);
    }
}
