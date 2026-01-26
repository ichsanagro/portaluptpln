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
        Schema::table('substations', function (Blueprint $table) {
            $table->double('latitude', 15, 12)->change();
            $table->double('longitude', 15, 12)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('substations', function (Blueprint $table) {
            $table->double('latitude', 10, 7)->change();
            $table->double('longitude', 10, 7)->change();
        });
    }
};
