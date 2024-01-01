<?php

namespace App\Http\Controllers;

use App\Models\Products\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
            'name' => [
                'required',
                Rule::unique('product_variations', 'name')
                    ->where('product_variation_type_id', $request->input('product_variation_type_id'))
                    ->where('product_id', $request->input('product_id'))
            ],
            'product_id' => 'required|exists:products,id',
            'product_variation_type_id' => 'required|exists:product_variation_types,id'
        ]);

        $max = ProductVariation::where('product_id', $request->product_id)
            ->where('product_variation_type_id', $request->product_variation_type_id)
            ->max('order') + 1;

        $type = ProductVariation::create([
            'name' => $request->name,
            'price_modifier' => $request->price_modifier ?? 0,
            'active' => true,
            'order' => $max,
            'product_id' => $request->product_id,
            'product_variation_type_id' => $request->product_variation_type_id
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
            'image' => "/storage/" . $request->image->store('product_variation_images', 'public')
        ]);

        return response()->json($variation);
    }

    /**
     * deleteImage
     *
     * @param ProductVariation $variation
     * @return \Illuminate\Http\Response
     */
    public function deleteImage(ProductVariation $variation): \Illuminate\Http\Response
    {
        Storage::disk('public')->delete(str_replace('/storage/', '', $variation->image));

        $variation->update([
            'image' => null
        ]);

        return response()->noContent();
    }
}
