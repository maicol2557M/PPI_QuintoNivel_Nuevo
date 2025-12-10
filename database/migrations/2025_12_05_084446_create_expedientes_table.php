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
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id('expediente_id');

            // Datos del Expediente
            $table->string('num_expediente_interno', 50)->unique();
            $table->string('num_judicial', 50)->nullable();
            $table->string('juzgado_tribunal', 100);
            $table->string('materia', 50);
            $table->string('tipo_procedimiento', 50);
            $table->date('fecha_inicio');
            $table->enum('estado_flujo', ['Abierto', 'En Litigio', 'Suspendido', 'Cerrado', 'Archivado'])->default('Abierto');
            $table->decimal('cuantia', 15, 2)->nullable();
            $table->text('resumen_asunto')->nullable();
            $table->date('fecha_ultima_actuacion')->nullable();
            $table->string('ubicacion_archivo', 100)->nullable();
            $table->text('observaciones_internas')->nullable();

            // CLAVE FORÁNEA a USERS
            $table->unsignedBigInteger('abogado_responsable_id');

            $table->timestamps();

            // Definición de la Foreign Key
            $table->foreign('abogado_responsable_id')
                  ->references('usuario_id')
                  ->on('usuarios')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes');
    }
};
