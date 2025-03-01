<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\TransactionController;

// Public routes
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');
    
    // Authentication Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Credit Card Routes
    Route::post('/credit-cards', [CreditCardController::class, 'store']);
    Route::get('/credit-cards', [CreditCardController::class, 'index']);
    Route::delete('/credit-cards/{id}', [CreditCardController::class, 'destroy']);
    
    // Transaction Routes
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions', [TransactionController::class, 'index']);
});

// Fallback route
Route::fallback(function () {
    return redirect('/');
});