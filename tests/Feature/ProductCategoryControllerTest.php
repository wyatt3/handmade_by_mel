<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductCategoryController;
use App\Models\Products\ProductCategory;
use Tests\TestCase;

class ProductCategoryControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = app()->make(ProductCategoryController::class)->index();

        $this->assertEquals(200, $response->status());
    }

    public function testStore()
    {
        $response = app()->make(ProductCategoryController::class)->store(new \Illuminate\Http\Request([
            'name' => 'Test Category'
        ]));

        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('product_categories', [
            'name' => 'Test Category'
        ]);
    }

    public function testUpdate()
    {
        $category = ProductCategory::factory()->create();

        $response = app()->make(ProductCategoryController::class)->update(new \Illuminate\Http\Request([
            'name' => 'Test Category'
        ]), $category);

        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('product_categories', [
            'name' => 'Test Category'
        ]);
    }

    public function testDestroy()
    {
        $category = ProductCategory::factory()->create();

        $response = app()->make(ProductCategoryController::class)->destroy($category);

        $this->assertEquals(204, $response->status());
        $this->assertDatabaseMissing('product_categories', [
            'name' => $category->name
        ]);
    }
}
