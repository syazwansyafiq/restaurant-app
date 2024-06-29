<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    protected $model = Restaurant::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'category' => $this->faker->randomElement(['Asian', 'Western', 'Desserts']),
            'user_id' => 1, // Assuming a manager exists
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'phone' => $this->faker->phoneNumber,
            'description' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'image' => $this->faker->imageUrl,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'email' => $this->faker->email,
        ];
    }
}
