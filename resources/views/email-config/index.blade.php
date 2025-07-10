@extends('layouts.app')

@section('title', 'Configuração de Email - Sistema de Denúncias')

@section('page-title', 'Configuração de Email')

@section('breadcrumb')
    <x-admin.breadcrumb :items="[
        ['title' => 'Dashboard', 'url' => route('dashboard.index'), 'icon' => 'fas fa-tachometer-alt'],
        ['title' => 'Configurações', 'icon' => 'fas fa-cog'],
        ['title' => 'Email', 'icon' => 'fas fa-envelope']
    ]" />
@endsection

@section('content')
<div class="container-fluid">
    <!-- Alertas -->
    @if(session('success'))
        <x-admin.alert type="success">
            {{ session('success') }}
        </x-admin.alert>
    @endif
    
    @if(session('error'))
        <x-admin.alert type="danger">
            <div style="white-space: pre-line;">{{ session('error') }}</div>
        </x-admin.alert>
    @endif
    
    @if(session('warning'))
        <x-admin.alert type="warning">
            {{ session('warning') }}
        </x-admin.alert>
    @endif

    <!-- Status da Configuração -->
    <div class="row mb-4">
        <div class="col-12">
            <x-email-config.status-card :config="$config" />
        </div>
    </div>

    <!-- Configurações Populares -->
    <div class="row mb-4">
        <div class="col-12">
            <x-admin.card title="Configurações Populares" subtitle="Clique para aplicar configurações pré-definidas">
                <div class="row g-3">
                    @foreach(['gmail', 'outlook', 'yahoo', 'protonmail'] as $provider)
                        <div class="col-md-3">
                            <x-email-config.provider-card :provider="$provider" :config="$popularConfigs" />
                        </div>
                    @endforeach
                </div>
            </x-admin.card>
        </div>
    </div>

    <!-- Formulário de Configuração -->
    <div class="row mb-4">
        <div class="col-12">
            <x-admin.card title="Configuração Manual" subtitle="Configure manualmente as opções de email">
                <form action="{{ route('email-config.update') }}" method="POST" id="configForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">
                                <i class="fas fa-cogs me-2"></i>Configurações Gerais
                            </h6>
                            
                            <div class="mb-3">
                                <label for="MAIL_MAILER" class="form-label">Driver de Email</label>
                                <select class="form-select" id="MAIL_MAILER" name="MAIL_MAILER" required>
                                    <option value="smtp" {{ $config['MAIL_MAILER'] === 'smtp' ? 'selected' : '' }}>SMTP</option>
                                    <option value="sendmail" {{ $config['MAIL_MAILER'] === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                    <option value="mailgun" {{ $config['MAIL_MAILER'] === 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                    <option value="ses" {{ $config['MAIL_MAILER'] === 'ses' ? 'selected' : '' }}>Amazon SES</option>
                                    <option value="postmark" {{ $config['MAIL_MAILER'] === 'postmark' ? 'selected' : '' }}>Postmark</option>
                                    <option value="log" {{ $config['MAIL_MAILER'] === 'log' ? 'selected' : '' }}>Log (para testes)</option>
                                    <option value="array" {{ $config['MAIL_MAILER'] === 'array' ? 'selected' : '' }}>Array (para testes)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="MAIL_FROM_ADDRESS" class="form-label">Email Remetente</label>
                                <input type="email" class="form-control" id="MAIL_FROM_ADDRESS" name="MAIL_FROM_ADDRESS" 
                                       value="{{ $config['MAIL_FROM_ADDRESS'] }}" required>
                                <div class="form-text">Email que aparecerá como remetente</div>
                            </div>

                            <div class="mb-3">
                                <label for="MAIL_FROM_NAME" class="form-label">Nome Remetente</label>
                                <input type="text" class="form-control" id="MAIL_FROM_NAME" name="MAIL_FROM_NAME" 
                                       value="{{ $config['MAIL_FROM_NAME'] }}" required>
                                <div class="form-text">Nome que aparecerá como remetente</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="mb-3">
                                <i class="fas fa-server me-2"></i>Configurações SMTP
                            </h6>
                            
                            <div class="mb-3">
                                <label for="MAIL_HOST" class="form-label">Host SMTP</label>
                                <input type="text" class="form-control" id="MAIL_HOST" name="MAIL_HOST" 
                                       value="{{ $config['MAIL_HOST'] }}" placeholder="ex: smtp.gmail.com">
                            </div>

                            <div class="mb-3">
                                <label for="MAIL_PORT" class="form-label">Porta SMTP</label>
                                <input type="number" class="form-control" id="MAIL_PORT" name="MAIL_PORT" 
                                       value="{{ $config['MAIL_PORT'] }}" placeholder="587, 465, 25">
                            </div>

                            <div class="mb-3">
                                <label for="MAIL_ENCRYPTION" class="form-label">Criptografia</label>
                                <select class="form-select" id="MAIL_ENCRYPTION" name="MAIL_ENCRYPTION">
                                    <option value="tls" {{ $config['MAIL_ENCRYPTION'] === 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ $config['MAIL_ENCRYPTION'] === 'ssl' ? 'selected' : '' }}>SSL</option>
                                    <option value="" {{ $config['MAIL_ENCRYPTION'] === null ? 'selected' : '' }}>Nenhuma</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="MAIL_USERNAME" class="form-label">Usuário SMTP</label>
                                <input type="text" class="form-control" id="MAIL_USERNAME" name="MAIL_USERNAME" 
                                       value="{{ $config['MAIL_USERNAME'] }}" placeholder="seu@email.com">
                            </div>

                            <div class="mb-3">
                                <label for="MAIL_PASSWORD" class="form-label">Senha SMTP</label>
                                <input type="password" class="form-control" id="MAIL_PASSWORD" name="MAIL_PASSWORD" 
                                       placeholder="Preencha para alterar ou deixar em branco para manter a atual">
                                <div class="form-text">Preencha apenas se quiser alterar a senha SMTP atual. Para Gmail, use uma senha de app se 2FA estiver ativado.</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" id="saveBtn">
                            <i class="fas fa-save me-2"></i>Salvar Configuração
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                            <i class="fas fa-undo me-2"></i>Resetar
                        </button>
                        <button type="button" class="btn btn-outline-info" onclick="validateConfig()">
                            <i class="fas fa-check-circle me-2"></i>Validar
                        </button>
                    </div>
                </form>
            </x-admin.card>
        </div>
    </div>

    <!-- Teste de Email -->
    <div class="row">
        <div class="col-12">
            <x-admin.card title="Teste de Email" subtitle="Envie um email de teste para verificar a configuração">
                <form action="{{ route('email-config.test') }}" method="POST" id="testForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="test_email" class="form-label">Email para Teste</label>
                                <input type="email" class="form-control" id="test_email" name="test_email" 
                                       placeholder="email@exemplo.com" required>
                                <div class="form-text">Digite um email válido para receber o teste</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-success w-100" id="testBtn">
                                    <i class="fas fa-paper-plane me-2"></i>Enviar Teste
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </x-admin.card>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Configurações pré-definidas
const configs = @json($popularConfigs);

// Loading states
document.addEventListener('DOMContentLoaded', function() {
    // Form de configuração
    const configForm = document.getElementById('configForm');
    const saveBtn = document.getElementById('saveBtn');
    
    configForm.addEventListener('submit', function() {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Salvando...';
    });
    
    // Form de teste
    const testForm = document.getElementById('testForm');
    const testBtn = document.getElementById('testBtn');
    
    testForm.addEventListener('submit', function() {
        testBtn.disabled = true;
        testBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enviando...';
    });
    
    // Inicializar visibilidade dos campos
    document.getElementById('MAIL_MAILER').dispatchEvent(new Event('change'));
});

// Aplicar configuração pré-definida
function applyConfig(type) {
    if (confirm(`Aplicar configuração do ${type.toUpperCase()}?`)) {
        const config = configs[type];
        
        document.getElementById('MAIL_MAILER').value = 'smtp';
        document.getElementById('MAIL_HOST').value = config.host;
        document.getElementById('MAIL_PORT').value = config.port;
        document.getElementById('MAIL_ENCRYPTION').value = config.encryption || '';
        
        // Mostrar alerta com instruções
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-info alert-dismissible fade show';
        alertDiv.innerHTML = `
            <strong>Configuração aplicada!</strong><br>
            <strong>Nota:</strong> ${config.note}<br>
            <strong>Próximo passo:</strong> Configure o usuário e senha SMTP, depois teste o envio.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.row'));
    }
}

// Resetar formulário
function resetForm() {
    if (confirm('Resetar todas as configurações?')) {
        document.getElementById('MAIL_MAILER').value = 'smtp';
        document.getElementById('MAIL_HOST').value = '';
        document.getElementById('MAIL_PORT').value = '';
        document.getElementById('MAIL_ENCRYPTION').value = 'tls';
        document.getElementById('MAIL_USERNAME').value = '';
        document.getElementById('MAIL_PASSWORD').value = '';
        document.getElementById('MAIL_FROM_ADDRESS').value = '';
        document.getElementById('MAIL_FROM_NAME').value = '';
    }
}

// Validar configuração
function validateConfig() {
    fetch('{{ route("email-config.validate") }}')
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                showAlert('success', '✅ Configuração válida! O sistema está pronto para enviar emails.');
            } else {
                showAlert('warning', `⚠️ Problemas encontrados:\n\n${data.issues.join('\n')}\n\n${data.suggestions}`);
            }
        })
        .catch(error => {
            showAlert('danger', '❌ Erro ao validar configuração: ' + error.message);
        });
}

// Mostrar alerta
function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <div style="white-space: pre-line;">${message}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.row'));
}

// Mostrar/ocultar campos SMTP baseado no driver
document.getElementById('MAIL_MAILER').addEventListener('change', function() {
    const smtpFields = document.querySelectorAll('#MAIL_HOST, #MAIL_PORT, #MAIL_ENCRYPTION, #MAIL_USERNAME, #MAIL_PASSWORD');
    const isSmtp = this.value === 'smtp';
    
    smtpFields.forEach(field => {
        field.required = isSmtp;
        field.parentElement.style.display = isSmtp ? 'block' : 'none';
    });
});
</script>
@endpush
@endsection 