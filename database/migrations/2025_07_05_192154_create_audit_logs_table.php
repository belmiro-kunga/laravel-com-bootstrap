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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('event'); // create, update, delete, login, logout, etc.
            $table->string('auditable_type'); // Model class (User, Denuncia, etc.)
            $table->unsignedBigInteger('auditable_id')->nullable(); // ID do modelo
            $table->unsignedBigInteger('user_id')->nullable(); // Usuário que executou a ação
            $table->string('user_type')->nullable(); // Tipo do usuário (admin, responsavel, etc.)
            $table->string('ip_address')->nullable(); // IP do usuário
            $table->string('user_agent')->nullable(); // User agent do navegador
            $table->text('old_values')->nullable(); // Valores antigos (JSON)
            $table->text('new_values')->nullable(); // Valores novos (JSON)
            $table->text('description')->nullable(); // Descrição da ação
            $table->string('url')->nullable(); // URL da ação
            $table->string('method')->nullable(); // Método HTTP (GET, POST, etc.)
            $table->json('metadata')->nullable(); // Dados adicionais (JSON)
            $table->timestamps();
            
            // Índices para performance
            $table->index(['auditable_type', 'auditable_id']);
            $table->index(['user_id']);
            $table->index(['event']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
