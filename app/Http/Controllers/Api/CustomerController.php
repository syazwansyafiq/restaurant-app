<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InitPayment;
use App\Http\Requests\StoreOrder;
use App\Http\Resources\InitPayment as ResourcesInitPayment;
use App\Http\Resources\OrderCreated;
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
        try {

            $request->merge(['status' => 'active']);
            $restaurants = $this->restaurantService->query($request);

            return new RestaurantCollection($restaurants);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function showRestaurant($id)
    {
        try {

            $restaurant = $this->restaurantService->show($id);

            return new Restaurant($restaurant);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function storeOrder(Request $request)
    {
        try {
            $request->validate([
                'restaurant_id' => 'required|exists:restaurants,id',
                'items' => 'required|array|min:1',
                'delivery_type' => 'required|in:pickup,delivery',
                'delivery_address' => 'required_if:delivery_type,delivery',
            ]);

            $order = $this->orderService->storeOrder($request);

            return new OrderCreated($order);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function processPayment(InitPayment $request)
    {
        try {
            $request->validate([
                'order_id' => 'required|exists:orders,id',
                'amount' => 'required|numeric',
                'description' => 'required',
            ]);

            $payment = $this->paymentService->create($request);

            return new ResourcesInitPayment($payment);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
