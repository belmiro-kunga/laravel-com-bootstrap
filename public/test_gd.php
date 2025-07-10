<?php
echo "<h2>Teste da Extensão GD</h2>";

// Verificar se a extensão GD está carregada
if (extension_loaded('gd')) {
    echo "<p style='color: green;'>✅ Extensão GD está carregada!</p>";
    
    // Verificar informações da GD
    $gd_info = gd_info();
    echo "<h3>Informações da GD:</h3>";
    echo "<ul>";
    foreach ($gd_info as $key => $value) {
        echo "<li><strong>$key:</strong> " . ($value ? 'Sim' : 'Não') . "</li>";
    }
    echo "</ul>";
    
    // Testar criação de imagem
    try {
        $image = imagecreate(100, 100);
        if ($image) {
            echo "<p style='color: green;'>✅ Criação de imagem funcionou!</p>";
            imagedestroy($image);
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Erro ao criar imagem: " . $e->getMessage() . "</p>";
    }
    
} else {
    echo "<p style='color: red;'>❌ Extensão GD NÃO está carregada!</p>";
}

// Verificar outras extensões relacionadas
echo "<h3>Outras extensões relacionadas:</h3>";
$extensions = ['gd', 'imagick', 'mbstring', 'xml', 'zip'];
foreach ($extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<p style='color: green;'>✅ $ext está carregada</p>";
    } else {
        echo "<p style='color: red;'>❌ $ext NÃO está carregada</p>";
    }
}

// Informações do PHP
echo "<h3>Informações do PHP:</h3>";
echo "<p><strong>Versão PHP:</strong> " . PHP_VERSION . "</p>";
echo "<p><strong>Arquivo php.ini:</strong> " . php_ini_loaded_file() . "</p>";
echo "<p><strong>SAPI:</strong> " . php_sapi_name() . "</p>";
?> 