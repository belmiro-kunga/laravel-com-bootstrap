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
        Schema::create('historico_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('denuncia_id')->constrained()->onDelete('cascade');
            $table->foreignId('status_anterior_id')->nullable()->constrained('status')->onDelete('set null');
            $table->foreignId('status_novo_id')->constrained('status')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->text('comentario')->nullable();
            $table->json('dados_anteriores')->nullable(); // Para armazenar dados anteriores se necessário
            $table->timestamps();
            
            $table->index(['denuncia_id', 'created_at']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_status');
    }
};
