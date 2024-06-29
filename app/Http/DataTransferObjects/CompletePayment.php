<?php

namespace App\Http\DataTransferObjects;

use Ramsey\Uuid\Type\Decimal;

class CompletePayment
{
    public int $user_id;
    public int $order_id;
    public Decimal $total_amount;
    public int $restaurant_id;


    public function __construct(int $user_id, int $order_id, Decimal $total_amount, int $restaurant_id)
    {
        $this->user_id = $user_id;
        $this->order_id = $order_id;
        $this->total_amount = $total_amount;
        $this->restaurant_id = $restaurant_id;
    }
}

