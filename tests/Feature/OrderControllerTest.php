<?php

namespace Tests\Feature;

use App\Http\Controllers\OrderController;
use App\Models\Orders\Order;
use App\Models\Orders\Shipment;
use App\Models\Products\Product;
use App\Models\Products\ProductVariation;
use App\Services\OrderService;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    /** @var \Mockery\MockInterface $orderService */
    public $orderService;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderService = $this->mock(OrderService::class);
    }

    public function testIndex()
    {
        $response = $this->actingAs($this->user)->get(route('admin.home'));

        $response->assertStatus(200);
    }

    public function testGetOrders()
    {
        $this->orderService->shouldReceive('getOrders')->once()->andReturn(collect([
            Order::factory()->make(),
        ]));

        $response = app()->make(OrderController::class)->getOrders(new \Illuminate\Http\Request());

        $this->assertEquals(200, $response->status());
    }

    public function testShow()
    {
        $response = app()->make(OrderController::class)->show($order = Order::factory()->create());

        $this->assertEquals(200, $response->status());
        $this->assertEquals($order->getKey(), $response->getData()->id);
    }

    public function testStore()
    {
        $this->orderService->shouldReceive('createOrder')->once()->andReturn(Order::factory()->make());

        $response = $this->postJson('/api/orders/', [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'billing_address' => [
                'line_1' => $this->faker->streetAddress(),
                'line_2' => $this->faker->secondaryAddress(),
                'line_3' => $this->faker->secondaryAddress(),
                'line_4' => $this->faker->secondaryAddress(),
                'city' => $this->faker->city(),
                'state' => $this->faker->state(),
                'postal_code' => $this->faker->postcode(),
            ],
            'shipping_address' => [
                'line_1' => $this->faker->streetAddress(),
                'line_2' => $this->faker->secondaryAddress(),
                'line_3' => $this->faker->secondaryAddress(),
                'line_4' => $this->faker->secondaryAddress(),
                'city' => $this->faker->city(),
                'state' => $this->faker->state(),
                'postal_code' => $this->faker->postcode(),
            ],
            'items' => [
                [
                    'product' => [
                        'id' => ($product = Product::factory()->create())->getKey(),
                    ],
                    'quantity' => $this->faker->numberBetween(1, 10),
                    'variations' => [
                        [
                            'id' => ProductVariation::factory()->for($product)->create()->getKey(),
                            'product_id' => $product->getKey(),
                        ],
                    ]
                ],
            ],
        ]);

        $response->assertSuccessful();
    }

    public function testStoreWithBadVariation()
    {
        $this->orderService->shouldReceive('createOrder')->never();

        $response = $this->postJson('/api/orders/', [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'billing_address' => [
                'line_1' => $this->faker->streetAddress(),
                'line_2' => $this->faker->secondaryAddress(),
                'line_3' => $this->faker->secondaryAddress(),
                'line_4' => $this->faker->secondaryAddress(),
                'city' => $this->faker->city(),
                'state' => $this->faker->state(),
                'postal_code' => $this->faker->postcode(),
            ],
            'shipping_address' => [
                'line_1' => $this->faker->streetAddress(),
                'line_2' => $this->faker->secondaryAddress(),
                'line_3' => $this->faker->secondaryAddress(),
                'line_4' => $this->faker->secondaryAddress(),
                'city' => $this->faker->city(),
                'state' => $this->faker->state(),
                'postal_code' => $this->faker->postcode(),
            ],
            'items' => [
                [
                    'product' => [
                        'id' => ($product = Product::factory()->create())->getKey(),
                    ],
                    'quantity' => $this->faker->numberBetween(1, 10),
                    'variations' => [
                        [
                            'id' => ProductVariation::factory()->for($product)->create()->getKey(),
                            'product_id' => Product::factory()->create()->getKey() + 1,
                        ],
                    ]
                ],
            ],
        ]);

        $response->assertStatus(422);
    }

    public function testMarkShipped()
    {
        $this->orderService->shouldReceive('markShipped')->once()->andReturn(Shipment::factory()->make());

        $order = Order::factory()->create();

        $response = app()->make(OrderController::class)->markShipped($order, new \Illuminate\Http\Request([
            'carrier' => $this->faker->company(),
            'tracking_number' => $this->faker->uuid(),
        ]));

        $this->assertEquals(200, $response->status());
    }

    public function testMarkCompleted()
    {
        $this->orderService->shouldReceive('markCompleted')->once()->andReturn(Order::factory()->make());

        $order = Order::factory()->create();

        $response = app()->make(OrderController::class)->markCompleted($order);

        $this->assertEquals(200, $response->status());
    }

    public function testCancelOrder()
    {
        $this->orderService->shouldReceive('cancelOrder')->once()->andReturn(Order::factory()->make());

        $order = Order::factory()->create();

        $response = app()->make(OrderController::class)->cancelOrder($order);

        $this->assertEquals(200, $response->status());
    }
}
