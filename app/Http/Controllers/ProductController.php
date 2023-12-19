<?php

namespace App\Http\Controllers;

use App\Models\Products\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    public ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * getProducts
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts()
    {
        $products = $this->productService->getProducts(null, null, null, false, null, 'name');

        return response()->json($products->load('category'));
    }

    /**
     * index
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('admin.products.index');
    }

    /**
     * show
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product): \Illuminate\Http\JsonResponse
    {
        return response()->json($product->load('category', 'variations'));
    }

    /**
     * create
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('admin.products.create');
    }
}
