@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-10">
            <h1 class="display-one">Categories</h1>
        </div>
        @auth
            <div class="col-2">
                <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm">Add Category</a>
            </div>
        @endauth
    </div>
    <div class="category-list"></div>
@endsection
@section('scripts')
    <script>
        $.ajax({
            url: "{{ route('api.category.index') }}",
            type: "GET",
            success: function (response) {
                $('.category-list').empty();
                if (response.data.length > 0) {
                    $.each(response.data, function (index, value) {
                        $('.category-list').append(`
                            <ul>
                                <li>
                                    ` + value.name + `
                                    <a href="/category/edit/` + value.id + `">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </li>
                            </ul>
                        `);
                    });
                } else {
                    $('.category-list').append('<p class="text-warning">No Categories available</p>');
                }
            },
            error: function (error) {
                alert(error.responseJSON.message)
            }
        });
    </script>
@endsection