<?php $__env->startSection('title', 'Permissões de ' . $user->name); ?>
<?php $__env->startSection('page-title', 'Permissões de Usuário'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .permission-group {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        margin-bottom: 1rem;
        overflow: hidden;
    }
    .permission-group-header {
        background-color: #f8f9fa;
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid #dee2e6;
        cursor: pointer;
    }
    .permission-group-body {
        padding: 1rem;
    }
    .permission-item {
        padding: 0.5rem 0;
        border-bottom: 1px dashed #eee;
    }
    .permission-item:last-child {
        border-bottom: none;
    }
    .nav-tabs .nav-link {
        font-weight: 500;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php if (isset($component)) { $__componentOriginaldbbc880c47f621cda59b70d6eb356b2f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldbbc880c47f621cda59b70d6eb356b2f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.breadcrumb','data' => ['items' => [
        ['title' => 'Usuários', 'url' => route('users.index'), 'icon' => 'fas fa-users'],
        ['title' => 'Permissões', 'icon' => 'fas fa-key']
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['title' => 'Usuários', 'url' => route('users.index'), 'icon' => 'fas fa-users'],
        ['title' => 'Permissões', 'icon' => 'fas fa-key']
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
    <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['title' => 'Permissões de '.e($user->name).'','subtitle' => 'Gerencie as permissões deste usuário']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Permissões de '.e($user->name).'','subtitle' => 'Gerencie as permissões deste usuário']); ?>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="badge bg-<?php echo e($user->role_cor); ?> me-2"><?php echo e($user->role_label); ?></span>
                <span class="text-muted"><?php echo e($user->email); ?></span>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary" id="selectAll">
                    <i class="fas fa-check-double me-1"></i>Selecionar Tudo
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAll">
                    <i class="fas fa-times me-1"></i>Desmarcar Tudo
                </button>
            </div>
        </div>

        <?php if(session('success')): ?>
            <?php if (isset($component)) { $__componentOriginald888329b8246e32afd68d2decbd25cf1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald888329b8246e32afd68d2decbd25cf1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.alert','data' => ['type' => 'success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success']); ?><?php echo e(session('success')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald888329b8246e32afd68d2decbd25cf1)): ?>
<?php $attributes = $__attributesOriginald888329b8246e32afd68d2decbd25cf1; ?>
<?php unset($__attributesOriginald888329b8246e32afd68d2decbd25cf1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald888329b8246e32afd68d2decbd25cf1)): ?>
<?php $component = $__componentOriginald888329b8246e32afd68d2decbd25cf1; ?>
<?php unset($__componentOriginald888329b8246e32afd68d2decbd25cf1); ?>
<?php endif; ?>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <?php if (isset($component)) { $__componentOriginald888329b8246e32afd68d2decbd25cf1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald888329b8246e32afd68d2decbd25cf1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.alert','data' => ['type' => 'danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'danger']); ?><?php echo e(session('error')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald888329b8246e32afd68d2decbd25cf1)): ?>
<?php $attributes = $__attributesOriginald888329b8246e32afd68d2decbd25cf1; ?>
<?php unset($__attributesOriginald888329b8246e32afd68d2decbd25cf1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald888329b8246e32afd68d2decbd25cf1)): ?>
<?php $component = $__componentOriginald888329b8246e32afd68d2decbd25cf1; ?>
<?php unset($__componentOriginald888329b8246e32afd68d2decbd25cf1); ?>
<?php endif; ?>
        <?php endif; ?>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar permissões...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" id="categoryFilter">
                            <option value="">Todas as categorias</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category); ?>"><?php echo e(ucfirst($category)); ?> (<?php echo e($count); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <form action="<?php echo e(route('users.permissions.update', $user)); ?>" method="POST" id="permissionsForm">
            <?php echo csrf_field(); ?>
            
            <ul class="nav nav-tabs mb-3" id="permissionTabs" role="tablist">
                <?php $__currentLoopData = $groupedPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $groups): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo e($loop->first ? 'active' : ''); ?>" 
                                id="tab-<?php echo e(Str::slug($category)); ?>" 
                                data-bs-toggle="tab" 
                                data-bs-target="#<?php echo e(Str::slug($category)); ?>" 
                                type="button" 
                                role="tab">
                            <?php echo e(ucfirst($category)); ?>

                            <span class="badge bg-secondary ms-1"><?php echo e(count($groups)); ?></span>
                        </button>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <div class="tab-content" id="permissionTabsContent">
                <?php $__currentLoopData = $groupedPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $groups): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="tab-pane fade <?php echo e($loop->first ? 'show active' : ''); ?>" 
                         id="<?php echo e(Str::slug($category)); ?>" 
                         role="tabpanel" 
                         aria-labelledby="tab-<?php echo e(Str::slug($category)); ?>">
                        
                        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $permissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="permission-group mb-4">
                                <div class="permission-group-header d-flex justify-content-between align-items-center" 
                                     data-bs-toggle="collapse" 
                                     href="#group-<?php echo e(Str::slug($category)); ?>-<?php echo e(Str::slug($group)); ?>">
                                    <h6 class="mb-0">
                                        <i class="fas fa-folder-open me-2"></i>
                                        <?php echo e($group ?: 'Geral'); ?>

                                        <span class="badge bg-primary ms-2"><?php echo e(count($permissions)); ?></span>
                                    </h6>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="permission-group-body collapse show" id="group-<?php echo e(Str::slug($category)); ?>-<?php echo e(Str::slug($group)); ?>">
                                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="permission-item d-flex align-items-center">
                                            <div class="form-check form-switch flex-grow-1">
                                                <input class="form-check-input permission-checkbox" 
                                                       type="checkbox" 
                                                       name="permissions[]" 
                                                       value="<?php echo e($permission->id); ?>" 
                                                       id="perm_<?php echo e($permission->id); ?>"
                                                       data-category="<?php echo e($permission->category); ?>"
                                                       <?php echo e(in_array($permission->id, $userPermissions) ? 'checked' : ''); ?>>
                                                <label class="form-check-label ms-3" for="perm_<?php echo e($permission->id); ?>">
                                                    <div class="d-flex flex-column">
                                                        <strong class="permission-name"><?php echo e($permission->name); ?></strong>
                                                        <small class="text-muted permission-description"><?php echo e($permission->description); ?></small>
                                                        <small class="text-primary"><?php echo e($permission->slug); ?></small>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar
                </a>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary" id="resetForm">
                        <i class="fas fa-undo me-2"></i>Reverter
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Salvar Permissões
                    </button>
                </div>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtro de busca
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const checkboxes = document.querySelectorAll('.permission-checkbox');
    
    // Função para filtrar permissões
    function filterPermissions() {
        const searchTerm = searchInput.value.toLowerCase();
        const category = categoryFilter.value;
        
        checkboxes.forEach(checkbox => {
            const permissionItem = checkbox.closest('.permission-item');
            const permissionName = checkbox.nextElementSibling.querySelector('.permission-name').textContent.toLowerCase();
            const permissionDesc = checkbox.nextElementSibling.querySelector('.permission-description').textContent.toLowerCase();
            const permissionCategory = checkbox.dataset.category;
            
            const matchesSearch = permissionName.includes(searchTerm) || permissionDesc.includes(searchTerm);
            const matchesCategory = !category || permissionCategory === category;
            
            if (matchesSearch && matchesCategory) {
                permissionItem.style.display = 'flex';
                // Mostrar o grupo pai se algum item for exibido
                permissionItem.closest('.permission-group-body').style.display = 'block';
                permissionItem.closest('.permission-group').style.display = 'block';
            } else {
                permissionItem.style.display = 'none';
                // Verificar se ainda há itens visíveis no grupo
                const group = permissionItem.closest('.permission-group-body');
                if (group) {
                    const visibleItems = group.querySelectorAll('.permission-item[style!="display: none;"]');
                    if (visibleItems.length === 0) {
                        group.style.display = 'none';
                        group.previousElementSibling.style.display = 'none';
                    }
                }
            }
        });
    }
    
    // Event listeners
    searchInput.addEventListener('input', filterPermissions);
    categoryFilter.addEventListener('change', filterPermissions);
    
    // Selecionar/desmarcar tudo
    document.getElementById('selectAll').addEventListener('click', function() {
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.checked = true;
        });
    });
    
    document.getElementById('deselectAll').addEventListener('click', function() {
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
    });
    
    // Reverter alterações
    document.getElementById('resetForm').addEventListener('click', function() {
        if (confirm('Tem certeza que deseja descartar todas as alterações feitas?')) {
            window.location.reload();
        }
    });
    
    // Atualizar contagem de selecionados
    function updateSelectedCount() {
        const selected = document.querySelectorAll('.permission-checkbox:checked').length;
        const total = checkboxes.length;
        document.getElementById('selectedCount').textContent = `${selected} de ${total} selecionadas`;
    }
    
    // Atualizar contagem quando as caixas de seleção forem alteradas
    document.getElementById('permissionsForm').addEventListener('change', updateSelectedCount);
    updateSelectedCount();
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/users/permissions.blade.php ENDPATH**/ ?>