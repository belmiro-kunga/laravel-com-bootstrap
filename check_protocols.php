<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Denuncia;

echo "=== PROTOCOLOS ATUALIZADOS ===\n";
echo "ID | Protocolo | Data de Criação\n";
echo "---|-----------|----------------\n";

$denuncias = Denuncia::orderBy('id')->get();

foreach ($denuncias as $denuncia) {
    echo sprintf(
        "%d | %s | %s\n",
        $denuncia->id,
        $denuncia->protocolo,
        $denuncia->created_at->format('d/m/Y H:i')
    );
}

echo "\n=== TOTAL: " . $denuncias->count() . " denúncias ===\n"; 