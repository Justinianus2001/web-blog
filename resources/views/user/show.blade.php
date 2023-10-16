@extends('layouts.app')
@section('content')
    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm">Dashboard</a>
    <div class="border rounded mt-5 ps-4 pe-4 pt-4 pb-4">
        <h3 class="display-7">Info User {{ $user->name }}</h3>
        <hr>
        <form action="" method="POST" enctype="multipart/form-data" id="form-edit-user">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="control-group col-6 mt-2">
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="User Avatar" width="50%"
                        style="display: block; margin-left: auto; margin-right:auto; border-radius: 50%;">
                    <label for="avatar">User Avatar</label>
                    @if (auth('sanctum')->user() && auth('sanctum')->user()->id == $user->id)
                        <input type="file" id="avatar" class="form-control" name="avatarFile"
                            placeholder="Enter User Avatar">
                    @else
                        <input type="file" id="avatar" class="form-control" name="avatarFile"
                            placeholder="Enter User Avatar" disabled>
                    @endif
                    @if ($errors->has('avatar'))
                        <span class="text-danger">{{ $errors->first('avatar') }}</span>
                    @endif
                </div>
                <div class="control-group col-6 mt-2">
                    <div class="control-group col-12 mt-2">
                        <label for="name">User Name</label>
                        @if (auth('sanctum')->user() && auth('sanctum')->user()->id == $user->id)
                            <input type="text" id="name" class="form-control" name="name"
                                placeholder="Enter User Name" value="{{ $user->name }}" required>
                        @else
                            <input type="text" id="name" class="form-control" name="name"
                                placeholder="Enter User Name" value="{{ $user->name }}" required disabled>
                        @endif
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="control-group col-12 mt-2">
                        <label for="email">User Email</label>
                        <input type="text" id="email" class="form-control" name="email"
                            placeholder="Enter User Email" value="{{ $user->email }}" disabled>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="control-group col-12 mt-2">
                        <label for="password">User Password</label>
                        @if (auth('sanctum')->user() && auth('sanctum')->user()->id == $user->id)
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="Enter User Password">
                        @else
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="Enter User Password" disabled>
                        @endif
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="control-group col-12 mt-2">
                        <label for="confirm_password">User Confirm Password</label>
                        @if (auth('sanctum')->user() && auth('sanctum')->user()->id == $user->id)
                            <input type="password" id="confirm_password" class="form-control" name="confirm_password"
                                placeholder="Enter User Confirm Password">
                        @else
                            <input type="password" id="confirm_password" class="form-control" name="confirm_password"
                                placeholder="Enter User Confirm Password" disabled>
                        @endif
                        @if ($errors->has('confirm_password'))
                            <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @if (auth('sanctum')->user() && auth('sanctum')->user()->id == $user->id)
                <div class="row mt-2">
                    <div class="control-group col-12 text-center">
                        <button type="submit" id="btn-submit" class="btn btn-primary">
                            Update User
                        </button>
                    </div>
                </div>
            @endif
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#form-edit-user').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "{{ route('api.user.update', ['user' => $user]) }}",
                type: "PATCH",
                headers: {"Authorization": "Bearer " + localStorage.getItem('token')},
                // processData: false,
                // contentType: false,
                data: $(this).serialize(),
                success: function (response) {
                    alert(response.message);
                    window.location.href = "/user/" + response.data.id;
                },
                error: function (error) {
                    alert(error.responseJSON.message);
                }
            });
        });
    </script>
@endsection