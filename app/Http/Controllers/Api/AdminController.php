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
        return $this->restaurantService->approveRestaurant($id);
    }

    public function banRestaurant($id)
    {
        return $this->restaurantService->banRestaurant($id);
    }
}
