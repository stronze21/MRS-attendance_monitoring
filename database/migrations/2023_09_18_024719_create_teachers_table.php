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
        Schema::create('teachers', function (Blueprint $table) {
            $table->string('id', 30)->primary();
            $table->string('lastname', 30);
            $table->string('firstname', 60);
            $table->string('middlename', 30)->nullable();
            $table->date('birthdate');
            $table->enum('gender', ['m', 'f']);
            $table->string('contact_no', 15);
            $table->text('address')->nullable();
            $table->date('appointment_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
