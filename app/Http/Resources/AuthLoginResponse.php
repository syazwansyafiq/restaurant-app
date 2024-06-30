<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthLoginResponse extends JsonResource
{
    private $user;
    private $token;
    private $expires_in;
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
        $this->expires_in = 3600;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $return = [
            'access_token' => $this->token,
            'token_type' => 'bearer',
            'expires_in' => $this->expires_in,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email
            ],
        ];

        if(auth()->user()->role == 'customer') {
            $return['user']['loyalty_points'] = new LoyaltyPoint($this->user->loyaltyPoint);
        }

        return $return;
    }
}
