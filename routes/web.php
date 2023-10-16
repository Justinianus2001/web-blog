<?php

use App\Http\Controllers\Web\V1\AuthController;
use App\Http\Controllers\Web\V1\BlogController;
use App\Http\Controllers\Web\V1\CategoryController;
use App\Http\Controllers\Web\V1\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::prefix('/user')->name('user.')->group(function () {
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
});

Route::prefix('/blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/create', [BlogController::class, 'create'])->name('create');
    Route::get('/{blog}', [BlogController::class, 'show'])->name('show');
    Route::get('/edit/{blog}', [BlogController::class, 'edit'])->name('edit');
});

Route::prefix('category')->name('category.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('edit');
});