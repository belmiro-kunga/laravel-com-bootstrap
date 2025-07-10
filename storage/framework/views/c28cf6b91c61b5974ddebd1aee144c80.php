<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'variant' => 'default', // default, primary, success, warning, danger, info
    'hover' => true,
    'class' => '',
    'header' => null,
    'footer' => null,
    'bodyClass' => ''
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'variant' => 'default', // default, primary, success, warning, danger, info
    'hover' => true,
    'class' => '',
    'header' => null,
    'footer' => null,
    'bodyClass' => ''
]); ?>
<?php foreach (array_filter(([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'variant' => 'default', // default, primary, success, warning, danger, info
    'hover' => true,
    'class' => '',
    'header' => null,
    'footer' => null,
    'bodyClass' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $cardClasses = 'card';
    $cardClasses .= $hover ? ' card-hover' : '';
    $cardClasses .= $class ? ' ' . $class : '';
    
    $headerClasses = 'card-header';
    $bodyClasses = 'card-body' . ($bodyClass ? ' ' . $bodyClass : '');
    
    $variantClasses = [
        'default' => '',
        'primary' => 'border-primary',
        'success' => 'border-success',
        'warning' => 'border-warning',
        'danger' => 'border-danger',
        'info' => 'border-info'
    ];
    
    $cardClasses .= ' ' . ($variantClasses[$variant] ?? '');
?>

<div <?php echo e($attributes->merge(['class' => $cardClasses])); ?>>
    <?php if($header): ?>
        <div class="<?php echo e($headerClasses); ?>">
            <?php echo e($header); ?>

        </div>
    <?php elseif($title): ?>
        <div class="<?php echo e($headerClasses); ?>">
            <div class="d-flex align-items-center">
                <?php if($icon): ?>
                    <i class="<?php echo e($icon); ?> me-2"></i>
                <?php endif; ?>
                <h5 class="card-title mb-0"><?php echo e($title); ?></h5>
            </div>
            <?php if($subtitle): ?>
                <small class="text-muted"><?php echo e($subtitle); ?></small>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <div class="<?php echo e($bodyClasses); ?>">
        <?php echo e($slot); ?>

    </div>
    
    <?php if($footer): ?>
        <div class="card-footer">
            <?php echo e($footer); ?>

        </div>
    <?php endif; ?>
</div> <?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/components/admin/card.blade.php ENDPATH**/ ?>