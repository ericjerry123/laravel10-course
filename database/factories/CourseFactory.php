<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->paragraph(),
            'start_time' => str_pad(fake()->numberBetween(0, 23), 2, '0', STR_PAD_LEFT) . 
                           str_pad(fake()->numberBetween(0, 59), 2, '0', STR_PAD_LEFT),
            'end_time' => str_pad(fake()->numberBetween(0, 23), 2, '0', STR_PAD_LEFT) . 
                         str_pad(fake()->numberBetween(0, 59), 2, '0', STR_PAD_LEFT),
            'teacher_id' => Teacher::factory(),
        ];
    }
}
