<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['status' => '', 'class' => '']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['status' => '', 'class' => '']); ?>
<?php foreach (array_filter((['status' => '', 'class' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $statusConfig = [
        'Recebida' => [
            'class' => 'status-badge recebida',
            'icon' => 'fas fa-inbox'
        ],
        'Em Análise' => [
            'class' => 'status-badge em-analise',
            'icon' => 'fas fa-search'
        ],
        'Resolvida' => [
            'class' => 'status-badge resolvida',
            'icon' => 'fas fa-check'
        ],
        'Arquivada' => [
            'class' => 'status-badge arquivada',
            'icon' => 'fas fa-archive'
        ],
        'Urgente' => [
            'class' => 'status-badge urgente',
            'icon' => 'fas fa-exclamation-triangle'
        ],
        'Alta' => [
            'class' => 'status-badge urgente',
            'icon' => 'fas fa-exclamation-circle'
        ],
        'Média' => [
            'class' => 'status-badge em-analise',
            'icon' => 'fas fa-minus-circle'
        ],
        'Baixa' => [
            'class' => 'status-badge recebida',
            'icon' => 'fas fa-arrow-down'
        ]
    ];
    
    $config = $statusConfig[$status] ?? [
        'class' => 'status-badge recebida',
        'icon' => 'fas fa-circle'
    ];
?>

<span <?php echo e($attributes->merge(['class' => $config['class'] . ' ' . $class])); ?>>
    <i class="<?php echo e($config['icon']); ?> me-1"></i>
    <?php echo e($status); ?>

</span> <?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/components/admin/status-badge.blade.php ENDPATH**/ ?>