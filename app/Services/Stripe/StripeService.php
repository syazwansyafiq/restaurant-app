<?php

namespace App\Services\Stripe;

use App\Http\DataTransferObjects\CompletePayment;
use App\Services\Order\OrderService;
use App\Services\Payment\PaymentService;
use Stripe\StripeClient;

class StripeService
{
    public $stripe;
    public $orderService;
    public $paymentService;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
        $this->orderService = new OrderService();
        $this->paymentService = new PaymentService();
    }

    public function charge($request)
    {
        $response = $this->stripe->charges->create([
            'amount' => $request->amount * 100,
            'description' => $request->description,
            'metadata' => [
                'order_id' => $request->order_id,
                'user_id' => $request->user_id,
                'payment_id' => $request->payment_id,
                'restaurant_id' => $request->restaurant_id
            ],
            'currency' => config('services.stripe.currency'),
            'source' => config('services.stripe.source'),
        ]);

        if(!$response->status === 'succeeded') {
            return response()->json(['status' => 'Payment failed'], 400);
        }

        $this->updatePayment($response);
        $this->updateOrderStatus($response);

        return response()->json(['status' => 'Payment successful'], 200);
    }

    public function webhook($request)
    {
        $event = $this->stripe->events->retrieve($request->id);
        $data = json_decode($event->data);
        $object = $data->object;

        switch ($event->type) {
            case 'charge.succeeded':
                $this->updatePayment($object);
                $this->updateOrderStatus($object);
                break;
            default:
                break;
        }
    }

    private function updatePayment($object, $response = null)
    {
        $update = (object) [
            'order_id' => $object->metadata->order_id,
            'user_id' => $object->metadata->user_id,
            'payment_id' => $object->metadata->payment_id,
        ];
        $this->paymentService->completePayment($update, $response);
    }

    private function updateOrderStatus($object)
    {
        $complete = new CompletePayment(
            $object->metadata->user_id,
            $object->metadata->order_id,
            $object->metadata->restaurant_id,
            $object->amount,
        );
        $this->orderService->completePayment($complete);
    }
}
