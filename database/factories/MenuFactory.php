<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition()
    {
        return [
            'restaurant_id' => \App\Models\Restaurant::factory(),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'image' => $this->faker->imageUrl,
            'category' => $this->faker->word,
            'price' => $this->faker->numberBetween(5, 20),
            'created_at' => now(),
            'created_by' => 1,
        ];
    }
}
