<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Restaurant\RestaurantService;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    private $restaurantService;
    public function __construct()
    {
        $this->restaurantService = new RestaurantService();
    }
    public function index()
    {
        return view('dashboard.admin');
    }

    public function approve($id)
    {
        return $this->restaurantService->approveRestaurant($id);
    }

    public function ban($id)
    {
        return $this->restaurantService->banRestaurant($id);
    }
}
