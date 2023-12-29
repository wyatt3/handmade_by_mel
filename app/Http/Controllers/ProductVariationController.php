<?php

namespace App\Http\Controllers;

use App\Models\Products\ProductVariation;
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
            'name' => 'required|unique:product_variations,id,name',
            'price_modifier' => 'required|numeric'
        ]);

        $variation->update([
            'name' => $request->name,
            'price_modifier' => $request->price_modifier
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

    /**
     * updateOrder
     *
     * @param Request $request
     * @param ProductVariation $variation
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrder(Request $request, ProductVariation $variation): \Illuminate\Http\JsonResponse
    {
        $variation->update([
            'order' => $request->order
        ]);

        return response()->json($variation);
    }

    /**
     * updateImage
     *
     * @param Request $request
     * @param ProductVariation $variation
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateImage(Request $request, ProductVariation $variation): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'image' => 'required|image'
        ]);

        $variation->update([
            'image' => $request->image->store('product_variation_images', 'public')
        ]);

        return response()->json($variation);
    }
}
