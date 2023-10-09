<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\BlogFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\BulkStoreBlogRequest;
use App\Http\Requests\DeleteBlogRequest;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\V1\BlogCollection;
use App\Http\Resources\V1\BlogResource;
use App\Models\Blog;
use Elastic\Elasticsearch\ClientBuilder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): BlogCollection
    {
        $query = (new BlogFilter())->transform($request);
        $blogs = Blog::where($query)->with('category');

        return new BlogCollection($blogs->paginate(5)->appends($request->query()));
    }

    /**
     * Search a listing of the resource.
     */
    public function search(Request $request, string $keyword)
    {
        $elastic = $request->test ?? true;

        if ($elastic) {
            $client = ClientBuilder::create()
                ->setHosts([env('ELASTICSEARCH_HOST')])
                ->build();

            $params = [
                'index' => env('ELASTICSEARCH_INDEX'),
                'body' => [
                    'query' => [
                        'match' => [
                            'title' => $keyword,
                        ],
                    ],
                ],
            ];
            $response = $client->search($params);

            return $response->asArray();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request): BlogResource
    {
        $blog = Blog::create($request->all());

        $elastic = $request->test ?? true;

        if ($elastic) {
            $client = ClientBuilder::create()
                ->setHosts([env('ELASTICSEARCH_HOST')])
                ->build();

            $params = [
                'index' => env('ELASTICSEARCH_INDEX'),
                'id' => $blog->id,
                'body' => [
                    'title' => $blog->title,
                    'body' => $blog->body,
                ],
            ];
            $client->index($params);
        }

        return new BlogResource($blog);
    }

    /**
     * Store some newly created resource in storage.
     */
    public function bulkStore(BulkStoreBlogRequest $request): void
    {
        $bulk = collect($request->all())->map(function ($arr, $key) {
            return [
                'title' => $arr['title'],
                'body' => $arr['body'],
                'category_id' => $arr['category_id'],
                'user_id' => $arr['user_id'],
            ];
        });

        Blog::insert($bulk->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog): BlogResource
    {
        return new BlogResource($blog->loadMissing('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog): BlogResource
    {
        $blog->update($request->all());

        $elastic = $request->test ?? true;

        if ($elastic) {
            $client = ClientBuilder::create()
                ->setHosts([env('ELASTICSEARCH_HOST')])
                ->build();

            $params = [
                'index' => env('ELASTICSEARCH_INDEX'),
                'id' => $blog->id,
                'body' => [
                    'doc' => [
                        'title' => $blog->title,
                        'body' => $blog->body,
                    ],
                ],
            ];
            $client->update($params);
        }

        return new BlogResource($blog->loadMissing('category'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteBlogRequest $request, Blog $blog): void
    {
        $elastic = $request->test ?? true;

        if ($elastic) {
            $client = ClientBuilder::create()
                ->setHosts([env('ELASTICSEARCH_HOST')])
                ->build();

            $params = [
                'index' => env('ELASTICSEARCH_INDEX'),
                'id' => $blog->id,
            ];

            $client->delete($params);
        }

        $blog->delete();
    }
}
