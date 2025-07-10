<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configurações de Upload de Arquivos
    |--------------------------------------------------------------------------
    |
    | Este arquivo contém as configurações para uploads de arquivos no sistema.
    | Você pode modificar esses valores de acordo com as necessidades do seu projeto.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Logo do Sistema
    |--------------------------------------------------------------------------
    |
    */
    'logo' => [
        'max_size' => 1024, // KB
        'mimes' => ['png', 'jpg', 'jpeg', 'svg'],
        'directory' => 'public/images',
        'public_path' => 'storage/images',
    ],

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    */
    'favicon' => [
        'max_size' => 256, // KB
        'mimes' => ['ico', 'png', 'svg'],
        'directory' => 'public/images',
        'public_path' => 'storage/images',
    ],

    /*
    |--------------------------------------------------------------------------
    | Imagens do Slider
    |--------------------------------------------------------------------------
    |
    */
    'slider' => [
        'max_size' => 2048, // KB
        'mimes' => ['jpg', 'jpeg', 'png', 'svg'],
        'directory' => 'public/images/slider',
        'public_path' => 'storage/images/slider',
        'count' => 3, // Número de imagens do slider
    ],

    /*
    |--------------------------------------------------------------------------
    | Outros Uploads
    |--------------------------------------------------------------------------
    |
    */
    'default' => [
        'max_size' => 2048, // KB
        'mimes' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx'],
        'directory' => 'public/uploads',
        'public_path' => 'storage/uploads',
    ],
];
