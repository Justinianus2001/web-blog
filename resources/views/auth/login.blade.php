@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 card">
            <div class="card-header">Login</div>
            <div class="card-body">
                <form action="" method="POST" id="form-login">
                    @csrf
                    <div class="form-group row">
                        <label for="email_address" class="col-md-4 col-form-label text-md-right">Email Address</label>
                        <div class="col-md-6">
                            <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                        <div class="col-md-6">
                            <input type="password" id="password" class="form-control" name="password" required>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#form-login').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('api.login') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    alert(response.message);
                    localStorage.setItem('token', response.data.token);
                    window.location.href = "{{ route('dashboard') }}";
                },
                error: function (error) {
                    alert(error.responseJSON.message);
                }
            });
        })
    </script>
@endsection