<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_respuestas', function (Blueprint $table) {
            $table->id('id_respuesta');
            $table->unsignedBigInteger('id_pregunta');
            $table->text('opcion');
            $table->boolean('es_correcta')->default(false);
            $table->integer('orden')->default(1);
            $table->timestamps();
            
            // Índices
            $table->index(['id_pregunta', 'orden']);
            $table->foreign('id_pregunta')->references('id_pregunta')->on('quiz_preguntas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_respuestas');
    }
};