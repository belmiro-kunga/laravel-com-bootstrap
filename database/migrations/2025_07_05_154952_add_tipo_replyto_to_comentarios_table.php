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
        Schema::table('comentarios', function (Blueprint $table) {
            if (!Schema::hasColumn('comentarios', 'reply_to')) {
                $table->unsignedBigInteger('reply_to')->nullable()->after('tipo');
                $table->foreign('reply_to')->references('id')->on('comentarios')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comentarios', function (Blueprint $table) {
            if (Schema::hasColumn('comentarios', 'reply_to')) {
                $table->dropForeign(['reply_to']);
                $table->dropColumn('reply_to');
            }
        });
    }
};
