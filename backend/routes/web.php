<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\HotelController;

// Default route
Route::get('/', fn() => view('welcome'));

// Authentication routes
Auth::routes();

// Home route
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Group các route cần đăng nhập
Route::middleware('auth')->group(function () {

    // User Routes (resource đã đăng ký đầy đủ các route)
    Route::resource('users', UserController::class);
    Route::post('/users/check-hotels', [UserController::class, 'checkUserHotels'])->name('users.checkHotels');


    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Role Routes
    Route::resource('roles', RoleController::class);

    // Hotel Routes
    Route::resource('hotels', HotelController::class);
    
    // Các route bổ sung cho Hotel nếu cần
    Route::get('/hotels/search', [HotelController::class, 'search'])->name('hotels.search');
    // Nếu có method filter, đảm bảo đặt tên chính xác (ví dụ: '/hotels/filter')
    // Route::get('/hotels/filter', [HotelController::class, 'filter'])->name('hotels.filter');
});
