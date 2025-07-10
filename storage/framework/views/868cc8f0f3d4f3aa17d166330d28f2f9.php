<?php $__env->startPush('styles'); ?>
<link href="<?php echo e(asset('css/audit-filter.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'Registros de Auditoria'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-history"></i> Logs de Auditoria
                    </h3>
                    <a href="<?php echo e(route('audit.export')); ?>" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-file-export"></i> Exportar CSV
                    </a>
                </div>
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('audit.index')); ?>" class="audit-filter needs-validation" novalidate>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="user" class="form-label small text-muted mb-1">Usuário</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" 
                                               id="user" 
                                               name="user" 
                                               class="form-control form-control-lg" 
                                               placeholder="Filtrar por usuário" 
                                               value="<?php echo e(request('user')); ?>"
                                               autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="action" class="form-label small text-muted mb-1">Ação</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-tasks"></i></span>
                                        <select name="action" id="action" class="form-select form-select-lg">
                                            <option value="">Todas as ações</option>
                                            <option value="created" <?php echo e(request('action') == 'created' ? 'selected' : ''); ?>>Criação</option>
                                            <option value="updated" <?php echo e(request('action') == 'updated' ? 'selected' : ''); ?>>Atualização</option>
                                            <option value="deleted" <?php echo e(request('action') == 'deleted' ? 'selected' : ''); ?>>Exclusão</option>
                                            <option value="login" <?php echo e(request('action') == 'login' ? 'selected' : ''); ?>>Login</option>
                                            <option value="logout" <?php echo e(request('action') == 'logout' ? 'selected' : ''); ?>>Logout</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date" class="form-label small text-muted mb-1">Data</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        <input type="date" 
                                               id="date" 
                                               name="date" 
                                               class="form-control form-control-lg" 
                                               value="<?php echo e(request('date')); ?>"
                                               max="<?php echo e(now()->format('Y-m-d')); ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 d-flex align-items-end">
                                <div class="d-grid w-100">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-search me-2"></i> Filtrar
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <?php if(request()->hasAny(['user', 'action', 'date'])): ?>
                        <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    Filtros ativos: 
                                    <?php if(request('user')): ?>
                                        <span class="badge bg-primary me-1">Usuário: <?php echo e(request('user')); ?></span>
                                    <?php endif; ?>
                                    <?php if(request('action')): ?>
                                        <span class="badge bg-success me-1">Ação: <?php echo e(ucfirst(request('action'))); ?></span>
                                    <?php endif; ?>
                                    <?php if(request('date')): ?>
                                        <span class="badge bg-info text-dark">Data: <?php echo e(\Carbon\Carbon::parse(request('date'))->format('d/m/Y')); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <a href="<?php echo e(route('audit.index')); ?>" class="btn-close btn-clear-filters" aria-label="Limpar filtros">
                                <span class="ms-2">Limpar filtros</span>
                            </a>
                        </div>
                        <?php endif; ?>
                    </form>
                <div class="table-responsive">
                        <table class="table table-bordered table-hover datatable">
                        <thead class="table-light">
                            <tr>
                                    <th>#</th>
                                <th>Usuário</th>
                                    <th>Ação</th>
                                <th>IP</th>
                                    <th>Data/Hora</th>
                                    <th>Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($log->id); ?></td>
                                        <td><?php echo e($log->user ? $log->user->name : 'Sistema'); ?></td>
                                        <td><?php echo e($log->action); ?></td>
                                        <td><?php echo e($log->ip_address); ?></td>
                                        <td><?php echo e($log->created_at->format('d/m/Y H:i')); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('audit.show', $log)); ?>" class="btn btn-sm btn-info" title="Ver detalhes">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Nenhum log encontrado.</td>
                                    </tr>
                                <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                    <div class="mt-3">
                        <?php echo e($logs->withQueryString()->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
// Validação do formulário
(function () {
    'use strict'
    
    // Seleciona todos os formulários que precisam de validação
    var forms = document.querySelectorAll('.needs-validation')
    
    // Adiciona validação personalizada
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            
            form.classList.add('was-validated')
        }, false)
    })
    
    // Adiciona máscara de data
    const dateInput = document.getElementById('date');
    if (dateInput) {
        // Formata a data para o padrão brasileiro ao exibir
        dateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            if (!isNaN(selectedDate.getTime())) {
                const formattedDate = selectedDate.toLocaleDateString('pt-BR');
                this.setAttribute('data-formatted-date', formattedDate);
            }
        });
        
        // Se houver uma data pré-selecionada, formata-a
        if (dateInput.value) {
            const selectedDate = new Date(dateInput.value);
            if (!isNaN(selectedDate.getTime())) {
                dateInput.setAttribute('data-formatted-date', selectedDate.toLocaleDateString('pt-BR'));
            }
        }
    }
    
    // Adiciona tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Feedback visual ao enviar o formulário
    const filterForm = document.querySelector('.audit-filter form');
    if (filterForm) {
        filterForm.addEventListener('submit', function() {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Filtrando...';
            }
        });
    }
})();
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/audit/index.blade.php ENDPATH**/ ?>