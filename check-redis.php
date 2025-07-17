<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $result = \Illuminate\Support\Facades\Redis::ping();
    echo "Redis está funcionando! Resposta: " . $result . PHP_EOL;
} catch (\Exception $e) {
    echo "Redis não está funcionando: " . $e->getMessage() . PHP_EOL;
}