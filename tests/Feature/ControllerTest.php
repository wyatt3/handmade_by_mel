<?php

namespace Tests\Feature;

use Tests\TestCase;

class ControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
    }

    public function testAbout()
    {
        $response = $this->get(route('about'));

        $response->assertStatus(200);
    }
}
