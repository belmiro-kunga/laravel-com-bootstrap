

<?php $__env->startSection('title', 'Editar Permissão'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-edit"></i> Editar Permissão</h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('permissions.update', $permission)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?php echo e(old('name', $permission->name)); ?>" required maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" name="slug" id="slug" class="form-control" value="<?php echo e(old('slug', $permission->slug)); ?>" required maxlength="100">
                            <small class="form-text text-muted">Identificador único, ex: <code>denuncias.menu</code></small>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea name="description" id="description" class="form-control" rows="2"><?php echo e(old('description', $permission->description)); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Categoria</label>
                            <select name="category" id="category" class="form-select" required>
                                <option value="menu" <?php echo e(old('category', $permission->category) == 'menu' ? 'selected' : ''); ?>>Menu</option>
                                <option value="function" <?php echo e(old('category', $permission->category) == 'function' ? 'selected' : ''); ?>>Funcionalidade</option>
                                <option value="general" <?php echo e(old('category', $permission->category) == 'general' ? 'selected' : ''); ?>>Geral</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="group" class="form-label">Grupo</label>
                            <input type="text" name="group" id="group" class="form-control" value="<?php echo e(old('group', $permission->group)); ?>" required maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label for="order" class="form-label">Ordem</label>
                            <input type="number" name="order" id="order" class="form-control" value="<?php echo e(old('order', $permission->order)); ?>" min="0">
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="active" name="active" value="1" <?php echo e(old('active', $permission->active) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="active">Ativa</label>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('permissions.index')); ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/permissions/edit.blade.php ENDPATH**/ ?>