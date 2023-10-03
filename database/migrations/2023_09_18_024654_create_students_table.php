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
        Schema::create('students', function (Blueprint $table) {
            $table->string('id', 30)->primary();
            $table->string('lastname', 30);
            $table->string('firstname', 60);
            $table->string('middlename', 30)->nullable();
            $table->enum('gender', ['m', 'f']);
            $table->string('guardian_name');
            $table->string('contact_no', 15)->nullable();
            $table->boolean('notify_sms')->default(false);
            $table->foreignId('level_id');
            $table->string('tag')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
