<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isCustomer()
    {
        return $this->role == 'customer';
    }

    public function isRestaurantManager()
    {
        return $this->role == 'restaurant_manager';
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    public function restaurant()
    {
        return $this->hasOne(Restaurant::class, 'id', 'user_id');
    }

    public function LoyaltyPoint()
    {
        return $this->hasOne(LoyaltyPoint::class);
    }

}
