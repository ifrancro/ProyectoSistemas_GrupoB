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
        Schema::create('mesas', function (Blueprint $table) {
            $table->id('id_mesa');
            $table->integer('numero');
            $table->unsignedBigInteger('id_recinto');
            $table->foreign('id_recinto')->references('id_recinto')->on('recintos')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['id_recinto', 'numero']); // una mesa única por recinto
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesas');
    }
};
