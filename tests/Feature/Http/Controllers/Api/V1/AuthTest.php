<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Helpers\AppHelper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_sanctum_authentication(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*'],
        );

        $response = $this->get('/api/user');
        $response->assertOk();
    }

    public function test_register_return_successful(): void
    {
        $response = $this->post('/api/v1/register', [
            'name' => AppHelper::randStr(),
            'email' => AppHelper::randEmail(),
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertJsonStructure([
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'email',
                ], 'token',
            ],
        ]);
    }

    public function test_login_return_successful(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertJsonStructure([
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'email',
                ], 'token',
            ],
        ]);
    }

    public function test_login_return_failed(): void
    {
        $response = $this->post('/api/v1/login', [
            'email' => AppHelper::randEmail(),
            'password' => 'password',
        ]);

        $response->assertJsonStructure([
            'message',
        ]);
    }

    public function test_logout_return_successful(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*'],
        );

        $response = $this->post('/api/v1/logout');
        $response->assertOk();
    }
}
