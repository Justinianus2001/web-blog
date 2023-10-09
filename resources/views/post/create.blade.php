@extends('layouts.app')
@section('content')
    <a href="{{ route('post.index') }}" class="btn btn-outline-primary btn-sm">Go back</a>
    <div class="border rounded mt-5 ps-4 pe-4 pt-4 pb-4">
        <h1 class="display-4">Create Post</h1>
        <p>Fill and submit this form to create a post</p>
        <hr>
        <form action="" method="POST">
            @csrf
            <div class="row">
                <div class="control-group col-12">
                    <label for="title">Post Title</label>
                    <input type="text" id="title" class="form-control" name="title"
                        placeholder="Enter Post Title" required>
                    @if ($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="control-group col-12 mt-2">
                    <label for="body">Post Body</label>
                    <textarea id="body" class="form-control" name="body"
                        placeholder="Enter Post Body" rows="5" required></textarea>
                    @if ($errors->has('body'))
                        <span class="text-danger">{{ $errors->first('body') }}</span>
                    @endif
                </div>
                <div class="control-group col-12 mt-2">
                    <label for="category">Post Category</label>
                    <select id="category" class="form-control" name="category">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
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
                        Create Post
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection