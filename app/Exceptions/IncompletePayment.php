<?php

namespace App\Exceptions;

use Exception;

class IncompletePayment extends Exception
{

    public function render()
    {
        return response()->json(['error' => 'Payment failed'], 400);
    }
}
