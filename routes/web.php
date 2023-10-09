<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
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
Route::get('/login', [AuthController::class, 'loginForm'])->name('login-form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'registerForm'])->name('register-form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Route::prefix('/post')->name('post.')->group(function () {
//     Route::get('/', [PostController::class, 'index'])->name('index');
//     Route::get('/create', [PostController::class, 'create'])->name('create');
//     Route::post('/create', [PostController::class, 'store'])->name('store');
//     Route::get('/{post}', [PostController::class, 'show'])->name('show');
//     Route::get('/edit/{post}', [PostController::class, 'edit'])->name('edit');
//     Route::put('/edit/{post}', [PostController::class, 'update'])->name('update');
//     Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
// });

// Route::prefix('category')->name('category.')->group(function () {
//     Route::get('/', [CategoryController::class, 'index'])->name('index');
//     Route::get('/create', [CategoryController::class, 'create'])->name('create');
//     Route::post('/create', [CategoryController::class, 'store'])->name('store');
//     Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('edit');
//     Route::put('/edit/{category}', [CategoryController::class, 'update'])->name('update');
//     Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
// });