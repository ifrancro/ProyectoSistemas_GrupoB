<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('capacitacion_niveles', function (Blueprint $table) {
            $table->id('id_nivel');
            $table->unsignedBigInteger('id_capacitacion');
            $table->integer('numero_nivel');
            $table->string('titulo', 255);
            $table->text('contenido');
            $table->string('tipo_contenido', 50)->default('TEXTO'); // TEXTO, VIDEO, PDF, IMAGEN
            $table->string('archivo_url', 500)->nullable();
            $table->integer('duracion_minutos')->nullable();
            $table->boolean('requiere_completar')->default(true);
            $table->timestamps();
            
            // Índices
            $table->index(['id_capacitacion', 'numero_nivel']);
            $table->foreign('id_capacitacion')->references('id_capacitacion')->on('capacitaciones')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('capacitacion_niveles');
    }
};