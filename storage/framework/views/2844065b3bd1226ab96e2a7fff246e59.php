<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['config']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['config']); ?>
<?php foreach (array_filter((['config']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

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
                            <span class="badge bg-<?php echo e($config['MAIL_MAILER'] === 'smtp' ? 'success' : 'warning'); ?>">
                                <?php echo e($config['MAIL_MAILER']); ?>

                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Host:</strong></td>
                        <td>
                            <?php if($config['MAIL_HOST'] && $config['MAIL_HOST'] !== 'smtp.mailgun.org'): ?>
                                <span class="text-success"><?php echo e($config['MAIL_HOST']); ?></span>
                            <?php else: ?>
                                <span class="text-danger">Não configurado</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Porta:</strong></td>
                        <td><?php echo e($config['MAIL_PORT'] ?: 'Não configurada'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Criptografia:</strong></td>
                        <td><?php echo e($config['MAIL_ENCRYPTION'] ?: 'Nenhuma'); ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Usuário:</strong></td>
                        <td>
                            <?php if($config['MAIL_USERNAME']): ?>
                                <span class="text-success"><?php echo e($config['MAIL_USERNAME']); ?></span>
                            <?php else: ?>
                                <span class="text-danger">Não configurado</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Senha:</strong></td>
                        <td>
                            <?php if($config['MAIL_PASSWORD']): ?>
                                <span class="badge bg-success">Configurada</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Não configurada</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>From Address:</strong></td>
                        <td>
                            <?php if($config['MAIL_FROM_ADDRESS'] && $config['MAIL_FROM_ADDRESS'] !== 'hello@example.com'): ?>
                                <span class="text-success"><?php echo e($config['MAIL_FROM_ADDRESS']); ?></span>
                            <?php else: ?>
                                <span class="text-danger">Padrão</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>From Name:</strong></td>
                        <td>
                            <?php if($config['MAIL_FROM_NAME'] && $config['MAIL_FROM_NAME'] !== 'Laravel'): ?>
                                <span class="text-success"><?php echo e($config['MAIL_FROM_NAME']); ?></span>
                            <?php else: ?>
                                <span class="text-danger">Padrão</span>
                            <?php endif; ?>
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
</div> <?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/components/email-config/status-card.blade.php ENDPATH**/ ?>