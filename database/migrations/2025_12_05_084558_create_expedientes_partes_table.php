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
        Schema::create('expedientes_partes', function (Blueprint $table) {

            // Claves Foráneas
            $table->unsignedBigInteger('expediente_id');
            $table->unsignedBigInteger('persona_id');

            // Datos del Pivote
            $table->string('rol_en_caso', 50); // Ejem: 'Cliente', 'Abogado Contrario'
            $table->string('posicion_procesal', 50); // Ejem: 'Actor', 'Demandado', 'Tercero'

            $table->timestamps();

            // Definición de Foreign Keys
            $table->foreign('expediente_id')
                  ->references('expediente_id')
                  ->on('expedientes')
                  ->onDelete('cascade'); // Borra la relación si se borra el expediente

            $table->foreign('persona_id')
                  ->references('persona_id')
                  ->on('personas')
                  ->onDelete('cascade'); // Borra la relación si se borra la persona

            // Definir la clave primaria compuesta
            $table->primary(['expediente_id', 'persona_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes_partes');
    }
};
