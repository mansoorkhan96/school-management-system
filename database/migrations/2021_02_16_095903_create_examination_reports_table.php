<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExaminationReportsTable extends Migration
{
    public function up(): void
    {
        Schema::create('examination_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('subject_id')->constrained();
            $table->foreignId('education_level_id')->constrained();
            $table->string('type');
            $table->year('year');
            $table->tinyInteger('obtained_marks')->nullable();
            $table->timestamps();

            $table->unique([
                'student_id',
                'subject_id',
                'education_level_id',
                'type',
                'year',
            ], 'student_unique_exam_report_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
}
