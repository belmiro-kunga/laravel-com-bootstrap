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
        Schema::create('evidencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('denuncia_id')->constrained('denuncias')->onDelete('cascade');
            $table->string('nome_original', 255);
            $table->string('nome_arquivo', 255);
            $table->string('caminho', 500);
            $table->string('tipo_mime', 100);
            $table->bigInteger('tamanho'); // Tamanho em bytes
            $table->string('extensao', 10);
            $table->text('descricao')->nullable();
            $table->boolean('publico')->default(false); // Se pode ser visto pelo denunciante
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencias');
    }
};
