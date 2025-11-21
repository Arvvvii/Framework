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
        if (!Schema::hasTable('temu_dokter')) {
            return;
        }

        Schema::table('temu_dokter', function (Blueprint $table) {
            if (!Schema::hasColumn('temu_dokter', 'keluhan')) {
                $table->text('keluhan')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('temu_dokter')) {
            return;
        }

        Schema::table('temu_dokter', function (Blueprint $table) {
            if (Schema::hasColumn('temu_dokter', 'keluhan')) {
                $table->dropColumn('keluhan');
            }
        });
    }
};
