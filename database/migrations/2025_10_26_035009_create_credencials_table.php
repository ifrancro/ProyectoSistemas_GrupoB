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
            $table->enum('rol', ['JURADO', 'VEEDOR', 'DELEGADO']);
            $table->string('qr_code', 255)->nullable();
            $table->string('pdf_path', 255)->nullable();
            $table->timestamp('emitido_en')->useCurrent();
            $table->foreign('id_persona')->references('id_persona')->on('personas')->onDelete('cascade')->onUpdate('cascade');
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
