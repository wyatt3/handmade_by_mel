<?php

namespace App\Http\Controllers;

use App\Models\Products\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * index
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = ProductCategory::orderBy('name')->get();
        return response()->json($categories);
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
            'name' => 'required|unique:product_categories,name'
        ]);

        $category = ProductCategory::create([
            'name' => $request->name
        ]);

        return response()->json($category);
    }

    /**
     * update
     *
     * @param Request $request
     * @param ProductCategory $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ProductCategory $category): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required|unique:product_categories,name'
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return response()->json($category);
    }

    /**
     * destroy
     *
     * @param ProductCategory $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $category): \Illuminate\Http\Response
    {
        $category->delete();
        return response()->noContent();
    }
}
