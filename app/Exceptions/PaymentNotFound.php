<?php

namespace App\Exceptions;

use Exception;

class PaymentNotFound extends Exception
{
    public function render()
    {
        return response()->json(['error' => 'Payment not found'], 400);
    }
}
