<?php

namespace App\Services\Order;

use App\Http\DataTransferObjects\CompletePayment;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function storeOrder($request)
    {
        $user = auth()->user();
        $order = Order::create([
            'user_id' => $user->id,
            'restaurant_id' => $request->restaurant_id,
            'total_amount' => $request->total_amount,
            'status' => 'pending',
        ]);

        return response()->json(['status' => 'Order placed successfully', 'order' => $order], 201);
    }

    public function completePayment(CompletePayment $request)
    {
        $order = Order::where('user_id', $request->user_id)
            ->where('id', $request->order_id)
            ->where('restaurant_id', $request->restaurant_id)
            ->where('total_amount', $request->total_amount)
            ->where('status', 'pending')->first();
        $order->status = 'paid';
        $order->save();

        $this->addLotaltyPoints($order);

        return response()->json(['status' => 'Payment completed successfully', 'order' => $order], 200);
    }

    private function addLotaltyPoints($order)
    {
        $points = $order->total_amount; // Assuming total_amount is in RM
        $order->points = $points;
        $order->save();

        $order->user->loyaltyPoints()->updateOrCreate(
            ['user_id' => $order->user_id],
            ['points' => DB::raw('points + ' . $points)]
        );
    }


    public function getLoyaltyPoints()
    {
        $user = auth()->user();
        $points = $user->loyaltyPoints ? $user->loyaltyPoints->points : 0;

        return response()->json(['points' => $points], 200);
    }
}
