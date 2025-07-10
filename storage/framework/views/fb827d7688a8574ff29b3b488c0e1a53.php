

<?php $__env->startSection('title', 'Permissões do Sistema'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-key"></i> Permissões do Sistema
                    </h3>
                    <a href="<?php echo e(route('permissions.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nova Permissão
                    </a>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover datatable">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Slug</th>
                                    <th>Descrição</th>
                                    <th>Categoria</th>
                                    <th>Grupo</th>
                                    <th>Ativa</th>
                                    <th>Ordem</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($permission->id); ?></td>
                                        <td><?php echo e($permission->name); ?></td>
                                        <td><span class="badge bg-secondary"><?php echo e($permission->slug); ?></span></td>
                                        <td><?php echo e($permission->description); ?></td>
                                        <td><?php echo e(ucfirst($permission->category)); ?></td>
                                        <td><?php echo e(ucfirst($permission->group)); ?></td>
                                        <td>
                                            <?php if($permission->active): ?>
                                                <span class="badge bg-success">Sim</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Não</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($permission->order); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('permissions.edit', $permission)); ?>" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-edit"></i></a>
                                            <form action="<?php echo e(route('permissions.destroy', $permission)); ?>" method="POST" class="d-inline-block" onsubmit="return confirm('Tem certeza que deseja remover esta permissão?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" title="Remover"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">Nenhuma permissão cadastrada.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/permissions/index.blade.php ENDPATH**/ ?>