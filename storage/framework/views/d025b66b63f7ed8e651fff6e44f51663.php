<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'type' => 'info', // success, warning, danger, info
    'title' => null,
    'dismissible' => true,
    'icon' => null,
    'class' => ''
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'type' => 'info', // success, warning, danger, info
    'title' => null,
    'dismissible' => true,
    'icon' => null,
    'class' => ''
]); ?>
<?php foreach (array_filter(([
    'type' => 'info', // success, warning, danger, info
    'title' => null,
    'dismissible' => true,
    'icon' => null,
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
    $alertConfig = [
        'success' => [
            'class' => 'alert-success',
            'icon' => 'fas fa-check-circle',
            'title' => 'Sucesso!'
        ],
        'warning' => [
            'class' => 'alert-warning',
            'icon' => 'fas fa-exclamation-triangle',
            'title' => 'Atenção!'
        ],
        'danger' => [
            'class' => 'alert-danger',
            'icon' => 'fas fa-exclamation-circle',
            'title' => 'Erro!'
        ],
        'info' => [
            'class' => 'alert-info',
            'icon' => 'fas fa-info-circle',
            'title' => 'Informação'
        ]
    ];
    
    $config = $alertConfig[$type] ?? $alertConfig['info'];
    $alertClass = 'alert ' . $config['class'];
    $alertClass .= $dismissible ? ' alert-dismissible fade show' : '';
    $alertClass .= $class ? ' ' . $class : '';
    
    $icon = $icon ?? $config['icon'];
    $title = $title ?? $config['title'];
?>

<div <?php echo e($attributes->merge(['class' => $alertClass, 'role' => 'alert'])); ?>>
    <div class="d-flex align-items-start">
        <i class="<?php echo e($icon); ?> me-2 mt-1"></i>
        <div class="flex-grow-1">
            <?php if($title): ?>
                <strong><?php echo e($title); ?></strong>
                <?php if($slot->isNotEmpty()): ?>
                    <br>
                <?php endif; ?>
            <?php endif; ?>
            <?php echo e($slot); ?>

        </div>
    </div>
    
    <?php if($dismissible): ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    <?php endif; ?>
</div> <?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/components/admin/alert.blade.php ENDPATH**/ ?>