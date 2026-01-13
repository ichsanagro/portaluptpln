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
        Schema::create('hse_stats', function (Blueprint $table) {
            $table->id();
            $table->integer('safe_working_days')->default(0);
            $table->integer('accident_count')->default(0);
            $table->date('start_date')->nullable();
            $table->date('last_safe_working_day_update')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hse_stats');
    }
};
