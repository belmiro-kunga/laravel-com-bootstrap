<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Resultado do Rastreamento - Sistema de Denúncias Corporativas</title>
    
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
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --border-radius: 12px;
            --box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            --transition: all 0.3s ease;
            --card-bg: rgba(255, 255, 255, 0.98);
        }
        
        [data-bs-theme="dark"] {
            --card-bg: rgba(26, 32, 44, 0.98);
            --text-primary: #e2e8f0;
            --text-secondary: #a0aec0;
            --bg-primary: #1a202c;
            --bg-secondary: #2d3748;
            --border-color: #4a5568;
        }
        
        [data-bs-theme="light"] {
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --bg-primary: #ffffff;
            --bg-secondary: #f7fafc;
            --border-color: #e2e8f0;
        }
        
        body {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            min-height: 100vh;
            padding: 2rem 1rem;
            color: var(--text-primary);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            line-height: 1.6;
        }
        
        .resultado-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .resultado-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .resultado-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #3a0ca3 100%);
            color: white;
            padding: 2.5rem 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .resultado-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            transform: rotate(30deg);
            pointer-events: none;
        }
        
        .status-badge {
            font-size: 0.8rem;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .protocol-number {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .protocol-number:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }
        
        .btn-icon {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            transition: all 0.2s ease;
        }
        
        .btn-icon:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }
        
        .btn-icon:active {
            transform: scale(0.95);
        }
        
        /* Loader */
        .loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .loader.active {
            display: flex;
            opacity: 1;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
            margin-bottom: 1rem;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Suavizar transições */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        
        /* Botão de voltar ao topo */
        .back-to-top {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s ease;
            z-index: 99;
            border: none;
        }
        
        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .back-to-top:hover {
            background: var(--primary-hover);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.4);
        }
        
        .status-badge::before {
            content: '';
            width: 10px;
            height: 10px;
            background: white;
            border-radius: 50%;
            display: inline-block;
            animation: pulse 2s infinite;
        }
        
        .timeline {
            position: relative;
            padding-left: 40px;
            margin: 2.5rem 0;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 10px;
            bottom: 10px;
            width: 3px;
            background: linear-gradient(to bottom, var(--primary-color), var(--success-color));
            border-radius: 3px;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
            transition: var(--transition);
        }
        
        .timeline-item:last-child {
            margin-bottom: 0;
        }
        
        .timeline-marker {
            position: absolute;
            left: -32px;
            top: 5px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            background-color: var(--primary-color);
            border: 3px solid var(--bg-primary);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 2;
            transition: var(--transition);
        }
        
        .timeline-marker i {
            font-size: 1rem;
        }
        
        .timeline-marker.active {
            background-color: var(--success-color);
            transform: scale(1.1);
            box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.3);
        }
        
        .timeline-marker.completed {
            background-color: var(--success-color);
        }
        
        .timeline-marker.pending {
            background-color: var(--secondary-color);
        }
        
        .timeline-content {
            background: var(--bg-secondary);
            border-radius: var(--border-radius);
            padding: 1.25rem 1.5rem;
            border-left: 4px solid var(--primary-color);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }
        
        .timeline-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.03) 0%, rgba(67, 97, 238, 0.1) 100%);
            z-index: 0;
            opacity: 0;
            transition: var(--transition);
        }
        
        .timeline-content:hover::before {
            opacity: 1;
        }
        
        .timeline-content > * {
            position: relative;
            z-index: 1;
        }
        
        .timeline-content h5 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .timeline-content p {
            color: var(--text-secondary);
            margin-bottom: 0;
            font-size: 0.95rem;
        }
        
        .timeline-content .timeline-date {
            font-size: 0.8rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.75rem;
        }
        
        .timeline-content .timeline-date i {
            font-size: 0.9em;
        }
        
        .info-card {
            background: var(--bg-secondary);
            border-radius: var(--border-radius);
            padding: 1.75rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--box-shadow);
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }
        
        .info-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition);
        }
        
        .info-item:hover {
            transform: translateX(5px);
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 180px;
        }
        
        .info-label i {
            width: 20px;
            color: var(--primary-color);
            text-align: center;
        }
        
        .info-value {
            color: var(--text-secondary);
            text-align: right;
            flex: 1;
            word-break: break-word;
            padding-left: 1rem;
        }
        
        .info-value .badge {
            font-weight: 500;
            padding: 0.35em 0.8em;
            font-size: 0.85em;
            letter-spacing: 0.5px;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(67, 97, 238, 0.4);
                transform: scale(0.95);
            }
            70% {
                box-shadow: 0 0 0 12px rgba(67, 97, 238, 0);
                transform: scale(1);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(67, 97, 238, 0);
                transform: scale(0.95);
            }
        }
        
        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-5px);
            }
            100% {
                transform: translateY(0px);
            }
        }
        
        .btn-theme-toggle {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .btn-theme-toggle:hover {
            transform: translateY(-3px) rotate(30deg);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }
        
        .btn-action {
            padding: 0.8rem 1.75rem;
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn-action::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background-color: rgba(255,255,255,0.1);
            transition: all 0.3s ease;
            z-index: -1;
        }
        
        .btn-action:hover::before {
            width: 100%;
        }
        
        .btn-action i {
            font-size: 1rem;
            transition: transform 0.3s ease;
        }
        
        .btn-action:hover i {
            transform: translateX(3px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #3a0ca3 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.4);
            color: white;
            border-color: transparent;
        }
        
        .btn-outline-primary {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.3);
        }
        
        .btn-group-action {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 2.5rem;
            justify-content: center;
        }
        
        @media (max-width: 576px) {
            .btn-group-action {
                flex-direction: column;
                width: 100%;
            }
            
            .btn-group-action .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="resultado-card">
                    <!-- Header -->
                    <div class="resultado-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex flex-column">
                                <h3 class="mb-2"><i class="fas fa-search"></i> Resultado do Rastreamento</h3>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="protocol-number d-flex align-items-center bg-white bg-opacity-10 px-3 py-2 rounded-pill">
                                        <span class="me-2">Protocolo:</span>
                                        <strong class="me-2"><?php echo e($denuncia->protocolo); ?></strong>
                                        <button class="btn btn-sm btn-icon copy-protocol" data-bs-toggle="tooltip" title="Copiar protocolo">
                                            <i class="far fa-copy"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="status-badge" style="background-color: <?php echo e($denuncia->status->cor); ?>">
                                            <i class="fas fa-circle me-1" style="font-size: 0.5rem; vertical-align: middle;"></i> <?php echo e($denuncia->status->nome); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Body -->
                    <div class="card-body p-4">
                        <!-- Informações Básicas -->
                        <div class="info-card">
                            <h5 class="mb-3"><i class="fas fa-info-circle"></i> Informações da Denúncia</h5>
                            
                            <div class="info-item">
                                <span class="info-label">Título:</span>
                                <span class="info-value"><?php echo e($denuncia->titulo); ?></span>
                            </div>
                            
                            <div class="info-item">
                                <span class="info-label">Categoria:</span>
                                <span class="info-value">
                                    <span class="badge" style="background-color: <?php echo e($denuncia->categoria->cor); ?>">
                                        <?php echo e($denuncia->categoria->nome); ?>

                                    </span>
                                </span>
                            </div>
                            
                            <div class="info-item">
                                <span class="info-label">Data de Criação:</span>
                                <span class="info-value"><?php echo e($denuncia->created_at->format('d/m/Y H:i')); ?></span>
                            </div>
                            
                            <div class="info-item">
                                <span class="info-label">Última Atualização:</span>
                                <span class="info-value"><?php echo e($denuncia->updated_at->format('d/m/Y H:i')); ?></span>
                            </div>
                            
                            <?php if($denuncia->responsavel): ?>
                            <div class="info-item">
                                <span class="info-label">Responsável:</span>
                                <span class="info-value"><?php echo e($denuncia->responsavel->name); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="info-item">
                                <span class="info-label">Prioridade:</span>
                                <span class="info-value">
                                    <span class="badge bg-<?php echo e($denuncia->prioridade == 'alta' ? 'danger' : ($denuncia->prioridade == 'media' ? 'warning' : 'info')); ?>">
                                        <?php echo e(ucfirst($denuncia->prioridade)); ?>

                                    </span>
                                </span>
                            </div>
                            
                            <?php if($denuncia->urgente): ?>
                            <div class="info-item">
                                <span class="info-label">Urgente:</span>
                                <span class="info-value">
                                    <span class="badge bg-danger">
                                        <i class="fas fa-exclamation-triangle"></i> Sim
                                    </span>
                                </span>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Timeline de Status -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-history"></i> Timeline de Status
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <!-- Recebida -->
                                    <div class="timeline-item">
                                        <div class="timeline-marker completed">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="timeline-content completed">
                                            <h6><i class="fas fa-inbox"></i> Denúncia Recebida</h6>
                                            <p class="mb-1">Sua denúncia foi recebida e registrada no sistema.</p>
                                            <small class="text-success">
                                                <i class="fas fa-check-circle"></i> Concluído em <?php echo e($denuncia->created_at->format('d/m/Y H:i')); ?>

                                            </small>
                                        </div>
                                    </div>

                                    <!-- Em Análise -->
                                    <div class="timeline-item">
                                        <div class="timeline-marker <?php echo e($denuncia->status->ordem >= 2 ? 'completed' : 'pending'); ?>">
                                            <i class="fas fa-search"></i>
                                        </div>
                                        <div class="timeline-content <?php echo e($denuncia->status->ordem >= 2 ? 'completed' : 'pending'); ?>">
                                            <h6><i class="fas fa-search"></i> Em Análise</h6>
                                            <p class="mb-1">A denúncia está sendo analisada pela equipe responsável.</p>
                                            <?php if($denuncia->status->ordem >= 2): ?>
                                                <small class="text-success">
                                                    <i class="fas fa-check-circle"></i> Concluído
                                                </small>
                                            <?php else: ?>
                                                <small class="text-muted">
                                                    <i class="fas fa-clock"></i> Pendente
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Em Investigação -->
                                    <div class="timeline-item">
                                        <div class="timeline-marker <?php echo e($denuncia->status->ordem >= 3 ? 'completed' : 'pending'); ?>">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                        <div class="timeline-content <?php echo e($denuncia->status->ordem >= 3 ? 'completed' : 'pending'); ?>">
                                            <h6><i class="fas fa-search-plus"></i> Em Investigação</h6>
                                            <p class="mb-1">Investigação detalhada em andamento para apurar os fatos.</p>
                                            <?php if($denuncia->status->ordem >= 3): ?>
                                                <small class="text-success">
                                                    <i class="fas fa-check-circle"></i> Concluído
                                                </small>
                                            <?php else: ?>
                                                <small class="text-muted">
                                                    <i class="fas fa-clock"></i> Pendente
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Aguardando Decisão -->
                                    <div class="timeline-item">
                                        <div class="timeline-marker <?php echo e($denuncia->status->ordem >= 4 ? 'completed' : 'pending'); ?>">
                                            <i class="fas fa-gavel"></i>
                                        </div>
                                        <div class="timeline-content <?php echo e($denuncia->status->ordem >= 4 ? 'completed' : 'pending'); ?>">
                                            <h6><i class="fas fa-gavel"></i> Aguardando Decisão</h6>
                                            <p class="mb-1">Aguardando decisão da diretoria sobre as medidas a serem tomadas.</p>
                                            <?php if($denuncia->status->ordem >= 4): ?>
                                                <small class="text-success">
                                                    <i class="fas fa-check-circle"></i> Concluído
                                                </small>
                                            <?php else: ?>
                                                <small class="text-muted">
                                                    <i class="fas fa-clock"></i> Pendente
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Concluída -->
                                    <div class="timeline-item">
                                        <div class="timeline-marker <?php echo e($denuncia->status->ordem >= 5 ? 'active' : 'pending'); ?>">
                                            <i class="fas fa-check-double"></i>
                                        </div>
                                        <div class="timeline-content <?php echo e($denuncia->status->ordem >= 5 ? 'active' : 'pending'); ?>">
                                            <h6><i class="fas fa-check-double"></i> Concluída</h6>
                                            <p class="mb-1">Denúncia finalizada com as medidas apropriadas implementadas.</p>
                                            <?php if($denuncia->status->ordem >= 5): ?>
                                                <small class="text-success">
                                                    <i class="fas fa-check-circle"></i> Concluído
                                                </small>
                                            <?php else: ?>
                                                <small class="text-muted">
                                                    <i class="fas fa-clock"></i> Pendente
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Observações -->
                        <div class="alert alert-info mt-4">
                            <h6><i class="fas fa-info-circle"></i> Informações Importantes</h6>
                            <ul class="mb-0">
                                <li>O status é atualizado automaticamente conforme o progresso da denúncia</li>
                                <li>Você receberá notificações por e-mail quando houver atualizações</li>
                                <li>O prazo de análise pode variar conforme a complexidade do caso</li>
                                <li>Para mais informações, entre em contato com a equipe responsável</li>
                            </ul>
                        </div>

                        <!-- Mensagens Públicas e Respostas -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-comments"></i> Mensagens da Equipe e Respostas
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php
                                    $mensagens = $denuncia->comentarios->where('tipo', 'publico')->whereNull('reply_to')->sortBy('created_at');
                                ?>
                                <?php if($mensagens->count() > 0): ?>
                                    <?php $__currentLoopData = $mensagens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comentario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="message mb-4">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1"><?php echo e($comentario->user->name); ?></h6>
                                                        <span class="badge bg-info">Mensagem</span>
                                                    </div>
                                                    <small class="text-muted"><?php echo e($comentario->created_at->format('d/m/Y H:i')); ?></small>
                                                </div>
                                                <div class="message-content p-3 bg-light rounded mt-2">
                                                    <p class="mb-0"><?php echo e($comentario->comentario); ?></p>
                                                </div>
                                                <?php if($comentario->importante): ?>
                                                    <span class="badge bg-warning text-dark mt-2">
                                                        <i class="fas fa-star"></i> Importante
                                                    </span>
                                                <?php endif; ?>
                                                <!-- Respostas -->
                                                <?php if($comentario->replies->count() > 0): ?>
                                                    <div class="replies mt-3">
                                                        <?php $__currentLoopData = $comentario->replies->sortBy('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resposta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="reply ms-4 mb-2">
                                                            <div class="d-flex">
                                                                <div class="flex-shrink-0">
                                                                    <div class="avatar bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                                                        <i class="fas fa-reply"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <div class="d-flex justify-content-between align-items-start">
                                                                        <div>
                                                                            <small class="fw-bold"><?php echo e($resposta->user->email === 'anonimo@sistema.com' ? 'Denunciante' : $resposta->user->name); ?></small>
                                                                            <span class="badge bg-success ms-1">Resposta</span>
                                                                        </div>
                                                                        <small class="text-muted"><?php echo e($resposta->created_at->format('d/m/Y H:i')); ?></small>
                                                                    </div>
                                                                    <div class="reply-content p-2 bg-white border rounded mt-1">
                                                                        <small><?php echo e($resposta->comentario); ?></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <!-- Formulário de Resposta -->
                                                <div class="reply-form mt-3">
                                                    <form action="<?php echo e(route('rastreamento.publico.responder', ['protocolo' => $denuncia->protocolo, 'comentario' => $comentario->id])); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="input-group">
                                                            <textarea class="form-control" name="resposta" rows="2" placeholder="Digite sua resposta..." required></textarea>
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="fas fa-reply"></i> Responder
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="text-center py-4">
                                        <i class="fas fa-comment-slash fa-2x text-muted mb-2"></i>
                                        <p class="text-muted">Nenhuma mensagem da equipe ainda.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Botões de Ação -->
                        <div class="btn-group-action">
                            <a href="<?php echo e(route('rastreamento.publico.download', $denuncia->protocolo)); ?>" class="btn btn-action btn-warning" data-bs-toggle="tooltip" title="Baixar relatório em PDF">
                                <i class="fas fa-file-pdf"></i> Baixar Relatório
                            </a>
                            <a href="<?php echo e(route('rastreamento.publico')); ?>" class="btn btn-action btn-outline-primary" data-bs-toggle="tooltip" title="Fazer uma nova consulta">
                                <i class="fas fa-search"></i> Nova Consulta
                            </a>
                            <a href="<?php echo e(route('denuncias.formulario-publico')); ?>" class="btn btn-action btn-primary" data-bs-toggle="tooltip" title="Criar uma nova denúncia">
                                <i class="fas fa-plus-circle"></i> Nova Denúncia
                            </a>
                            <a href="<?php echo e(route('home')); ?>" class="btn btn-action btn-outline-secondary" data-bs-toggle="tooltip" title="Voltar para a página inicial">
                                <i class="fas fa-home"></i> Início
                            </a>
                            <button id="copyProtocolBtn" class="btn btn-action btn-outline-info copy-protocol" data-bs-toggle="tooltip" title="Copiar número do protocolo">
                                <i class="far fa-copy"></i> Copiar Protocolo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Loader -->
    <div class="loader" id="pageLoader">
        <div class="spinner"></div>
        <p>Carregando...</p>
    </div>
    
    <!-- Botão Voltar ao Topo -->
    <button class="back-to-top" id="backToTop" title="Voltar ao topo">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Theme Toggle and Animations -->
    <script>
        // Gerenciamento do loader
        const pageLoader = document.getElementById('pageLoader');
        
        // Mostrar loader
        function showLoader() {
            pageLoader.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        // Esconder loader
        function hideLoader() {
            pageLoader.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        // Mostrar loader por 1.5s ao carregar a página
        window.addEventListener('load', () => {
            setTimeout(hideLoader, 800);
        });
        
        // Gerenciar botão de voltar ao topo
        const backToTopButton = document.getElementById('backToTop');
        
        // Mostrar/ocultar botão ao rolar
        function toggleBackToTop() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        }
        
        // Rolar suavemente até o topo
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        
        // Adicionar eventos
        backToTopButton.addEventListener('click', scrollToTop);
        window.addEventListener('scroll', toggleBackToTop);
        
        document.addEventListener('DOMContentLoaded', function() {
            // Theme Toggle
            const themeToggle = document.createElement('button');
            themeToggle.className = 'btn-theme-toggle';
            themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
            themeToggle.title = 'Alternar tema';
            document.body.appendChild(themeToggle);
            
            // Verificar tema salvo ou preferência do sistema
            const savedTheme = localStorage.getItem('theme') || 'light';
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = savedTheme === 'system' ? (systemPrefersDark ? 'dark' : 'light') : savedTheme;
            
            // Aplicar tema
            document.documentElement.setAttribute('data-bs-theme', theme);
            themeToggle.innerHTML = `<i class="fas fa-${theme === 'dark' ? 'sun' : 'moon'}"></i>`;
            
            // Alternar tema
            themeToggle.addEventListener('click', () => {
                const currentTheme = document.documentElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                document.documentElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                
                themeToggle.innerHTML = `<i class="fas fa-${newTheme === 'dark' ? 'sun' : 'moon'}"></i>`;
                themeToggle.style.transform = 'rotate(180deg)';
                setTimeout(() => {
                    themeToggle.style.transform = 'rotate(0deg)';
                }, 300);
            });
            
            // Animações ao rolar a página
            const animateOnScroll = () => {
                const elements = document.querySelectorAll('.timeline-item, .info-card, .card');
                
                elements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;
                    
                    if (elementTop < windowHeight - 100) {
                        element.classList.add('animate__animated', 'animate__fadeInUp');
                    }
                });
            };
            
            // Executar animações ao carregar e rolar
            window.addEventListener('load', animateOnScroll);
            window.addEventListener('scroll', animateOnScroll);
            
            // Tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Copiar protocolo para área de transferência
            const copyProtocol = () => {
                const protocol = '<?php echo e($denuncia->protocolo); ?>';
                navigator.clipboard.writeText(protocol).then(() => {
                    const tooltip = bootstrap.Tooltip.getInstance('#copyProtocolBtn');
                    const originalTitle = tooltip._config.title;
                    
                    tooltip.setContent({'.tooltip-inner': 'Copiado!'});
                    setTimeout(() => {
                        tooltip.setContent({'.tooltip-inner': originalTitle});
                    }, 2000);
                });
            };
            
            document.querySelectorAll('.copy-protocol').forEach(btn => {
                btn.addEventListener('click', copyProtocol);
            });
        });
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/rastreamento/publico-resultado.blade.php ENDPATH**/ ?>