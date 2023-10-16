@extends('layouts.app')
@section('content')
    <a href="{{ route('blog.index') }}" class="btn btn-outline-primary btn-sm">Go back</a>
    <div class="blog-show"></div>
    <hr>
    @if (auth('sanctum')->user() && auth('sanctum')->user()->id == $blog->user_id)
        <a href="{{ route('blog.edit', ['blog' => $blog->id]) }}" class="btn btn-outline-primary">Edit Post</a>
        <br><br>
        <form id="form-delete-blog" class="" action="" method="POST">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-danger">Delete Post</button>
        </form>
    @endif
@endsection
@section('scripts')
    <script>
        $.ajax({
            url: "{{ route('api.blog.show', ['blog' => $blog->id]) }}",
            type: "GET",
            success: function (response) {
                $('.blog-show').append(`
                    <h1 class="display-one">` + response.data.title + `</h1>
                    <p>` + response.data.body + `</p>
                `);
            },
            error: function (error) {
                alert(error.responseJSON.message)
            }
        });
        $('#form-delete-blog').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('api.blog.destroy', ['blog' => $blog]) }}",
                type: "DELETE",
                headers: {"Authorization": "Bearer " + localStorage.getItem('token')},
                data: $(this).serialize(),
                success: function (response) {
                    alert(response.message);
                    window.location.href = "{{ route('blog.index') }}";
                },
                error: function (error) {
                    alert(error.responseJSON.message);
                }
            });
        });
    </script>
@endsection