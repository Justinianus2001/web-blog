<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Helpers\AppHelper;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_category_index_return_successful(): void
    {
        Category::factory()->count(10)->create();

        $response = $this->get('/api/v1/category');
        $response->assertOk();
    }

    public function test_category_store_return_successful(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['category:store'],
        );

        $response = $this->post('/api/v1/category', [
            'name' => AppHelper::randStr(),
        ]);
        $response->assertCreated();
    }

    public function test_category_show_return_successful(): void
    {
        $category = Category::factory()->create();

        $response = $this->get('/api/v1/category/' . $category->id);
        $response->assertOk();
    }

    public function test_category_update_return_successful(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['category:update'],
        );

        $category = Category::factory()->create();

        $response = $this->put('/api/v1/category/' . $category->id, [
            'name' => AppHelper::randStr(),
        ]);
        $response->assertOk();
    }

    public function test_category_delete_return_successful(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['category:delete'],
        );

        $category = Category::factory()->create();

        $response = $this->delete('/api/v1/category/' . $category->id);
        $response->assertOk();
    }
}
