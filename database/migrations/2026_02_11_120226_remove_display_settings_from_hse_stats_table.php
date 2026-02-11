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
        Schema::table('hse_stats', function (Blueprint $table) {
            $table->dropColumn(['video_url', 'image_path', 'display_mode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hse_stats', function (Blueprint $table) {
            $table->string('video_url')->nullable();
            $table->string('image_path')->nullable();
            $table->string('display_mode')->default('video');
        });
    }
};