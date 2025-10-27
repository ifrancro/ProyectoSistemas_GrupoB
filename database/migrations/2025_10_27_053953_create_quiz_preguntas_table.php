<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_preguntas', function (Blueprint $table) {
            $table->id('id_pregunta');
            $table->unsignedBigInteger('id_capacitacion');
            $table->text('pregunta');
            $table->string('tipo', 20)->default('MULTIPLE'); // MULTIPLE, VERDADERO_FALSO
            $table->integer('puntos')->default(1);
            $table->boolean('activa')->default(true);
            $table->timestamps();
            
            // Índices
            $table->index(['id_capacitacion', 'activa']);
            $table->foreign('id_capacitacion')->references('id_capacitacion')->on('capacitaciones')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_preguntas');
    }
};