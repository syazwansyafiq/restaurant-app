<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'menu_id', 'quantity', 'price', 'created_by'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function totalAmount()
    {
        return $this->menu->price * $this->quantity;
    }

    public function points()
    {
        return $this->totalAmount() / 100;
    }

    protected static function booted()
    {
        static::creating(function ($orderItem) {
            $orderItem->total_price = $orderItem->quantity * $orderItem->price;
        });
    }
}
