<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\MobyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\RestaurantManagerController;
use App\Http\Controllers\Web\UserController;
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
    return redirect('/login');
});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.post');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.post');

Route::get('reset-password', [NewPasswordController::class, 'create'])->name('password.request');
Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.reset.post');


Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.email');
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email.post');

Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, 'verify'])->name('verification.verify');
Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
Route::post('confirm-password', [ConfirmablePasswordController::class, 'store'])->name('password.confirm.post');


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::post('update-password', [PasswordController::class, 'update'])->name('password.update');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::post('send-verification-email', [UserController::class, 'sendVerificationEmail'])->name('verification.send');
});

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/restaurants/approve', [AdminController::class, 'approve'])->name('admin.restaurants.approve');
        Route::get('/restaurants/ban', [AdminController::class, 'ban'])->name('admin.restaurants.ban');
    });
});

Route::middleware(['auth', 'role:restaurant_manager'])->group(function () {
    Route::group(['prefix' => 'restaurant'], function () {
        Route::get('/dashboard', [RestaurantManagerController::class, 'index'])->name('manager.dashboard');
        Route::get('/orders/{id}/reject', [RestaurantManagerController::class, 'orderReject'])->name('restaurant.order.reject');
        Route::get('/orders/{id}/view', [RestaurantManagerController::class, 'orderView'])->name('restaurant.order.show');
        Route::get('/sales/update', [RestaurantManagerController::class, 'updateSale'])->name('restaurant.sale.update');


    });
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
        // other customer routes
    });
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


