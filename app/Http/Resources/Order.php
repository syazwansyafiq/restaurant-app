<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $return = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'restaurant_id' => $this->restaurant_id,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'created_at' => $this->created_at,
            'delivery_address' => $this->delivery_address,
            'delivery_type' => $this->delivery_type,
            'items' => OrderItem::collection($this->orderItems)
        ];

        $role = auth()->user()->role;

        if ($role == 'restaurant_manager') {
            $return['payments'] = Payment::collection($this->payments);
        }

        return $return;
    }
}
