@props(['config'])

<div class="card h-100">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0">
            <i class="fas fa-info-circle me-2"></i>Status da Configuração
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Driver:</strong></td>
                        <td>
                            <span class="badge bg-{{ $config['MAIL_MAILER'] === 'smtp' ? 'success' : 'warning' }}">
                                {{ $config['MAIL_MAILER'] }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Host:</strong></td>
                        <td>
                            @if($config['MAIL_HOST'] && $config['MAIL_HOST'] !== 'smtp.mailgun.org')
                                <span class="text-success">{{ $config['MAIL_HOST'] }}</span>
                            @else
                                <span class="text-danger">Não configurado</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Porta:</strong></td>
                        <td>{{ $config['MAIL_PORT'] ?: 'Não configurada' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Criptografia:</strong></td>
                        <td>{{ $config['MAIL_ENCRYPTION'] ?: 'Nenhuma' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Usuário:</strong></td>
                        <td>
                            @if($config['MAIL_USERNAME'])
                                <span class="text-success">{{ $config['MAIL_USERNAME'] }}</span>
                            @else
                                <span class="text-danger">Não configurado</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Senha:</strong></td>
                        <td>
                            @if($config['MAIL_PASSWORD'])
                                <span class="badge bg-success">Configurada</span>
                            @else
                                <span class="badge bg-danger">Não configurada</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>From Address:</strong></td>
                        <td>
                            @if($config['MAIL_FROM_ADDRESS'] && $config['MAIL_FROM_ADDRESS'] !== 'hello@example.com')
                                <span class="text-success">{{ $config['MAIL_FROM_ADDRESS'] }}</span>
                            @else
                                <span class="text-danger">Padrão</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>From Name:</strong></td>
                        <td>
                            @if($config['MAIL_FROM_NAME'] && $config['MAIL_FROM_NAME'] !== 'Laravel')
                                <span class="text-success">{{ $config['MAIL_FROM_NAME'] }}</span>
                            @else
                                <span class="text-danger">Padrão</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="mt-3">
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="validateConfig()">
                <i class="fas fa-check-circle me-1"></i>Validar Configuração
            </button>
        </div>
    </div>
</div> 