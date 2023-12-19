<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductController;
use App\Models\Products\Product;
use App\Services\ProductService;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    public function testGetProducts()
    {
        $products = Product::factory()->count(2)->create();

        $this->mock(ProductService::class, function ($mock) use ($products) {
            $mock->shouldReceive('getProducts')
                ->once()
                ->andReturn($products);
        });

        $response = app()->make(ProductController::class)->getProducts();
        $this->assertEquals(200, $response->status());
    }

    public function testIndex()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $this->actingAs($this->user);
        $product = Product::factory()->create();
        $response = app()->make(ProductController::class)->show($product);

        $this->assertEquals(200, $response->status());
    }

    public function testCreate()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('products.create'));

        $response->assertStatus(200);
    }
}
