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

    public function testAuthenticatedUserGetsRedirected()
    {
        $response = $this->actingAs($this->user)->get(route('login'));

        $response->assertRedirect(route('home'));
    }

    public function testUnauthenticatedUserGetsRedirected()
    {
        $response = $this->get(route('admin.home'));

        $response->assertRedirect(route('login'));
    }

    public function testAdminIndex()
    {
        $response = $this->actingAs($this->user)->get(route('admin.home'));

        $response->assertStatus(200);
    }
}
