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
        Schema::create('asistencia', function (Blueprint $table) {
            $table->id('id_asistencia');
            $table->unsignedBigInteger('id_jurado');
            $table->unsignedBigInteger('id_mesa');
            $table->enum('estado', ['PRESENTE', 'AUSENTE'])->default('AUSENTE');
            $table->timestamp('registrado_en')->useCurrent();
            $table->foreign('id_jurado')->references('id_jurado')->on('jurados')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_mesa')->references('id_mesa')->on('mesas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
