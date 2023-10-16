<?php

namespace App\Http\Controllers\Web\V1;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class AuthController extends Controller
{
    /**
     * Display dashboard.
     */
    public function dashboard(): View
    {
        return view('auth.dashboard');
    }

    /**
     * Display login form.
     */
    public function login(): View
    {
        return view('auth.login');
    }

    /**
     * Display register form.
     */
    public function register(): View
    {
        return view('auth.register');
    }
}
