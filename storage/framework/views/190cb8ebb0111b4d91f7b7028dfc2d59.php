<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['provider', 'config']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['provider', 'config']); ?>
<?php foreach (array_filter((['provider', 'config']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $providerConfig = $config[$provider] ?? [];
    $colors = [
        'gmail' => 'primary',
        'outlook' => 'info', 
        'yahoo' => 'warning',
        'protonmail' => 'success'
    ];
    $color = $colors[$provider] ?? 'secondary';
?>

<div class="card h-100">
    <div class="card-body text-center">
        <i class="fas fa-envelope text-<?php echo e($color); ?> mb-2" style="font-size: 2rem;"></i>
        <h6><?php echo e($providerConfig['name'] ?? 'Provedor'); ?></h6>
        <p class="small text-muted"><?php echo e($providerConfig['host'] ?? ''); ?>:<?php echo e($providerConfig['port'] ?? ''); ?></p>
        
        <div class="mb-2">
            <small class="text-muted"><?php echo e($providerConfig['note'] ?? ''); ?></small>
        </div>
        
        <button type="button" class="btn btn-sm btn-outline-<?php echo e($color); ?>" onclick="applyConfig('<?php echo e($provider); ?>')">
            <i class="fas fa-magic me-1"></i>Aplicar
        </button>
        
        <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="showInstructions('<?php echo e($provider); ?>')">
            <i class="fas fa-question-circle me-1"></i>Instruções
        </button>
    </div>
</div>

<?php $__env->startPush('modals'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function showInstructions(provider) {
    const configs = <?php echo json_encode($config, 15, 512) ?>;
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
<?php $__env->stopPush(); ?> <?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/components/email-config/provider-card.blade.php ENDPATH**/ ?>