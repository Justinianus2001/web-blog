@extends('layouts.app')
@section('content')
    <a href="{{ route('category.index') }}" class="btn btn-outline-primary btn-sm">Go back</a>
    <div class="border rounded mt-5 ps-4 pe-4 pt-4 pb-4">
        <h1 class="display-4">Create Category</h1>
        <p>Fill and submit this form to create a category</p>
        <hr>
        <form action="" method="POST" id="form-create-category">
            @csrf
            <div class="row">
                <div class="control-group col-12">
                    <label for="name">Category name</label>
                    <input type="text" id="name" class="form-control" name="name"
                        placeholder="Enter Category Name" required>
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            </div>
            <div class="row mt-2">
                <div class="control-group col-12 text-center">
                    <button type="submit" id="btn-submit" class="btn btn-primary">
                        Create Category
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $('#form-create-category').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('api.category.store') }}",
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
        })
    </script>
@endsection