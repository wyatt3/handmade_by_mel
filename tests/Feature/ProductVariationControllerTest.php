<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductVariationController;
use App\Models\Products\ProductVariationType;
use Tests\TestCase;

class ProductVariationControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = app()->make(ProductVariationController::class)->index();

        $this->assertEquals(200, $response->status());
    }

    public function testStore()
    {
        $response = app()->make(ProductVariationController::class)->store(new \Illuminate\Http\Request([
            'name' => 'Test Variation'
        ]));

        $this->assertEquals(200, $response->status());
    }

    public function testUpdate()
    {
        $variation = ProductVariationType::factory()->create();

        $response = app()->make(ProductVariationController::class)->update(new \Illuminate\Http\Request([
            'name' => 'Test Variation'
        ]), $variation);

        $this->assertEquals(200, $response->status());
    }

    public function testDestroy()
    {
        $variation = ProductVariationType::factory()->create();

        $response = app()->make(ProductVariationController::class)->destroy($variation);

        $this->assertEquals(204, $response->status());
    }
}
