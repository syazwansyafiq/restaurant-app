<?php

namespace App\Services\Order;

use App\Http\DataTransferObjects\CompletePayment;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService
{

    public function query($request)
    {
        // add filter and pagination
        $limit = $request->has('limit') ? $request->limit : 10;
        $page = $request->has('page') ? $request->page : 1;

        $offset = ($page - 1) * $limit;

        $query = $this->filter($request);
        $query = $query->offset($offset)->limit($limit);
        $query = $query->get();
        return $query;
    }

    public function filter($request)
    {
        $query = Order::query();

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('restaurant_id')) {
            $query->where('restaurant_id', $request->restaurant_id);
        }

        if ($request->has('total_amount')) {
            $query->where('total_amount', $request->total_amount);
        }

        if ($request->has('from')) {
            $query->where('created_at', '>=', $request->from);
        }

        if ($request->has('to')) {
            $query->where('created_at', '<=', $request->to);
        }

        return $query;
    }


    public function storeOrder($request)
    {
        $user = auth()->user();

        $total_amount = 0;

        $order = Order::create([
            'user_id' => $user->id,
            'restaurant_id' => $request->restaurant_id,
            'status' => 'pending',
            'created_by' => $user->id
        ]);
        $orderItems = $request->items;

        foreach ($orderItems as $orderItem) {
            dd($orderItems);
            $menuid = (int)$orderItem['menu_id'];
            $menu = DB::table('menus')->where('id', $menuid)->first();
            $createitem = [
                'order_id' => $order->id,
                'menu_id' => $orderItem['menu_id'],
                'quantity' => $orderItem['quantity'],
                'price' => $menu->price,
            ];
            $total_amount += $menu->price * $orderItem['quantity'];
            $order->orderItems()->create($createitem);
        }

        $order->total_amount = $total_amount;
        $order->save();

       return $order;
    }

    public function rejectOrder($request)
    {
        $order = Order::where('user_id', $request->user_id)
            ->where('id', $request->order_id)
            ->where('restaurant_id', $request->restaurant_id)
            ->where('total_amount', $request->total_amount)
            ->where('status', 'pending')->first();
        $order->status = 'rejected';
        $order->save();
        return response()->json(['status' => 'Order rejected successfully', 'order' => $order], 200);
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
