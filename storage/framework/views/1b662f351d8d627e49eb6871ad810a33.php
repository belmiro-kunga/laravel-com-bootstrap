

<?php $__env->startSection('title', 'Configuração de Email - Sistema de Denúncias'); ?>

<?php $__env->startSection('page-title', 'Configuração de Email'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php if (isset($component)) { $__componentOriginaldbbc880c47f621cda59b70d6eb356b2f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldbbc880c47f621cda59b70d6eb356b2f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.breadcrumb','data' => ['items' => [
        ['title' => 'Dashboard', 'url' => route('dashboard.index'), 'icon' => 'fas fa-tachometer-alt'],
        ['title' => 'Configurações', 'icon' => 'fas fa-cog'],
        ['title' => 'Email', 'icon' => 'fas fa-envelope']
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['title' => 'Dashboard', 'url' => route('dashboard.index'), 'icon' => 'fas fa-tachometer-alt'],
        ['title' => 'Configurações', 'icon' => 'fas fa-cog'],
        ['title' => 'Email', 'icon' => 'fas fa-envelope']
    ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldbbc880c47f621cda59b70d6eb356b2f)): ?>
<?php $attributes = $__attributesOriginaldbbc880c47f621cda59b70d6eb356b2f; ?>
<?php unset($__attributesOriginaldbbc880c47f621cda59b70d6eb356b2f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldbbc880c47f621cda59b70d6eb356b2f)): ?>
<?php $component = $__componentOriginaldbbc880c47f621cda59b70d6eb356b2f; ?>
<?php unset($__componentOriginaldbbc880c47f621cda59b70d6eb356b2f); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Alertas -->
    <?php if(session('success')): ?>
        <?php if (isset($component)) { $__componentOriginald888329b8246e32afd68d2decbd25cf1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald888329b8246e32afd68d2decbd25cf1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.alert','data' => ['type' => 'success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success']); ?>
            <?php echo e(session('success')); ?>

         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald888329b8246e32afd68d2decbd25cf1)): ?>
<?php $attributes = $__attributesOriginald888329b8246e32afd68d2decbd25cf1; ?>
<?php unset($__attributesOriginald888329b8246e32afd68d2decbd25cf1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald888329b8246e32afd68d2decbd25cf1)): ?>
<?php $component = $__componentOriginald888329b8246e32afd68d2decbd25cf1; ?>
<?php unset($__componentOriginald888329b8246e32afd68d2decbd25cf1); ?>
<?php endif; ?>
    <?php endif; ?>
    
    <?php if(session('error')): ?>
        <?php if (isset($component)) { $__componentOriginald888329b8246e32afd68d2decbd25cf1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald888329b8246e32afd68d2decbd25cf1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.alert','data' => ['type' => 'danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'danger']); ?>
            <div style="white-space: pre-line;"><?php echo e(session('error')); ?></div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald888329b8246e32afd68d2decbd25cf1)): ?>
<?php $attributes = $__attributesOriginald888329b8246e32afd68d2decbd25cf1; ?>
<?php unset($__attributesOriginald888329b8246e32afd68d2decbd25cf1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald888329b8246e32afd68d2decbd25cf1)): ?>
<?php $component = $__componentOriginald888329b8246e32afd68d2decbd25cf1; ?>
<?php unset($__componentOriginald888329b8246e32afd68d2decbd25cf1); ?>
<?php endif; ?>
    <?php endif; ?>
    
    <?php if(session('warning')): ?>
        <?php if (isset($component)) { $__componentOriginald888329b8246e32afd68d2decbd25cf1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald888329b8246e32afd68d2decbd25cf1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.alert','data' => ['type' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'warning']); ?>
            <?php echo e(session('warning')); ?>

         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald888329b8246e32afd68d2decbd25cf1)): ?>
<?php $attributes = $__attributesOriginald888329b8246e32afd68d2decbd25cf1; ?>
<?php unset($__attributesOriginald888329b8246e32afd68d2decbd25cf1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald888329b8246e32afd68d2decbd25cf1)): ?>
<?php $component = $__componentOriginald888329b8246e32afd68d2decbd25cf1; ?>
<?php unset($__componentOriginald888329b8246e32afd68d2decbd25cf1); ?>
<?php endif; ?>
    <?php endif; ?>

    <!-- Status da Configuração -->
    <div class="row mb-4">
        <div class="col-12">
            <?php if (isset($component)) { $__componentOriginal5cdd81617bdd200bfb2fa6cb5bf15706 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5cdd81617bdd200bfb2fa6cb5bf15706 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.email-config.status-card','data' => ['config' => $config]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('email-config.status-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['config' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($config)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5cdd81617bdd200bfb2fa6cb5bf15706)): ?>
<?php $attributes = $__attributesOriginal5cdd81617bdd200bfb2fa6cb5bf15706; ?>
<?php unset($__attributesOriginal5cdd81617bdd200bfb2fa6cb5bf15706); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5cdd81617bdd200bfb2fa6cb5bf15706)): ?>
<?php $component = $__componentOriginal5cdd81617bdd200bfb2fa6cb5bf15706; ?>
<?php unset($__componentOriginal5cdd81617bdd200bfb2fa6cb5bf15706); ?>
<?php endif; ?>
        </div>
    </div>

    <!-- Configurações Populares -->
    <div class="row mb-4">
        <div class="col-12">
            <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['title' => 'Configurações Populares','subtitle' => 'Clique para aplicar configurações pré-definidas']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Configurações Populares','subtitle' => 'Clique para aplicar configurações pré-definidas']); ?>
                <div class="row g-3">
                    <?php $__currentLoopData = ['gmail', 'outlook', 'yahoo', 'protonmail']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-3">
                            <?php if (isset($component)) { $__componentOriginal1ff5c89517dc3501fa42335073fd220f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1ff5c89517dc3501fa42335073fd220f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.email-config.provider-card','data' => ['provider' => $provider,'config' => $popularConfigs]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('email-config.provider-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['provider' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($provider),'config' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($popularConfigs)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1ff5c89517dc3501fa42335073fd220f)): ?>
<?php $attributes = $__attributesOriginal1ff5c89517dc3501fa42335073fd220f; ?>
<?php unset($__attributesOriginal1ff5c89517dc3501fa42335073fd220f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1ff5c89517dc3501fa42335073fd220f)): ?>
<?php $component = $__componentOriginal1ff5c89517dc3501fa42335073fd220f; ?>
<?php unset($__componentOriginal1ff5c89517dc3501fa42335073fd220f); ?>
<?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    </div>

    <!-- Formulário de Configuração -->
    <div class="row mb-4">
        <div class="col-12">
            <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['title' => 'Configuração Manual','subtitle' => 'Configure manualmente as opções de email']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Configuração Manual','subtitle' => 'Configure manualmente as opções de email']); ?>
                <form action="<?php echo e(route('email-config.update')); ?>" method="POST" id="configForm">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">
                                <i class="fas fa-cogs me-2"></i>Configurações Gerais
                            </h6>
                            
                            <div class="mb-3">
                                <label for="MAIL_MAILER" class="form-label">Driver de Email</label>
                                <select class="form-select" id="MAIL_MAILER" name="MAIL_MAILER" required>
                                    <option value="smtp" <?php echo e($config['MAIL_MAILER'] === 'smtp' ? 'selected' : ''); ?>>SMTP</option>
                                    <option value="sendmail" <?php echo e($config['MAIL_MAILER'] === 'sendmail' ? 'selected' : ''); ?>>Sendmail</option>
                                    <option value="mailgun" <?php echo e($config['MAIL_MAILER'] === 'mailgun' ? 'selected' : ''); ?>>Mailgun</option>
                                    <option value="ses" <?php echo e($config['MAIL_MAILER'] === 'ses' ? 'selected' : ''); ?>>Amazon SES</option>
                                    <option value="postmark" <?php echo e($config['MAIL_MAILER'] === 'postmark' ? 'selected' : ''); ?>>Postmark</option>
                                    <option value="log" <?php echo e($config['MAIL_MAILER'] === 'log' ? 'selected' : ''); ?>>Log (para testes)</option>
                                    <option value="array" <?php echo e($config['MAIL_MAILER'] === 'array' ? 'selected' : ''); ?>>Array (para testes)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="MAIL_FROM_ADDRESS" class="form-label">Email Remetente</label>
                                <input type="email" class="form-control" id="MAIL_FROM_ADDRESS" name="MAIL_FROM_ADDRESS" 
                                       value="<?php echo e($config['MAIL_FROM_ADDRESS']); ?>" required>
                                <div class="form-text">Email que aparecerá como remetente</div>
                            </div>

                            <div class="mb-3">
                                <label for="MAIL_FROM_NAME" class="form-label">Nome Remetente</label>
                                <input type="text" class="form-control" id="MAIL_FROM_NAME" name="MAIL_FROM_NAME" 
                                       value="<?php echo e($config['MAIL_FROM_NAME']); ?>" required>
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
                                       value="<?php echo e($config['MAIL_HOST']); ?>" placeholder="ex: smtp.gmail.com">
                            </div>

                            <div class="mb-3">
                                <label for="MAIL_PORT" class="form-label">Porta SMTP</label>
                                <input type="number" class="form-control" id="MAIL_PORT" name="MAIL_PORT" 
                                       value="<?php echo e($config['MAIL_PORT']); ?>" placeholder="587, 465, 25">
                            </div>

                            <div class="mb-3">
                                <label for="MAIL_ENCRYPTION" class="form-label">Criptografia</label>
                                <select class="form-select" id="MAIL_ENCRYPTION" name="MAIL_ENCRYPTION">
                                    <option value="tls" <?php echo e($config['MAIL_ENCRYPTION'] === 'tls' ? 'selected' : ''); ?>>TLS</option>
                                    <option value="ssl" <?php echo e($config['MAIL_ENCRYPTION'] === 'ssl' ? 'selected' : ''); ?>>SSL</option>
                                    <option value="" <?php echo e($config['MAIL_ENCRYPTION'] === null ? 'selected' : ''); ?>>Nenhuma</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="MAIL_USERNAME" class="form-label">Usuário SMTP</label>
                                <input type="text" class="form-control" id="MAIL_USERNAME" name="MAIL_USERNAME" 
                                       value="<?php echo e($config['MAIL_USERNAME']); ?>" placeholder="seu@email.com">
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
    </div>

    <!-- Teste de Email -->
    <div class="row">
        <div class="col-12">
            <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['title' => 'Teste de Email','subtitle' => 'Envie um email de teste para verificar a configuração']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Teste de Email','subtitle' => 'Envie um email de teste para verificar a configuração']); ?>
                <form action="<?php echo e(route('email-config.test')); ?>" method="POST" id="testForm">
                    <?php echo csrf_field(); ?>
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
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Configurações pré-definidas
const configs = <?php echo json_encode($popularConfigs, 15, 512) ?>;

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
    fetch('<?php echo e(route("email-config.validate")); ?>')
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/email-config/index.blade.php ENDPATH**/ ?>