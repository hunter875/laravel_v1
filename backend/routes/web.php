<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\HotelController;

// Default route
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Auth::routes();

// Home routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// User Routes (resource + custom)
Route::resource('users', UserController::class);  
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

// Profile Routes
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

// Role Routes
Route::resource('roles', RoleController::class);

// Hotel Routes
Route::resource('hotels', HotelController::class);
Route::get('/hotels/search', [HotelController::class, 'search'])->name('hotels.search');
Route::get('/hotels/fillter', [HotelController::class, 'filter'])->name('hotels.filter');
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{id}', [HotelController::class, 'show'])->name('hotels.show');
Route::get('/hotels/{id}/edit', [HotelController::class, 'edit'])->name('hotels.edit');
Route::put('/hotels/{hotel}', [HotelController::class, 'update'])->name('hotels.update');
Route::delete('/hotels/{hotel}', [HotelController::class, 'destroy'])->name('hotels.destroy');
Route::get('/hotels/create', [HotelController::class, 'create'])->name('hotels.create');


