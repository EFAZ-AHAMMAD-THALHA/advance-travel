<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\PackageController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/explore', [PageController::class, 'explore'])->name('explore');
Route::get('/package', [PageController::class, 'package'])->name('package');
Route::get('/locations', [PageController::class, 'locations'])->name('locations');
Route::get('/info', [PageController::class, 'info'])->name('info');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact-message', [ContactMessageController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Guest Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

/*
|--------------------------------------------------------------------------
| Payment Webhook Callbacks (SSLCommerz POST Calls)
| Whitelisted from CSRF in bootstrap/app.php
|--------------------------------------------------------------------------
*/
Route::match(['get', 'post'], '/success', [SslCommerzPaymentController::class, 'success'])->name('payment.success');
Route::match(['get', 'post'], '/fail', [SslCommerzPaymentController::class, 'fail'])->name('payment.fail');
Route::match(['get', 'post'], '/cancel', [SslCommerzPaymentController::class, 'cancel'])->name('payment.cancel');
Route::match(['get', 'post'], '/ipn', [SslCommerzPaymentController::class, 'ipn'])->name('payment.ipn');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Travelers & Admins)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // 1. Strictly Authenticated Booking Engine
    Route::get('/booking', [PageController::class, 'booking'])->name('booking');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/store', [BookingController::class, 'store']); // backward compatibility

    // 2. User Dashboard & Ticket Management
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my.bookings');
    Route::get('/ticket/{booking}', [BookingController::class, 'showTicket'])->name('booking.ticket');
    Route::post('/booking/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

    // 3. Checkout & Payment Initiation
    Route::get('/payment', function () {
        return redirect()->route('my.bookings');
    })->name('payment');

    Route::get('/checkout/{booking}', [SslCommerzPaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/pay-now', [SslCommerzPaymentController::class, 'payNow'])->name('payment.pay');
    Route::post('/payment/cash/{booking}', [SslCommerzPaymentController::class, 'cashOnBoarding'])->name('payment.cash');

    // 4. Logout
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        Route::resource('packages', PackageController::class);

        Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings.index');
        Route::post('/bookings/{booking}/status', [AdminController::class, 'updateBookingStatus'])->name('bookings.updateStatus');
        Route::post('/bookings/{booking}/refund', [AdminController::class, 'processRefund'])->name('bookings.refund');
        Route::delete('/bookings/{booking}', [AdminController::class, 'destroyBooking'])->name('bookings.destroy');

        Route::get('/contacts', [AdminController::class, 'contacts'])->name('contacts.index');
        Route::delete('/contacts/{contact}', [AdminController::class, 'destroyContact'])->name('contacts.destroy');
    });
