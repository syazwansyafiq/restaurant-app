<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = 1; // Assuming the admin created above has ID 1
        // Create restaurant manager
        Restaurant::create([
            'name' => 'Asian Delight',
            'email' => 'manager@example.com',
            'category' => 'Asian',
            'address' => '123 Main Street',
            'city' => 'Kuala Lumpur',
            'country' => 'Malaysia',
            'phone' => '01234567890',
            'description' => 'Delicious Asian food',
            'slug' => 'asian-delight',
            'image' => 'https://via.placeholder.com/150',
            'status' => 'active',
            'user_id' =>  $userId,
        ]);

        Restaurant::create([
            'name' => 'Western Feast',
            'email' => 'manager@example.com',
            'category' => 'Western',
            'address' => '456 Main Street',
            'city' => 'Kuala Lumpur',
            'country' => 'Malaysia',
            'phone' => '01234567890',
            'description' => 'Delicious Western food',
            'slug' => 'western-feast',
            'image' => 'https://via.placeholder.com/150',
            'status' => 'active',
            'user_id' =>  $userId,
        ]);

        Restaurant::create([
            'name' => 'Sweet Desserts',
            'email' => 'manager@example.com',
            'category' => 'Desserts',
            'address' => '789 Main Street',
            'city' => 'Kuala Lumpur',
            'country' => 'Malaysia',
            'phone' => '01234567890',
            'description' => 'Delicious Desserts',
            'slug' => 'sweet-desserts',
            'image' => 'https://via.placeholder.com/150',
            'status' => 'active',
            'user_id' =>  $userId,
        ]);

        // Additional restaurants for testing
        Restaurant::factory()->count(5)->create(['user_id' =>  $userId]);
    }
}
