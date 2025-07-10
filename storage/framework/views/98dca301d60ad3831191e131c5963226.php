

<?php $__env->startSection('page-title', 'Detalhes do Usuário - ' . $user->name); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('users.index')); ?>">Usuários</a></li>
<li class="breadcrumb-item active"><?php echo e($user->name); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user"></i>
                        Informações do Usuário
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nome:</strong> <?php echo e($user->name); ?></p>
                            <p><strong>Email:</strong> <?php echo e($user->email); ?></p>
                            <p><strong>Função:</strong> 
                                <span class="badge bg-<?php echo e($user->role_cor); ?>"><?php echo e($user->role_label); ?></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong> 
                                <?php if($user->ativo): ?>
                                    <span class="badge bg-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inativo</span>
                                <?php endif; ?>
                            </p>
                            <p><strong>Data de Criação:</strong> <?php echo e($user->created_at->format('d/m/Y H:i')); ?></p>
                            <p><strong>Último Login:</strong> 
                                <?php if($user->last_login_at): ?>
                                    <?php echo e($user->last_login_at->format('d/m/Y H:i')); ?>

                                <?php else: ?>
                                    <span class="text-muted">Nunca</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Denúncias como Responsável -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle"></i>
                        Denúncias como Responsável
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($user->denunciasResponsavel->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Protocolo</th>
                                        <th>Título</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $user->denunciasResponsavel->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $denuncia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($denuncia->protocolo); ?></td>
                                        <td><?php echo e(Str::limit($denuncia->titulo, 40)); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo e($denuncia->status->cor); ?>">
                                                <?php echo e($denuncia->status->nome); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($denuncia->created_at->format('d/m/Y')); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if($user->denunciasResponsavel->count() > 5): ?>
                            <p class="text-muted small">
                                Mostrando 5 de <?php echo e($user->denunciasResponsavel->count()); ?> denúncias
                            </p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-muted">Nenhuma denúncia atribuída como responsável.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Ações -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs"></i>
                        Ações
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <?php if(Auth::user()->hasPermission('usuarios.edit')): ?>
                        <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Editar Usuário
                        </a>
                        <?php endif; ?>
                        
                        <?php if(Auth::user()->hasPermission('usuarios.manage_permissions')): ?>
                            <a href="<?php echo e(route('users.permissions', $user)); ?>" class="btn btn-info">
                                <i class="fas fa-key"></i> Gerenciar Permissões
                            </a>
                        <?php endif; ?>
                        
                        <?php if($user->id !== Auth::id()): ?>
                            <form action="<?php echo e(route('users.toggle-ativo', $user)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-<?php echo e($user->ativo ? 'warning' : 'success'); ?> w-100">
                                    <i class="fas fa-<?php echo e($user->ativo ? 'ban' : 'check'); ?>"></i>
                                    <?php echo e($user->ativo ? 'Desativar' : 'Ativar'); ?> Usuário
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Estatísticas -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar"></i>
                        Estatísticas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-primary"><?php echo e($user->denuncias_responsavel_count); ?></h4>
                            <small class="text-muted">Denúncias</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning"><?php echo e($user->denuncias_pendentes_count); ?></h4>
                            <small class="text-muted">Pendentes</small>
                        </div>
                    </div>
                    <div class="row text-center mt-3">
                        <div class="col-6">
                            <h4 class="text-danger"><?php echo e($user->denuncias_atrasadas_count); ?></h4>
                            <small class="text-muted">Atrasadas</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success"><?php echo e($user->comentarios->count()); ?></h4>
                            <small class="text-muted">Comentários</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissões Ativas -->
            <?php if(Auth::user()->hasPermission('usuarios.manage_permissions')): ?>
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-key"></i>
                        Permissões Ativas
                    </h5>
                </div>
                <div class="card-body">
                    <?php
                        $grantedPermissions = $user->getGrantedPermissions();
                    ?>
                    
                    <?php if($grantedPermissions->count() > 0): ?>
                        <div class="mb-2">
                            <?php $__currentLoopData = $grantedPermissions->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge bg-success mb-1"><?php echo e($permission->name); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($grantedPermissions->count() > 3): ?>
                                <span class="badge bg-secondary">+<?php echo e($grantedPermissions->count() - 3); ?> mais</span>
                            <?php endif; ?>
                        </div>
                        <a href="<?php echo e(route('users.permissions', $user)); ?>" class="btn btn-sm btn-outline-info">
                            Ver Todas
                        </a>
                    <?php else: ?>
                        <p class="text-muted small">Nenhuma permissão personalizada concedida.</p>
                        <a href="<?php echo e(route('users.permissions', $user)); ?>" class="btn btn-sm btn-outline-primary">
                            Conceder Permissões
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/users/show.blade.php ENDPATH**/ ?>