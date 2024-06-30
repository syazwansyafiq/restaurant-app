<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateRestaurantSale;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Sales;
use Illuminate\Http\Request;

class RestaurantManagerController extends Controller
{
    public function index()
    {
        $restaurant = Restaurant::where('user_id', auth()->user()->id)->first();
        $sale = Sales::where('restaurant_id', $restaurant->id)->first();

        $orders = $restaurant->orders;

        if(is_null($sale)) {
            dispatch(new UpdateRestaurantSale($restaurant));
        }

        return view('restaurant.index', compact('restaurant', 'sale', 'orders'));
    }

    public function orderView($id)
    {
        $order = Order::where('id', $id)->firstOrFail();
        return view('restaurant.order', compact('order'));
    }

    public function orderReject($id)
    {
        $order = Order::where('id', $id)->firstOrFail();
        $order->status = 'rejected';
        $order->save();
        return redirect()->back();
    }

}
