<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//Not Logged In

//Welcome page

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('welcome');
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.show');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

//Logged In

Route::middleware('auth')->get('/home', function () {
    return view('home');
})->name('home');
// Route::get('/', function () {
//     return view('welcome');
// });
