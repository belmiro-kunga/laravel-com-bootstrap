

<?php $__env->startSection('title', 'Usuários - Sistema de Denúncias'); ?>

<?php $__env->startSection('page-title', 'Gerenciar Usuários'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard.index')); ?>">Dashboard</a></li>
<li class="breadcrumb-item active">Usuários</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['title' => 'Gerenciamento de Usuários','subtitle' => 'Administre os usuários do sistema']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Gerenciamento de Usuários','subtitle' => 'Administre os usuários do sistema']); ?>
        <form method="GET" class="row g-2 mb-3 align-items-end">
            <div class="col-md-3">
                <label for="busca" class="form-label">Buscar</label>
                <input type="text" name="busca" id="busca" class="form-control" value="<?php echo e(request('busca')); ?>" placeholder="Nome, e-mail ou ID">
            </div>
            <div class="col-md-3">
                <label for="role" class="form-label">Papel</label>
                <select name="role" id="role" class="form-select">
                    <option value="">Todos</option>
                    <option value="admin" <?php if(request('role')=='admin'): echo 'selected'; endif; ?>>Administrador</option>
                    <option value="responsavel" <?php if(request('role')=='responsavel'): echo 'selected'; endif; ?>>Responsável</option>
                    <option value="usuario" <?php if(request('role')=='usuario'): echo 'selected'; endif; ?>>Usuário</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="ativo" class="form-label">Status</label>
                <select name="ativo" id="ativo" class="form-select">
                    <option value="">Todos</option>
                    <option value="1" <?php if(request('ativo')==='1'): echo 'selected'; endif; ?>>Ativo</option>
                    <option value="0" <?php if(request('ativo')==='0'): echo 'selected'; endif; ?>>Inativo</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-2"></i>Filtrar
                </button>
            </div>
        </form>

        <form id="mass-action-form" method="POST" action="<?php echo e(route('users.mass-action')); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-2 d-flex align-items-center gap-2">
                <select name="action" class="form-select w-auto" required>
                    <option value="">Ação em massa</option>
                    <option value="ativar">Ativar selecionados</option>
                    <option value="desativar">Desativar selecionados</option>
                    <option value="resetar_senha">Resetar senha dos selecionados</option>
                </select>
                <button type="submit" class="btn btn-outline-primary btn-sm">Aplicar</button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Papel</th>
                            <th>Status</th>
                            <th>Último Login</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><input type="checkbox" name="users[]" value="<?php echo e($user->id); ?>" class="user-checkbox"></td>
                            <td><?php echo e($user->id); ?></td>
                            <td>
                                <strong><?php echo e($user->name); ?></strong>
                                <?php if($user->id === auth()->id()): ?>
                                    <span class="badge bg-info ms-1">Você</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($user->email); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($user->role_cor); ?>"><?php echo e($user->role_label); ?></span>
                            </td>
                            <td>
                                <?php if($user->ativo): ?>
                                    <span class="badge bg-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inativo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($user->last_login_at): ?>
                                    <span title="<?php echo e($user->last_login_at); ?>"><?php echo e($user->last_login_at->diffForHumans()); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">Nunca</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?php echo e(route('users.show', $user)); ?>" class="btn btn-sm btn-outline-primary" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-sm btn-outline-secondary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo e(route('users.permissions', $user)); ?>" class="btn btn-sm btn-outline-warning" title="Permissões">
                                    <i class="fas fa-key"></i>
                                </a>
                                <form action="<?php echo e(route('users.toggle-ativo', $user)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-<?php echo e($user->ativo ? 'danger' : 'success'); ?>" title="<?php echo e($user->ativo ? 'Desativar' : 'Ativar'); ?>">
                                        <i class="fas fa-<?php echo e($user->ativo ? 'user-slash' : 'user-check'); ?>"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">Nenhum usuário encontrado.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </form>
        <div class="mt-3">
            <?php echo e($users->withQueryString()->links()); ?>

        </div>
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

<!-- Modal para Criar/Editar Usuário -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formUsuario" method="POST" action="<?php echo e(route('users.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUsuarioLabel">Novo Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome Completo *</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="name" name="name" required maxlength="255" 
                                       placeholder="Digite o nome completo">
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
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="email" name="email" required maxlength="255"
                                       placeholder="usuario@empresa.com">
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
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Senha *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="password" name="password" required minlength="8"
                                           placeholder="Mínimo 8 caracteres">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="password-icon"></i>
                                    </button>
                                </div>
                                <div class="form-text">
                                    <small>A senha deve ter pelo menos 8 caracteres</small>
                                </div>
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
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Senha *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required minlength="8"
                                           placeholder="Confirme a senha">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye" id="password_confirmation-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role" class="form-label">Função *</label>
                                <select class="form-select <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="role" name="role" required>
                                    <option value="">Selecione uma função</option>
                                    <option value="admin">
                                        <i class="fas fa-user-shield"></i> Administrador
                                    </option>
                                    <option value="responsavel">
                                        <i class="fas fa-user-tie"></i> Responsável
                                    </option>
                                    <option value="usuario">
                                        <i class="fas fa-user"></i> Usuário
                                    </option>
                                </select>
                                <div class="form-text">
                                    <small>A função determina as permissões padrão do usuário</small>
                                </div>
                                <?php $__errorArgs = ['role'];
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" checked>
                                    <label class="form-check-label" for="ativo">
                                        <i class="fas fa-check-circle text-success"></i> Usuário ativo
                                    </label>
                                </div>
                                <div class="form-text">
                                    <small>Usuários inativos não podem fazer login</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Dica:</strong> Após criar o usuário, você pode personalizar suas permissões 
                        clicando no botão <i class="fas fa-key"></i> na listagem.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Salvar Usuário
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Alterar Senha -->
<div class="modal fade" id="modalSenha" tabindex="-1" aria-labelledby="modalSenhaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formSenha" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSenhaLabel">Alterar Senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nova_senha" class="form-label">Nova Senha *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="nova_senha" name="password" required minlength="8">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('nova_senha')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirmar_senha" class="form-label">Confirmar Nova Senha *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmar_senha" name="password_confirmation" required minlength="8">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmar_senha')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key"></i> Alterar Senha
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Função para alternar visibilidade da senha
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon') || field.nextElementSibling.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Função para alterar senha
function alterarSenha(userId, userName) {
    document.getElementById('modalSenhaLabel').textContent = `Alterar Senha - ${userName}`;
    document.getElementById('formSenha').action = `/users/${userId}/alterar-senha`;
    
    // Limpar campos
    document.getElementById('nova_senha').value = '';
    document.getElementById('confirmar_senha').value = '';
    
    new bootstrap.Modal(document.getElementById('modalSenha')).show();
}

// Validação de senha em tempo real
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    
    if (password && confirmPassword) {
        function validatePassword() {
            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('As senhas não coincidem');
            } else {
                confirmPassword.setCustomValidity('');
            }
        }
        
        password.addEventListener('change', validatePassword);
        confirmPassword.addEventListener('keyup', validatePassword);
    }
    
    // Validação de força da senha
    if (password) {
        password.addEventListener('input', function() {
            const strength = checkPasswordStrength(this.value);
            updatePasswordStrengthIndicator(strength);
        });
    }
});

// Verificar força da senha
function checkPasswordStrength(password) {
    let score = 0;
    
    if (password.length >= 8) score++;
    if (/[a-z]/.test(password)) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;
    
    if (score < 2) return 'weak';
    if (score < 4) return 'medium';
    return 'strong';
}

// Atualizar indicador de força da senha
function updatePasswordStrengthIndicator(strength) {
    const passwordField = document.getElementById('password');
    const feedback = passwordField.parentNode.querySelector('.form-text');
    
    if (!feedback) return;
    
    const strengthText = {
        'weak': '<span class="text-danger"><i class="fas fa-times-circle"></i> Senha fraca</span>',
        'medium': '<span class="text-warning"><i class="fas fa-exclamation-circle"></i> Senha média</span>',
        'strong': '<span class="text-success"><i class="fas fa-check-circle"></i> Senha forte</span>'
    };
    
    feedback.innerHTML = strengthText[strength] || '';
}

// Resetar formulário quando modal for fechado
document.getElementById('modalUsuario').addEventListener('hidden.bs.modal', function () {
    const form = document.getElementById('formUsuario');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    
    // Resetar formulário
    form.reset();
    form.action = '<?php echo e(route("users.store")); ?>';
    
    // Remover método PUT se existir
    const methodInput = document.querySelector('input[name="_method"]');
    if (methodInput) {
        methodInput.remove();
    }
    
    // Resetar campos de senha
    if (password) {
        password.required = true;
        password.type = 'password';
    }
    if (confirmPassword) {
        confirmPassword.required = true;
        confirmPassword.type = 'password';
    }
    
    // Atualizar título
    document.getElementById('modalUsuarioLabel').textContent = 'Novo Usuário';
    
    // Limpar validações
    form.querySelectorAll('.is-invalid').forEach(element => {
        element.classList.remove('is-invalid');
    });
});

// Confirmação para ações destrutivas
document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('form[action*="/destroy"]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.')) {
                e.preventDefault();
            }
        });
    });
    
    const toggleForms = document.querySelectorAll('form[action*="/toggle-ativo"]');
    toggleForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const button = form.querySelector('button[type="submit"]');
            const isActive = button.classList.contains('btn-outline-warning');
            const action = isActive ? 'desativar' : 'ativar';
            
            if (!confirm(`Tem certeza que deseja ${action} este usuário?`)) {
                e.preventDefault();
            }
        });
    });
});

// Auto-submit para filtros
document.addEventListener('DOMContentLoaded', function() {
    const autoSubmitSelects = document.querySelectorAll('select[name="role"], select[name="status"], select[name="per_page"]');
    autoSubmitSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
});

document.getElementById('select-all').addEventListener('change', function() {
    document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = this.checked);
});
</script>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/users/index.blade.php ENDPATH**/ ?>