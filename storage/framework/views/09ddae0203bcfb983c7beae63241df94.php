

<?php $__env->startSection('title', 'Detalhes da Denúncia'); ?>

<?php $__env->startSection('page-title', 'Detalhes da Denúncia'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
    <a href="<?php echo e(route('rastreamento.index')); ?>">Rastrear Denúncias</a>
</li>
<li class="breadcrumb-item active"><?php echo e($denuncia->protocolo); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Informações Principais -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt"></i> Denúncia <?php echo e($denuncia->protocolo); ?>

                    </h5>
                    <div>
                        <?php if($denuncia->urgente): ?>
                            <span class="badge bg-danger">Urgente</span>
                        <?php endif; ?>
                        <span class="badge" style="background-color: <?php echo e($denuncia->status->cor); ?>">
                            <?php echo e($denuncia->status->nome); ?>

                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-heading"></i> Título</h6>
                        <p class="mb-3"><?php echo e($denuncia->titulo); ?></p>
                        
                        <h6><i class="fas fa-tag"></i> Categoria</h6>
                        <span class="badge mb-3" style="background-color: <?php echo e($denuncia->categoria->cor); ?>">
                            <?php echo e($denuncia->categoria->nome); ?>

                        </span>
                        
                        <h6><i class="fas fa-map-marker-alt"></i> Local da Ocorrência</h6>
                        <p class="mb-3"><?php echo e($denuncia->local_ocorrencia ?? 'Não informado'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-calendar"></i> Data da Ocorrência</h6>
                        <p class="mb-3"><?php echo e($denuncia->data_ocorrencia ? \Carbon\Carbon::parse($denuncia->data_ocorrencia)->format('d/m/Y') : 'Não informada'); ?></p>
                        
                        <h6><i class="fas fa-clock"></i> Hora da Ocorrência</h6>
                        <p class="mb-3"><?php echo e($denuncia->hora_ocorrencia ?? 'Não informada'); ?></p>
                        
                        <h6><i class="fas fa-exclamation-triangle"></i> Prioridade</h6>
                        <span class="badge bg-<?php echo e($denuncia->prioridade == 'alta' ? 'danger' : ($denuncia->prioridade == 'media' ? 'warning' : 'info')); ?> mb-3">
                            <?php echo e(ucfirst($denuncia->prioridade)); ?>

                        </span>
                    </div>
                </div>
                
                <h6><i class="fas fa-align-left"></i> Descrição</h6>
                <p><?php echo e($denuncia->descricao); ?></p>
                
                <?php if($denuncia->envolvidos): ?>
                <h6><i class="fas fa-users"></i> Envolvidos</h6>
                <p><?php echo e($denuncia->envolvidos); ?></p>
                <?php endif; ?>
                
                <?php if($denuncia->testemunhas): ?>
                <h6><i class="fas fa-user-friends"></i> Testemunhas</h6>
                <p><?php echo e($denuncia->testemunhas); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Timeline de Status -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history"></i> Timeline de Status
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <?php $__currentLoopData = $historicoStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="timeline-item">
                        <div class="timeline-marker <?php echo e($status->ordem <= $denuncia->status->ordem ? 'active' : ''); ?>" 
                             style="background-color: <?php echo e($status->cor); ?>">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="timeline-content">
                            <h6><?php echo e($status->nome); ?></h6>
                            <p class="text-muted"><?php echo e($status->descricao); ?></p>
                            <?php if($status->ordem <= $denuncia->status->ordem): ?>
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
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- Mensagens e Comentários -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-comments"></i> Mensagens e Atualizações
                </h5>
            </div>
            <div class="card-body">
                <?php if($denuncia->comentarios->where('tipo', 'publico')->count() > 0): ?>
                    <?php $__currentLoopData = $denuncia->comentarios->where('tipo', 'publico')->whereNull('reply_to')->sortBy('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comentario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                            <small class="fw-bold"><?php echo e($resposta->user->name); ?></small>
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
                                <?php if(Auth::check() && ($denuncia->user_id === Auth::id() || $denuncia->email_denunciante === Auth::user()->email)): ?>
                                <div class="reply-form mt-3">
                                    <form action="<?php echo e(route('comentarios.responder', $comentario)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="input-group">
                                            <textarea class="form-control" name="resposta" rows="2" 
                                                      placeholder="Digite sua resposta..." required></textarea>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-reply"></i> Responder
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-comment-slash fa-2x text-muted mb-2"></i>
                        <p class="text-muted">Nenhuma mensagem ainda.</p>
                        <!-- Debug temporário -->
                        <small class="text-muted">
                            Total de comentários: <?php echo e($denuncia->comentarios->count()); ?><br>
                            Comentários públicos: <?php echo e($denuncia->comentarios->where('tipo', 'publico')->count()); ?><br>
                            Comentários sem reply_to: <?php echo e($denuncia->comentarios->where('tipo', 'publico')->whereNull('reply_to')->count()); ?>

                        </small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Informações do Responsável -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-user-tie"></i> Responsável
                </h6>
            </div>
            <div class="card-body text-center">
                <?php if($denuncia->responsavel): ?>
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-user fa-2x"></i>
                    </div>
                    <h6><?php echo e($denuncia->responsavel->name); ?></h6>
                    <p class="text-muted"><?php echo e($denuncia->responsavel->email); ?></p>
                    <span class="badge bg-info"><?php echo e(ucfirst($denuncia->responsavel->role)); ?></span>
                <?php else: ?>
                    <i class="fas fa-user-slash fa-2x text-muted mb-2"></i>
                    <p class="text-muted">Não atribuído</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Datas Importantes -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-calendar-alt"></i> Datas Importantes
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Criada em:</strong><br>
                    <small class="text-muted"><?php echo e($denuncia->created_at->format('d/m/Y H:i')); ?></small>
                </div>
                <div class="mb-3">
                    <strong>Última atualização:</strong><br>
                    <small class="text-muted"><?php echo e($denuncia->updated_at->format('d/m/Y H:i')); ?></small>
                </div>
                <?php if($denuncia->data_limite): ?>
                <div class="mb-3">
                    <strong>Data limite:</strong><br>
                    <small class="text-muted"><?php echo e(\Carbon\Carbon::parse($denuncia->data_limite)->format('d/m/Y')); ?></small>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Evidências -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-paperclip"></i> Evidências
                </h6>
            </div>
            <div class="card-body">
                <?php if($denuncia->evidencias->count() > 0): ?>
                    <?php $__currentLoopData = $denuncia->evidencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evidencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="evidence-item mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file me-2"></i>
                            <div class="flex-grow-1">
                                <small><?php echo e($evidencia->nome_original); ?></small><br>
                                <small class="text-muted"><?php echo e(number_format($evidencia->tamanho / 1024, 2)); ?> KB</small>
                            </div>
                            <a href="<?php echo e(route('evidencias.download', $evidencia->id)); ?>" 
                               class="btn btn-sm btn-outline-primary" title="Download">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p class="text-muted text-center mb-0">Nenhuma evidência anexada.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    background-color: #6c757d;
}

.timeline-marker.active {
    background-color: #28a745;
}

.timeline-content {
    padding-left: 20px;
}

.message {
    border-left: 3px solid #007bff;
    padding-left: 15px;
}

.message-content {
    border-left: 3px solid #007bff;
}

.reply {
    border-left: 2px solid #28a745;
    padding-left: 10px;
}

.reply-content {
    border-left: 2px solid #28a745;
}

.reply-form {
    border-top: 1px solid #e9ecef;
    padding-top: 15px;
}

.evidence-item {
    padding: 10px;
    border: 1px solid #e9ecef;
    border-radius: 5px;
}
</style>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/rastreamento/show.blade.php ENDPATH**/ ?>