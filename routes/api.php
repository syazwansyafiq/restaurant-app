<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\RestaurantManagerController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
     // Customer Routes
     Route::get('/restaurants', [CustomerController::class, 'index']);
     Route::get('/restaurants/{id}', [CustomerController::class, 'show']);
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
