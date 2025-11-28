<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReportController;

// Landing page
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/verify', [AuthController::class, 'showVerify'])->name('verify.show');
    Route::post('/verify', [AuthController::class, 'verify'])->name('verify');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        // Properties
        Route::resource('properties', PropertyController::class);
        
        // Rooms
        Route::resource('rooms', RoomController::class);
        
        // Bookings Management
        Route::get('/bookings', [BookingController::class, 'adminIndex'])->name('admin.bookings.index');
        Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('admin.bookings.updateStatus');
        
        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
    });

    // Penyewa Routes
    Route::middleware('penyewa')->prefix('penyewa')->group(function () {
        // Browse rooms
        Route::get('/rooms', [BookingController::class, 'index'])->name('penyewa.rooms.index');
        Route::get('/rooms/{room}', [BookingController::class, 'show'])->name('penyewa.rooms.show');
        
        // Booking
        Route::get('/rooms/{room}/book', [BookingController::class, 'create'])->name('penyewa.bookings.create');
        Route::post('/rooms/{room}/book', [BookingController::class, 'store'])->name('penyewa.bookings.store');
        
        // Upload payment
        Route::post('/bookings/{booking}/payment', [BookingController::class, 'uploadPayment'])->name('penyewa.bookings.uploadPayment');
    });
});