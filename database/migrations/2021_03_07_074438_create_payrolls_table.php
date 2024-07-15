<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->decimal('basic_salary');
            $table->decimal('bonus')->default(0);
            $table->year('year');
            $table->string('month');
            $table->date('payment_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
}
