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
        Schema::table('equipment', function (Blueprint $table) {
            $table->decimal('current_meter_reading', 15, 2)->default(0)->after('status');
            $table->string('meter_unit')->nullable()->after('current_meter_reading');
        });

        Schema::table('maintenance_plans', function (Blueprint $table) {
            $table->decimal('meter_interval', 15, 2)->nullable()->after('frequency_value');
            $table->decimal('last_meter_reading', 15, 2)->nullable()->after('meter_interval');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn(['current_meter_reading', 'meter_unit']);
        });

        Schema::table('maintenance_plans', function (Blueprint $table) {
            $table->dropColumn(['meter_interval', 'last_meter_reading']);
        });
    }
};
