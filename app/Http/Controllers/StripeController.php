<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{

    public function charge(Request $request)
    {
        return (new \App\Services\Stripe\StripeService())->charge($request->amount);
    }

    public function webhook(Request $request)
    {
        return (new \App\Services\Stripe\StripeService())->webhook($request);
    }
}
