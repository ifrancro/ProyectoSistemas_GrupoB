<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('progreso_capacitaciones', function (Blueprint $table) {
            $table->id('id_progreso');
            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('id_capacitacion');
            $table->integer('nivel_actual')->default(1);
            $table->boolean('completado')->default(false);
            $table->integer('puntaje_quiz')->nullable();
            $table->boolean('aprobado')->default(false);
            $table->timestamp('fecha_inicio')->useCurrent();
            $table->timestamp('fecha_completado')->nullable();
            $table->timestamps();
            
            // Índices
            $table->index(['id_persona', 'id_capacitacion']);
            $table->index('completado');
            $table->index('aprobado');
            $table->foreign('id_persona')->references('id_persona')->on('personas')->onDelete('cascade');
            $table->foreign('id_capacitacion')->references('id_capacitacion')->on('capacitaciones')->onDelete('cascade');
            
            // Evitar duplicados
            $table->unique(['id_persona', 'id_capacitacion']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progreso_capacitaciones');
    }
};