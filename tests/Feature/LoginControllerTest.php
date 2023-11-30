<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginControllerTest extends TestCase
{

    public function testItShowsTheLoginPage()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    public function testLogIn()
    {
        $response = $this->post(route('login'), [
            'email' => $this->user->email,
            'password' => $this->user->email,
        ]);

        $response->assertRedirect(route('home'));
    }

    public function testUnauthenticatedUserGetsRedirected()
    {
        $response = $this->get(route('admin.home'));

        dd(route('admin.home'));
        $response->assertRedirect(route('login'));
    }
}
