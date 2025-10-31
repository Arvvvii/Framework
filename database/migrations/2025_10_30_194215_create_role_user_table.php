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
        Schema::create('role_user', function (Blueprint $table) {
            $table->id('idrole_user');
            $table->unsignedBigInteger('iduser');
            $table->unsignedBigInteger('idrole');
            $table->tinyInteger('status')->default(1);
            $table->foreign('iduser')->references('iduser')->on('datauser')->onDelete('cascade');
            $table->foreign('idrole')->references('idrole')->on('role')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
