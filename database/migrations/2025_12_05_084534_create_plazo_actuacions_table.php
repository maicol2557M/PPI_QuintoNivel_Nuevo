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
        Schema::create('plazos_actuaciones', function (Blueprint $table) {
            $table->id('plazo_actuacion_id');

            // CLAVE FORÁNEA a EXPEDIENTES (Relación 1:M)
            $table->unsignedBigInteger('expediente_id');

            $table->string('descripcion_actuacion', 255);
            $table->date('fecha_limite');
            $table->string('responsable', 100);
            $table->enum('estado', ['Pendiente', 'Completado', 'Vencido'])->default('Pendiente');
            $table->text('notas')->nullable();

            $table->timestamps();

            // Definición de Foreign Key
            $table->foreign('expediente_id')
                  ->references('expediente_id')
                  ->on('expedientes')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plazo_actuacions');
    }
};
