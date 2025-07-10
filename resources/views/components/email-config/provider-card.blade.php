@props(['provider', 'config'])

@php
    $providerConfig = $config[$provider] ?? [];
    $colors = [
        'gmail' => 'primary',
        'outlook' => 'info', 
        'yahoo' => 'warning',
        'protonmail' => 'success'
    ];
    $color = $colors[$provider] ?? 'secondary';
@endphp

<div class="card h-100">
    <div class="card-body text-center">
        <i class="fas fa-envelope text-{{ $color }} mb-2" style="font-size: 2rem;"></i>
        <h6>{{ $providerConfig['name'] ?? 'Provedor' }}</h6>
        <p class="small text-muted">{{ $providerConfig['host'] ?? '' }}:{{ $providerConfig['port'] ?? '' }}</p>
        
        <div class="mb-2">
            <small class="text-muted">{{ $providerConfig['note'] ?? '' }}</small>
        </div>
        
        <button type="button" class="btn btn-sm btn-outline-{{ $color }}" onclick="applyConfig('{{ $provider }}')">
            <i class="fas fa-magic me-1"></i>Aplicar
        </button>
        
        <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="showInstructions('{{ $provider }}')">
            <i class="fas fa-question-circle me-1"></i>Instruções
        </button>
    </div>
</div>

@push('modals')
<div class="modal fade" id="instructionsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Instruções - <span id="providerName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="providerInstructions"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
function showInstructions(provider) {
    const configs = @json($config);
    const providerConfig = configs[provider];
    
    if (!providerConfig) {
        alert('Configuração não encontrada para este provedor.');
        return;
    }
    
    document.getElementById('providerName').textContent = providerConfig.name || provider;
    document.getElementById('providerInstructions').innerHTML = `
        <div class="alert alert-info">
            <h6>Configuração Automática:</h6>
            <ul>
                <li><strong>Host:</strong> ${providerConfig.host || 'Não definido'}</li>
                <li><strong>Porta:</strong> ${providerConfig.port || 'Não definida'}</li>
                <li><strong>Criptografia:</strong> ${providerConfig.encryption || 'Nenhuma'}</li>
            </ul>
        </div>
        
        <h6>Instruções Manuais:</h6>
        <pre style="white-space: pre-line; background: #f8f9fa; padding: 1rem; border-radius: 0.375rem;">${providerConfig.instructions || 'Instruções não disponíveis'}</pre>
        
        <div class="alert alert-warning">
            <strong>Nota:</strong> ${providerConfig.note || 'Nenhuma nota disponível'}
        </div>
    `;
    
    new bootstrap.Modal(document.getElementById('instructionsModal')).show();
}
</script>
@endpush 