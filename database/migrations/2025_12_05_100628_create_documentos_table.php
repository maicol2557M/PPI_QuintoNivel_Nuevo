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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id('documento_id');

            // Relación 1:M con expedientes
            // Asume que la clave primaria de 'expedientes' es 'expediente_id'
            $table->foreignId('expediente_id')->constrained('expedientes', 'expediente_id')->onDelete('cascade');

            $table->string('nombre_original'); // Nombre del archivo que subió el usuario
            $table->string('ruta_archivo');    // La ruta interna donde Laravel lo almacena (storage/app/public/...)
            $table->string('tipo_mime')->nullable();
            $table->unsignedBigInteger('tamano_bytes')->nullable();
            $table->string('descripcion')->nullable(); // Breve descripción del documento

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
