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
        Schema::table('students', function (Blueprint $table) {
            $table->string('contact_no_2', 15)->nullable();
            $table->string('nickname', 30)->nullable();
            $table->text('address')->nullable();
            $table->string('barangay', 80)->nullable();
            $table->string('city', 80)->nullable();
            $table->string('province', 80)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('nickname', 'address', 'contact_no_2', 'barangay', 'city', 'province');
        });
    }
};
