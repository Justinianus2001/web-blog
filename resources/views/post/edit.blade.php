@extends('layouts.app')
@section('content')
    <a href="{{ route('post.show', ['post' => $post]) }}" class="btn btn-outline-primary btn-sm">Go back</a>
    <div class="border rounded mt-5 ps-4 pe-4 pt-4 pb-4">
        <h1 class="display-4">Edit Post</h1>
        <p>Edit and submit this form to update a post</p>
        <hr>
        <form action="" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="control-group col-12">
                    <label for="title">Post Title</label>
                    <input type="text" id="title" class="form-control" name="title"
                        placeholder="Enter Post Title" value="{{ $post->title }}" required>
                    @if ($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="control-group col-12 mt-2">
                    <label for="body">Post Body</label>
                    <textarea id="body" class="form-control" name="body"
                        placeholder="Enter Post Body" rows="5" required>{{ $post->body }}</textarea>
                    @if ($errors->has('body'))
                        <span class="text-danger">{{ $errors->first('body') }}</span>
                    @endif
                </div>
                <div class="control-group col-12 mt-2">
                    <label for="category">Post Category</label>
                    <select id="category" class="form-control" name="category">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            @if ($post->category_id == $category->id)
                                <option value="{{ $category->id }}" selected>
                                    {{ $category->name }}
                                </option>
                            @else
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @if ($errors->has('category'))
                        <span class="text-danger">{{ $errors->first('category') }}</span>
                    @endif
                </div>
            </div>
            <div class="row mt-2">
                <div class="control-group col-12 text-center">
                    <button id="btn-submit" class="btn btn-primary">
                        Update Post
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection