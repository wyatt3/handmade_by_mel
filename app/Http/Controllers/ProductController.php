<?php

namespace App\Http\Controllers;

use App\Models\Products\Product;
use App\Models\Products\ProductImage;
use App\Services\ProductService;
use Illuminate\Http\Request;

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
        $product->load('category', 'variations.type');
        $product->sortedImages = $product->images->sortBy('order')->values();
        $product->groupedVariations = $product->variations->sortBy('order')->groupBy('type.name')->sortKeys();
        return response()->json($product);
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

    /**
     * updateActiveStatus
     *
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function updateActiveStatus(Request $request, Product $product): \Illuminate\Http\Response
    {
        $this->productService->updateActiveStatus($product, (bool) $request->input('active'));

        return response()->noContent();
    }

    /**
     * storeImage
     *
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeImages(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'required|image',
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->input('product_id'));

        dd($request->file('images'));
        // $this->productService->storeImage($product, $request->file('images'));

        return response()->json();
    }

    /**
     * updateImageOrder
     *
     * @param Request $request
     * @param ProductImage $image
     * @return \Illuminate\Http\Response
     */
    public function updateImageOrder(Request $request, ProductImage $image): \Illuminate\Http\Response
    {
        $this->productService->updateImageOrder($image, $request->input('order'));

        return response()->noContent();
    }

    /**
     * deleteImage
     *
     * @param Product $product
     * @param int $imageId
     * @return \Illuminate\Http\Response
     */
    public function deleteImage(ProductImage $image): \Illuminate\Http\Response
    {
        $this->productService->deleteImage($image);

        return response()->noContent();
    }
}
