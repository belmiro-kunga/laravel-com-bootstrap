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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome da permissão
            $table->string('slug')->unique(); // Slug único para identificação
            $table->text('description')->nullable(); // Descrição da permissão
            $table->string('category')->default('general'); // Categoria (menu, funcionalidade, etc)
            $table->string('group')->default('general'); // Grupo de permissões
            $table->boolean('active')->default(true); // Se a permissão está ativa
            $table->integer('order')->default(0); // Ordem de exibição
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
