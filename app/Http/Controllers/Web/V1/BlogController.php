<?php

namespace App\Http\Controllers\Web\V1;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('blog.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog): View
    {
        return view('blog.show', [
            'blog' => $blog,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog): View
    {
        return view('blog.edit', [
            'blog' => $blog,
        ]);
    }
}
