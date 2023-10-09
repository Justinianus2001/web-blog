<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Helpers\AppHelper;
use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_blog_index_return_successful(): void
    {
        Blog::factory()->count(10)->create();

        $response = $this->get('/api/v1/blog?userId[eq]=1');
        $response->assertOk();
    }

    public function test_blog_search_return_successful(): void
    {
        Blog::factory()->count(10)->create();

        $response = $this->get('/api/v1/blog/search/a?test=0');
        $response->assertOk();
    }

    public function test_blog_store_return_successful(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['blog:store']
        );

        $response = $this->post('/api/v1/blog', [
            'title' => AppHelper::randStr(),
            'body' => AppHelper::randStr(),
            'categoryId' => Category::factory()->create()->id,
            'test' => false,
        ]);
        $response->assertCreated();
    }

    public function test_blog_bulk_store_return_successful(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['blog:store']
        );

        $response = $this->post('/api/v1/blog/bulk', [
            [
                'title' => AppHelper::randStr(),
                'body' => AppHelper::randStr(),
                'categoryId' => Category::factory()->create()->id,
            ],
            [
                'title' => AppHelper::randStr(),
                'body' => AppHelper::randStr(),
                'categoryId' => Category::factory()->create()->id,
            ],
        ]);
        $response->assertOk();
    }

    public function test_blog_show_return_successful(): void
    {
        $blog = Blog::factory()->create();

        $response = $this->get('/api/v1/blog/' . $blog->id);
        $response->assertOk();
    }

    public function test_blog_update_put_return_successful(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['blog:update']
        );

        $blog = Blog::factory()->create(['user_id' => $user->id]);

        $response = $this->put('/api/v1/blog/' . $blog->id, [
            'title' => AppHelper::randStr(),
            'body' => AppHelper::randStr(),
            'categoryId' => Category::factory()->create()->id,
            'test' => false,
        ]);
        $response->assertOk();
    }

    public function test_blog_delete_return_successful(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['blog:delete']
        );

        $blog = Blog::factory()->create(['user_id' => $user->id]);

        $response = $this->delete('/api/v1/blog/' . $blog->id . '?test=0');
        $response->assertOk();
    }
}
