<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->boolean('publico')->default(true)->after('tipo');
        });
    }

    public function down()
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->dropColumn('publico');
        });
    }
}; 