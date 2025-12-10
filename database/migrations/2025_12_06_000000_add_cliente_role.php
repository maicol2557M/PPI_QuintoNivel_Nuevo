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
        // Nota: Este cambio es documentativo. El campo 'rol' ya existe.
        // Solo asegurarse de que 'Cliente' sea un valor válido en la aplicación.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
