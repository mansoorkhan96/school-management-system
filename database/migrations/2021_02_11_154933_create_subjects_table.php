<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('subject teacher')->constrained();
            $table->foreignId('education_level_id')->constrained();
            $table->string('name');
            $table->tinyInteger('max_marks');
            $table->tinyInteger('min_passing_marks');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
}
