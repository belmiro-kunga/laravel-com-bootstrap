<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'title' => '',
    'subtitle' => '',
    'icon' => null,
    'variant' => 'default',
    'collapsible' => false,
    'collapsed' => false,
    'refreshable' => false,
    'loading' => false,
    'class' => '',
    'header' => null,
    'footer' => null
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'title' => '',
    'subtitle' => '',
    'icon' => null,
    'variant' => 'default',
    'collapsible' => false,
    'collapsed' => false,
    'refreshable' => false,
    'loading' => false,
    'class' => '',
    'header' => null,
    'footer' => null
]); ?>
<?php foreach (array_filter(([
    'title' => '',
    'subtitle' => '',
    'icon' => null,
    'variant' => 'default',
    'collapsible' => false,
    'collapsed' => false,
    'refreshable' => false,
    'loading' => false,
    'class' => '',
    'header' => null,
    'footer' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $widgetId = 'widget-' . uniqid();
    $variantClasses = [
        'default' => '',
        'primary' => 'border-primary',
        'success' => 'border-success',
        'warning' => 'border-warning',
        'danger' => 'border-danger',
        'info' => 'border-info'
    ];
    
    $widgetClass = 'widget ' . ($variantClasses[$variant] ?? '') . ' ' . $class;
?>

<div <?php echo e($attributes->merge(['class' => $widgetClass, 'id' => $widgetId])); ?>>
    <?php if($header): ?>
        <div class="widget-header">
            <?php echo e($header); ?>

        </div>
    <?php elseif($title): ?>
        <div class="widget-header">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <?php if($icon): ?>
                        <i class="<?php echo e($icon); ?> me-2 text-muted"></i>
                    <?php endif; ?>
                    <div>
                        <h6 class="widget-title mb-0"><?php echo e($title); ?></h6>
                        <?php if($subtitle): ?>
                            <small class="text-muted"><?php echo e($subtitle); ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="widget-actions">
                    <?php if($refreshable): ?>
                        <button class="btn btn-sm btn-outline-secondary" onclick="refreshWidget('<?php echo e($widgetId); ?>')" title="Atualizar">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    <?php endif; ?>
                    
                    <?php if($collapsible): ?>
                        <button class="btn btn-sm btn-outline-secondary" onclick="toggleWidget('<?php echo e($widgetId); ?>')" title="<?php echo e($collapsed ? 'Expandir' : 'Recolher'); ?>">
                            <i class="fas fa-<?php echo e($collapsed ? 'expand' : 'compress'); ?>"></i>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="widget-content <?php echo e($collapsed ? 'd-none' : ''); ?>">
        <?php if($loading): ?>
            <div class="d-flex align-items-center justify-content-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
            </div>
        <?php else: ?>
            <?php echo e($slot); ?>

        <?php endif; ?>
    </div>
    
    <?php if($footer): ?>
        <div class="widget-footer">
            <?php echo e($footer); ?>

        </div>
    <?php endif; ?>
</div>

<?php if($collapsible || $refreshable): ?>
    <?php $__env->startPush('scripts'); ?>
    <script>
        function toggleWidget(widgetId) {
            const widget = document.getElementById(widgetId);
            const content = widget.querySelector('.widget-content');
            const button = widget.querySelector('.widget-actions button:last-child i');
            
            if (content.classList.contains('d-none')) {
                content.classList.remove('d-none');
                button.className = 'fas fa-compress';
                button.parentElement.title = 'Recolher';
            } else {
                content.classList.add('d-none');
                button.className = 'fas fa-expand';
                button.parentElement.title = 'Expandir';
            }
        }
        
        function refreshWidget(widgetId) {
            const widget = document.getElementById(widgetId);
            const content = widget.querySelector('.widget-content');
            const button = widget.querySelector('.widget-actions button i.fa-sync-alt');
            
            // Adicionar classe de rotação
            button.classList.add('fa-spin');
            
            // Simular carregamento (substitua por chamada AJAX real)
            setTimeout(() => {
                button.classList.remove('fa-spin');
                // Aqui você pode adicionar lógica para atualizar o conteúdo
            }, 1000);
        }
    </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?> <?php /**PATH C:\Users\Kunga\Documents\GitHub\laravel-com-bootstrap\resources\views/components/admin/widget.blade.php ENDPATH**/ ?>