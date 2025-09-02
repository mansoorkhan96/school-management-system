<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('education_level_id')->constrained();
            $table->foreignId('subject_id')->default(0);
            $table->string('attendance_status');
            $table->date('date');
            $table->timestamps();

            $table->unique([
                'education_level_id',
                'date',
                'student_id',
                'subject_id',
            ], 'student_unique_attendance_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
}
