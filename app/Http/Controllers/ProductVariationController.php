<?php

namespace App\Http\Controllers;

use App\Models\Products\ProductVariation;
use App\Models\Products\ProductVariationType;
use Illuminate\Http\Request;

class ProductVariationController extends Controller
{
    /**
     * store
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required|unique:product_variations,name'
        ]);

        $type = ProductVariation::create([
            'name' => $request->name
        ]);

        return response()->json($type);
    }

    /**
     * update
     *
     * @param Request $request
     * @param ProductVariation $variation
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ProductVariation $variation): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required|unique:product_variations,name'
        ]);

        $variation->update([
            'name' => $request->name
        ]);

        return response()->json($variation);
    }

    /**
     * destroy
     *
     * @param ProductVariation $variation
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductVariation $variation): \Illuminate\Http\Response
    {
        $variation->delete();
        return response()->noContent();
    }

    /**
     * updateActiveStatus
     *
     * @param Request $request
     * @param ProductVariation $variation
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateActiveStatus(Request $request, ProductVariation $variation): \Illuminate\Http\JsonResponse
    {
        $variation->update([
            'active' => $request->active
        ]);

        return response()->json($variation);
    }
}
