<?php

namespace App\Services\Report;

use App\Jobs\UpdateRestaurantSale;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Sales;

class ReportService
{
    public function sales($request)
    {
        $user = auth()->user();
        $restaurant = Restaurant::where('user_id', $user->id)->first();
        if(is_null($restaurant)) {
            return response()->json(['message' => 'Please register your restaurant.'], 200);
        }

        $sale = Sales::where('restaurant_id', $restaurant->id)->first();

        if(is_null($sale)) {
            dispatch(new UpdateRestaurantSale($restaurant));

            return response()->json(['message' => 'Please wait until the restaurant sale data is updated.'], 200);
        }

        $report = [
            'total_amount' => $sale->total_amount,
            'order_count' => $sale->total_amount,
            'paid_amount' => $sale->total_amount,
            'average_amount' => $sale->total_amount,
            'latest_order' => $sale->total_amount,
            'today_amount' => $sale->total_amount,
            'week_amount' => $sale->total_amount,
            'month_amount' => $sale->total_amount,
            'year_amount' => $sale->total_amount,
        ];

        return response()->json(['sales_report' => $report], 200);
    }
}
