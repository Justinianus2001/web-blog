<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\RegisterAuthRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(RegisterAuthRequest $request): UserResource
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=> Hash::make($request->password),
        ]);

        Auth::login($user);

        return new UserResource([
            'user' => $user,
            'token' => $user->createToken('user_token', [
                'blog:store',
                'blog:update',
                'blog:delete',
                'category:store',
                'category:update',
                'category:delete',
            ])->plainTextToken,
        ]);
    }

    /**
     * Login a user.
     */
    public function login(LoginAuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return new UserResource([
                'user' => $user,
                'token' => $user->createToken('user_token', [
                    'blog:store',
                    'blog:update',
                    'blog:delete',
                    'category:store',
                    'category:update',
                    'category:delete',
                ])->plainTextToken,
            ]);
        }
    }

    /**
     * Logout a user.
     */
    public function logout(): void
    {
        auth()->user()->tokens()->delete();
    }
}
