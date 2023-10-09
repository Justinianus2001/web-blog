@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-8">
            <h1 class="display-one">List of Categories</h1>
        </div>
        <div class="col-4">
            <p>Create new Category</p>
            <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm">Add Category</a>
        </div>
    </div>
    @foreach($categories as $category)
        <ul>
            <li>
                {{ ucfirst($category->name) }}
                <a href="{{ route('category.edit', ['category' => $category]) }}">
                    <i class="bi bi-pencil-square"></i>
                </a>
            </li>
        </ul>
    @empty
        <p class="text-warning">No Categories available</p>
    @endforeach
@endsection