<?php

namespace App\Http\Controllers;

use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    private $paymentService;
    public function __construct()
    {
        $this->paymentService = new PaymentService();
    }

    public function index(Request $request)
    {
        $payment = $this->paymentService->findSlug($request->slug);
        $order = $payment->order;
        $orderItems = $order->orderItems;

        $cartItems = [];

        foreach ($orderItems as $orderItem) {
            $cartItems[] = (object)[
                'name' => $orderItem->menu->name,
                'quantity' => $orderItem->quantity,
                'price' => $orderItem->price,
                'total' => $orderItem->totalAmount(),
            ];
        }

        $data = [
            'payment_id' => $payment->id,
            'order_id' => $payment->order_id,
            'order_date' => $order->created_at->format('d/m/Y'),
            'order_time' => $order->created_at->format('H:i'),
            'order_reference' => $payment->reference,
            'cart_items' => $cartItems,
            'amount' => $payment->amount,
            'currency' => 'MYR',
            'description' => 'Payment for Order #' . $payment->order_id,
            'user_id' => $payment->user_id,
            'restaurant_id' => $order->restaurant_id,
            'restaurant_name'   => $order->restaurant->name,
            'user_name' => $payment->user->name,
            'user_email' => $payment->user->email,
            'user_phone' => $payment->user->phone,
        ];
        return view('payment.index', $data);
    }

    public function success(Request $request)
    {
        return view('payment.success');
    }
}
