<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Achievement>
 */
class AchievementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3) . ' Badge',
            'description' => fake()->paragraph(),
            'badge_icon_url' => fake()->imageUrl(),
            'threshold' => fake()->unique()->numberBetween(1, 100),
        ];
    }
}
