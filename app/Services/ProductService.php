<?php

namespace App\Services;

use App\Models\Products\Product;
use App\Models\Products\ProductCategory;
use App\Models\Products\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    /**
     * Get Products
     *
     * @param integer|null $offset
     * @param integer|null $limit
     * @param integer|null $categoryId
     * @param boolean $restrictToActive
     * @param string|null $search
     * @return Collection
     */
    public function getProducts(
        ?int $offset = null,
        ?int $limit = null,
        ?int $categoryId = null,
        bool $restrictToActive = false,
        ?string $search = null,
        ?string $sort = null,
        ?bool $sortDesc = false
    ): Collection {
        $products = Product::query();

        if (filled($categoryId)) {
            $products->where('product_category_id', $categoryId);
        }

        if ($restrictToActive) {
            $products->where('active', true);
        }

        if (filled($search)) {
            $products->where('name', 'like', "%{$search}%");
        }

        if (filled($sort)) {
            $products->orderBy($sort, $sortDesc ? 'desc' : 'asc');
        } else {
            $products->orderByRaw('sale_price is NULL');
        }

        if (filled($offset)) {
            $products->offset($offset);
        }

        if (filled($limit)) {
            $products->limit($limit);
        }

        return $products->get();
    }

    public function updateProduct(Product $product, ProductCategory $category, string $name, string $sku, string $description, float $price, ?float $salePrice): Product
    {
        $product->update([
            'product_category_id' => $category->id,
            'name' => $name,
            'sku' => $sku,
            'description' => $description,
            'price' => $price,
            'sale_price' => $salePrice
        ]);

        return $product;
    }

    /**
     * update the active status of a product
     *
     * @param Product $product
     * @param boolean $active
     * @return Product
     */
    public function updateActiveStatus(Product $product, bool $active): Product
    {
        $product->update([
            'active' => $active
        ]);

        return $product;
    }

    /**
     * Ingests a product and image and stores it
     *
     * @param Product $product
     * @param UploadedFile $image
     * @return ProductImage
     */
    public function storeImage(Product $product, UploadedFile $image): ProductImage
    {
        $path = '/storage/' . $image->store('products', 'public');

        $productImage = ProductImage::create([
            'product_id' => $product->id,
            'order' => $product->images()->max('order') + 1,
            'path' => $path
        ]);

        return $productImage;
    }

    /**
     * Update the order of a product image
     *
     * @param ProductImage $image
     * @param integer $order
     * @return ProductImage
     */
    public function updateImageOrder(ProductImage $image, int $order): ProductImage
    {
        $image->update([
            'order' => $order
        ]);

        return $image;
    }

    /**
     * Delete a product image
     *
     * @param ProductImage $image
     * @return void
     */
    public function deleteImage(ProductImage $image): void
    {
        Storage::disk('public')->delete(str_replace('/storage/', '', $image->path));
        $image->delete();
    }
}
