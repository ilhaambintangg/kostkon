<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;

// Landing page
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/verify', [AuthController::class, 'showVerify'])->name('verify.show');
    Route::post('/verify', [AuthController::class, 'verify'])->name('verify');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');  // ← BARU
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        // User Management
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::patch('/users/{user}/approve', [AdminUserController::class, 'approve'])->name('admin.users.approve');
        Route::delete('/users/{user}/reject', [AdminUserController::class, 'reject'])->name('admin.users.reject');
        Route::delete('/users/{user}/delete', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');  // ← BARU
        
        // Admin Profile
        Route::get('/profile', [AdminUserController::class, 'editProfile'])->name('admin.profile.edit');
        Route::put('/profile', [AdminUserController::class, 'updateProfile'])->name('admin.profile.update');
        
        // Properties
        Route::resource('properties', PropertyController::class);
        
        // Rooms
        Route::resource('rooms', RoomController::class);
        
        // Bookings
        Route::get('/bookings', [BookingController::class, 'adminIndex'])->name('admin.bookings.index');
        Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('admin.bookings.updateStatus');
        Route::post('/bookings/{booking}/refund', [BookingController::class, 'uploadRefund'])->name('admin.bookings.uploadRefund');
        
        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
    });

    // Penyewa Routes
    Route::middleware('penyewa')->prefix('penyewa')->group(function () {
        Route::get('/rooms', [BookingController::class, 'index'])->name('penyewa.rooms.index');
        Route::get('/rooms/{room}', [BookingController::class, 'show'])->name('penyewa.rooms.show');
        Route::get('/rooms/{room}/book', [BookingController::class, 'create'])->name('penyewa.bookings.create');
        Route::post('/rooms/{room}/book', [BookingController::class, 'store'])->name('penyewa.bookings.store');
        Route::post('/bookings/{booking}/payment', [BookingController::class, 'uploadPayment'])->name('penyewa.bookings.uploadPayment');
        Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('penyewa.bookings.destroy');
        
        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('penyewa.profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('penyewa.profile.update');
        Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('penyewa.profile.deletePhoto');
    });
});