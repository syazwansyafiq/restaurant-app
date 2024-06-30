<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Services\Order\OrderService;
use App\Services\Report\ReportService;
use Illuminate\Http\Request;

class RestaurantManagerController extends Controller
{
    private $orderService;
    private $reportService;
    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->reportService = new ReportService();
    }
    public function orderList(Request $request)
    {
        try {
            $orders = $this->orderService->query($request);
            return new OrderCollection($orders);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function rejectOrder(Request $request, $id)
    {
        try {
            return $this->orderService->rejectOrder($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }
    public function sales(Request $request)
    {
        try {
            return $this->reportService->sales($request);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }
}
