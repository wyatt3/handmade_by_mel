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

        $products = $this->productService->getProducts(0, 10, $product->category->getKey(), true, 'Test', 'name', 'asc');

        $this->assertCount(1, $products);
    }

    public function testGetProductsWithNoSort()
    {
        Product::factory()->create([
            'sale_price' => null,
        ]);
        $firstProduct = Product::factory()->create([
            'sale_price' => 1,
        ]);

        $products = $this->productService->getProducts();

        $this->assertCount(2, $products);
        $this->assertEquals($firstProduct->getKey(), $products->first()->getKey());
    }
}
