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
        $courseNames = [
            '程式設計入門',
            '網頁開發實務',
            '資料庫管理',
            'PHP 進階課程',
            'Laravel 框架開發',
            '前端技術實戰',
            '資訊安全概論',
            '雲端服務應用',
            '人工智慧導論',
            '區塊鏈技術',
        ];

        return [
            'name' => fake()->randomElement($courseNames),
            'description' => fake()->realText(200),
            'start_time' => str_pad(fake()->numberBetween(0, 23), 2, '0', STR_PAD_LEFT) .
                str_pad(fake()->numberBetween(0, 59), 2, '0', STR_PAD_LEFT),
            'end_time' => str_pad(fake()->numberBetween(0, 23), 2, '0', STR_PAD_LEFT) .
                str_pad(fake()->numberBetween(0, 59), 2, '0', STR_PAD_LEFT),
            'teacher_id' => Teacher::factory(),
        ];
    }
}
