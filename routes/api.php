<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
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
        Route::get('/', [ProductController::class, 'getProducts']);
        Route::put('/{product}/active', [ProductController::class, 'updateActiveStatus']);
        Route::get('/{product}', [ProductController::class, 'show']);
    });
});

Route::get('/listings', [ListingController::class, 'getActiveListings']);
