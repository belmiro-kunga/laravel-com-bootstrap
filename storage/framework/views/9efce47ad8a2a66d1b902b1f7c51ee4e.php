<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['user' => null]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['user' => null]); ?>
<?php foreach (array_filter((['user' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $user = $user ?? auth()->user();
    $unreadNotifications = $user ? $user->unreadNotifications()->count() : 0;
    $recentNotifications = $user ? $user->unreadNotifications()->take(5)->get() : collect();
?>

<nav class="navbar navbar-expand-lg navbar-light py-3">
    <div class="container-fluid">
        <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target=".sidebar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="d-flex align-items-center">
            <h4 class="mb-0"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h4>
        </div>
        
        <div class="navbar-nav ms-auto">
            <?php if(auth()->guard()->check()): ?>
            <div class="nav-item dropdown me-3">
                <a class="nav-link dropdown-toggle position-relative" href="#" role="button" data-bs-toggle="dropdown" id="notificationsDropdown">
                    <i class="fas fa-bell"></i>
                    <?php if($unreadNotifications > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge">
                            <?php echo e($unreadNotifications > 99 ? '99+' : $unreadNotifications); ?>

                        </span>
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" style="width: 350px; max-height: 400px; overflow-y: auto;">
                    <li><h6 class="dropdown-header">
                        <i class="fas fa-bell me-2"></i>Notificações
                        <?php if($unreadNotifications > 0): ?>
                            <span class="badge bg-primary ms-2"><?php echo e($unreadNotifications); ?></span>
                        <?php endif; ?>
                    </h6></li>
                    
                    <?php if($recentNotifications->count() > 0): ?>
                        <?php $__currentLoopData = $recentNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a class="dropdown-item py-2" href="#" onclick="handleNotificationClick(<?php echo e($notification->id); ?>, '<?php echo e($notification->data['denuncia_id'] ?? ''); ?>')">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <?php if(($notification->data['tipo'] ?? '') === 'nova_denuncia'): ?>
                                            <i class="fas fa-exclamation-triangle text-warning"></i>
                                        <?php elseif(($notification->data['tipo'] ?? '') === 'denuncia_finalizada'): ?>
                                            <i class="fas fa-check-circle text-success"></i>
                                        <?php else: ?>
                                            <i class="fas fa-bell text-info"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <div class="fw-bold small"><?php echo e(Str::limit($notification->data['mensagem'] ?? 'Notificação', 40)); ?></div>
                                        <div class="text-muted small"><?php echo e($notification->created_at->diffForHumans()); ?></div>
                                        <?php if(isset($notification->data['protocolo'])): ?>
                                            <div class="text-muted small">Protocolo: <?php echo e($notification->data['protocolo']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <li><span class="dropdown-item-text text-muted">Nenhuma notificação não lida</span></li>
                    <?php endif; ?>
                    
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?php echo e(route('notifications.index')); ?>">
                        <i class="fas fa-list me-2"></i>Ver todas as notificações
                    </a></li>
                    <?php if($unreadNotifications > 0): ?>
                    <li><a class="dropdown-item" href="#" onclick="markAllAsReadFromDropdown()">
                        <i class="fas fa-check-double me-2"></i>Marcar todas como lidas
                    </a></li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <span class="d-none d-md-block"><?php echo e($user->name); ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header"><?php echo e($user->name); ?></h6></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?php echo e(route('users.perfil')); ?>">
                        <i class="fas fa-user-edit me-2"></i>Meu Perfil
                    </a></li>
                    <li><a class="dropdown-item" href="<?php echo e(route('dashboard.index')); ?>">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form id="navbar-logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="redirect_to" value="<?php echo e(url('/admin')); ?>">
                        </form>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('navbar-logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>Sair
                        </a>
                    </li>
                </ul>
            </div>
            <?php else: ?>
            <div class="nav-item">
                <a class="nav-link" href="<?php echo e(route('login')); ?>">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<?php $__env->startPush('scripts'); ?>
<script>
// Atualizar notificações periodicamente
function updateNotifications() {
    fetch('/notifications/unread')
    .then(response => response.json())
    .then(data => {
        const badge = document.querySelector('.notification-badge');
        const dropdown = document.getElementById('notificationsDropdown');
        
        if (data.count > 0) {
            if (badge) {
                badge.textContent = data.count > 99 ? '99+' : data.count;
                badge.style.display = 'inline';
            } else {
                // Criar badge se não existir
                const newBadge = document.createElement('span');
                newBadge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge';
                newBadge.textContent = data.count > 99 ? '99+' : data.count;
                dropdown.appendChild(newBadge);
            }
        } else {
            if (badge) {
                badge.style.display = 'none';
            }
        }
    })
    .catch(error => {
        console.error('Erro ao atualizar notificações:', error);
    });
}

// Marcar como lida a partir do dropdown
function markAllAsReadFromDropdown() {
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
            // Atualizar badge
            const badge = document.querySelector('.notification-badge');
            if (badge) {
                badge.style.display = 'none';
            }
            
            // Recarregar dropdown
            location.reload();
        }
    })
    .catch(error => {
        console.error('Erro:', error);
    });
}

// Lidar com clique em notificação
function handleNotificationClick(notificationId, denunciaId) {
    // Marcar como lida
    fetch(`/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    });
    
    // Redirecionar para denúncia se existir
    if (denunciaId) {
        window.location.href = `/denuncias/${denunciaId}`;
    } else {
        window.location.href = '/notifications';
    }
}

// Atualizar notificações a cada 30 segundos
setInterval(updateNotifications, 30000);

// Atualizar ao carregar a página
document.addEventListener('DOMContentLoaded', function() {
    updateNotifications();
});
</script>
<?php $__env->stopPush(); ?> <?php /**PATH C:\Users\Kunga\Documents\GitHub\laravel-com-bootstrap\resources\views/components/admin/navbar.blade.php ENDPATH**/ ?>