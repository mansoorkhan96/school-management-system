<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('initial_education_level_id')->constrained('education_levels');
            $table->foreignId('education_level_id')->constrained();
            $table->string('registery_number')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('surname');
            $table->string('gender');
            $table->date('admission_date');

            $table->date('date_of_birth')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('religion')->nullable();
            $table->string('nationality')->nullable();
            $table->string('family_no')->nullable();
            $table->string('languages_known')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->date('school_leaving_date')->nullable();

            $table->string('father_name')->nullable();
            $table->string('father_cnic')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_cnic')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();

            $table->foreignId('previous_education_level_id')->nullable()->constrained('education_levels');
            $table->string('previous_study_year')->nullable();
            $table->string('previous_school_name')->nullable();
            $table->integer('previous_level_marks')->nullable();

            $table->boolean('has_disability')->default(false);
            $table->text('disease')->nullable();
            $table->text('medication')->nullable();
            $table->boolean('has_doctor_consultancy')->default(false);
            $table->boolean('is_active')->default(true);

            $table->string('profile_photo_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
}
