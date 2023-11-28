<?php

namespace Tests\Unit;

use App\Models\Products\Product;
use App\Services\ProductService;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{

    protected ProductService $productService;

    public function setUp(): void
    {
        parent::setUp();
        $this->productService = app()->make(ProductService::class);
    }

    public function testGetProducts()
    {
        $product = Product::factory()->create([
            'name' => 'Test Product 1',
            'active' => true,
        ]);
        Product::factory()->create([
            'name' => 'Test Product 2',
            'active' => false,
        ]);

        $products = $this->productService->getProducts(0, 10, $product->category->getKey(), true, 'Test');

        $this->assertCount(1, $products);
    }
}
