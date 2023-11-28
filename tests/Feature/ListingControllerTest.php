<?php

namespace Tests\Feature;

use App\Models\Products\Product;
use App\Services\ProductService;
use Tests\TestCase;

class ListingControllerTest extends TestCase
{
    protected $mockProductService;

    public function setUp(): void
    {
        parent::setUp();
        $this->mockProductService = $this->mock(ProductService::class);
    }

    public function testGetActiveListings()
    {
        $this->mockProductService->shouldReceive('getProducts')
            ->once()
            ->andReturn(collect([]));

        $response = $this->getJson('/api/listings', [
            'offset' => 0,
            'limit' => 10,
            'category_id' => 1,
            'search' => 'Test',
        ]);

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $product = Product::factory()->create();
        $response = $this->get(route('listing.show', $product->name));

        $response->assertStatus(200);
    }
}
