<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetListingsRequest;
use App\Models\Products\Product;
use App\Services\ProductService;
use Illuminate\Support\Collection;

class ListingController extends Controller
{
    public function __construct(
        public ProductService $productService
    ) {
    }

    /**
     * get a list of active listings
     *
     * @param GetListingsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getActiveListings(GetListingsRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->validated();

        $listings = $this->productService->getProducts($request->input('offset'), $request->input('limit'), $request->input('category_id'), true, $request->input('search'), $request->input('sort'), $request->input('sort_desc'));

        return response()->json($listings);
    }

    /**
     * show a listing
     *
     * @param string $listing
     * @return \Illuminate\Contracts\View\View
     */
    public function show(string $listing): \Illuminate\Contracts\View\View
    {
        /** @var Product $product */
        $product = Product::with([
            'variations' => function ($query) {
                $query->where('active', true)->orderBy('order')->with('type');
            },
            'images',
        ])
            ->where('name', $listing)
            ->firstOrFail();

        $product->groupedVariations = $product->variations->sortBy('order')->groupBy('type.name')->sortKeys();

        /** @var Collection<Product> $related */
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

        $related->load('images');

        return view('listing', compact('product', 'related'));
    }
}
