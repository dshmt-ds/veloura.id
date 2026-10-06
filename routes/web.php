<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\OperatingHourController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffScheduleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/category/{serviceCategory}', [LandingController::class, 'show'])->name('categories.show');

/*
|--------------------------------------------------------------------------
| Midtrans Webhook (Harus Bebas dari Auth Middleware)
|--------------------------------------------------------------------------
*/
Route::post(
    '/payment/midtrans/webhook',
    [PaymentController::class, 'webhook']
)->name('midtrans.webhook');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('customer.bookings.index');
    
    // Rute detail booking (Mendukung nama customer.bookings.show & bookings.show)
    Route::get('/my-bookings/{booking}', [BookingController::class, 'show'])
        ->name('customer.bookings.show');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])
        ->name('bookings.show');

    Route::delete('/my-bookings/{booking}', [BookingController::class, 'destroy'])
        ->name('customer.bookings.destroy');

    Route::get(
        '/customer/bookings/{booking}/payment',
        [PaymentController::class, 'checkout']
    )->name('customer.bookings.payment');

    Route::post(
        '/customer/payment/finish',
        [PaymentController::class, 'finish']
    )->name('customer.payment.finish');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('services', ServiceController::class);
        Route::patch('/services/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('services.toggle-status');
        Route::resource('service-categories', ServiceCategoryController::class)->names('service-categories');
        Route::resource('staffs', StaffController::class);
        Route::resource('operating-hours', OperatingHourController::class)->except(['show']);
        Route::resource('staff-schedules', StaffScheduleController::class);
        Route::resource('bookings', BookingController::class)->except(['store']);
    });

require __DIR__ . '/auth.php';