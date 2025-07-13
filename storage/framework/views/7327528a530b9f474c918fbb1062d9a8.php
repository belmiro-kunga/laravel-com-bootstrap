<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'title' => '',
    'value' => 0,
    'subtitle' => '',
    'icon' => 'fas fa-chart-line',
    'variant' => 'primary', // primary, success, warning, danger, info
    'trend' => null, // positive, negative, neutral
    'trendValue' => null,
    'trendLabel' => '',
    'loading' => false,
    'class' => ''
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'title' => '',
    'value' => 0,
    'subtitle' => '',
    'icon' => 'fas fa-chart-line',
    'variant' => 'primary', // primary, success, warning, danger, info
    'trend' => null, // positive, negative, neutral
    'trendValue' => null,
    'trendLabel' => '',
    'loading' => false,
    'class' => ''
]); ?>
<?php foreach (array_filter(([
    'title' => '',
    'value' => 0,
    'subtitle' => '',
    'icon' => 'fas fa-chart-line',
    'variant' => 'primary', // primary, success, warning, danger, info
    'trend' => null, // positive, negative, neutral
    'trendValue' => null,
    'trendLabel' => '',
    'loading' => false,
    'class' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $variantConfig = [
        'primary' => [
            'bg' => 'bg-primary',
            'text' => 'text-primary',
            'border' => 'border-primary',
            'iconBg' => 'bg-primary'
        ],
        'success' => [
            'bg' => 'bg-success',
            'text' => 'text-success',
            'border' => 'border-success',
            'iconBg' => 'bg-success'
        ],
        'warning' => [
            'bg' => 'bg-warning',
            'text' => 'text-warning',
            'border' => 'border-warning',
            'iconBg' => 'bg-warning'
        ],
        'danger' => [
            'bg' => 'bg-danger',
            'text' => 'text-danger',
            'border' => 'border-danger',
            'iconBg' => 'bg-danger'
        ],
        'info' => [
            'bg' => 'bg-info',
            'text' => 'text-info',
            'border' => 'border-info',
            'iconBg' => 'bg-info'
        ]
    ];
    
    $config = $variantConfig[$variant] ?? $variantConfig['primary'];
    
    $trendConfig = [
        'positive' => ['icon' => 'fas fa-arrow-up', 'class' => 'text-success'],
        'negative' => ['icon' => 'fas fa-arrow-down', 'class' => 'text-danger'],
        'neutral' => ['icon' => 'fas fa-minus', 'class' => 'text-muted']
    ];
    
    $trendInfo = $trend ? ($trendConfig[$trend] ?? $trendConfig['neutral']) : null;
?>

<div <?php echo e($attributes->merge(['class' => 'metric-card ' . $class])); ?>>
    <div class="d-flex align-items-center justify-content-between">
        <div class="flex-grow-1">
            <div class="d-flex align-items-center mb-2">
                <div class="<?php echo e($config['iconBg']); ?> rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                    <i class="<?php echo e($icon); ?> text-white"></i>
                </div>
                <div>
                    <h6 class="mb-0 text-muted"><?php echo e($title); ?></h6>
                    <?php if($subtitle): ?>
                        <small class="text-muted"><?php echo e($subtitle); ?></small>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="d-flex align-items-end">
                <h3 class="mb-0 me-2 <?php echo e($loading ? 'placeholder-glow' : ''); ?>">
                    <?php if($loading): ?>
                        <span class="placeholder col-4"></span>
                    <?php else: ?>
                        <?php echo e(number_format($value)); ?>

                    <?php endif; ?>
                </h3>
                
                <?php if($trend && $trendValue): ?>
                    <div class="d-flex align-items-center">
                        <i class="<?php echo e($trendInfo['icon']); ?> me-1 <?php echo e($trendInfo['class']); ?>"></i>
                        <small class="<?php echo e($trendInfo['class']); ?>">
                            <?php echo e($trendValue); ?>%
                        </small>
                        <?php if($trendLabel): ?>
                            <small class="text-muted ms-1"><?php echo e($trendLabel); ?></small>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if($loading): ?>
            <div class="spinner-border spinner-border-sm text-muted" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
        <?php endif; ?>
    </div>
</div> <?php /**PATH C:\Users\Kunga\Documents\GitHub\laravel-com-bootstrap\resources\views/components/admin/metric-card.blade.php ENDPATH**/ ?>