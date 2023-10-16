<?php

namespace Tests\Unit\Models;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_categories_table_has_expected_columns(): void
    {
        $this->assertTrue(Schema::hasColumns('categories', [
            'id', 'name',
        ]), 1);
    }

    public function test_category_has_many_blogs(): void
    {
        $category = Category::factory()->create();
        $blog = Blog::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Collection::class, $category->blogs);
    }
}
