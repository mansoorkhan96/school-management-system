<?php

namespace Database\Factories;

use App\Enums\AttendanceStatus;
use App\Models\EducationLevel;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'education_level_id' => EducationLevel::factory(),
            'attendance_status' => fake()->randomElement(AttendanceStatus::cases()),
            'date' => now(),
        ];
    }
}
