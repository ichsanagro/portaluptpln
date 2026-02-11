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
        Schema::table('playlist_videos', function (Blueprint $table) {
            $table->string('type')->after('original_name'); // e.g., 'video', 'image'
            $table->string('thumbnail_path')->nullable()->after('type');
            $table->integer('duration')->nullable()->after('thumbnail_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('playlist_videos', function (Blueprint $table) {
            $table->dropColumn(['type', 'thumbnail_path', 'duration']);
        });
    }
};