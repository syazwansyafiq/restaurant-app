<?php

namespace App\Services\Moby;

use App\Http\DataTransferObjects\CompletePayment;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Restaurant;
use App\Models\User;
use App\Services\Order\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MobyService
{

    private $clientId;
    private $secretKey;
    private $url;
    private $orderService;
    public function __construct()
    {
        // replace with your client id and secret key
        $this->clientId = config('services.mobypay.key');
        $this->secretKey = config('services.mobypay.secret');
        $this->url = config('services.mobypay.url');
        $this->orderService = new OrderService();
    }

    public function hosted($request)
    {
        $post['referenceNo'] = $request->reference; // required
        $post['amount'] = $request->amount; // required
        $post['currency'] = $request->currency; // required
        $post['details'] = $request->description; // optional
        $post['customerName'] = $request->user_name; // required
        $post['customerEmail'] = $request->user_email; // required
        $post['customerMobile'] = $request->user_phone;    // required
        $post['returnUrl'] = route('payment.moby.return', ['slug' => $request->slug]); // optional
        $post['callbackUrl'] = route('payment.moby.callback', ['slug' => $request->slug]); // optional
        $post['clientId'] = $this->clientId;

        //Step 1 : get auth token
        $resTokenData = $this->getAuthToken();
        $token = $resTokenData->token;

        try {
            $url =  $this->url . '/api/merchant/payment/checkout/hosted';
            $http = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->post($url, $post);
            $res = json_decode($http->body());

            if($res->success === 'false') {
                return response()->json(['success' => false, 'message' => $res->message]);
            }

            if(!empty($res->success) && $res->success && !empty($res->payLink)) {
                return redirect($res->payLink);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function getAuthToken()
    {
        try {
            $tokenUrl  = $this->url. '/api/auth/token';
            $tokenData = [
                'clientId' => $this->clientId,
                'secretKey' => $this->secretKey
            ];

            $resToken = Http::post($tokenUrl, $tokenData)->body();
            $resTokenData = json_decode($resToken);

            return $resTokenData;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function callback(Request $request)
    {
        $data = $request->all();
        $status = $data['status'];

        $verify = $this->verifySignature($data, $this->secretKey);
        $is_api_request = $request->route()->getPrefix() === 'api';

        if(!$verify || $status === 'cancelled' || $status === 'failed') {
            if($is_api_request) {
                return response()->json(['status' => 'Payment failed'], 400);
            }
            return redirect()->route('payment.failed');
        }

        $this->markPaymentAsPaid($data);

        if($is_api_request) {
            return response()->json(['status' => 'Payment successful'], 200);
        }

        return redirect()->route('payment.success');
    }

    private function markPaymentAsPaid($data)
    {
        $payment = Payment::where('reference', $data['referenceNo'])
        ->first();
        $payment->transaction_id = $data['transactionId'];
        $payment->amount = $data['amount'];
        $payment->payment_method = $data['payMethod'];
        $payment->payment_details = json_encode($data);
        $payment->status = 'paid';
        $payment->save();

        $this->completeOrder($payment);
    }

    private function completeOrder($payment)
    {
        $user_id = $payment->user_id;
        $order_id = $payment->order_id;
        $total_amount = number_format($payment->amount, 2, '.', '');
        $restaurant_id = Order::where('id', $order_id)->first()->restaurant_id;

        $completeOrde = new CompletePayment($user_id, $order_id, $total_amount, $restaurant_id);
        $this->orderService->completePayment($completeOrde);
    }

    private function hashParams(array $params, string $secret)
    {
        ksort($params);
        $string = implode('', $params);
        // hmac266
        $sig = hash_hmac('sha256', $string, $secret);

        return $sig;
    }

    private function verifySignature(array $params, string $secret)
    {
        $sig = $params['signature'];
        unset($params['signature']);
        $expectedSig = $this->hashParams($params, $secret);
        return $sig === $expectedSig;
    }
}
