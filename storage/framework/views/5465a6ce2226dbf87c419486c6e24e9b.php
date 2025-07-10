

<?php $__env->startSection('title', 'Denúncia ' . $denuncia->protocolo . ' - Sistema de Denúncias'); ?>

<?php $__env->startSection('page-title', 'Denúncia ' . $denuncia->protocolo); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php if (isset($component)) { $__componentOriginaldbbc880c47f621cda59b70d6eb356b2f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldbbc880c47f621cda59b70d6eb356b2f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.breadcrumb','data' => ['items' => [
        ['title' => 'Denúncias', 'url' => route('denuncias.index'), 'icon' => 'fas fa-exclamation-triangle'],
        ['title' => $denuncia->protocolo, 'icon' => 'fas fa-eye']
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['title' => 'Denúncias', 'url' => route('denuncias.index'), 'icon' => 'fas fa-exclamation-triangle'],
        ['title' => $denuncia->protocolo, 'icon' => 'fas fa-eye']
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
    <div class="row">
        <!-- Detalhes principais -->
        <div class="col-lg-8">
            <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['title' => ''.e($denuncia->titulo).'','subtitle' => 'Protocolo: '.e($denuncia->protocolo).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($denuncia->titulo).'','subtitle' => 'Protocolo: '.e($denuncia->protocolo).'']); ?>
                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <span class="badge bg-<?php echo e($denuncia->status->cor ?? 'secondary'); ?> me-2"><?php echo e($denuncia->status->nome ?? '-'); ?></span>
                        <span class="badge bg-<?php echo e($denuncia->prioridade_cor); ?>"><?php echo e($denuncia->prioridade_label); ?></span>
                        <?php if($denuncia->urgente): ?>
                            <span class="badge bg-danger ms-1">Urgente</span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-2 text-end">
                        <span class="badge bg-primary"><?php echo e($denuncia->categoria->nome ?? '-'); ?></span>
                        <?php if($denuncia->responsavel): ?>
                            <span class="badge bg-info ms-1"><?php echo e($denuncia->responsavel->name); ?></span>
                        <?php else: ?>
                            <span class="badge bg-secondary ms-1">Não atribuído</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Data de Criação:</strong> <?php echo e($denuncia->created_at->format('d/m/Y H:i')); ?><br>
                    <?php if($denuncia->data_ocorrencia): ?>
                        <strong>Data da Ocorrência:</strong> <?php echo e($denuncia->data_ocorrencia->format('d/m/Y')); ?><br>
                    <?php endif; ?>
                    <?php if($denuncia->local_ocorrencia): ?>
                        <strong>Local:</strong> <?php echo e($denuncia->local_ocorrencia); ?><br>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <strong>Descrição:</strong>
                    <p class="mt-2"><?php echo e($denuncia->descricao); ?></p>
                </div>
                <?php if($denuncia->envolvidos): ?>
                <div class="mb-3">
                    <strong>Envolvidos:</strong>
                    <p class="mt-2"><?php echo e($denuncia->envolvidos); ?></p>
                </div>
                <?php endif; ?>
                <?php if($denuncia->testemunhas): ?>
                <div class="mb-3">
                    <strong>Testemunhas:</strong>
                    <p class="mt-2"><?php echo e($denuncia->testemunhas); ?></p>
                </div>
                <?php endif; ?>
                <?php if($denuncia->observacoes_internas): ?>
                <div class="mb-3">
                    <strong>Observações Internas:</strong>
                    <div class="alert alert-info">
                        <?php echo e($denuncia->observacoes_internas); ?>

                    </div>
                </div>
                <?php endif; ?>
                <div class="mb-3">
                    <strong>Tipo de Denúncia:</strong>
                    <?php if($denuncia->is_anonima): ?>
                        <span class="badge bg-warning"><i class="fas fa-user-secret"></i> Anônima</span>
                    <?php else: ?>
                        <span class="badge bg-info"><i class="fas fa-user"></i> Identificada</span>
                        <small class="text-muted d-block mt-1">Denunciante: <?php echo e($denuncia->nome_denunciante); ?> (<?php echo e($denuncia->email_denunciante); ?>)</small>
                    <?php endif; ?>
                </div>
                <!-- Workflow de status com modal para comentário -->
                <div class="mb-3 d-flex flex-wrap gap-2">
                    <?php $__currentLoopData = ['Recebida', 'Em Análise', 'Resolvida', 'Arquivada']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusNome): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $statusObj = \App\Models\Status::where('nome', $statusNome)->first();
                        ?>
                        <?php if($statusObj && $denuncia->status_id !== $statusObj->id): ?>
                        <button type="button" 
                                class="btn btn-outline-<?php echo e($statusObj->cor ?? 'secondary'); ?> btn-sm"
                                data-bs-toggle="modal" 
                                data-bs-target="#modalAlterarStatus"
                                data-status-id="<?php echo e($statusObj->id); ?>"
                                data-status-nome="<?php echo e($statusObj->nome); ?>"
                                data-status-cor="<?php echo e($statusObj->cor ?? 'secondary'); ?>">
                            <?php echo e($statusObj->nome); ?>

                        </button>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <!-- Botão para modal de atribuição de responsável -->
                <button type="button" class="btn btn-outline-info btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#modalResponsavel">
                    <i class="fas fa-user-plus"></i> Atribuir/Alterar Responsável
                </button>
                <!-- Ações rápidas com confirmação -->
                <div class="d-flex gap-2 flex-wrap mb-3">
                    <!-- Botão removido: funcionalidade de marcar como urgente não implementada -->
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

            <!-- Timeline de status com logs de auditoria -->
            <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['title' => 'Histórico de Status e Auditoria','class' => 'mb-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Histórico de Status e Auditoria','class' => 'mb-4']); ?>
                <div class="timeline">
                    <?php $__currentLoopData = $denuncia->historicoStatus()->with(['statusAnterior', 'statusNovo', 'user'])->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="timeline-item">
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <?php if($item->statusAnterior): ?>
                                        <span class="badge bg-secondary me-1"><?php echo e($item->statusAnterior->nome); ?></span>
                                        <i class="fas fa-arrow-right text-muted me-1"></i>
                                    <?php endif; ?>
                                    <span class="badge bg-<?php echo e($item->statusNovo->cor ?? 'secondary'); ?>"><?php echo e($item->statusNovo->nome); ?></span>
                                    <small class="text-muted ms-2"><?php echo e($item->created_at->format('d/m/Y H:i')); ?></small>
                                </div>
                                <div>
                                    <?php if($item->user): ?>
                                        <span class="text-muted"><i class="fas fa-user"></i> <?php echo e($item->user->name); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">Sistema</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if($item->comentario): ?>
                            <div class="mt-2">
                                <div class="alert alert-light border">
                                    <i class="fas fa-comment text-muted me-1"></i>
                                    <strong>Comentário:</strong> <?php echo e($item->comentario); ?>

                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="mt-1">
                                <small class="text-muted"><?php echo e($item->tempo_decorrido); ?></small>
                            </div>
                        </div>
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

            <!-- Comentários -->
            <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['title' => 'Comentários']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Comentários']); ?>
                <?php if(Auth::user()->podeGerenciarDenuncias()): ?>
                <form action="<?php echo e(route('comentarios.store', $denuncia)); ?>" method="POST" class="mb-4">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="comentario" class="form-label">Novo Comentário</label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="interno">Interno</option>
                                    <option value="publico">Público</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" id="importante" name="importante">
                                    <label class="form-check-label" for="importante">
                                        Marcar como importante
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Adicionar Comentário
                    </button>
                </form>
                <?php endif; ?>
                <div id="comentarios-lista">
                    <?php $__currentLoopData = $denuncia->comentarios()->with('user')->orderBy('created_at', 'desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comentario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card mb-3 <?php echo e($comentario->importante ? 'border-warning' : ''); ?>">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <strong><?php echo e($comentario->user->name); ?></strong>
                                    <span class="badge bg-<?php echo e($comentario->tipo_cor); ?> ms-2"><?php echo e($comentario->tipo_label); ?></span>
                                    <?php if($comentario->importante): ?>
                                        <span class="badge bg-warning ms-1">Importante</span>
                                    <?php endif; ?>
                                </div>
                                <small class="text-muted"><?php echo e($comentario->created_at->format('d/m/Y H:i')); ?></small>
                            </div>
                            <div><?php echo e($comentario->comentario); ?></div>
                        </div>
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
        <!-- Galeria de evidências -->
        <div class="col-lg-4">
            <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['title' => 'Evidências']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Evidências']); ?>
                <div class="row g-2">
                    <?php $__empty_1 = true; $__currentLoopData = $denuncia->evidencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evidencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-6 col-md-12 mb-2">
                        <a href="<?php echo e($evidencia->url); ?>" target="_blank">
                            <img src="<?php echo e($evidencia->thumbnail_url ?? $evidencia->url); ?>" alt="Evidência" class="img-fluid rounded shadow-sm mb-1" style="max-height:120px;object-fit:cover;">
                        </a>
                        <div class="small text-muted text-truncate"><?php echo e($evidencia->nome_arquivo); ?></div>
                        <a href="<?php echo e($evidencia->url); ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-1"><i class="fas fa-search"></i> Ver</a>
                        <a href="<?php echo e($evidencia->url); ?>" download class="btn btn-sm btn-outline-success mt-1"><i class="fas fa-download"></i> Baixar</a>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12 text-muted">Nenhuma evidência anexada.</div>
                    <?php endif; ?>
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
</div>

<!-- Modal para alterar status com comentário -->
<div class="modal fade" id="modalAlterarStatus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alterar Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('denuncias.alterar-status', $denuncia)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <input type="hidden" name="status_id" id="status_id">
                    <div class="mb-3">
                        <label class="form-label">Novo Status</label>
                        <div class="alert alert-info">
                            <span id="status_nome" class="badge bg-secondary"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="comentario_status" class="form-label">Comentário (opcional)</label>
                        <textarea class="form-control" id="comentario_status" name="comentario" rows="3" 
                                  placeholder="Descreva o motivo da alteração de status..."></textarea>
                        <div class="form-text">Este comentário será registrado no histórico de auditoria.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Confirmar Alteração
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de atribuição de responsável -->
<div class="modal fade" id="modalResponsavel" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atribuir Responsável</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('denuncias.atribuir-responsavel', $denuncia)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <label for="responsavel_id" class="form-label">Selecione o responsável</label>
                    <select class="form-select" id="responsavel_id" name="responsavel_id" required>
                        <option value="">Selecione...</option>
                        <?php $__currentLoopData = \App\Models\User::responsaveis()->orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->id); ?>" <?php if($denuncia->responsavel_id == $user->id): echo 'selected'; endif; ?>><?php echo e($user->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="mb-3 mt-3">
                        <label for="comentario_responsavel" class="form-label">Comentário (opcional)</label>
                        <textarea class="form-control" id="comentario_responsavel" name="comentario" rows="2" 
                                  placeholder="Motivo da atribuição..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Atribuir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Formulário oculto para ações sensíveis -->
<form id="formAcaoSensivel" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
</form>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Configurar modal de alteração de status
document.addEventListener('DOMContentLoaded', function() {
    const modalAlterarStatus = document.getElementById('modalAlterarStatus');
    if (modalAlterarStatus) {
        modalAlterarStatus.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const statusId = button.getAttribute('data-status-id');
            const statusNome = button.getAttribute('data-status-nome');
            const statusCor = button.getAttribute('data-status-cor');
            
            document.getElementById('status_id').value = statusId;
            document.getElementById('status_nome').textContent = statusNome;
            document.getElementById('status_nome').className = `badge bg-${statusCor}`;
        });
    }
});

// Função para confirmação de ações sensíveis
function confirmarAcaoSensivel(url, titulo, mensagem) {
    if (confirm(`${mensagem}\n\nAção: ${titulo}`)) {
        const form = document.getElementById('formAcaoSensivel');
        form.action = url;
        form.submit();
    }
}

// Adicionar confirmação para outras ações sensíveis
document.addEventListener('DOMContentLoaded', function() {
    // Confirmação para exclusão
    const btnExcluir = document.querySelector('.btn-excluir');
    if (btnExcluir) {
        btnExcluir.addEventListener('click', function(e) {
            if (!confirm('Tem certeza que deseja excluir esta denúncia? Esta ação não pode ser desfeita.')) {
                e.preventDefault();
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/denuncias/show.blade.php ENDPATH**/ ?>