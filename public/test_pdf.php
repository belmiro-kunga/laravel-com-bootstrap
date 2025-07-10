<?php
require_once '../vendor/autoload.php';

use Barryvdh\DomPDF\Facade\Pdf;

echo "<h2>Teste do DomPDF</h2>";

try {
    // Teste simples sem gráficos
    $html = '
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            .header { background: #3498db; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>Teste de PDF</h1>
        </div>
        <div class="content">
            <h2>Relatório Simples</h2>
            <p>Este é um teste do DomPDF sem gráficos.</p>
            <p>Data: ' . date('d/m/Y H:i:s') . '</p>
        </div>
    </body>
    </html>';
    
    $pdf = Pdf::loadView('test', ['html' => $html]);
    $pdf->setPaper('a4', 'portrait');
    
    echo "<p style='color: green;'>✅ DomPDF carregado com sucesso!</p>";
    echo "<p><a href='test_pdf_download.php' target='_blank'>Baixar PDF de Teste</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro no DomPDF: " . $e->getMessage() . "</p>";
}

// Verificar extensões
echo "<h3>Extensões PHP:</h3>";
$required = ['gd', 'mbstring', 'xml', 'zip'];
foreach ($required as $ext) {
    if (extension_loaded($ext)) {
        echo "<p style='color: green;'>✅ $ext</p>";
    } else {
        echo "<p style='color: red;'>❌ $ext</p>";
    }
}
?> 