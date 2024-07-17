<?php

namespace Database\Factories;

use App\Enums\BloodGroup;
use App\Enums\Gender;
use App\Models\EducationLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'initial_education_level_id' => EducationLevel::factory(),
            'education_level_id' => EducationLevel::factory(),
            'registery_number' => str()->random(),
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'surname' => fake()->lastName,
            'gender' => fake()->randomElement(Gender::cases()),
            'admission_date' => now(),
            'date_of_birth' => now()->subYears(random_int(5, 15)),
            'blood_group' => fake()->randomElement(BloodGroup::cases()),
            // 'religion' => ,
            // 'nationality' => ,
            // 'family_no' => ,
            // 'languages_known' => ,
            // 'mother_tongue' => ,
            // 'school_leaving_date' => ,
            // 'father_name' => ,
            // 'father_cnic' => ,
            // 'mother_name' => ,
            // 'mother_cnic' => ,
            // 'phone' => ,
            // 'address' => ,
            // 'previous_education_level_id' => ,
            // 'previous_study_year' => ,
            // 'previous_school_name' => ,
            // 'previous_level_marks' => ,
            // 'has_disability' => ,
            // 'disease' => ,
            // 'medication' => ,
            // 'has_doctor_consultancy' => ,
            // 'is_active' => ,
        ];
    }
}
