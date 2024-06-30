<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Restaurant\RestaurantService;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    private RestaurantService $restaurantService;

    public function __construct()
    {
        $this->restaurantService = new RestaurantService();
    }

    public function approveRestaurant($id)
    {
        try {
            return $this->restaurantService->approveRestaurant($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function banRestaurant($id)
    {
        try {
            return $this->restaurantService->banRestaurant($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
