<?php

namespace Database\Seeders;

use App\Models\EducationLevel;
use Illuminate\Database\Seeder;

class EducationLevelSeeder extends Seeder
{
    public function run(): void
    {
        collect([
            ['name' => 'Primary'],
            ['name' => 'Secondary'],
            ['name' => 'Senior Secondary'],
            ['name' => 'Higher Secondary'],
            ['name' => 'Undergraduate'],
            ['name' => 'Postgraduate'],
        ])->each(fn (array $attributes) => EducationLevel::factory()->create($attributes));
    }
}
