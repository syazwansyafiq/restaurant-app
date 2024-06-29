<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'city', 'country', 'phone', 'image', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }

    public function menuCategory()
    {
        return $this->hasMany(MenuCategory::class);
    }

    public function loyaltyPoint()
    {
        return $this->hasMany(LoyaltyPoint::class);
    }
}
