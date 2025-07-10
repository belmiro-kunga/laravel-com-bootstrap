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
        Schema::create('denuncias', function (Blueprint $table) {
            $table->id();
            $table->string('protocolo', 20)->unique(); // Número do protocolo
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('status_id')->constrained('status');
            $table->string('titulo', 200);
            $table->text('descricao');
            $table->text('local_ocorrencia')->nullable();
            $table->date('data_ocorrencia')->nullable();
            $table->time('hora_ocorrencia')->nullable();
            
            // Dados do denunciante (opcional para denúncias anônimas)
            $table->string('nome_denunciante', 100)->nullable();
            $table->string('email_denunciante', 100)->nullable();
            $table->string('telefone_denunciante', 20)->nullable();
            $table->string('departamento_denunciante', 100)->nullable();
            
            // Dados dos envolvidos
            $table->text('envolvidos')->nullable(); // Nomes dos envolvidos
            $table->text('testemunhas')->nullable(); // Nomes das testemunhas
            
            // Prioridade e urgência
            $table->enum('prioridade', ['baixa', 'media', 'alta', 'critica'])->default('media');
            $table->boolean('urgente')->default(false);
            
            // Controle interno
            $table->foreignId('responsavel_id')->nullable()->constrained('users');
            $table->date('data_limite')->nullable();
            $table->text('observacoes_internas')->nullable();
            
            // Auditoria
            $table->string('ip_denunciante', 45)->nullable();
            $table->string('user_agent')->nullable();
            
            $table->timestamps();
            $table->softDeletes(); // Soft delete para manter histórico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denuncias');
    }
};
