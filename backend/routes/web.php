<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;

// Default route
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Auth::routes();

// Home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// User Routes (resource + custom)
Route::resource('users', UserController::class);  // Đã bao gồm index, store, show, edit, update, destroy
Route::get('/users/search/{name?}', [UserController::class, 'searchByName'])->name('users.searchByName');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update'); // Cập nhật route để truyền ID của người dùng

// Profile Routes
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

// Role Routes
Route::resource('roles', RoleController::class);
