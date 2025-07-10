

<?php $__env->startSection('title', 'Notificações - Sistema de Denúncias'); ?>

<?php $__env->startSection('page-title', 'Notificações'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php if (isset($component)) { $__componentOriginaldbbc880c47f621cda59b70d6eb356b2f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldbbc880c47f621cda59b70d6eb356b2f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.breadcrumb','data' => ['items' => [
        ['title' => 'Dashboard', 'url' => route('dashboard.index'), 'icon' => 'fas fa-tachometer-alt'],
        ['title' => 'Notificações', 'icon' => 'fas fa-bell']
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['title' => 'Dashboard', 'url' => route('dashboard.index'), 'icon' => 'fas fa-tachometer-alt'],
        ['title' => 'Notificações', 'icon' => 'fas fa-bell']
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
    <!-- Cabeçalho com Estatísticas -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">
                        <i class="fas fa-bell text-primary me-2"></i>
                        Notificações
                    </h2>
                    <p class="text-muted mb-0">
                        Gerencie suas notificações do sistema
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-primary" onclick="markAllAsRead()">
                        <i class="fas fa-check-double me-2"></i>Marcar Todas como Lidas
                    </button>
                    <button type="button" class="btn btn-outline-danger" onclick="deleteAllNotifications()">
                        <i class="fas fa-trash me-2"></i>Limpar Todas
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-12">
            <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['title' => 'Filtros','subtitle' => 'Filtrar notificações']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Filtros','subtitle' => 'Filtrar notificações']); ?>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" onchange="filterNotifications()">
                            <option value="">Todas</option>
                            <option value="unread">Não lidas</option>
                            <option value="read">Lidas</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="type" class="form-label">Tipo</label>
                        <select class="form-select" id="type" onchange="filterNotifications()">
                            <option value="">Todos os tipos</option>
                            <option value="nova_denuncia">Nova Denúncia</option>
                            <option value="denuncia_finalizada">Denúncia Finalizada</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="form-label">Data</label>
                        <select class="form-select" id="date" onchange="filterNotifications()">
                            <option value="">Todas as datas</option>
                            <option value="today">Hoje</option>
                            <option value="week">Esta semana</option>
                            <option value="month">Este mês</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" class="form-control" id="search" placeholder="Buscar notificações..." onkeyup="filterNotifications()">
                    </div>
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

    <!-- Lista de Notificações -->
    <div class="row">
        <div class="col-12">
            <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['title' => 'Notificações','subtitle' => 'Lista de todas as notificações']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Notificações','subtitle' => 'Lista de todas as notificações']); ?>
                <div id="notifications-container">
                    <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="notification-item border-bottom p-3 <?php echo e($notification->read_at ? 'bg-light' : 'bg-white'); ?>" 
                         data-id="<?php echo e($notification->id); ?>" 
                         data-type="<?php echo e($notification->data['tipo'] ?? 'unknown'); ?>"
                         data-date="<?php echo e($notification->created_at->format('Y-m-d')); ?>">
                        
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <!-- Ícone e Status -->
                                <div class="d-flex align-items-center mb-2">
                                    <?php if(!$notification->read_at): ?>
                                        <span class="badge bg-primary me-2">Nova</span>
                                    <?php endif; ?>
                                    
                                    <?php if(($notification->data['tipo'] ?? '') === 'nova_denuncia'): ?>
                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    <?php elseif(($notification->data['tipo'] ?? '') === 'denuncia_finalizada'): ?>
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                    <?php else: ?>
                                        <i class="fas fa-bell text-info me-2"></i>
                                    <?php endif; ?>
                                    
                                    <span class="text-muted small">
                                        <?php echo e($notification->created_at->diffForHumans()); ?>

                                    </span>
                                </div>

                                <!-- Mensagem -->
                                <h6 class="mb-1"><?php echo e($notification->data['mensagem'] ?? 'Notificação'); ?></h6>
                                
                                <!-- Detalhes -->
                                <div class="text-muted small mb-2">
                                    <?php if(isset($notification->data['protocolo'])): ?>
                                        <strong>Protocolo:</strong> <?php echo e($notification->data['protocolo']); ?>

                                    <?php endif; ?>
                                    <?php if(isset($notification->data['titulo'])): ?>
                                        <br><strong>Título:</strong> <?php echo e(Str::limit($notification->data['titulo'], 50)); ?>

                                    <?php endif; ?>
                                    <?php if(isset($notification->data['categoria'])): ?>
                                        <br><strong>Categoria:</strong> <?php echo e($notification->data['categoria']); ?>

                                    <?php endif; ?>
                                </div>

                                <!-- Ações -->
                                <div class="d-flex gap-2">
                                    <?php if(isset($notification->data['denuncia_id'])): ?>
                                        <a href="<?php echo e(route('denuncias.show', $notification->data['denuncia_id'])); ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>Ver Denúncia
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if(!$notification->read_at): ?>
                                        <button type="button" class="btn btn-sm btn-outline-success" 
                                                onclick="markAsRead(<?php echo e($notification->id); ?>)">
                                            <i class="fas fa-check me-1"></i>Marcar como Lida
                                        </button>
                                    <?php endif; ?>
                                    
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteNotification(<?php echo e($notification->id); ?>)">
                                        <i class="fas fa-trash me-1"></i>Deletar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-bell-slash text-muted" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 text-muted">Nenhuma notificação encontrada</h5>
                        <p class="text-muted">Você não tem notificações no momento.</p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Paginação -->
                <?php if($notifications->hasPages()): ?>
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($notifications->links()); ?>

                </div>
                <?php endif; ?>
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

<!-- Modal de Confirmação -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Ação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="confirmMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmButton">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Filtrar notificações
function filterNotifications() {
    const status = document.getElementById('status').value;
    const type = document.getElementById('type').value;
    const date = document.getElementById('date').value;
    const search = document.getElementById('search').value.toLowerCase();
    
    const items = document.querySelectorAll('.notification-item');
    
    items.forEach(item => {
        let show = true;
        
        // Filtro por status
        if (status === 'unread' && item.classList.contains('bg-light')) {
            show = false;
        } else if (status === 'read' && !item.classList.contains('bg-light')) {
            show = false;
        }
        
        // Filtro por tipo
        if (type && item.dataset.type !== type) {
            show = false;
        }
        
        // Filtro por data
        if (date) {
            const itemDate = item.dataset.date;
            const today = new Date().toISOString().split('T')[0];
            
            if (date === 'today' && itemDate !== today) {
                show = false;
            } else if (date === 'week') {
                const weekAgo = new Date();
                weekAgo.setDate(weekAgo.getDate() - 7);
                const weekAgoStr = weekAgo.toISOString().split('T')[0];
                if (itemDate < weekAgoStr) {
                    show = false;
                }
            } else if (date === 'month') {
                const monthAgo = new Date();
                monthAgo.setMonth(monthAgo.getMonth() - 1);
                const monthAgoStr = monthAgo.toISOString().split('T')[0];
                if (itemDate < monthAgoStr) {
                    show = false;
                }
            }
        }
        
        // Filtro por busca
        if (search) {
            const text = item.textContent.toLowerCase();
            if (!text.includes(search)) {
                show = false;
            }
        }
        
        item.style.display = show ? 'block' : 'none';
    });
}

// Marcar como lida
function markAsRead(id) {
    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const item = document.querySelector(`[data-id="${id}"]`);
            item.classList.add('bg-light');
            item.classList.remove('bg-white');
            
            // Remover badge "Nova"
            const badge = item.querySelector('.badge');
            if (badge) {
                badge.remove();
            }
            
            // Atualizar contador de notificações não lidas
            updateUnreadCount();
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao marcar notificação como lida');
    });
}

// Marcar todas como lidas
function markAllAsRead() {
    if (!confirm('Marcar todas as notificações como lidas?')) return;
    
    fetch('/notifications/read-all', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Marcar todas como lidas visualmente
            document.querySelectorAll('.notification-item').forEach(item => {
                item.classList.add('bg-light');
                item.classList.remove('bg-white');
                
                const badge = item.querySelector('.badge');
                if (badge) {
                    badge.remove();
                }
            });
            
            updateUnreadCount();
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao marcar notificações como lidas');
    });
}

// Deletar notificação
function deleteNotification(id) {
    showConfirmModal(
        'Tem certeza que deseja deletar esta notificação?',
        () => performDelete(id)
    );
}

// Deletar todas as notificações
function deleteAllNotifications() {
    showConfirmModal(
        'Tem certeza que deseja deletar TODAS as notificações? Esta ação não pode ser desfeita.',
        () => performDeleteAll()
    );
}

// Mostrar modal de confirmação
function showConfirmModal(message, onConfirm) {
    document.getElementById('confirmMessage').textContent = message;
    document.getElementById('confirmButton').onclick = () => {
        onConfirm();
        bootstrap.Modal.getInstance(document.getElementById('confirmModal')).hide();
    };
    new bootstrap.Modal(document.getElementById('confirmModal')).show();
}

// Executar deleção
function performDelete(id) {
    fetch(`/notifications/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const item = document.querySelector(`[data-id="${id}"]`);
            item.remove();
            updateUnreadCount();
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao deletar notificação');
    });
}

// Executar deleção de todas
function performDeleteAll() {
    fetch('/notifications', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('notifications-container').innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-bell-slash text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">Nenhuma notificação encontrada</h5>
                    <p class="text-muted">Você não tem notificações no momento.</p>
                </div>
            `;
            updateUnreadCount();
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao deletar notificações');
    });
}

// Atualizar contador de notificações não lidas
function updateUnreadCount() {
    fetch('/notifications/unread')
    .then(response => response.json())
    .then(data => {
        // Atualizar badge no menu (se existir)
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            if (data.count > 0) {
                badge.textContent = data.count;
                badge.style.display = 'inline';
            } else {
                badge.style.display = 'none';
            }
        }
    });
}

// Atualizar contador ao carregar a página
document.addEventListener('DOMContentLoaded', function() {
    updateUnreadCount();
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/notifications/index.blade.php ENDPATH**/ ?>