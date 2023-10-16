<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\CategoryFilter;
use App\Http\Controllers\BaseController;
use App\Http\Requests\DeleteCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\V1\CategoryCollection;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = (new CategoryFilter())->transform($request);
        $categories = Category::where($query);

        return $this->sendResponse(
            new CategoryCollection($categories->paginate(5)->appends($request->query())),
            'Categories retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        return $this->sendResponse(
            new CategoryResource(Category::create($request->all())),
            'Category created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): JsonResponse
    {
        return $this->sendResponse(
            new CategoryResource($category),
            'Category retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category->update($request->all());

        return $this->sendResponse(
            new CategoryResource($category),
            'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteCategoryRequest $request, Category $category): JsonResponse
    {
        $category->delete();

        return $this->sendResponse([], 'Category deleted successfully');
    }
}
