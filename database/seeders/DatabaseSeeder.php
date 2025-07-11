<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Attendance;
use App\Models\EducationLevel;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => UserRole::Admin,
        ]);

        $users = User::factory(2)->create();

        $educationLevels = EducationLevel::factory(2)
            ->sequence(fn (Sequence $sequence) => ['user_id' => $users[$sequence->index]->getKey()])
            ->create();

        $educationLevels->each(function (EducationLevel $educationLevel) use ($users) {
            Subject::factory(8)
                ->sequence(fn () => ['user_id' => $users->random()->getKey()])
                ->create(['education_level_id' => $educationLevel->getKey()]);

            Student::factory(2)
                ->create([
                    'initial_education_level_id' => $educationLevel->getKey(),
                    'education_level_id' => $educationLevel->getKey(),
                ])
                ->each(
                    fn (Student $student) => Attendance::factory(30)
                    // TODO: if day is sunday, then addDay()
                        ->sequence(fn (Sequence $sequence) => ['date' => now()->startOfMonth()->addDay($sequence->index)->toDateString()])
                        ->create([
                            'student_id' => $student->getKey(),
                            'education_level_id' => $student->educationLevel->getKey(),
                        ])
                );
        });
    }
}
