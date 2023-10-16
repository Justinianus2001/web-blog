<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\BlogFilter;
use App\Http\Controllers\BaseController;
use App\Http\Requests\BulkStoreBlogRequest;
use App\Http\Requests\DeleteBlogRequest;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\V1\BlogCollection;
use App\Http\Resources\V1\BlogResource;
use App\Models\Blog;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = (new BlogFilter())->transform($request);
        $blogs = Blog::where($query)->with(['user', 'category'])
            ->paginate(5)->appends($request->query());

        return $this->sendResponse(
            new BlogCollection($blogs),
            'Blogs retrieved successfully');
    }

    /**
     * Search a listing of the resource.
     */
    public function search(Request $request)
    {
        $elastic = $request->test ?? true;
        $keyword = $request->keyword;
        $ids = [];

        if ($elastic && isset($keyword)) {
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

            foreach ($response['hits']['hits'] as $hit) {
                $ids[] = $hit['_id'];
            }
        }

        $blogs = Blog::whereIn('id', $ids)->with(['user', 'category'])
            ->paginate(5)->appends($request->query())
            ->sortBy(function($model) use ($ids) {
                return array_search($model->getKey(), $ids);
            });

        return $this->sendResponse(
            new BlogCollection($blogs),
            'Blogs retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request): JsonResponse
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

        return $this->sendResponse(
            new BlogResource($blog),
            'Blog created successfully', 201);
    }

    /**
     * Store some newly created resource in storage.
     */
    public function bulkStore(BulkStoreBlogRequest $request): JsonResponse
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

        return $this->sendResponse([], 'Blog created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog): JsonResponse
    {
        return $this->sendResponse(
            new BlogResource($blog->loadMissing('category')),
            'Blog retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog): JsonResponse
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

        return $this->sendResponse(
            new BlogResource($blog->loadMissing('category')),
            'Blog updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteBlogRequest $request, Blog $blog): JsonResponse
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

        return $this->sendResponse([], 'Blog deleted successfully');
    }
}
