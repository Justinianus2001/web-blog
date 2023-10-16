@extends('layouts.app')
@section('content')
    <a href="{{ route('blog.show', ['blog' => $blog]) }}" class="btn btn-outline-primary btn-sm">Go back</a>
    <div class="border rounded mt-5 ps-4 pe-4 pt-4 pb-4">
        <h1 class="display-4">Edit Blog</h1>
        <p>Edit and submit this form to update a blog</p>
        <hr>
        <form action="" method="POST" id="form-edit-blog">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="control-group col-12">
                    <label for="title">Blog Title</label>
                    <input type="text" id="title" class="form-control" name="title"
                        placeholder="Enter Blog Title" required>
                    @if ($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="control-group col-12 mt-2">
                    <label for="body">Blog Body</label>
                    <textarea id="body" class="form-control" name="body"
                        placeholder="Enter Blog Body" rows="5" required></textarea>
                    @if ($errors->has('body'))
                        <span class="text-danger">{{ $errors->first('body') }}</span>
                    @endif
                </div>
                <div class="control-group col-12 mt-2">
                    <label for="category">Blog Category</label>
                    <select id="category" class="form-control" name="categoryId" required>
                        <option value="">Select Category</option>
                    </select>
                    @if ($errors->has('category'))
                        <span class="text-danger">{{ $errors->first('category') }}</span>
                    @endif
                </div>
            </div>
            <div class="row mt-2">
                <div class="control-group col-12 text-center">
                    <button id="btn-submit" class="btn btn-primary">
                        Update Blog
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $.ajax({
            url: "{{ route('api.category.index') }}",
            type: "GET",
            success: function (response) {
                $.each(response.data, function (index, value) {
                    $('#category').append(`
                        <option value="` + value.id + `">
                            ` + value.name + `
                        </option>
                    `);
                });
            },
            error: function (error) {
                alert(error.responseJSON.message)
            }
        });
        $.ajax({
            url: "{{ route('api.blog.show', ['blog' => $blog]) }}",
            type: "GET",
            success: function (response) {
                $('#title').val(response.data.title);
                $('#body').val(response.data.body);
                $('#category').val(response.data.category.id);
            },
            error: function (error) {
                alert(error.responseJSON.message)
            }
        });
        $('#form-edit-blog').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('api.blog.update', ['blog' => $blog]) }}",
                type: "POST",
                headers: {"Authorization": "Bearer " + localStorage.getItem('token')},
                data: $(this).serialize(),
                success: function (response) {
                    alert(response.message);
                    window.location.href = "/blog/" + response.data.id;
                },
                error: function (error) {
                    alert(error.responseJSON.message);
                }
            });
        });
    </script>
@endsection