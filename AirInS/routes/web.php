<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Models\Property;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


//=======================Not Logged In=========================

Route::middleware('guest')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('welcome');
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
});

Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
Route::get('/property/detail/{id}', [PropertyController::class, 'show'])->name('bookings.detail');
Route::get('/search', [PropertyController::class, 'search'])->name('search');

//================================================

//Logged In

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{id}', [BookingController::class, 'store'])->name('bookings.store');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    Route::get('/review/{bookingId}', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/{bookingId}', [ReviewController::class, 'store'])->name('review.store');

    Route::get('/my-properties', [PropertyController::class, 'myProperties'])->name('property.index');
    Route::get('/my-properties/create', [PropertyController::class, 'create'])->name('property.create');
    Route::post('/my-properties/store', [PropertyController::class, 'store'])->name('property.store');
    Route::get('/my-properties/{id}/edit', [PropertyController::class, 'edit'])->name('property.edit');
    Route::post('/my-properties/{id}/update', [PropertyController::class, 'update'])->name('property.update');
    Route::post('/my-properties/{id}/delete', [PropertyController::class, 'destroy'])->name('property.destroy');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{propertyID}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
