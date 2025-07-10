

<?php $__env->startSection('title', 'Dashboard - Sistema de Denúncias'); ?>

<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php if (isset($component)) { $__componentOriginaldbbc880c47f621cda59b70d6eb356b2f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldbbc880c47f621cda59b70d6eb356b2f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.breadcrumb','data' => ['items' => [
        ['title' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt']
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['title' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt']
    ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldbbc880c47f621cda59b70d6eb356b2f)): ?>
<?php $attributes = $__attributesOriginaldbbc880c47f621cda59b70d6eb356b2f; ?>
<?php unset($__attributesOriginaldbbc880c47f621cda59b70d6eb356b2f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldbbc880c47f621cda59b70d6eb356b2f)): ?>
<?php $component = $__componentOriginaldbbc880c47f621cda59b70d6eb356b2f; ?>
<?php unset($__componentOriginaldbbc880c47f621cda59b70d6eb356b2f); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Métricas Principais -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <?php if (isset($component)) { $__componentOriginal6787d12cf91691b0002d6d0db371a00e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6787d12cf91691b0002d6d0db371a00e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.metric-card','data' => ['title' => 'Total de Denúncias','value' => $metrics['total_denuncias']['value'],'icon' => 'fas fa-exclamation-triangle','variant' => 'primary','trend' => $metrics['total_denuncias']['trend'],'trendValue' => $metrics['total_denuncias']['trend_value'],'trendLabel' => $metrics['total_denuncias']['trend_label']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.metric-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Total de Denúncias','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($metrics['total_denuncias']['value']),'icon' => 'fas fa-exclamation-triangle','variant' => 'primary','trend' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($metrics['total_denuncias']['trend']),'trendValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($metrics['total_denuncias']['trend_value']),'trendLabel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($metrics['total_denuncias']['trend_label'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6787d12cf91691b0002d6d0db371a00e)): ?>
<?php $attributes = $__attributesOriginal6787d12cf91691b0002d6d0db371a00e; ?>
<?php unset($__attributesOriginal6787d12cf91691b0002d6d0db371a00e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6787d12cf91691b0002d6d0db371a00e)): ?>
<?php $component = $__componentOriginal6787d12cf91691b0002d6d0db371a00e; ?>
<?php unset($__componentOriginal6787d12cf91691b0002d6d0db371a00e); ?>
<?php endif; ?>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <?php if (isset($component)) { $__componentOriginal6787d12cf91691b0002d6d0db371a00e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6787d12cf91691b0002d6d0db371a00e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.metric-card','data' => ['title' => 'Denúncias Pendentes','value' => $metrics['denuncias_pendentes']['value'],'icon' => 'fas fa-clock','variant' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.metric-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Denúncias Pendentes','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($metrics['denuncias_pendentes']['value']),'icon' => 'fas fa-clock','variant' => 'warning']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6787d12cf91691b0002d6d0db371a00e)): ?>
<?php $attributes = $__attributesOriginal6787d12cf91691b0002d6d0db371a00e; ?>
<?php unset($__attributesOriginal6787d12cf91691b0002d6d0db371a00e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6787d12cf91691b0002d6d0db371a00e)): ?>
<?php $component = $__componentOriginal6787d12cf91691b0002d6d0db371a00e; ?>
<?php unset($__componentOriginal6787d12cf91691b0002d6d0db371a00e); ?>
<?php endif; ?>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <?php if (isset($component)) { $__componentOriginal6787d12cf91691b0002d6d0db371a00e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6787d12cf91691b0002d6d0db371a00e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.metric-card','data' => ['title' => 'Denúncias Urgentes','value' => $metrics['denuncias_urgentes']['value'],'icon' => 'fas fa-exclamation-circle','variant' => 'danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.metric-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Denúncias Urgentes','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($metrics['denuncias_urgentes']['value']),'icon' => 'fas fa-exclamation-circle','variant' => 'danger']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6787d12cf91691b0002d6d0db371a00e)): ?>
<?php $attributes = $__attributesOriginal6787d12cf91691b0002d6d0db371a00e; ?>
<?php unset($__attributesOriginal6787d12cf91691b0002d6d0db371a00e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6787d12cf91691b0002d6d0db371a00e)): ?>
<?php $component = $__componentOriginal6787d12cf91691b0002d6d0db371a00e; ?>
<?php unset($__componentOriginal6787d12cf91691b0002d6d0db371a00e); ?>
<?php endif; ?>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <?php if (isset($component)) { $__componentOriginal6787d12cf91691b0002d6d0db371a00e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6787d12cf91691b0002d6d0db371a00e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.metric-card','data' => ['title' => 'Denúncias Resolvidas','value' => $metrics['denuncias_resolvidas']['value'],'icon' => 'fas fa-check-circle','variant' => 'success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.metric-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Denúncias Resolvidas','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($metrics['denuncias_resolvidas']['value']),'icon' => 'fas fa-check-circle','variant' => 'success']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6787d12cf91691b0002d6d0db371a00e)): ?>
<?php $attributes = $__attributesOriginal6787d12cf91691b0002d6d0db371a00e; ?>
<?php unset($__attributesOriginal6787d12cf91691b0002d6d0db371a00e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6787d12cf91691b0002d6d0db371a00e)): ?>
<?php $component = $__componentOriginal6787d12cf91691b0002d6d0db371a00e; ?>
<?php unset($__componentOriginal6787d12cf91691b0002d6d0db371a00e); ?>
<?php endif; ?>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row mb-4">
        <div class="col-xl-8 col-lg-7">
            <?php if (isset($component)) { $__componentOriginal91b17fe816eccd2dd419f56044b0f392 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91b17fe816eccd2dd419f56044b0f392 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.chart-card','data' => ['title' => 'Denúncias por Período','subtitle' => 'Últimos 30 dias','type' => 'line','data' => $denunciasPorPeriodo,'height' => '350px','options' => [
                    'plugins' => [
                        'legend' => ['display' => false]
                    ],
                    'scales' => [
                        'y' => ['beginAtZero' => true]
                    ]
                ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.chart-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Denúncias por Período','subtitle' => 'Últimos 30 dias','type' => 'line','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($denunciasPorPeriodo),'height' => '350px','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    'plugins' => [
                        'legend' => ['display' => false]
                    ],
                    'scales' => [
                        'y' => ['beginAtZero' => true]
                    ]
                ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91b17fe816eccd2dd419f56044b0f392)): ?>
<?php $attributes = $__attributesOriginal91b17fe816eccd2dd419f56044b0f392; ?>
<?php unset($__attributesOriginal91b17fe816eccd2dd419f56044b0f392); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91b17fe816eccd2dd419f56044b0f392)): ?>
<?php $component = $__componentOriginal91b17fe816eccd2dd419f56044b0f392; ?>
<?php unset($__componentOriginal91b17fe816eccd2dd419f56044b0f392); ?>
<?php endif; ?>
        </div>
        
        <div class="col-xl-4 col-lg-5">
            <?php if (isset($component)) { $__componentOriginal91b17fe816eccd2dd419f56044b0f392 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91b17fe816eccd2dd419f56044b0f392 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.chart-card','data' => ['title' => 'Denúncias por Status','subtitle' => 'Distribuição atual','type' => 'doughnut','data' => $denunciasPorStatus,'height' => '350px','options' => [
                    'plugins' => [
                        'legend' => ['position' => 'bottom']
                    ]
                ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.chart-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Denúncias por Status','subtitle' => 'Distribuição atual','type' => 'doughnut','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($denunciasPorStatus),'height' => '350px','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    'plugins' => [
                        'legend' => ['position' => 'bottom']
                    ]
                ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91b17fe816eccd2dd419f56044b0f392)): ?>
<?php $attributes = $__attributesOriginal91b17fe816eccd2dd419f56044b0f392; ?>
<?php unset($__attributesOriginal91b17fe816eccd2dd419f56044b0f392); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91b17fe816eccd2dd419f56044b0f392)): ?>
<?php $component = $__componentOriginal91b17fe816eccd2dd419f56044b0f392; ?>
<?php unset($__componentOriginal91b17fe816eccd2dd419f56044b0f392); ?>
<?php endif; ?>
        </div>
    </div>

    <!-- Widgets Adicionais -->
    <div class="row mb-4">
        <div class="col-xl-6 col-lg-6">
            <?php if (isset($component)) { $__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.widget','data' => ['title' => 'Denúncias Recentes','icon' => 'fas fa-list','refreshable' => true,'collapsible' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Denúncias Recentes','icon' => 'fas fa-list','refreshable' => true,'collapsible' => true]); ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Protocolo</th>
                                <th>Título</th>
                                <th>Status</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $denunciasRecentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $denuncia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <a href="<?php echo e(route('denuncias.show', $denuncia)); ?>" class="text-decoration-none">
                                        <?php echo e($denuncia->protocolo); ?>

                                    </a>
                                </td>
                                <td><?php echo e(Str::limit($denuncia->titulo, 30)); ?></td>
                                <td>
                                    <?php if (isset($component)) { $__componentOriginal72ffe10338c4ec71bdf1582010227fb9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal72ffe10338c4ec71bdf1582010227fb9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.status-badge','data' => ['status' => $denuncia->status->nome]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($denuncia->status->nome)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal72ffe10338c4ec71bdf1582010227fb9)): ?>
<?php $attributes = $__attributesOriginal72ffe10338c4ec71bdf1582010227fb9; ?>
<?php unset($__attributesOriginal72ffe10338c4ec71bdf1582010227fb9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal72ffe10338c4ec71bdf1582010227fb9)): ?>
<?php $component = $__componentOriginal72ffe10338c4ec71bdf1582010227fb9; ?>
<?php unset($__componentOriginal72ffe10338c4ec71bdf1582010227fb9); ?>
<?php endif; ?>
                                </td>
                                <td><?php echo e($denuncia->created_at->format('d/m/Y')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Nenhuma denúncia recente
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb)): ?>
<?php $attributes = $__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb; ?>
<?php unset($__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb)): ?>
<?php $component = $__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb; ?>
<?php unset($__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb); ?>
<?php endif; ?>
        </div>
        
        <div class="col-xl-6 col-lg-6">
            <?php if (isset($component)) { $__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.widget','data' => ['title' => 'Denúncias Urgentes','icon' => 'fas fa-exclamation-triangle','variant' => 'danger','refreshable' => true,'collapsible' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Denúncias Urgentes','icon' => 'fas fa-exclamation-triangle','variant' => 'danger','refreshable' => true,'collapsible' => true]); ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Protocolo</th>
                                <th>Título</th>
                                <th>Responsável</th>
                                <th>Prioridade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $denunciasUrgentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $denuncia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <a href="<?php echo e(route('denuncias.show', $denuncia)); ?>" class="text-decoration-none">
                                        <?php echo e($denuncia->protocolo); ?>

                                    </a>
                                </td>
                                <td><?php echo e(Str::limit($denuncia->titulo, 25)); ?></td>
                                <td>
                                    <?php if($denuncia->responsavel): ?>
                                        <?php echo e($denuncia->responsavel->name); ?>

                                    <?php else: ?>
                                        <span class="text-muted">Não atribuído</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (isset($component)) { $__componentOriginal72ffe10338c4ec71bdf1582010227fb9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal72ffe10338c4ec71bdf1582010227fb9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.status-badge','data' => ['status' => $denuncia->prioridade]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($denuncia->prioridade)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal72ffe10338c4ec71bdf1582010227fb9)): ?>
<?php $attributes = $__attributesOriginal72ffe10338c4ec71bdf1582010227fb9; ?>
<?php unset($__attributesOriginal72ffe10338c4ec71bdf1582010227fb9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal72ffe10338c4ec71bdf1582010227fb9)): ?>
<?php $component = $__componentOriginal72ffe10338c4ec71bdf1582010227fb9; ?>
<?php unset($__componentOriginal72ffe10338c4ec71bdf1582010227fb9); ?>
<?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Nenhuma denúncia urgente
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb)): ?>
<?php $attributes = $__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb; ?>
<?php unset($__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb)): ?>
<?php $component = $__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb; ?>
<?php unset($__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb); ?>
<?php endif; ?>
        </div>
    </div>

    <!-- Estatísticas por Responsável -->
    <div class="row mb-4">
        <div class="col-xl-6">
            <?php if (isset($component)) { $__componentOriginal91b17fe816eccd2dd419f56044b0f392 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91b17fe816eccd2dd419f56044b0f392 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.chart-card','data' => ['title' => 'Denúncias por Categoria','subtitle' => 'Últimos 30 dias','type' => 'bar','data' => $denunciasPorCategoria,'height' => '300px','options' => [
                    'plugins' => [
                        'legend' => ['display' => false]
                    ],
                    'scales' => [
                        'y' => ['beginAtZero' => true]
                    ]
                ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.chart-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Denúncias por Categoria','subtitle' => 'Últimos 30 dias','type' => 'bar','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($denunciasPorCategoria),'height' => '300px','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    'plugins' => [
                        'legend' => ['display' => false]
                    ],
                    'scales' => [
                        'y' => ['beginAtZero' => true]
                    ]
                ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91b17fe816eccd2dd419f56044b0f392)): ?>
<?php $attributes = $__attributesOriginal91b17fe816eccd2dd419f56044b0f392; ?>
<?php unset($__attributesOriginal91b17fe816eccd2dd419f56044b0f392); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91b17fe816eccd2dd419f56044b0f392)): ?>
<?php $component = $__componentOriginal91b17fe816eccd2dd419f56044b0f392; ?>
<?php unset($__componentOriginal91b17fe816eccd2dd419f56044b0f392); ?>
<?php endif; ?>
        </div>
        
        <div class="col-xl-6">
            <?php if (isset($component)) { $__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.widget','data' => ['title' => 'Top Responsáveis','icon' => 'fas fa-users','subtitle' => 'Por denúncias pendentes']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Top Responsáveis','icon' => 'fas fa-users','subtitle' => 'Por denúncias pendentes']); ?>
                <div class="list-group list-group-flush">
                    <?php $__empty_1 = true; $__currentLoopData = $estatisticasResponsavel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $responsavel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0"><?php echo e($responsavel->name); ?></h6>
                            <small class="text-muted"><?php echo e($responsavel->email); ?></small>
                        </div>
                        <span class="badge bg-primary rounded-pill">
                            <?php echo e($responsavel->denuncias_responsavel_count); ?>

                        </span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="list-group-item text-center text-muted">
                        Nenhum responsável encontrado
                    </div>
                    <?php endif; ?>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb)): ?>
<?php $attributes = $__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb; ?>
<?php unset($__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb)): ?>
<?php $component = $__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb; ?>
<?php unset($__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb); ?>
<?php endif; ?>
        </div>
    </div>

    <!-- Atividades Recentes -->
    <div class="row">
        <div class="col-12">
            <?php if (isset($component)) { $__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.widget','data' => ['title' => 'Atividades Recentes','icon' => 'fas fa-history','subtitle' => 'Últimas atividades do sistema','refreshable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Atividades Recentes','icon' => 'fas fa-history','subtitle' => 'Últimas atividades do sistema','refreshable' => true]); ?>
                <div class="timeline">
                    <?php $__empty_1 = true; $__currentLoopData = $atividadesRecentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atividade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="timeline-item">
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong><?php echo e($atividade->action); ?></strong>
                                    <p class="mb-0 text-muted"><?php echo e($atividade->description); ?></p>
                                </div>
                                <small class="text-muted"><?php echo e($atividade->created_at->diffForHumans()); ?></small>
                            </div>
                            <?php if($atividade->user): ?>
                            <small class="text-muted">
                                Por: <?php echo e($atividade->user->name); ?>

                            </small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-3">
                        Nenhuma atividade recente
                    </div>
                    <?php endif; ?>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb)): ?>
<?php $attributes = $__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb; ?>
<?php unset($__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb)): ?>
<?php $component = $__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb; ?>
<?php unset($__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb); ?>
<?php endif; ?>
        </div>
    </div>
</div>

<!-- Scripts para atualização automática -->
<?php $__env->startPush('scripts'); ?>
<script>
// Atualizar dados do dashboard a cada 5 minutos
setInterval(function() {
    atualizarDashboard();
}, 300000);

function atualizarDashboard() {
    // Atualizar métricas
    fetch('/dashboard/api-dados?tipo=metrics')
        .then(response => response.json())
        .then(data => {
            // Atualizar cards de métricas
            atualizarMetricas(data);
        });
    
    // Atualizar gráficos
    fetch('/dashboard/api-dados?tipo=status')
        .then(response => response.json())
        .then(data => {
            if (window.charts && window.charts['chart-status']) {
                window.charts['chart-status'].data = data;
                window.charts['chart-status'].update();
            }
        });
}

function atualizarMetricas(data) {
    // Implementar atualização das métricas
    console.log('Métricas atualizadas:', data);
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/dashboard/index.blade.php ENDPATH**/ ?>