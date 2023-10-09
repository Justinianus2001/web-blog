<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">{{ config('app.name') }}</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <div class="navbar-nav">
                <a class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="nav-link {{ Request::routeIs('post.index') ? 'active' : '' }}" href="{{ route('post.index') }}">Blogs</a>
                <a class="nav-link {{ Request::routeIs('category.index') ? 'active' : '' }}" href="{{ route('category.index') }}">Categories</a>
            </div>
        </div>
        <span class="navbar-text">
            @if (Auth::guest())
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm">Register</a>
            @else
                Hello {{ Auth::user()->name }},
                <a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Log out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endif
        </span>
    </div>
</nav>