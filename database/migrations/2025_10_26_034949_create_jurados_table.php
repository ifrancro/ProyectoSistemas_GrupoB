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
        Schema::create('jurados', function (Blueprint $table) {
            $table->id('id_jurado');
            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('id_mesa');
            $table->enum('cargo', ['PRESIDENTE', 'SECRETARIO', 'VOCAL', 'SUPLENTE']);
            $table->boolean('verificado')->default(false);
            $table->foreign('id_persona')->references('id_persona')->on('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_mesa')->references('id_mesa')->on('mesas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurados');
    }
};
