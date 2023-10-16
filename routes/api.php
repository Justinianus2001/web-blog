<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BlogController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->name('api.')->group(function() {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::prefix('/user')->group(function () {
        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::patch('/{user}', [UserController::class, 'update'])->name('user.update');
        });
    });

    Route::prefix('/blog')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/search', [BlogController::class, 'search'])->name('blog.search');
        Route::get('/{blog}', [BlogController::class, 'show'])->name('blog.show');

        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('/', [BlogController::class, 'store'])->name('blog.store');
            Route::post('/bulk', [BlogController::class, 'bulkStore'])->name('blog.bulk-store');
            Route::put('/{blog}', [BlogController::class, 'update'])->name('blog.update');
            Route::patch('/{blog}', [BlogController::class, 'update'])->name('blog.update');
            Route::delete('/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy');
        });
    });

    Route::prefix('/category')->group(function() {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('category.show');

        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('/', [CategoryController::class, 'store'])->name('category.store');
            Route::put('/{category}', [CategoryController::class, 'update'])->name('category.update');
            Route::patch('/{category}', [CategoryController::class, 'update'])->name('category.update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
        });
    });
});

Route::fallback(function() {
    return response()->json([
        "message" => "Page Not Found.",
    ], 404);
});