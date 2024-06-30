<?php

use App\Http\Controllers\MobyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\RestaurantManagerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/approve', [AdminController::class, 'approve'])->name('admin.approve');
    Route::get('/dashboard/ban', [AdminController::class, 'ban'])->name('admin.ban');
});

Route::middleware(['auth', 'role:restaurant_manager'])->group(function () {
    Route::get('/dashboard', [RestaurantManagerController::class, 'index'])->name('manager.dashboard');
    // other manager routes
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
    // other customer routes
});

Route::group(['prefix' => 'payment', 'as' => 'payment.'], function () {
    Route::get('{slug}/checkout', [PaymentController::class, 'index'])->name('index');
    Route::get('/success', [PaymentController::class, 'success'])->name('success');
    Route::get('/fail', [PaymentController::class, 'fail'])->name('fail');

    Route::group(['prefix' => 'stripe', 'as' => 'stripe.'], function () {
        Route::post('/charge', [StripeController::class, 'charge'])->name('charge');
        Route::post('/webhook', [StripeController::class, 'webhook'])->name('webhook');
    });

    Route::group(['prefix' => 'moby', 'as' => 'moby.'], function () {
        Route::post('/callback', [MobyController::class, 'callback'])->name('callback');
        Route::get('/return', [MobyController::class, 'return'])->name('return');
        Route::post('/hosted', [MobyController::class, 'hosted'])->name('hosted');
    });
});


