

<?php $__env->startSection('title', 'Relatórios - Sistema de Denúncias'); ?>

<?php $__env->startSection('page-title', 'Relatórios'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php if (isset($component)) { $__componentOriginaldbbc880c47f621cda59b70d6eb356b2f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldbbc880c47f621cda59b70d6eb356b2f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.breadcrumb','data' => ['items' => [
        ['title' => 'Dashboard', 'url' => route('dashboard.index'), 'icon' => 'fas fa-tachometer-alt'],
        ['title' => 'Relatórios', 'icon' => 'fas fa-chart-bar']
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['title' => 'Dashboard', 'url' => route('dashboard.index'), 'icon' => 'fas fa-tachometer-alt'],
        ['title' => 'Relatórios', 'icon' => 'fas fa-chart-bar']
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
    <!-- Filtros de Relatório -->
    <div class="row mb-4">
        <div class="col-12">
            <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['title' => 'Filtros de Relatório','subtitle' => 'Personalize os dados do relatório']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Filtros de Relatório','subtitle' => 'Personalize os dados do relatório']); ?>
                <form id="filtrosRelatorio" class="row g-3">
                    <div class="col-md-3">
                        <label for="periodo" class="form-label">Período</label>
                        <select class="form-select" id="periodo" name="periodo">
                            <option value="7">Últimos 7 dias</option>
                            <option value="30" selected>Últimos 30 dias</option>
                            <option value="90">Últimos 90 dias</option>
                            <option value="180">Últimos 6 meses</option>
                            <option value="365">Último ano</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="categoria" class="form-label">Categoria</label>
                        <select class="form-select" id="categoria" name="categoria">
                            <option value="">Todas as categorias</option>
                            <?php $__currentLoopData = \App\Models\Categoria::where('ativo', true)->orderBy('nome')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($categoria->id); ?>"><?php echo e($categoria->nome); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Todos os status</option>
                            <?php $__currentLoopData = \App\Models\Status::where('ativo', true)->orderBy('ordem')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($status->id); ?>"><?php echo e($status->nome); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="responsavel" class="form-label">Responsável</label>
                        <select class="form-select" id="responsavel" name="responsavel">
                            <option value="">Todos os responsáveis</option>
                            <?php $__currentLoopData = \App\Models\User::where('ativo', true)->orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-2"></i>Filtrar
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="limparFiltros()">
                            <i class="fas fa-times me-2"></i>Limpar
                        </button>
                        <button type="button" class="btn btn-success" onclick="exportarRelatorio()">
                            <i class="fas fa-download me-2"></i>Exportar
                        </button>
                    </div>
                </form>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalad5130b5347ab6ecc017d2f5a278b926)): ?>
<?php $attributes = $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926; ?>
<?php unset($__attributesOriginalad5130b5347ab6ecc017d2f5a278b926); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalad5130b5347ab6ecc017d2f5a278b926)): ?>
<?php $component = $__componentOriginalad5130b5347ab6ecc017d2f5a278b926; ?>
<?php unset($__componentOriginalad5130b5347ab6ecc017d2f5a278b926); ?>
<?php endif; ?>
        </div>
    </div>

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
        <div class="col-xl-6">
            <?php if (isset($component)) { $__componentOriginal91b17fe816eccd2dd419f56044b0f392 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91b17fe816eccd2dd419f56044b0f392 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.chart-card','data' => ['title' => 'Denúncias por Status','subtitle' => 'Distribuição atual','type' => 'doughnut','data' => $denunciasPorStatus,'height' => '400px','options' => [
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
<?php $component->withAttributes(['title' => 'Denúncias por Status','subtitle' => 'Distribuição atual','type' => 'doughnut','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($denunciasPorStatus),'height' => '400px','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
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
        
        <div class="col-xl-6">
            <?php if (isset($component)) { $__componentOriginal91b17fe816eccd2dd419f56044b0f392 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91b17fe816eccd2dd419f56044b0f392 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.chart-card','data' => ['title' => 'Denúncias por Categoria','subtitle' => 'Últimos 90 dias','type' => 'bar','data' => $denunciasPorCategoria,'height' => '400px','options' => [
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
<?php $component->withAttributes(['title' => 'Denúncias por Categoria','subtitle' => 'Últimos 90 dias','type' => 'bar','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($denunciasPorCategoria),'height' => '400px','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
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
    </div>

    <!-- Gráfico de Tendência -->
    <div class="row mb-4">
        <div class="col-12">
            <?php if (isset($component)) { $__componentOriginal91b17fe816eccd2dd419f56044b0f392 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91b17fe816eccd2dd419f56044b0f392 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.chart-card','data' => ['title' => 'Tendência de Denúncias','subtitle' => 'Últimos 90 dias','type' => 'line','data' => $denunciasPorPeriodo,'height' => '400px','options' => [
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
<?php $component->withAttributes(['title' => 'Tendência de Denúncias','subtitle' => 'Últimos 90 dias','type' => 'line','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($denunciasPorPeriodo),'height' => '400px','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
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
    </div>

    <!-- Estatísticas Detalhadas -->
    <div class="row mb-4">
        <div class="col-xl-6">
            <?php if (isset($component)) { $__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.widget','data' => ['title' => 'Top Responsáveis','icon' => 'fas fa-users','subtitle' => 'Por denúncias pendentes','refreshable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Top Responsáveis','icon' => 'fas fa-users','subtitle' => 'Por denúncias pendentes','refreshable' => true]); ?>
                <div class="list-group list-group-flush">
                    <?php $__empty_1 = true; $__currentLoopData = $estatisticasResponsavel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $responsavel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0"><?php echo e($responsavel->name); ?></h6>
                            <small class="text-muted"><?php echo e($responsavel->email); ?></small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary rounded-pill">
                                <?php echo e($responsavel->denuncias_responsavel_count); ?>

                            </span>
                            <small class="d-block text-muted">pendentes</small>
                        </div>
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
        
        <div class="col-xl-6">
            <?php if (isset($component)) { $__componentOriginal8f30e5b1b95edb166550d1418cd3d4eb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f30e5b1b95edb166550d1418cd3d4eb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.widget','data' => ['title' => 'Denúncias Recentes','icon' => 'fas fa-list','subtitle' => 'Últimas 10 denúncias','refreshable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Denúncias Recentes','icon' => 'fas fa-list','subtitle' => 'Últimas 10 denúncias','refreshable' => true]); ?>
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
                                <td><?php echo e(Str::limit($denuncia->titulo, 25)); ?></td>
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
    </div>
</div>

<!-- Modal de Exportação -->
<div class="modal fade" id="modalExportacao" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Exportar Relatório</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formExportacao">
                    <div class="mb-3">
                        <label for="formato" class="form-label">Formato</label>
                        <select class="form-select" id="formato" name="formato" required>
                            <option value="pdf">PDF com Gráficos</option>
                            <option value="pdf-simple">PDF Simples</option>
                            <option value="excel">Excel</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="incluirGraficos" name="incluir_graficos" checked>
                            <label class="form-check-label" for="incluirGraficos">
                                Incluir gráficos visuais (apenas PDF)
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="periodoExport" class="form-label">Período</label>
                        <select class="form-select" id="periodoExport" name="periodo" required>
                            <option value="7">Últimos 7 dias</option>
                            <option value="30" selected>Últimos 30 dias</option>
                            <option value="90">Últimos 90 dias</option>
                            <option value="180">Últimos 6 meses</option>
                            <option value="365">Último ano</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="confirmarExportacao()">
                    <i class="fas fa-download me-2"></i>Exportar
                </button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Filtros de relatório
document.getElementById('filtrosRelatorio').addEventListener('submit', function(e) {
    e.preventDefault();
    aplicarFiltros();
});

function aplicarFiltros() {
    const formData = new FormData(document.getElementById('filtrosRelatorio'));
    const params = new URLSearchParams(formData);
    
    // Atualizar dados via AJAX
    fetch(`/dashboard/api-dados?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            // Atualizar gráficos e métricas
            atualizarRelatorio(data);
        });
}

function limparFiltros() {
    document.getElementById('filtrosRelatorio').reset();
    aplicarFiltros();
}

function exportarRelatorio() {
    const modal = new bootstrap.Modal(document.getElementById('modalExportacao'));
    modal.show();
}

function confirmarExportacao() {
    const formData = new FormData(document.getElementById('formExportacao'));
    const formato = document.getElementById('formato').value;
    const incluirGraficos = document.getElementById('incluirGraficos').checked;
    
    // Ajustar formato baseado no checkbox
    let tipoFinal = formato;
    if (formato === 'pdf' && !incluirGraficos) {
        tipoFinal = 'pdf-simple';
    } else if (formato === 'pdf-simple' && incluirGraficos) {
        tipoFinal = 'pdf';
    }
    
    // Adicionar parâmetros
    const params = new URLSearchParams(formData);
    params.set('formato', tipoFinal);
    params.set('incluir_graficos', incluirGraficos);
    
    // Redirecionar para download
    window.open(`/dashboard/exportar?${params.toString()}`, '_blank');
    
    // Fechar modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalExportacao'));
    modal.hide();
}

function atualizarRelatorio(data) {
    // Atualizar métricas
    if (data.metrics) {
        // Implementar atualização das métricas
        console.log('Métricas atualizadas:', data.metrics);
    }
    
    // Atualizar gráficos
    if (data.denuncias_por_status && window.charts) {
        Object.keys(window.charts).forEach(chartId => {
            if (chartId.includes('status')) {
                window.charts[chartId].data = data.denuncias_por_status;
                window.charts[chartId].update();
            }
        });
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/dashboard/relatorios.blade.php ENDPATH**/ ?>