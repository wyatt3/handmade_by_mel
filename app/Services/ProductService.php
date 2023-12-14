<?php

namespace App\Services;

use App\Models\Products\Product;
use Illuminate\Support\Collection;

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
}
