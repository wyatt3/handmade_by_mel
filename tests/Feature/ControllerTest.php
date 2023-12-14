<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
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

    public function testAdminAbout()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('admin.about'));

        $response->assertStatus(200);
    }

    public function testAdminAboutUpdate()
    {
        File::shouldReceive('put')->once()->withAnyArgs();
        $this->actingAs($this->user);
        $response = $this->post(route('admin.about'), [
            'about' => 'This is the about page',
        ]);

        $response->assertRedirect(route('admin.about'));
    }
}
