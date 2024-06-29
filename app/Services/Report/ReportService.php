<?php

namespace App\Services\Report;

use App\Models\Order;
use App\Models\Sales;

class ReportService
{
    public function sales($request)
    {
        $sale = Sales::where('restaurant_id', $request->restaurant_id)->first();

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
