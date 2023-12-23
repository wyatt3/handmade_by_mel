<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductVariationTypeController;
use App\Models\Products\ProductVariationType;
use Illuminate\Http\Request;
use Tests\TestCase;

class ProductVariationTypeControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = app()->make(ProductVariationTypeController::class)->index();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStore()
    {
        $response = app()->make(ProductVariationTypeController::class)->store(new Request([
            'name' => 'test'
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('product_variation_types', [
            'name' => 'test'
        ]);
    }

    public function testUpdate()
    {
        $type = ProductVariationType::factory()->create();

        $response = app()->make(ProductVariationTypeController::class)->update(new Request([
            'name' => 'test'
        ]), $type);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('product_variation_types', [
            'name' => 'test'
        ]);
    }

    public function testDestroy()
    {
        $type = ProductVariationType::factory()->create();

        $response = app()->make(ProductVariationTypeController::class)->destroy($type);

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertDatabaseMissing('product_variation_types', [
            'name' => $type->name
        ]);
    }
}
