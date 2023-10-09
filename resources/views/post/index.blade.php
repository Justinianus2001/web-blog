@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-8">
            <h1 class="display-one">List of Blogs</h1>
        </div>
        <div class="col-4">
            <p>Create new Post</p>
            <a href="{{ route('post.create') }}" class="btn btn-primary btn-sm">Add Post</a>
        </div>
    </div>
    @foreach($posts as $post)
        <ul>
            <li><a href="{{ route('post.show', ['post' => $post]) }}">{{ ucfirst($post->title) }}</a></li>
        </ul>
    @empty
        <p class="text-warning">No blog Posts available</p>
    @endforeach
@endsection