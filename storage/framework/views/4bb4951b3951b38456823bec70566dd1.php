<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(\App\Helpers\ConfigHelper::get('site_name', 'Sistema de Denúncias')); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1><?php echo e(\App\Helpers\ConfigHelper::get('home_main_title', 'Bem-vindo ao Sistema de Denúncias')); ?></h1>
        <p><?php echo e(\App\Helpers\ConfigHelper::get('home_main_subtitle', 'Sua voz protegida, sua denúncia segura.')); ?></p>
        
        <div class="row mt-4">
            <div class="col-md-4">
                <h3><?php echo e(\App\Helpers\ConfigHelper::get('home_feature_1_title', 'Confidencialidade')); ?></h3>
                <p><?php echo e(\App\Helpers\ConfigHelper::get('home_feature_1_text', 'Todas as denúncias são tratadas com sigilo.')); ?></p>
            </div>
            <div class="col-md-4">
                <h3><?php echo e(\App\Helpers\ConfigHelper::get('home_feature_2_title', 'Segurança')); ?></h3>
                <p><?php echo e(\App\Helpers\ConfigHelper::get('home_feature_2_text', 'Plataforma protegida e segura.')); ?></p>
            </div>
            <div class="col-md-4">
                <h3><?php echo e(\App\Helpers\ConfigHelper::get('home_feature_3_title', 'Rastreamento')); ?></h3>
                <p><?php echo e(\App\Helpers\ConfigHelper::get('home_feature_3_text', 'Acompanhe o andamento da sua denúncia.')); ?></p>
            </div>
        </div>
        
        <div class="mt-4">
            <a href="<?php echo e(route('denuncias.formulario-publico')); ?>" class="btn btn-primary">
                <?php echo e(\App\Helpers\ConfigHelper::get('home_cta_button_text', 'Fazer Denúncia')); ?>

            </a>
            <a href="<?php echo e(route('rastreamento.publico')); ?>" class="btn btn-secondary">
                <?php echo e(\App\Helpers\ConfigHelper::get('home_cta_button_secondary', 'Rastrear Denúncia')); ?>

            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> <?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/welcome_simple.blade.php ENDPATH**/ ?>