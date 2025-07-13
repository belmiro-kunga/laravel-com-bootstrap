<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Verificando estrutura da tabela categorias:\n";
$columns = DB::select('DESCRIBE categorias');

foreach ($columns as $column) {
    echo $column->Field . ' - ' . $column->Type . "\n";
}

echo "\nVerificando se deleted_at existe:\n";
$hasDeletedAt = collect($columns)->contains('Field', 'deleted_at');
echo $hasDeletedAt ? "deleted_at existe" : "deleted_at NÃO existe"; 