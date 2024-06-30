<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'phone' => '1234567890',
            'role' => 'admin',
        ]);

        // Create restaurant manager
        User::create([
            'name' => 'Restaurant Manager',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
            'phone' => '1234567890',
            'role' => 'restaurant_manager',
        ]);

        // Create customer
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
            'phone' => '1234567890',
            'role' => 'customer',
        ]);

        // Create additional customers for testing
        User::factory()->count(10)->create(['role' => 'customer']);
    }
}
