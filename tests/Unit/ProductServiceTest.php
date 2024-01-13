<?php

namespace Tests\Unit;

use App\Models\Products\Product;
use App\Models\Products\ProductCategory;
use App\Models\Products\ProductImage;
use App\Services\ProductService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function testCreateProduct()
    {
        $category = ProductCategory::factory()->create();

        $product = $this->productService->createProduct('Test', 'sku', 'description', 1.00, 2.00, $category);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertDatabaseHas('products', [
            'name' => 'Test',
            'sku' => 'sku',
            'description' => 'description',
            'price' => 1.00,
            'sale_price' => 2.00,
            'product_category_id' => $category->getKey(),
        ]);
    }

    public function testUpdateProduct()
    {
        $product = Product::factory()->create([
            'name' => 'Test Product',
        ]);

        $updatedProduct = $this->productService->updateProduct($product, $product->category, 'Test Product 2', 'new sku', 'new description', 2.00, 1.00);

        $this->assertEquals('Test Product 2', $updatedProduct->name);
        $this->assertEquals('new sku', $updatedProduct->sku);
        $this->assertEquals('new description', $updatedProduct->description);
        $this->assertEquals(2.00, $updatedProduct->price);
        $this->assertEquals(1.00, $updatedProduct->sale_price);
    }

    public function testStoreImage()
    {
        Storage::fake('public');
        $product = Product::factory()->create();
        $file = UploadedFile::fake()->image('test.jpg');

        $productImage = $this->productService->storeImage($product, $file);

        $this->assertInstanceOf(ProductImage::class, $productImage);
        $this->assertEquals($product->id, $productImage->product_id);

        Storage::disk('public')->assertExists("products/{$file->hashName()}");
    }

    public function testUpdateImageOrder()
    {
        $image = ProductImage::factory()->create();

        $this->productService->updateImageOrder($image, 10);

        $this->assertDatabaseHas('product_images', [
            'id' => $image->getKey(),
            'order' => 10,
        ]);
    }

    public function testDeleteProductImage()
    {
        Storage::fake('public');
        $image = ProductImage::factory()->create();

        $this->productService->deleteImage($image);

        $this->assertDatabaseMissing('product_images', [
            'id' => $image->getKey(),
        ]);
        Storage::disk('public')->assertMissing($image->path);
    }
}
