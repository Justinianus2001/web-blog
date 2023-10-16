<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\RegisterAuthRequest;
use App\Http\Resources\V1\AuthResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    /**
     * Register a new user.
     */
    public function register(RegisterAuthRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=> Hash::make($request->password),
        ]);

        auth()->login($user);

        return $this->sendResponse(new AuthResource([
            'user' => $user,
            'token' => $user->createToken('user_token', [
                'blog:store', 'blog:update', 'blog:delete',
                'category:store', 'category:update', 'category:delete',
            ])->plainTextToken,
        ]), 'Registered successfully');
    }

    /**
     * Login a user.
     */
    public function login(LoginAuthRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendError('The provided email or password are incorrect.', 401);
        }

        auth()->login($user);

        return $this->sendResponse(new AuthResource([
            'user' => $user,
            'token' => $user->createToken('user_token', [
                'blog:store', 'blog:update', 'blog:delete',
                'category:store', 'category:update', 'category:delete',
            ])->plainTextToken,
        ]), 'Logged in successfully');
    }

    /**
     * Logout a user.
     */
    public function logout(Request $request): JsonResponse
    {
        auth('sanctum')->user()->tokens()->delete();
        $request->session()->invalidate();

        return $this->sendResponse([], 'Logged out successfully');
    }
}
