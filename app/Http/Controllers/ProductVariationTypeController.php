<?php

namespace App\Http\Controllers;

use App\Models\Products\ProductVariationType;
use Illuminate\Http\Request;

class ProductVariationTypeController extends Controller
{
    /**
     * index
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $types = ProductVariationType::orderBy('name')->get();
        return response()->json($types);
    }

    /**
     * store
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required|unique:product_variation_types,name'
        ]);

        $type = ProductVariationType::create([
            'name' => $request->name
        ]);

        return response()->json($type);
    }

    /**
     * update
     *
     * @param Request $request
     * @param ProductVariationType $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ProductVariationType $type): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required|unique:product_variation_types,name'
        ]);

        $type->update([
            'name' => $request->name
        ]);

        return response()->json($type);
    }

    /**
     * destroy
     *
     * @param ProductVariationType $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductVariationType $type): \Illuminate\Http\Response
    {
        $type->delete();
        return response()->noContent();
    }
}
