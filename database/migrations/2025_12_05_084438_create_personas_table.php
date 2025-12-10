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
        Schema::create('personas', function (Blueprint $table) {
            $table->id('persona_id'); // Clave primaria personalizada (ej. 'persona_id')

            $table->string('ruc_cc', 20)->nullable()->unique(); // RUC o Cédula de Identidad (UNIQUE para evitar duplicados)
            $table->string('nombre_razonsocial', 200);
            $table->text('domicilio_completo')->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('email', 150)->nullable();

            // Campo clave: Define si es 'Cliente', 'Demandado', 'Tercero', etc.
            $table->string('tipo_persona', 30);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
