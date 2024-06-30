<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateRestaurantSale implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $restaurant;
    /**
     * Create a new job instance.
     */
    public function __construct($restaurant)
    {
        $this->restaurant = $restaurant;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $salesData = [
            'total_amount' => Order::where('restaurant_id', $this->restaurant->id)
                ->sum('total_amount'),
            'order_count' => Order::where('restaurant_id', $this->restaurant->id)
                ->count(),
            'paid_amount' => Order::where('restaurant_id', $this->restaurant->id)
                ->where('status', 'paid')
                ->sum('total_amount'),
            'average_amount' => Order::where('restaurant_id', $this->restaurant->id)
                ->avg('total_amount'),
            'latest_order' => Order::where('restaurant_id', $this->restaurant->id)
                ->latest()
                ->sum('total_amount'),
            'today_amount' => Order::where('restaurant_id', $this->restaurant->id)
                ->whereDate('created_at', now())
                ->sum('total_amount'),
            'week_amount' => Order::where('restaurant_id', $this->restaurant->id)
                ->where('status', 'paid')
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->sum('total_amount'),
            'month_amount' => Order::where('restaurant_id', $this->restaurant->id)
                ->where('status', 'paid')
                ->whereMonth('created_at', now())
                ->sum('total_amount'),
            'year_amount' => Order::where('restaurant_id', $this->restaurant->id)
                ->where('status', 'paid')
                ->whereYear('created_at', now())
                ->sum('total_amount'),
        ];

        $this->restaurant->sale()->updateOrCreate(['restaurant_id' => $this->restaurant->id], $salesData);
    }
}
