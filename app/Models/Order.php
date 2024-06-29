<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'restaurant_id', 'menu_id', 'quantity', 'status', 'total_amount', 'created_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function totalAmount()
    {
        return $this->orderItems->sum('total_amount');
    }

    public function points()
    {
        return $this->totalAmount() / 100;
    }

    public function isPaid()
    {
        return $this->status == 'paid';
    }

    public function isPending()
    {
        return $this->status == 'pending';
    }

    public function isCancelled()
    {
        return $this->status == 'cancelled';
    }

    public function isCompleted()
    {
        return $this->status == 'completed';
    }

    public function isDelivered()
    {
        return $this->status == 'delivered';
    }

    public function isFailed()
    {
        return $this->status == 'failed';
    }

    public function cancel()
    {
        $this->status = 'cancelled';
        $this->save();
    }

    public function complete()
    {
        $this->status = 'completed';
        $this->save();
    }

    public function deliver()
    {
        $this->status = 'delivered';
        $this->save();
    }

    public function fail()
    {
        $this->status = 'failed';
        $this->save();
    }

    public function markAsPaid()
    {
        $this->status = 'paid';
        $this->save();
    }

    public function markAsPending()
    {
        $this->status = 'pending';
        $this->save();
    }
}
