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
        Schema::table('levels', function (Blueprint $table) {
            $table->string('school_year', 15)->default('2023-2024');
            $table->string('section')->default('Sunrise');
            $table->time('time_in')->default('08:00');
            $table->time('time_out')->default('11:00');
            $table->string('am_pm', 2)->default('AM');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->dropColumn('school_year', 'section', 'time_in', 'time_out', 'am_pm');
        });
    }
};
