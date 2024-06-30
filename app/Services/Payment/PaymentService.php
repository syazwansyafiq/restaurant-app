<?php


namespace App\Services\Payment;

use App\Exceptions\IncompletePayment;
use App\Exceptions\PaymentNotFound;
use App\Http\Requests\InitPayment as RequestsInitPayment;
use App\Http\Resources\InitPayment;
use App\Models\Payment;
use App\Services\Stripe\StripeService;

class PaymentService
{

    private $stripeService;
    public function __construct()
    {
        $this->stripeService = new StripeService();
    }

    public function create(RequestsInitPayment $request)
    {
        $user = $request->user();
        $slug = $this->createPaymentSlug(11);
        $payment = Payment::create([
            'user_id' => $user->id,
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method ?? config('services.payment.default_method'),
            'description' => $request->description,
            'status' => 'pending',
            'slug' => $slug,
            'reference' => $this->generateReference($request->order_id),
        ]);

        return $payment;
    }

    private function generateReference($orderId)
    {
        $ymd = date('ymd');
        $time = date('His');

        return $ymd . $time . $orderId;
    }

    public function findSlug($slug)
    {
        $payment = Payment::where('slug', $slug)->first();
        if (!$payment) {
            throw new PaymentNotFound();
        }
        return $payment;
    }

    public function completePayment($request)
    {
        $payment = Payment::where('order_id', $request->order_id)
            ->where('user_id', $request->user_id)
            ->where('id', $request->payment_id)
            ->first();
        $payment->status = 'paid';
        $payment->save();
    }

    private function createPaymentSlug($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
