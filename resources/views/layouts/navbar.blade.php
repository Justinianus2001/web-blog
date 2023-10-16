<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">{{ config('app.name') }}</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <div class="navbar-nav">
                <a class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="nav-link {{ Request::routeIs('blog.index') ? 'active' : '' }}" href="{{ route('blog.index') }}">Blogs</a>
                <a class="nav-link {{ Request::routeIs('category.index') ? 'active' : '' }}" href="{{ route('category.index') }}">Categories</a>
            </div>
        </div>
        <span class="navbar-text">
            @auth
                <img src="{{ asset('storage/' . auth('sanctum')->user()->avatar) }}" alt="User Avatar"
                    height="24" width="24" style="border-radius: 50%">
                Hello {{ auth('sanctum')->user()->name }},
                <a href="{{ route('user.show', ['user' => auth('sanctum')->user()->id ]) }}"
                    class="btn btn-outline-primary btn-sm">Profile</a>
                <form action="" method="POST" id="form-logout" style="display: inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-sm" style="color: #fff">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm">Register</a>
            @endauth
        </span>
    </div>
</nav>
<script>
    $('#form-logout').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('api.logout') }}",
            type: "POST",
            headers: {"Authorization": "Bearer " + localStorage.getItem('token')},
            data: $(this).serialize(),
            success: function (response) {
                alert(response.message);
                localStorage.removeItem('token');
                window.location.href = "{{ route('dashboard') }}";
            },
            error: function (error) {
                alert(error.responseJSON.message);
            }
        });
    });
</script>