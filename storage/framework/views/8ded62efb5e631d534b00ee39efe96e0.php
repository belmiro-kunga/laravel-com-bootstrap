<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['items' => []]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['items' => []]); ?>
<?php foreach (array_filter((['items' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php if(!empty($items)): ?>
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard.index')); ?>" class="text-decoration-none">
                <i class="fas fa-home"></i>
                <span class="d-none d-sm-inline">Dashboard</span>
            </a>
        </li>
        
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($index === count($items) - 1): ?>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php if(isset($item['icon'])): ?>
                        <i class="<?php echo e($item['icon']); ?>"></i>
                    <?php endif; ?>
                    <?php echo e($item['title']); ?>

                </li>
            <?php else: ?>
                <li class="breadcrumb-item">
                    <?php if(isset($item['url'])): ?>
                        <a href="<?php echo e($item['url']); ?>" class="text-decoration-none">
                            <?php if(isset($item['icon'])): ?>
                                <i class="<?php echo e($item['icon']); ?>"></i>
                            <?php endif; ?>
                            <?php echo e($item['title']); ?>

                        </a>
                    <?php else: ?>
                        <?php if(isset($item['icon'])): ?>
                            <i class="<?php echo e($item['icon']); ?>"></i>
                        <?php endif; ?>
                        <?php echo e($item['title']); ?>

                    <?php endif; ?>
                </li>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>
</nav>
<?php endif; ?> <?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/components/admin/breadcrumb.blade.php ENDPATH**/ ?>