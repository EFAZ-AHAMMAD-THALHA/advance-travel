<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
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
Route::get('/package', [PageController::class, 'package'])->name('package');
Route::get('/locations', [PageController::class, 'locations'])->name('locations');
Route::get('/info', [PageController::class, 'info'])->name('info');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/booking', [PageController::class, 'booking'])->name('booking');

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
| Form Submissions (Public)
|--------------------------------------------------------------------------
*/
Route::post('/store', [BookingController::class, 'store'])->name('booking.store');
Route::post('/contact-message', [ContactMessageController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Payment Routes
|--------------------------------------------------------------------------
*/
Route::get('/payment', function () {
    return view('payment');
})->name('payment');

Route::post('/pay-now', [SslCommerzPaymentController::class, 'payNow'])->name('payment.pay');
Route::post('/success', [SslCommerzPaymentController::class, 'success'])->name('payment.success');
Route::post('/fail', [SslCommerzPaymentController::class, 'fail'])->name('payment.fail');
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel'])->name('payment.cancel');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
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
        Route::delete('/bookings/{booking}', [AdminController::class, 'destroyBooking'])->name('bookings.destroy');

        Route::get('/contacts', [AdminController::class, 'contacts'])->name('contacts.index');
        Route::delete('/contacts/{contact}', [AdminController::class, 'destroyContact'])->name('contacts.destroy');
    });
