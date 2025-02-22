<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Teacher::factory(5)->create();

        Course::factory()
            ->count(10)
            ->state(function (array $attributes) {
                return [
                    'teacher_id' => Teacher::inRandomOrder()->first()->id,
                ];
            })
            ->create();
    }
}
