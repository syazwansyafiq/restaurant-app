<?php

namespace App\Services\Stripe;

use App\Http\DataTransferObjects\CompletePayment;
use App\Models\Payment;
use App\Models\User;
use App\Services\Order\OrderService;
use App\Services\Payment\PaymentService;
use Stripe\StripeClient;

class StripeService
{
    public $stripe;
    public $orderService;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
        $this->orderService = new OrderService();
    }

    public function charge($request)
    {
        $user = User::find($request->user_id);

        $chargeRequest = $this->getChargeRequest($request, $user);

        $response = $this->stripe->charges->create($chargeRequest);

        if(!$response->status === 'succeeded') {
            return response()->json(['status' => 'Payment failed'], 400);
        }

        $this->updatePaymentAsPaid($response);
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
                $this->updatePaymentAsPaid($object);
                $this->updateOrderStatus($object);
                break;
            default:
                break;
        }
    }

    public function success($request)
    {
        $payment = Payment::where('order_id', $request->order_id)
            ->where('user_id', $request->user_id)
            ->where('id', $request->payment_id)
            ->first();
        $payment->transaction_id = $request->transaction_id;
        $payment->amount = $request->amount;
        $payment->payment_details = json_encode($request);
        $payment->status = 'paid';
        $payment->save();

        return response()->json(['status' => 'Payment successful'], 200);
    }

    public function cancel($request)
    {
        $payment = Payment::where('order_id', $request->order_id)
            ->where('user_id', $request->user_id)
            ->where('id', $request->payment_id)
            ->first();
        $payment->status = 'cancelled';
        $payment->save();
        return response()->json(['status' => 'Payment cancelled'], 200);
    }

    private function getChargeRequest($request, $user)
    {
        return [
            'amount' => $request->amount * 100,
            'description' => $request->description,
            'metadata' => [
                'order_id' => $request->order_id,
                'user_id' => $request->user_id,
                'payment_id' => $request->payment_id,
                'restaurant_id' => $request->restaurant_id
            ],
            'currency' => config('services.stripe.currency'),
            'customer' => [
                'email' => $user->email
            ],
            'source' => $request->stripeToken ?? null,
            'receipt_email' => $user->email
        ];
    }

    private function updatePaymentAsPaid($object, $response = null)
    {
        $payment = Payment::where('order_id', $object->metadata->order_id)
        ->where('user_id', $object->metadata->user_id)
        ->where('payment_id', $object->metadata->payment_id)
        ->first();
        $payment->transaction_id = $response->id;
        $payment->amount = $response->amount;
        $payment->payment_details = json_encode($response);
        $payment->status = 'paid';
        $payment->save();
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
