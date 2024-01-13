<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductVariationController;
use App\Models\Products\Product;
use App\Models\Products\ProductVariation;
use App\Models\Products\ProductVariationType;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductVariationControllerTest extends TestCase
{

    public function testStore()
    {
        $product = Product::factory()->create()->getKey();
        $variationType = ProductVariationType::factory()->create()->getKey();

        $response = app()->make(ProductVariationController::class)->store(new \Illuminate\Http\Request([
            'name' => 'test',
            'product_id' => $product,
            'product_variation_type_id' => $variationType
        ]));

        $this->assertDatabaseHas('product_variations', [
            'name' => 'test',
            'product_id' => $product,
            'product_variation_type_id' => $variationType,
        ]);

        $this->assertEquals(200, $response->status());
    }

    public function testUpdate()
    {
        $variation = ProductVariation::factory()->create();
        $response = app()->make(ProductVariationController::class)->update(new \Illuminate\Http\Request([
            'name' => 'test',
            'price_modifier' => 10
        ]), $variation);

        $this->assertDatabaseHas('product_variations', [
            'id' => $variation->getKey(),
            'name' => 'test',
            'price_modifier' => 10
        ]);

        $this->assertEquals(200, $response->status());
    }

    public function testDestroy()
    {
        $variation = ProductVariation::factory()->create();
        $response = app()->make(ProductVariationController::class)->destroy($variation);

        $this->assertDatabaseMissing('product_variations', [
            'id' => $variation->getKey()
        ]);

        $this->assertEquals(204, $response->status());
    }

    public function testUpdateActiveStatus()
    {
        $variation = ProductVariation::factory()->create([
            'active' => true
        ]);
        $response = app()->make(ProductVariationController::class)->updateActiveStatus(new \Illuminate\Http\Request([
            'active' => false
        ]), $variation);

        $this->assertDatabaseHas('product_variations', [
            'id' => $variation->getKey(),
            'active' => false
        ]);

        $this->assertEquals(200, $response->status());
    }

    public function testUpdateOrder()
    {
        $variation = ProductVariation::factory()->create([
            'order' => 1
        ]);
        $response = app()->make(ProductVariationController::class)->updateOrder(new \Illuminate\Http\Request([
            'order' => 2
        ]), $variation);

        $this->assertDatabaseHas('product_variations', [
            'id' => $variation->getKey(),
            'order' => 2
        ]);

        $this->assertEquals(200, $response->status());
    }

    public function testUpdateImage()
    {
        Storage::fake('public');
        $variation = ProductVariation::factory()->create();
        $response = app()->make(ProductVariationController::class)->updateImage(new \Illuminate\Http\Request(
            [],
            [],
            [],
            [],
            [
                'image' => $file = \Illuminate\Http\UploadedFile::fake()->image('test.jpg')
            ]
        ), $variation);

        $variation = json_decode($response->getContent());

        $this->assertDatabaseHas('product_variations', [
            'id' => $variation->id,
            'image' => $variation->image
        ]);
        $this->assertEquals(200, $response->status());
        Storage::disk('public')->assertExists("product_variation_images/{$file->hashName()}");
    }

    public function testDeleteImage()
    {
        $variation = ProductVariation::factory()->create([
            'image' => 'test.jpg'
        ]);
        $response = app()->make(ProductVariationController::class)->deleteImage($variation);

        $this->assertDatabaseHas('product_variations', [
            'id' => $variation->getKey(),
            'image' => null
        ]);

        $this->assertEquals(204, $response->status());
    }
}
