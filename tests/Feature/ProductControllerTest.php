<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
    }
}
