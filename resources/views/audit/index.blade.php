@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/audit-filter.css') }}" rel="stylesheet">
@endpush

@section('title', 'Registros de Auditoria')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-history"></i> Logs de Auditoria
                    </h3>
                    <a href="{{ route('audit.export') }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-file-export"></i> Exportar CSV
                    </a>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('audit.index') }}" class="audit-filter needs-validation" novalidate>
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
                                               value="{{ request('user') }}"
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
                                            <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Criação</option>
                                            <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Atualização</option>
                                            <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Exclusão</option>
                                            <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                                            <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Logout</option>
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
                                               value="{{ request('date') }}"
                                               max="{{ now()->format('Y-m-d') }}">
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
                        
                        @if(request()->hasAny(['user', 'action', 'date']))
                        <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    Filtros ativos: 
                                    @if(request('user'))
                                        <span class="badge bg-primary me-1">Usuário: {{ request('user') }}</span>
                                    @endif
                                    @if(request('action'))
                                        <span class="badge bg-success me-1">Ação: {{ ucfirst(request('action')) }}</span>
                                    @endif
                                    @if(request('date'))
                                        <span class="badge bg-info text-dark">Data: {{ \Carbon\Carbon::parse(request('date'))->format('d/m/Y') }}</span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('audit.index') }}" class="btn-close btn-clear-filters" aria-label="Limpar filtros">
                                <span class="ms-2">Limpar filtros</span>
                            </a>
                        </div>
                        @endif
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
                                @forelse($logs as $log)
                                    <tr>
                                        <td>{{ $log->id }}</td>
                                        <td>{{ $log->user ? $log->user->name : 'Sistema' }}</td>
                                        <td>{{ $log->action }}</td>
                                        <td>{{ $log->ip_address }}</td>
                                        <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('audit.show', $log) }}" class="btn btn-sm btn-info" title="Ver detalhes">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Nenhum log encontrado.</td>
                                    </tr>
                                @endforelse
                        </tbody>
                    </table>
                </div>
                    <div class="mt-3">
                        {{ $logs->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
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
@endpush

@endsection 