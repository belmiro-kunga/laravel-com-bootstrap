<?php $__env->startSection('title', 'Detalhes do Log de Auditoria'); ?>

<?php $__env->startSection('page-title', 'Detalhes do Log'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php if (isset($component)) { $__componentOriginaldbbc880c47f621cda59b70d6eb356b2f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldbbc880c47f621cda59b70d6eb356b2f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.breadcrumb','data' => ['items' => [
        ['title' => 'Auditoria', 'url' => route('audit.index'), 'icon' => 'fas fa-shield-alt'],
        ['title' => 'Detalhes do Log', 'icon' => 'fas fa-eye']
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['title' => 'Auditoria', 'url' => route('audit.index'), 'icon' => 'fas fa-shield-alt'],
        ['title' => 'Detalhes do Log', 'icon' => 'fas fa-eye']
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
    <div class="row">
        <div class="col-12">
            <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0"><i class="fas fa-eye"></i> Detalhes do Log #<?php echo e($auditLog->id); ?></h4>
                    <a href="<?php echo e(route('audit.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>

                <dl class="row">
                    <dt class="col-sm-4">Usuário:</dt>
                    <dd class="col-sm-8"><?php echo e($auditLog->user ? $auditLog->user->name : 'Sistema'); ?></dd>

                    <dt class="col-sm-4">Ação:</dt>
                    <dd class="col-sm-8"><?php echo e($auditLog->action); ?></dd>

                    <dt class="col-sm-4">Descrição:</dt>
                    <dd class="col-sm-8"><?php echo e($auditLog->description); ?></dd>

                    <dt class="col-sm-4">Endereço IP:</dt>
                    <dd class="col-sm-8"><?php echo e($auditLog->ip_address); ?></dd>

                    <dt class="col-sm-4">Data/Hora:</dt>
                    <dd class="col-sm-8"><?php echo e($auditLog->created_at->format('d/m/Y H:i:s')); ?></dd>

                    <?php if($auditLog->old_values): ?>
                    <dt class="col-sm-4">Valores Anteriores:</dt>
                    <dd class="col-sm-8">
                        <pre class="bg-light p-2 rounded"><?php echo e(json_encode(\App\Helpers\AuditHelper::filterSensitiveFields($auditLog->old_values), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                    </dd>
                    <?php endif; ?>

                    <?php if($auditLog->new_values): ?>
                    <dt class="col-sm-4">Valores Novos:</dt>
                    <dd class="col-sm-8">
                        <pre class="bg-light p-2 rounded"><?php echo e(json_encode(\App\Helpers\AuditHelper::filterSensitiveFields($auditLog->new_values), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                    </dd>
                    <?php endif; ?>
                </dl>
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
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/audit/show.blade.php ENDPATH**/ ?>