<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithFaker, RefreshDatabase;

    /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }
}
