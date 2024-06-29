<?php

namespace App\Http\Services\Cron;

use App\Jobs\UpdateRestaurantSale;
use App\Models\Order;

class CalculateSales
{
    public function handle()
    {
        $restaurants = \App\Models\Restaurant::where('status', 'active')->get();
        foreach ($restaurants as $restaurant) {
           dispatch(new UpdateRestaurantSale($restaurant));
        }
    }
}
