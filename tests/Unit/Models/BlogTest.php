<?php

namespace Tests\Unit\Models;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_blogs_table_has_expected_columns(): void
    {
        $this->assertTrue(Schema::hasColumns('blogs', [
            'id', 'title', 'body', 'image', 'user_id', 'category_id',
        ]), 1);
    }

    public function test_blog_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $blog->user);
    }

    public function test_blog_belongs_to_category(): void
    {
        $category = Category::factory()->create();
        $blog = Blog::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $blog->category);
    }
}
