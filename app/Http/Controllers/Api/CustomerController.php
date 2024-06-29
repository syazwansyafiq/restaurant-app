<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InitPayment;
use App\Http\Requests\StoreOrder;
use App\Http\Resources\Restaurant;
use App\Http\Resources\RestaurantCollection;
use App\Services\Order\OrderService;
use App\Services\Payment\PaymentService;
use App\Services\Restaurant\RestaurantService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    private $orderService;

    private $paymentService;

    private $restaurantService;

    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->paymentService = new PaymentService();
        $this->restaurantService = new RestaurantService();
    }

    public function restaurants(Request $request)
    {
        $restaurants = $this->restaurantService->query($request);

        return new RestaurantCollection($restaurants);
    }

    public function showRestaurant($id)
    {
        $restaurant = $this->restaurantService->show($id);

        return new Restaurant($restaurant);
    }

    public function storeOrder(StoreOrder $request)
    {
        return $this->orderService->storeOrder($request);
    }

    public function processPayment(InitPayment $request)
    {
        return $this->paymentService->processPayment($request);
    }
}
