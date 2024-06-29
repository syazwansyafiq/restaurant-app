<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\RestaurantManagerController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

     // Customer Routes
    Route::get('/restaurants', [CustomerController::class, 'restaurants']);
    Route::get('/restaurants/{id}', [CustomerController::class, 'showRestaurant']);
    Route::post('/orders', [CustomerController::class, 'storeOrder']);
    Route::post('/payments', [CustomerController::class, 'processPayment']);

    // Restaurant Manager Routes
    Route::middleware('role:restaurant_manager')->group(function () {
        Route::get('/orders', [RestaurantManagerController::class, 'index']);
        Route::put('/orders/{id}/reject', [RestaurantManagerController::class, 'rejectOrder']);
        Route::get('/sales', [RestaurantManagerController::class, 'sales']);
    });

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::put('/restaurants/{id}/approve', [AdminController::class, 'approveRestaurant']);
        Route::put('/restaurants/{id}/ban', [AdminController::class, 'banRestaurant']);
    });

});
