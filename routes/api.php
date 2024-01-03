<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariationController;
use App\Http\Controllers\ProductVariationTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::domain('admin.' . env('APP_URL'))->middleware('auth:sanctum')->group(function () {
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
    });

    Route::prefix('products')->group(function () {
        Route::prefix('categories')->group(function () {
            Route::get('/', [ProductCategoryController::class, 'index']);
            Route::post('/', [ProductCategoryController::class, 'store']);
            Route::put('/{category}', [ProductCategoryController::class, 'update']);
            Route::delete('/{category}', [ProductCategoryController::class, 'destroy']);
        });

        Route::prefix('variations')->group(function () {
            Route::prefix('types')->group(function () {
                Route::get('/', [ProductVariationTypeController::class, 'index']);
                Route::post('/', [ProductVariationTypeController::class, 'store']);
                Route::put('/{type}', [ProductVariationTypeController::class, 'update']);
                Route::delete('/{type}', [ProductVariationTypeController::class, 'destroy']);
            });

            Route::post('/', [ProductVariationController::class, 'store']);
            Route::put('/{variation}', [ProductVariationController::class, 'update']);
            Route::put('/{variation}/active', [ProductVariationController::class, 'updateActiveStatus']);
            Route::put('/{variation}/order', [ProductVariationController::class, 'updateOrder']);
            Route::post('/{variation}/image', [ProductVariationController::class, 'updateImage']);
            Route::delete('/{variation}/image', [ProductVariationController::class, 'deleteImage']);
            Route::delete('/{variation}', [ProductVariationController::class, 'destroy']);
        });

        Route::prefix('images')->group(function () {
            Route::post('/', [ProductController::class, 'storeImages']);
            Route::put('/{image}', [ProductController::class, 'updateImageOrder']);
            Route::delete('/{image}', [ProductController::class, 'deleteImage']);
        });

        Route::get('/', [ProductController::class, 'getProducts']);
        Route::put('/{product}/active', [ProductController::class, 'updateActiveStatus']);
        Route::get('/{product}', [ProductController::class, 'show']);
    });
});

Route::get('/listings', [ListingController::class, 'getActiveListings']);
