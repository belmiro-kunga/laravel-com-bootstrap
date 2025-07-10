@extends('layouts.app')

@section('title', 'Notificações - Sistema de Denúncias')

@section('page-title', 'Notificações')

@section('breadcrumb')
    <x-admin.breadcrumb :items="[
        ['title' => 'Dashboard', 'url' => route('dashboard.index'), 'icon' => 'fas fa-tachometer-alt'],
        ['title' => 'Notificações', 'icon' => 'fas fa-bell']
    ]" />
@endsection

@section('content')
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
            <x-admin.card title="Filtros" subtitle="Filtrar notificações">
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
            </x-admin.card>
        </div>
    </div>

    <!-- Lista de Notificações -->
    <div class="row">
        <div class="col-12">
            <x-admin.card title="Notificações" subtitle="Lista de todas as notificações">
                <div id="notifications-container">
                    @forelse($notifications as $notification)
                    <div class="notification-item border-bottom p-3 {{ $notification->read_at ? 'bg-light' : 'bg-white' }}" 
                         data-id="{{ $notification->id }}" 
                         data-type="{{ $notification->data['tipo'] ?? 'unknown' }}"
                         data-date="{{ $notification->created_at->format('Y-m-d') }}">
                        
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <!-- Ícone e Status -->
                                <div class="d-flex align-items-center mb-2">
                                    @if(!$notification->read_at)
                                        <span class="badge bg-primary me-2">Nova</span>
                                    @endif
                                    
                                    @if(($notification->data['tipo'] ?? '') === 'nova_denuncia')
                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    @elseif(($notification->data['tipo'] ?? '') === 'denuncia_finalizada')
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                    @else
                                        <i class="fas fa-bell text-info me-2"></i>
                                    @endif
                                    
                                    <span class="text-muted small">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <!-- Mensagem -->
                                <h6 class="mb-1">{{ $notification->data['mensagem'] ?? 'Notificação' }}</h6>
                                
                                <!-- Detalhes -->
                                <div class="text-muted small mb-2">
                                    @if(isset($notification->data['protocolo']))
                                        <strong>Protocolo:</strong> {{ $notification->data['protocolo'] }}
                                    @endif
                                    @if(isset($notification->data['titulo']))
                                        <br><strong>Título:</strong> {{ Str::limit($notification->data['titulo'], 50) }}
                                    @endif
                                    @if(isset($notification->data['categoria']))
                                        <br><strong>Categoria:</strong> {{ $notification->data['categoria'] }}
                                    @endif
                                </div>

                                <!-- Ações -->
                                <div class="d-flex gap-2">
                                    @if(isset($notification->data['denuncia_id']))
                                        <a href="{{ route('denuncias.show', $notification->data['denuncia_id']) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>Ver Denúncia
                                        </a>
                                    @endif
                                    
                                    @if(!$notification->read_at)
                                        <button type="button" class="btn btn-sm btn-outline-success" 
                                                onclick="markAsRead({{ $notification->id }})">
                                            <i class="fas fa-check me-1"></i>Marcar como Lida
                                        </button>
                                    @endif
                                    
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteNotification({{ $notification->id }})">
                                        <i class="fas fa-trash me-1"></i>Deletar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-bell-slash text-muted" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 text-muted">Nenhuma notificação encontrada</h5>
                        <p class="text-muted">Você não tem notificações no momento.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Paginação -->
                @if($notifications->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $notifications->links() }}
                </div>
                @endif
            </x-admin.card>
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

@push('scripts')
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
@endpush
@endsection 