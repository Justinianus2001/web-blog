<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BlogController;
use App\Http\Controllers\Api\V1\CategoryController;
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

// , 'middleware' => 'auth:sanctum'
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::prefix('/blog')->group(function () {
        Route::get('/', [BlogController::class, 'index']);
        Route::get('/search/{keyword}', [BlogController::class, 'search']);
        Route::get('/{blog}', [BlogController::class, 'show']);

        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('/', [BlogController::class, 'store']);
            Route::post('/bulk', [BlogController::class, 'bulkStore']);
            Route::put('/{blog}', [BlogController::class, 'update']);
            Route::patch('/{blog}', [BlogController::class, 'update']);
            Route::delete('/{blog}', [BlogController::class, 'destroy']);
        });
    });

    Route::prefix('/category')->group(function() {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{category}', [CategoryController::class, 'show']);

        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('/', [CategoryController::class, 'store']);
            Route::put('/{category}', [CategoryController::class, 'update']);
            Route::patch('/{category}', [CategoryController::class, 'update']);
            Route::delete('/{category}', [CategoryController::class, 'destroy']);
        });
    });
});

Route::fallback(function() {
    return response()->json([
        "message" => "Page Not Found.",
    ], 404);
});