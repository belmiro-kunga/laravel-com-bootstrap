<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'title' => '',
    'subtitle' => '',
    'type' => 'line', // line, bar, pie, doughnut, area
    'data' => [],
    'options' => [],
    'height' => '300px',
    'loading' => false,
    'class' => '',
    'id' => null
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'title' => '',
    'subtitle' => '',
    'type' => 'line', // line, bar, pie, doughnut, area
    'data' => [],
    'options' => [],
    'height' => '300px',
    'loading' => false,
    'class' => '',
    'id' => null
]); ?>
<?php foreach (array_filter(([
    'title' => '',
    'subtitle' => '',
    'type' => 'line', // line, bar, pie, doughnut, area
    'data' => [],
    'options' => [],
    'height' => '300px',
    'loading' => false,
    'class' => '',
    'id' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $chartId = $id ?? 'chart-' . uniqid();
    
    $defaultOptions = [
        'responsive' => true,
        'maintainAspectRatio' => false,
        'plugins' => [
            'legend' => [
                'display' => true,
                'position' => 'top'
            ],
            'tooltip' => [
                'enabled' => true,
                'mode' => 'index',
                'intersect' => false
            ]
        ],
        'scales' => [
            'x' => [
                'display' => true,
                'grid' => [
                    'display' => false
                ]
            ],
            'y' => [
                'display' => true,
                'grid' => [
                    'color' => 'rgba(0,0,0,0.05)'
                ],
                'beginAtZero' => true
            ]
        ]
    ];
    
    $chartOptions = array_merge_recursive($defaultOptions, $options);
?>

<?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['title' => ''.e($title).'','subtitle' => ''.e($subtitle).'','class' => ''.e($class).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($title).'','subtitle' => ''.e($subtitle).'','class' => ''.e($class).'']); ?>
    <div class="chart-container" style="height: <?php echo e($height); ?>; position: relative;">
        <?php if($loading): ?>
            <div class="d-flex align-items-center justify-content-center h-100">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Carregando gráfico...</span>
                </div>
            </div>
        <?php else: ?>
            <canvas id="<?php echo e($chartId); ?>"></canvas>
        <?php endif; ?>
    </div>
    
    <?php if(!$loading): ?>
        <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('<?php echo e($chartId); ?>').getContext('2d');
                
                const chart = new Chart(ctx, {
                    type: '<?php echo e($type); ?>',
                    data: <?php echo json_encode($data, 15, 512) ?>,
                    options: <?php echo json_encode($chartOptions, 15, 512) ?>
                });
                
                // Armazenar referência do gráfico para possível atualização
                window.charts = window.charts || {};
                window.charts['<?php echo e($chartId); ?>'] = chart;
            });
        </script>
        <?php $__env->stopPush(); ?>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalad5130b5347ab6ecc017d2f5a278b926)): ?>
<?php $attributes = $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926; ?>
<?php unset($__attributesOriginalad5130b5347ab6ecc017d2f5a278b926); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalad5130b5347ab6ecc017d2f5a278b926)): ?>
<?php $component = $__componentOriginalad5130b5347ab6ecc017d2f5a278b926; ?>
<?php unset($__componentOriginalad5130b5347ab6ecc017d2f5a278b926); ?>
<?php endif; ?> <?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/components/admin/chart-card.blade.php ENDPATH**/ ?>