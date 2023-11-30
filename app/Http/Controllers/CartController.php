<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * show the cart
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('cart.index');
    }

    /**
     * show the checkout page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function checkout(): \Illuminate\Contracts\View\View
    {
        return view('cart.checkout');
    }
}
