<?php


namespace App\Services\Payment;

use App\Exceptions\IncompletePayment;
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

    public function processPayment(RequestsInitPayment $request)
    {
        try {

            $payment = Payment::create([
                'order_id' => $request->order_id,
                'amount' => $request->amount,
                'payment_method' => 'stripe',
                'status' => 'pending',
            ]);

            $response = [
                'redirect' => route('payment.index', [
                    'description' => $request->description,
                    'amount' => $request->amount,
                    'order_id' => $request->order_id,
                    'user_id' => $request->user_id,
                    'payment_id' => $payment->id
                ]),
                'amount' => $request->amount,
                'description' => $request->description

            ];
            return new InitPayment($response);
        } catch (\Exception $exception) {
            throw new IncompletePayment($exception->getMessage());
        }
    }

    public function completePayment($request, $response)
    {
        $payment = Payment::where('order_id', $request->order_id)
            ->where('user_id', $request->user_id)
            ->where('payment_id', $request->payment_id)
            ->where('status', 'pending')
            ->first();
        $payment->transaction_id = $response->id;
        $payment->amount = $response->amount;
        $payment->payment_details = json_encode($response);
        $payment->status = 'paid';
        $payment->save();
        $this->stripeService->charge($request);
    }

}
