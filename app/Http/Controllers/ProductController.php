<?php

namespace App\Http\Controllers;

use App\Models\Products\Product;
use App\Models\Products\ProductCategory;
use App\Models\Products\ProductImage;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        public ProductService $productService
    ) {
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
        $categories = ProductCategory::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * store
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'sku' => 'required|string|unique:products',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'description' => 'required|string',
            'product_category_id' => 'sometimes|exists:product_categories,id',
            'images' => 'sometimes|array',
            'images.*' => 'sometimes|image',
        ]);

        if ($request->input('product_category_id')) {
            $category = ProductCategory::findOrFail($request->input('product_category_id'));
        }

        $product = $this->productService->createProduct(
            $request->input('name'),
            $request->input('sku'),
            $request->input('description'),
            $request->input('price'),
            $request->input('sale_price'),
            $category ?? null,
        );

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $this->productService->storeImage($product, $image);
            }
        }

        return redirect()->route('products.index');
    }

    /**
     * update
     *
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'sku' => 'required|string|unique:products,sku,' . $product->getKey(),
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'description' => 'required|string',
            'product_category_id' => 'required|exists:product_categories,id',

        ]);

        $category = ProductCategory::findOrFail($request->input('product_category_id'));

        $this->productService->updateProduct(
            $product,
            $category,
            $request->input('name'),
            $request->input('sku'),
            $request->input('description'),
            $request->input('price'),
            $request->input('sale_price'),
        );

        return response()->json($product);
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

        $product = Product::findOrFail($request->input('product_id'));

        $images = [];
        foreach ($request->file('images') as $image) {
            $images[] = $this->productService->storeImage($product, $image);
        }

        return response()->json($images);
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
