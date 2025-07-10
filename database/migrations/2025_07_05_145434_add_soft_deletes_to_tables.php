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
        // Adicionar deleted_at apenas na tabela evidencias (as outras já têm)
        Schema::table('evidencias', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remover deleted_at da tabela evidencias
        Schema::table('evidencias', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
