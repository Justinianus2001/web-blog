<?php

namespace Tests\Feature\Http\Controllers\Web\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_dashboard_return_successful(): void
    {
        $response = $this->get('/');
        $response->assertOk();
    }

    public function test_login_return_successful(): void
    {
        $response = $this->get('/login');
        $response->assertOk();
    }

    public function test_register_return_successful(): void
    {
        $response = $this->get('/register');
        $response->assertOk();
    }
}
