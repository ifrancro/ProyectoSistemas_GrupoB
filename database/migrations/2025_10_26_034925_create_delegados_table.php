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
        Schema::create('delegados', function (Blueprint $table) {
            $table->id('id_delegado');
            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('id_partido');
            $table->unsignedBigInteger('id_mesa')->nullable();
            $table->boolean('habilitado')->default(true);
            $table->foreign('id_persona')->references('id_persona')->on('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_partido')->references('id_partido')->on('partidos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_mesa')->references('id_mesa')->on('mesas')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['id_persona', 'id_partido', 'id_mesa']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delegados');
    }
};
