<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('capacitaciones', function (Blueprint $table) {
            $table->id('id_capacitacion');
            $table->string('titulo', 255);
            $table->text('descripcion')->nullable();
            $table->string('rol_destino', 50); // JURADO, VEEDOR, DELEGADO
            $table->string('estado', 20)->default('ACTIVO'); // ACTIVO, INACTIVO
            $table->integer('total_niveles')->default(3);
            $table->integer('puntaje_minimo')->default(90); // Porcentaje mínimo para aprobar
            $table->timestamps();
            
            // Índices
            $table->index('rol_destino');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('capacitaciones');
    }
};