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
        $restaurants = $this->restaurantService->index();
        return view('admin.index', compact('restaurants'));
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
