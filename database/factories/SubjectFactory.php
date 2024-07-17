<?php

namespace Database\Factories;

use App\Models\EducationLevel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'education_level_id' => EducationLevel::factory(),
            'name' => fake()->word,
            'max_marks' => 100,
            'min_passing_marks' => 40,
        ];
    }
}
