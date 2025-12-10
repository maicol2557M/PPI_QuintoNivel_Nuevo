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
        Schema::table('usuarios', function (Blueprint $table) {
            // Agregar campos que faltaban para autenticación y gestión
            $table->string('id_cedula')->nullable()->unique()->after('email');
            $table->string('identificacion')->nullable()->after('id_cedula');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn(['id_cedula', 'identificacion']);
        });
    }
};
