<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTable extends Migration
{
    public function up(): void
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('education_level_id')->constrained();
            $table->decimal('amount');
            $table->string('type')->nullable();
            $table->tinyInteger('fee_month')->nullable();
            $table->year('year');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
}
