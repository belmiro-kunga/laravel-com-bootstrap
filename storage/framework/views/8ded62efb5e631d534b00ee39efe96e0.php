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
<div class="breadcrumb-container mb-4">
    <nav aria-label="breadcrumb" class="bg-white rounded-3 shadow-sm py-2 px-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="<?php echo e(route('dashboard.index')); ?>" class="text-decoration-none d-flex align-items-center">
                    <i class="fas fa-home me-1"></i>
                    <span class="d-none d-sm-inline">Dashboard</span>
                </a>
            </li>
            
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($index === count($items) - 1): ?>
                    <li class="breadcrumb-item active d-flex align-items-center" aria-current="page">
                        <?php if(isset($item['icon'])): ?>
                            <i class="<?php echo e($item['icon']); ?> me-1"></i>
                        <?php endif; ?>
                        <span><?php echo e($item['title']); ?></span>
                    </li>
                <?php else: ?>
                    <li class="breadcrumb-item d-flex align-items-center">
                        <?php if(isset($item['url'])): ?>
                            <a href="<?php echo e($item['url']); ?>" class="text-decoration-none d-flex align-items-center">
                                <?php if(isset($item['icon'])): ?>
                                    <i class="<?php echo e($item['icon']); ?> me-1"></i>
                                <?php endif; ?>
                                <span><?php echo e($item['title']); ?></span>
                            </a>
                        <?php else: ?>
                            <?php if(isset($item['icon'])): ?>
                                <i class="<?php echo e($item['icon']); ?> me-1"></i>
                            <?php endif; ?>
                            <span><?php echo e($item['title']); ?></span>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ol>
    </nav>
</div>

<style>
.breadcrumb {
    --bs-breadcrumb-padding-y: 0.5rem;
    --bs-breadcrumb-padding-x: 0;
    --bs-breadcrumb-margin-bottom: 0;
    --bs-breadcrumb-bg: transparent;
    --bs-breadcrumb-border-radius: 0;
    --bs-breadcrumb-divider-color: #6c757d;
    --bs-breadcrumb-item-padding-x: 0.5rem;
    --bs-breadcrumb-item-active-color: #6c757d;
    font-size: 0.875rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: var(--bs-breadcrumb-divider, ">");
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    opacity: 0.6;
}

.breadcrumb-item a {
    color: var(--bs-primary);
    transition: color 0.2s ease-in-out;
}

.breadcrumb-item a:hover {
    color: var(--bs-primary-dark);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: var(--bs-gray-700);
    font-weight: 500;
}

.breadcrumb-container {
    margin-top: 1rem;
    margin-left: -0.75rem;
    margin-right: -0.75rem;
}

@media (max-width: 767.98px) {
    .breadcrumb {
        white-space: nowrap;
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 0.5rem;
    }
    
    .breadcrumb::-webkit-scrollbar {
        height: 4px;
    }
    
    .breadcrumb::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.1);
        border-radius: 2px;
    }
}
</style>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/components/admin/breadcrumb.blade.php ENDPATH**/ ?>