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
        Schema::create('credenciales', function (Blueprint $table) {
            $table->id('id_credencial');
            $table->unsignedBigInteger('id_persona');
            $table->string('rol', 50); // JURADO, VEEDOR, DELEGADO
            $table->string('tipo', 50)->default('CREDENCIAL');
            $table->string('nombre_archivo', 255);
            $table->string('ruta_archivo', 500);
            $table->string('estado', 50)->default('GENERADO'); // GENERADO, DESCARGADO, EXPIRADO
            $table->text('contenido_qr')->nullable();
            $table->timestamp('generado_en')->useCurrent();
            $table->timestamp('descargado_en')->nullable();
            $table->timestamp('expira_en')->nullable();
            
            // Índices
            $table->index(['id_persona', 'rol']);
            $table->index('estado');
            $table->index('generado_en');
            
            // Claves foráneas
            $table->foreign('id_persona')->references('id_persona')->on('personas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credenciales');
    }
};
