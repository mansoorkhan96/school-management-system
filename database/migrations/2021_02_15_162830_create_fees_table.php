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
            $table->foreignId('education_level_id')->nullable()->constrained();
            $table->decimal('amount', 10, 2);
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->date('payment_date')->nullable();
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
