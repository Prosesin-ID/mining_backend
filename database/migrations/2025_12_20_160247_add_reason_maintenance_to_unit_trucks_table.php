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
        Schema::table('unit_trucks', function (Blueprint $table) {
            $table->string('reason_maintenance')->nullable();
            $table->string('maintenance_start_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit_trucks', function (Blueprint $table) {
            $table->dropColumn('reason_maintenance');
            $table->dropColumn('maintenance_start_time');
        });
    }
};
