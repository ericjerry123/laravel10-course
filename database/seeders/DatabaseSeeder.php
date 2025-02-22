<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(50)->create();

        Course::factory()
            ->count(10)
            ->state(function (array $attributes) {
                return [
                    'user_id' => User::where('role', 'teacher')->inRandomOrder()->first()->id,
                ];
            })
            ->create();
    }
}
