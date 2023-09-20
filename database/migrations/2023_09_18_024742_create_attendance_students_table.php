<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendance_students', function (Blueprint $table) {
            $table->id();
            $table->date('dtr_date');
            $table->foreignId('student_id');
            $table->dateTime('time_in_am')->nullable();
            $table->dateTime('time_out_am')->nullable();
            $table->dateTime('time_in_pm')->nullable();
            $table->dateTime('time_out_pm')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_students');
    }
};
