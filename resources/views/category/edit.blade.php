@extends('layouts.app')
@section('content')
    <a href="{{ route('category.index') }}" class="btn btn-outline-primary btn-sm">Go back</a>
    <div class="border rounded mt-5 ps-4 pe-4 pt-4 pb-4">
        <h1 class="display-4">Edit Category</h1>
        <p>Edit and submit this form to update a category</p>
        <hr>
        <form action="" method="POST" id="form-edit-category">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="control-group col-12">
                    <label for="name">Category Name</label>
                    <input type="text" id="name" class="form-control" name="name"
                        placeholder="Enter Category Name" required>
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            </div>
            <div class="row mt-2">
                <div class="control-group col-12 text-center">
                    <button id="btn-submit" class="btn btn-primary">
                        Update Category
                    </button>
                </div>
            </div>
        </form>
        <div class="row mt-2">
            <div class="control-group col-12 text-center">
                <form id="form-delete-category" class="" action="" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">Delete Category</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $.ajax({
            url: "{{ route('api.category.show', ['category' => $category]) }}",
            type: "GET",
            success: function (response) {
                $('#name').val(response.data.name);
            },
            error: function (error) {
                alert(error.responseJSON.message)
            }
        });
        $('#form-edit-category').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('api.category.update', ['category' => $category]) }}",
                type: "POST",
                headers: {"Authorization": "Bearer " + localStorage.getItem('token')},
                data: $(this).serialize(),
                success: function (response) {
                    alert(response.message);
                    window.location.href = "{{ route('category.index') }}";
                },
                error: function (error) {
                    alert(error.responseJSON.message);
                }
            });
        });
        $('#form-delete-category').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('api.category.destroy', ['category' => $category]) }}",
                type: "DELETE",
                headers: {"Authorization": "Bearer " + localStorage.getItem('token')},
                data: $(this).serialize(),
                success: function (response) {
                    alert(response.message);
                    window.location.href = "{{ route('category.index') }}";
                },
                error: function (error) {
                    alert(error.responseJSON.message);
                }
            });
        });
    </script>
@endsection