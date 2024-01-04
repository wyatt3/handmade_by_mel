<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductController;
use App\Models\Products\Product;
use App\Models\Products\ProductCategory;
use App\Models\Products\ProductImage;
use App\Services\ProductService;
use Illuminate\Http\UploadedFile;
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

    public function testStore()
    {
        $this->mock(ProductService::class, function ($mock) {
            $mock->shouldReceive('createProduct')
                ->once()
                ->andReturn(Product::factory()->make());
            $mock->shouldReceive('storeImage')
                ->times(2)
                ->andReturn(ProductImage::factory()->make());
        });

        $response = app()->make(ProductController::class)->store(new \Illuminate\Http\Request([
            'name' => 'test',
            'sku' => 'test',
            'description' => 'test',
            'product_category_id' => ProductCategory::factory()->create()->getKey(),
            'price' => 1.00,
            'active' => true,
        ], [], [], [], [
            'images' => [
                UploadedFile::fake()->image('test.jpg'),
                UploadedFile::fake()->image('test2.jpg'),
            ],
        ]));

        $this->assertEquals(302, $response->status());
    }

    public function testCreate()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('product.create'));

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $product = Product::factory()->create();
        $this->mock(ProductService::class, function ($mock) use ($product) {
            $mock->shouldReceive('updateProduct')
                ->once()
                ->andReturn($product);
        });

        $response = app()->make(ProductController::class)->update(new \Illuminate\Http\Request([
            'name' => 'test',
            'sku' => 'test',
            'description' => 'test',
            'product_category_id' => ProductCategory::factory()->create()->getKey(),
            'price' => 1.00,
            'active' => true,
        ]), $product);

        $this->assertEquals(200, $response->status());
    }

    public function testUpdateActiveStatus()
    {
        $product = Product::factory()->create();
        $response = app()->make(ProductController::class)->updateActiveStatus(new \Illuminate\Http\Request([
            'active' => false
        ]), $product);

        $this->assertEquals(204, $response->status());
        $this->assertDatabaseHas('products', [
            'id' => $product->getKey(),
            'active' => false
        ]);
    }

    public function testStoreImages()
    {
        $this->mock(ProductService::class, function ($mock) {
            $mock->shouldReceive('storeImage')
                ->once()
                ->andReturn(ProductImage::factory()->make());
        });

        $product = Product::factory()->create();
        $response = app()->make(ProductController::class)->storeImages(new \Illuminate\Http\Request(
            [
                'product_id' => $product->getKey(),
            ],
            [],
            [],
            [],
            [
                'images' => [UploadedFile::fake()->image('test.jpg')],
            ]
        ));

        $this->assertEquals(200, $response->status());
    }

    public function testUpdateImageOrder()
    {
        $image = ProductImage::factory()->create();

        $this->mock(ProductService::class, function ($mock) use ($image) {
            $mock->shouldReceive('updateImageOrder')
                ->once()
                ->andReturn($image);
        });

        $response = app()->make(ProductController::class)->updateImageOrder(new \Illuminate\Http\Request([
            'order' => 2
        ]), $image);

        $this->assertEquals(204, $response->status());
    }

    public function testDeleteImage()
    {
        $image = ProductImage::factory()->create();

        $this->mock(ProductService::class, function ($mock) use ($image) {
            $mock->shouldReceive('deleteImage')
                ->once();
        });

        $response = app()->make(ProductController::class)->deleteImage($image);

        $this->assertEquals(204, $response->status());
    }
}
