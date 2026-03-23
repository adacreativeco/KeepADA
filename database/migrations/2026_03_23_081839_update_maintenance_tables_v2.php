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
        Schema::table('maintenance_plans', function (Blueprint $table) {
            $table->integer('sla_hours')->nullable()->after('estimated_cost');
        });

        Schema::table('maintenance_tasks', function (Blueprint $table) {
            $table->decimal('labor_cost', 15, 2)->nullable()->after('actual_cost');
            $table->decimal('material_cost', 15, 2)->nullable()->after('labor_cost');
        });
    }

    public function down(): void
    {
        Schema::table('maintenance_plans', function (Blueprint $table) {
            $table->dropColumn('sla_hours');
        });

        Schema::table('maintenance_tasks', function (Blueprint $table) {
            $table->dropColumn(['labor_cost', 'material_cost']);
        });
    }
};
