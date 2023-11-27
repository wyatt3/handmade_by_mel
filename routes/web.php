<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('home');


Route::domain('admin.' . env('APP_URL'))->group(function () {
    Auth::routes(['register' => false, 'password.request' => false, 'password.reset' => false, 'password.update' => false, 'password.confirm' => false, 'email.verification' => false, 'email.verification.notice' => false]);
    Route::get('/', function () {
        return view('index');
    })->name('admin.home');
});
