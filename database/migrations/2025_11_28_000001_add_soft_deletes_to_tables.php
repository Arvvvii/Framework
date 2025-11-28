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
        $tables = ['pet', 'temu_dokter', 'rekam_medis', 'pemilik', 'user', 'role_user'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $tableBlueprint) use ($table) {
                    if (! Schema::hasColumn($tableBlueprint->getTable(), 'deleted_at')) {
                        $tableBlueprint->softDeletes();
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['pet', 'temu_dokter', 'rekam_medis', 'pemilik', 'user', 'role_user'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $tableBlueprint) use ($table) {
                    if (Schema::hasColumn($tableBlueprint->getTable(), 'deleted_at')) {
                        $tableBlueprint->dropSoftDeletes();
                    }
                });
            }
        }
    }
};
