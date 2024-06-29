<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Restaurant;

class RestaurantTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_all_restaurants()
    {
        Restaurant::factory()->count(3)->create();

        $response = $this->getJson('/api/restaurants');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test */
    public function a_user_can_view_a_single_restaurant()
    {
        $restaurant = Restaurant::factory()->create();

        $response = $this->getJson("/api/restaurants/{$restaurant->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $restaurant->id,
                     'name' => $restaurant->name,
                 ]);
    }
}
