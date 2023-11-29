<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetListingsRequest;
use App\Models\Products\Product;
use App\Services\ProductService;
use Illuminate\Support\Collection;

class ListingController extends Controller
{
    public ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getActiveListings(GetListingsRequest $request)
    {
        $request->validated();

        $listings = $this->productService->getProducts($request->input('offset'), $request->input('limit'), $request->input('category_id'), true, $request->input('search'));

        return response()->json($listings);
    }

    public function show($listing)
    {
        $product = Product::where('name', $listing)->firstOrFail();

        /** @var Collection $related */
        $related = $product->category->products()
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        if ($related->count() < 4) {
            $related = $related->merge(Product::where('id', '!=', $product->id)
                ->where('product_category_id', '!=', $product->product_category_id)
                ->where('active', true)
                ->limit(4 - $related->count())
                ->get());
        }

        return view('listing', [
            'product' => $product->loadMissing('category', 'variations'),
            'related' => $related,
        ]);
    }
}
