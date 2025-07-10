<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Rastrear Denúncia - Sistema de Denúncias Corporativas</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --border-radius: 10px;
            --box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }
        
        body {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #2d3748;
        }
        
        .rastreamento-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
            max-width: 500px;
        }
        
        .rastreamento-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }
        
        .rastreamento-header {
            text-align: center;
            padding: 2.5rem 2rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, #3a0ca3 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .rastreamento-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            transform: rotate(30deg);
        }
        
        .rastreamento-header i {
            font-size: 3.5rem;
            color: white;
            margin-bottom: 1rem;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .rastreamento-header h3 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .rastreamento-header p {
            opacity: 0.9;
            margin-bottom: 0;
        }
        
        .form-control, .form-select {
            border-radius: var(--border-radius);
            border: 2px solid #e1e5ee;
            padding: 0.8rem 1.2rem;
            font-size: 1rem;
            transition: var(--transition);
            box-shadow: none;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }
        
        .form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
        }
        
        .btn-rastreamento {
            background: linear-gradient(135deg, var(--primary-color) 0%, #3a0ca3 100%);
            border: none;
            border-radius: var(--border-radius);
            padding: 0.9rem 1.5rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.9rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-rastreamento:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-rastreamento i {
            font-size: 1.1em;
        }
        
        .alert {
            border-radius: var(--border-radius);
            border: none;
            padding: 1rem 1.25rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .alert i {
            margin-right: 0.5rem;
        }
        
        .alert-info {
            background-color: #e6f3ff;
            color: #0c63e4;
            border-left: 4px solid var(--primary-color);
        }
        
        .alert-danger {
            background-color: #fff0f0;
            color: var(--danger-color);
            border-left: 4px solid var(--danger-color);
        }
        
        .form-text {
            color: #6c757d;
            font-size: 0.85rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }
        
        .form-control.is-invalid {
            border-color: var(--danger-color);
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        .card-body {
            padding: 2.5rem;
        }
        
        .btn-outline-primary {
            border-radius: var(--border-radius);
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: var(--transition);
            border-width: 2px;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .text-muted {
            color: #6c757d !important;
        }
        
        /* Estilos para o grupo de input */
        .input-group {
            transition: var(--transition);
            border-radius: var(--border-radius) !important;
        }
        
        .input-group:focus-within {
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }
        
        .input-group .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #e1e5ee;
            border-right: none;
            border-radius: var(--border-radius) 0 0 var(--border-radius) !important;
            transition: var(--transition);
        }
        
        .input-group-focus .input-group-text {
            border-color: var(--primary-color);
            background-color: #f0f4ff;
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 var(--border-radius) var(--border-radius) 0 !important;
        }
        
        .input-group-focus .form-control {
            border-color: var(--primary-color);
        }
        
        /* Estilos para validação */
        .is-valid, .is-invalid {
            background-position: right calc(0.375em + 0.1875rem) center;
            padding-right: 2.25rem;
        }
        
        .is-valid {
            border-color: var(--success-color) !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        /* Animações */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        
        .btn-rastreamento:not(:disabled):hover {
            animation: pulse 1.5s infinite;
        }
        
        /* Responsividade */
        @media (max-width: 768px) {
            .rastreamento-header {
                padding: 2rem 1.5rem;
            }
            
            .card-body {
                padding: 2rem 1.5rem;
            }
            
            .rastreamento-header i {
                font-size: 3rem;
            }
            
            .rastreamento-header h3 {
                font-size: 1.5rem;
            }
            
            .btn-rastreamento {
                padding: 0.8rem 1.25rem;
                font-size: 0.85rem;
            }
        }
        
        @media (max-width: 576px) {
            body {
                padding: 1.5rem 0.75rem;
            }
            
            .rastreamento-header {
                padding: 1.75rem 1.25rem;
            }
            
            .card-body {
                padding: 1.75rem 1.25rem;
            }
            
            .rastreamento-header i {
                font-size: 2.5rem;
                margin-bottom: 0.75rem;
            }
            
            .rastreamento-header h3 {
                font-size: 1.4rem;
                margin-bottom: 0.25rem;
            }
            
            .rastreamento-header p {
                font-size: 0.95rem;
            }
            
            .form-control, .form-select {
                padding: 0.7rem 1rem;
                font-size: 0.95rem;
            }
            
            .btn-rastreamento {
                padding: 0.75rem 1rem;
                font-size: 0.85rem;
            }
        }
        
        /* Ajustes para dark mode */
        @media (prefers-color-scheme: dark) {
            .rastreamento-card {
                background: rgba(26, 32, 44, 0.95);
                color: #e2e8f0;
            }
            
            .form-control, .form-select {
                background-color: #2d3748;
                border-color: #4a5568;
                color: #e2e8f0;
            }
            
            .form-control:focus, .form-select:focus {
                background-color: #2d3748;
                color: #e2e8f0;
            }
            
            .form-control::placeholder {
                color: #a0aec0;
            }
            
            .input-group-text {
                background-color: #2d3748;
                border-color: #4a5568;
                color: #a0aec0;
            }
            
            .form-text {
                color: #a0aec0;
            }
            
            .text-muted {
                color: #a0aec0 !important;
            }
            
            .alert-info {
                background-color: #2c5282;
                color: #ebf8ff;
                border-left-color: #63b3ed;
            }
            
            .alert-danger {
                background-color: #742a2a;
                color: #fff5f5;
                border-left-color: #fc8181;
            }
        }
    </style>
</head>
<body class="animate__animated animate__fadeIn">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="rastreamento-card animate__animated animate__fadeInUp">
                    <div class="rastreamento-header">
                        <i class="fas fa-search-location"></i>
                        <h3 class="mb-2">Rastrear Denúncia</h3>
                        <p class="mb-0">Acompanhe o andamento da sua denúncia de forma simples e segura</p>
                    </div>
                    
                    <div class="card-body">
                        <?php if(session('error')): ?>
                            <div class="alert alert-danger animate__animated animate__shakeX">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span><?php echo e(session('error')); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($protocolo): ?>
                            <div class="alert alert-info d-flex align-items-center animate__animated animate__fadeIn">
                                <i class="fas fa-spinner fa-spin me-2"></i>
                                <div>
                                    <strong>Protocolo encontrado!</strong>
                                    <div class="small">Redirecionando para os detalhes da sua denúncia...</div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <form method="GET" action="<?php echo e(route('rastreamento.publico.buscar')); ?>" class="needs-validation" novalidate>
                            <div class="mb-4">
                                <label for="protocolo" class="form-label">
                                    <i class="fas fa-hashtag me-1"></i> Número do Protocolo
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-key text-primary"></i></span>
                                    <input type="text" 
                                           class="form-control form-control-lg <?php $__errorArgs = ['protocolo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="protocolo" 
                                           name="protocolo" 
                                           placeholder="Ex: DEN-2024-001" 
                                           value="<?php echo e($protocolo ?? old('protocolo')); ?>" 
                                           required 
                                           autofocus
                                           pattern="[A-Za-z0-9-]+"
                                           title="Digite um número de protocolo válido">
                                    <button class="btn btn-primary" type="submit" id="button-rastrear">
                                        <i class="fas fa-search me-1"></i> Rastrear
                                    </button>
                                </div>
                                <?php $__errorArgs = ['protocolo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i> <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text mt-2">
                                    <i class="fas fa-info-circle text-primary"></i>
                                    Informe o número do protocolo que foi enviado para seu e-mail ao registrar a denúncia.
                                </div>
                            </div>
                            
                            <div class="d-grid gap-3">
                                <button type="submit" class="btn btn-rastreamento">
                                    <i class="fas fa-search-location me-2"></i> Acompanhar Denúncia
                                </button>
                                
                                <div class="text-center my-3 position-relative">
                                    <span class="bg-white px-3 text-muted">ou</span>
                                    <hr class="position-absolute top-50 w-100" style="z-index: -1;">
                                </div>
                                
                                <a href="<?php echo e(route('denuncias.formulario-publico')); ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-plus-circle me-2"></i> Nova Denúncia
                                </a>
                                
                                <div class="text-center mt-3">
                                    <a href="<?php echo e(route('home')); ?>" class="btn btn-link text-decoration-none">
                                        <i class="fas fa-arrow-left me-1"></i> Voltar para a página inicial
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <p class="text-white-50 mb-0">
                        <small>
                            <i class="fas fa-shield-alt me-1"></i> 
                            Sua privacidade e segurança são importantes para nós
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const protocoloInput = document.getElementById('protocolo');
            const submitButton = document.getElementById('button-rastrear');
            let isSubmitting = false;
            
            // Auto-submit se protocolo foi passado via URL
            if (protocoloInput.value.trim() !== '') {
                // Pequeno atraso para mostrar a animação
                setTimeout(() => {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Carregando...';
                    form.submit();
                }, 800);
            }
            
            // Validação em tempo real
            protocoloInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
                
                // Validação básica do formato
                const isValid = /^[A-Z0-9-]+$/.test(this.value);
                
                if (this.value.length > 0 && !isValid) {
                    this.setCustomValidity('Use apenas letras, números e hífen');
                } else {
                    this.setCustomValidity('');
                }
                
                // Atualiza a aparência do input
                updateInputState(this, isValid);
            });
            
            // Feedback visual ao enviar o formulário
            form.addEventListener('submit', function(e) {
                if (isSubmitting) {
                    e.preventDefault();
                    return;
                }
                
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Adiciona animação de shake no input inválido
                    protocoloInput.classList.add('is-invalid');
                    protocoloInput.classList.add('animate__animated', 'animate__headShake');
                    
                    // Remove a animação após terminar
                    setTimeout(() => {
                        protocoloInput.classList.remove('animate__headShake');
                    }, 1000);
                    
                    return;
                }
                
                // Feedback visual durante o envio
                isSubmitting = true;
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Buscando...';
                
                // Adiciona classe de loading ao form
                form.classList.add('was-validated');
            });
            
            // Função para atualizar o estado visual do input
            function updateInputState(input, isValid) {
                if (input.value.length === 0) {
                    input.classList.remove('is-valid', 'is-invalid');
                    return;
                }
                
                if (isValid) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
            }
            
            // Foco no campo de protocolo ao carregar a página
            if (!protocoloInput.value) {
                protocoloInput.focus();
            }
            
            // Adiciona efeito de foco suave
            protocoloInput.addEventListener('focus', function() {
                this.parentElement.classList.add('input-group-focus');
            });
            
            protocoloInput.addEventListener('blur', function() {
                this.parentElement.classList.remove('input-group-focus');
            });
        });
    </script>
</body>
</html> <?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/rastreamento/publico.blade.php ENDPATH**/ ?>