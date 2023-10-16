@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-11">
            <h1 class="display-one">Blogs</h1>
        </div>
        @auth
            <div class="col-1">
                <a href="{{ route('blog.create') }}" class="btn btn-primary btn-sm">Add Blog</a>
            </div>
        @endauth
        <form action="" method="POST" id="form-search-blog">
            @csrf
            <div class="input-group mb-3">
                <input type="text" id="keyword" class="form-control" name="keyword"
                    placeholder="Enter your search keyword here">
                <div class="input-group-append">
                    <button class="btn btn-success" type="submit">Search</button>
                </div>
            </div>
        </form>
    </div>
    <div class="blog-list row"></div>
@endsection
@section('scripts')
    <script>
        $.ajax({
            url: "{{ route('api.blog.index') }}",
            type: "GET",
            success: function (response) {
                var src = "{{ asset('storage') }}" + "/";
                $('.blog-list').empty();
                if (response.data.length > 0) {
                    $.each(response.data, function (index, value) {
                        $('.blog-list').append(`
                            <div class="control-group col-3 mt-2">
                                <img src="` + src + value.image + `" alt="Blog Image"
                                    style="width: 250px">
                            </div>
                            <div class="control-group col-9 mt-2">
                                <a href="/blog/` + value.id + `">
                                    <h3>` + value.title + `</h3>
                                </a>
                                <a href="/user/` + value.user.id + `">
                                    <b>` + value.user.name + `</b>
                                </a> |
                                <span>` + value.category.name + `</span>
                            </div>
                        `);
                    });
                } else {
                    $('.blog-list').append('<p class="text-warning">No Blogs available</p>');
                }
            },
            error: function (error) {
                alert(error.responseJSON.message)
            }
        });
        $('#form-search-blog').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('api.blog.search') }}",
                type: "GET",
                data: $(this).serialize(),
                success: function (response) {
                    var src = "{{ asset('storage') }}" + "/";
                    $('.blog-list').empty();
                    if (response.data.length > 0) {
                        $.each(response.data, function (index, value) {
                            $('.blog-list').append(`
                                <div class="control-group col-3 mt-2">
                                    <img src="` + src + value.image + `" alt="Blog Image"
                                        style="width: 250px">
                                </div>
                                <div class="control-group col-9 mt-2">
                                    <a href="/blog/` + value.id + `">
                                        <h3>` + value.title + `</h3>
                                    </a>
                                    <a href="/user/` + value.user.id + `">
                                        <b>` + value.user.name + `</b>
                                    </a> |
                                    <span>` + value.category.name + `</span>
                                </div>
                            `);
                        });
                    } else {
                        $('.blog-list').append('<p class="text-warning">No Blogs available</p>');
                    }
                },
                error: function (error) {
                    alert(error.responseJSON.message);
                }
            });
        });
    </script>
@endsection