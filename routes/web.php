<?php

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

Route::group(['middleware' => 'csrf'], function () {
    Route::group(['name' => 'payment.'], function () {
        Route::get('/', 'App\Http\Controllers\PaymentController@payment')->name('payment.index');
        Route::post('/stripe/charge', 'App\Http\Controllers\StripeController@charge')->name('stripe.charge');
    });
});

