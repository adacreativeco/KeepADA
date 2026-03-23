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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('plan')->default('basics'); // basics, professional, enterprise
            $table->date('plan_expires_at')->nullable();
            $table->integer('max_locations')->default(1);
            $table->integer('max_equipment')->default(50);
            $table->integer('max_users')->default(3);
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['plan', 'plan_expires_at', 'max_locations', 'max_equipment', 'max_users']);
        });
    }
};
