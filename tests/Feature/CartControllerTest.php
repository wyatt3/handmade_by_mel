<?php

namespace Tests\Feature;

use Tests\TestCase;

class CartControllerTest extends TestCase
{

    public function testItShowsTheCartPage()
    {
        $response = $this->get(route('cart.index'));

        $response->assertStatus(200);
    }

    public function testItShowsTheCheckoutPage()
    {
        $response = $this->get(route('cart.checkout'));

        $response->assertStatus(200);
    }
}
