@extends('layouts.app')

@section('title', 'Usuários - Sistema de Denúncias')

@section('page-title', 'Gerenciar Usuários')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Usuários</li>
@endsection

@section('content')
<div class="container-fluid">
    <x-admin.card title="Gerenciamento de Usuários" subtitle="Administre os usuários do sistema">
        <form method="GET" class="row g-2 mb-3 align-items-end">
            <div class="col-md-3">
                <label for="busca" class="form-label">Buscar</label>
                <input type="text" name="busca" id="busca" class="form-control" value="{{ request('busca') }}" placeholder="Nome, e-mail ou ID">
            </div>
            <div class="col-md-3">
                <label for="role" class="form-label">Papel</label>
                <select name="role" id="role" class="form-select">
                    <option value="">Todos</option>
                    <option value="admin" @selected(request('role')=='admin')>Administrador</option>
                    <option value="responsavel" @selected(request('role')=='responsavel')>Responsável</option>
                    <option value="usuario" @selected(request('role')=='usuario')>Usuário</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="ativo" class="form-label">Status</label>
                <select name="ativo" id="ativo" class="form-select">
                    <option value="">Todos</option>
                    <option value="1" @selected(request('ativo')==='1')>Ativo</option>
                    <option value="0" @selected(request('ativo')==='0')>Inativo</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-2"></i>Filtrar
                </button>
            </div>
        </form>

        <form id="mass-action-form" method="POST" action="{{ route('users.mass-action') }}">
            @csrf
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
                        @forelse($users as $user)
                        <tr>
                            <td><input type="checkbox" name="users[]" value="{{ $user->id }}" class="user-checkbox"></td>
                            <td>{{ $user->id }}</td>
                            <td>
                                <strong>{{ $user->name }}</strong>
                                @if($user->id === auth()->id())
                                    <span class="badge bg-info ms-1">Você</span>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->role_cor }}">{{ $user->role_label }}</span>
                            </td>
                            <td>
                                @if($user->ativo)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-secondary">Inativo</span>
                                @endif
                            </td>
                            <td>
                                @if($user->last_login_at)
                                    <span title="{{ $user->last_login_at }}">{{ $user->last_login_at->diffForHumans() }}</span>
                                @else
                                    <span class="text-muted">Nunca</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-primary" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-secondary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('users.permissions', $user) }}" class="btn btn-sm btn-outline-warning" title="Permissões">
                                    <i class="fas fa-key"></i>
                                </a>
                                <form action="{{ route('users.toggle-ativo', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-{{ $user->ativo ? 'danger' : 'success' }}" title="{{ $user->ativo ? 'Desativar' : 'Ativar' }}">
                                        <i class="fas fa-{{ $user->ativo ? 'user-slash' : 'user-check' }}"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Nenhum usuário encontrado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
        <div class="mt-3">
            {{ $users->withQueryString()->links() }}
        </div>
    </x-admin.card>
</div>

<!-- Modal para Criar/Editar Usuário -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formUsuario" method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUsuarioLabel">Novo Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome Completo *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" required maxlength="255" 
                                       placeholder="Digite o nome completo">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" required maxlength="255"
                                       placeholder="usuario@empresa.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Senha *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required minlength="8"
                                           placeholder="Mínimo 8 caracteres">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="password-icon"></i>
                                    </button>
                                </div>
                                <div class="form-text">
                                    <small>A senha deve ter pelo menos 8 caracteres</small>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
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
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                @csrf
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
@endsection

@push('scripts')
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
    form.action = '{{ route("users.store") }}';
    
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
@endpush 