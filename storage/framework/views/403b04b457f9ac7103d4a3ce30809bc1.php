

<?php $__env->startSection('title', 'Meu Perfil - Sistema de Denúncias'); ?>

<?php $__env->startSection('page-title', 'Meu Perfil'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard.index')); ?>">Dashboard</a></li>
<li class="breadcrumb-item active">Meu Perfil</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-edit"></i> Informações do Perfil
                </h5>
            </div>
            <div class="card-body">
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('users.atualizar-perfil')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nome *</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">Alterar Senha (opcional)</h6>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="password_atual" class="form-label">Senha Atual</label>
                            <input type="password" class="form-control <?php $__errorArgs = ['password_atual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="password_atual" name="password_atual">
                            <?php $__errorArgs = ['password_atual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="password" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="password" name="password" minlength="8">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" minlength="8">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Atualizar Perfil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle"></i> Informações da Conta
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="avatar-lg mx-auto mb-3">
                        <div class="avatar-title bg-<?php echo e($user->role_cor); ?> rounded-circle" style="width: 80px; height: 80px; font-size: 2rem;">
                            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                        </div>
                    </div>
                    <h5><?php echo e($user->name); ?></h5>
                    <p class="text-muted"><?php echo e($user->email); ?></p>
                </div>

                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-primary"><?php echo e($user->denuncias_responsavel_count ?? 0); ?></h4>
                            <small class="text-muted">Denúncias</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success"><?php echo e($user->denuncias_pendentes_count ?? 0); ?></h4>
                        <small class="text-muted">Pendentes</small>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <strong>Função:</strong>
                    <span class="badge bg-<?php echo e($user->role_cor); ?>"><?php echo e($user->role_label); ?></span>
                </div>

                <div class="mb-3">
                    <strong>Status:</strong>
                    <?php if($user->ativo): ?>
                        <span class="badge bg-success">Ativo</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Inativo</span>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <strong>Membro desde:</strong>
                    <br>
                    <small class="text-muted"><?php echo e($user->created_at->format('d/m/Y')); ?></small>
                </div>

                <?php if($user->last_login_at): ?>
                <div class="mb-3">
                    <strong>Último acesso:</strong>
                    <br>
                    <small class="text-muted"><?php echo e($user->last_login_at->format('d/m/Y H:i')); ?></small>
                </div>
                <?php endif; ?>

                <div class="mb-3">
                    <strong>Permissões:</strong>
                    <ul class="list-unstyled mt-2">
                        <?php if($user->podeGerenciarDenuncias()): ?>
                            <li><i class="fas fa-check text-success"></i> Gerenciar Denúncias</li>
                        <?php endif; ?>
                        <?php if($user->podeVerTodasDenuncias()): ?>
                            <li><i class="fas fa-check text-success"></i> Ver Todas Denúncias</li>
                        <?php endif; ?>
                        <?php if($user->podeGerenciarUsuarios()): ?>
                            <li><i class="fas fa-check text-success"></i> Gerenciar Usuários</li>
                        <?php endif; ?>
                        <?php if($user->podeGerenciarCategorias()): ?>
                            <li><i class="fas fa-check text-success"></i> Gerenciar Categorias</li>
                        <?php endif; ?>
                        <?php if($user->podeVerRelatorios()): ?>
                            <li><i class="fas fa-check text-success"></i> Ver Relatórios</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/users/perfil.blade.php ENDPATH**/ ?>