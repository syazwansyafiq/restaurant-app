<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all restaurants
        $restaurants = Restaurant::all();

        // Create menu for each restaurant
        foreach ($restaurants as $restaurant) {
            Menu::create([
                'restaurant_id' => $restaurant->id,
                'name' => 'Sample Dish 1',
                'description' => 'Sample Description 1',
                'slug' => 'sample-dish-1',
                'status' => 'active',
                'image' => 'https://via.placeholder.com/150',
                'price' => 10.0,
                'created_at' => now(),
                'created_by' => $restaurant->user_id,
            ]);

            Menu::create([
                'restaurant_id' => $restaurant->id,
                'name' => 'Sample Dish 2',
                'description' => 'Sample Description 2',
                'slug' => 'sample-dish-2',
                'status' => 'active',
                'image' => 'https://via.placeholder.com/150',
                'price' => 15.0,
                'created_at' => now(),
                'created_by' => $restaurant->user_id,
            ]);
        }
    }
}
