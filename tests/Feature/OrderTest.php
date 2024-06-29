<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Menu;
use App\Models\Order;
use Laravel\Sanctum\Sanctum;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_place_an_order()
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();
        $menu = Menu::factory()->create(['restaurant_id' => $restaurant->id]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/orders', [
            'restaurant_id' => $restaurant->id,
            'total_amount' => 100,
            'items' => [
                [
                    'menu_item_id' => $menu->id,
                    'quantity' => 1,
                    'price' => 100,
                ]
            ]
        ]);

        $response->assertStatus(201)
                 ->assertJson(['status' => 'pending']);
    }

    /** @test */
    public function a_user_can_process_payment()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/payments', [
            'order_id' => $order->id,
            'amount' => $order->total_amount,
            'payment_method' => 'pm_card_visa', // Example payment method ID from Stripe
        ]);

        $response->assertStatus(200)
                 ->assertJson(['status' => 'Payment successful']);
    }
}
