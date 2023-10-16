<?php

namespace Tests\Unit\Models;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_users_table_has_expected_columns(): void
    {
        $this->assertTrue(Schema::hasColumns('users', [
            'id', 'name', 'email', 'email_verified_at',
            'password', 'avatar', 'remember_token'
        ]), 1);
    }

    public function test_user_has_many_blogs(): void
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Collection::class, $user->blogs);
    }
}
