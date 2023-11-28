<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetListingsRequest;
use App\Services\ProductService;

class ListingController extends Controller
{
    public ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getActiveListings(GetListingsRequest $request)
    {
        $validated = $request->validated();

        $listings = $this->productService->getProducts($request->input('offset'), $request->input('limit'), $request->input('category_id'), true, $request->input('search'));

        return response()->json($listings);
    }
}
