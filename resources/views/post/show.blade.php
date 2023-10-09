@extends('layouts.app')
@section('content')
    <a href="{{ route('post.index') }}" class="btn btn-outline-primary btn-sm">Go back</a>
    <h1 class="display-one">{{ ucfirst($post->title) }}</h1>
    <p>{!! $post->body !!}</p>
    <hr>
    <a href="{{ route('post.edit', ['post' => $post]) }}" class="btn btn-outline-primary">Edit Post</a>
    <br><br>
    <form id="delete-frm" class="" action="" method="POST">
        @method('DELETE')
        @csrf
        <button class="btn btn-danger">Delete Post</button>
    </form>
@endsection