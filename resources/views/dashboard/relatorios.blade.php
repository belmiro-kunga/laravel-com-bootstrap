@extends('layouts.app')

@section('title', 'Relatórios - Sistema de Denúncias')

@section('page-title', 'Relatórios')

@section('breadcrumb')
    <x-admin.breadcrumb :items="[
        ['title' => 'Dashboard', 'url' => route('dashboard.index'), 'icon' => 'fas fa-tachometer-alt'],
        ['title' => 'Relatórios', 'icon' => 'fas fa-chart-bar']
    ]" />
@endsection

@section('content')
<div class="container-fluid">
    <!-- Filtros de Relatório -->
    <div class="row mb-4">
        <div class="col-12">
            <x-admin.card title="Filtros de Relatório" subtitle="Personalize os dados do relatório">
                <form id="filtrosRelatorio" class="row g-3">
                    <div class="col-md-3">
                        <label for="periodo" class="form-label">Período</label>
                        <select class="form-select" id="periodo" name="periodo">
                            <option value="7">Últimos 7 dias</option>
                            <option value="30" selected>Últimos 30 dias</option>
                            <option value="90">Últimos 90 dias</option>
                            <option value="180">Últimos 6 meses</option>
                            <option value="365">Último ano</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="categoria" class="form-label">Categoria</label>
                        <select class="form-select" id="categoria" name="categoria">
                            <option value="">Todas as categorias</option>
                            @foreach(\App\Models\Categoria::where('ativo', true)->orderBy('nome')->get() as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Todos os status</option>
                            @foreach(\App\Models\Status::where('ativo', true)->orderBy('ordem')->get() as $status)
                                <option value="{{ $status->id }}">{{ $status->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="responsavel" class="form-label">Responsável</label>
                        <select class="form-select" id="responsavel" name="responsavel">
                            <option value="">Todos os responsáveis</option>
                            @foreach(\App\Models\User::where('ativo', true)->orderBy('name')->get() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-2"></i>Filtrar
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="limparFiltros()">
                            <i class="fas fa-times me-2"></i>Limpar
                        </button>
                        <button type="button" class="btn btn-success" onclick="exportarRelatorio()">
                            <i class="fas fa-download me-2"></i>Exportar
                        </button>
                    </div>
                </form>
            </x-admin.card>
        </div>
    </div>

    <!-- Métricas Principais -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <x-admin.metric-card 
                title="Total de Denúncias"
                :value="$metrics['total_denuncias']['value']"
                icon="fas fa-exclamation-triangle"
                variant="primary"
                :trend="$metrics['total_denuncias']['trend']"
                :trendValue="$metrics['total_denuncias']['trend_value']"
                :trendLabel="$metrics['total_denuncias']['trend_label']"
            />
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <x-admin.metric-card 
                title="Denúncias Pendentes"
                :value="$metrics['denuncias_pendentes']['value']"
                icon="fas fa-clock"
                variant="warning"
            />
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <x-admin.metric-card 
                title="Denúncias Urgentes"
                :value="$metrics['denuncias_urgentes']['value']"
                icon="fas fa-exclamation-circle"
                variant="danger"
            />
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <x-admin.metric-card 
                title="Denúncias Resolvidas"
                :value="$metrics['denuncias_resolvidas']['value']"
                icon="fas fa-check-circle"
                variant="success"
            />
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row mb-4">
        <div class="col-xl-6">
            <x-admin.chart-card 
                title="Denúncias por Status"
                subtitle="Distribuição atual"
                type="doughnut"
                :data="$denunciasPorStatus"
                height="400px"
                :options="[
                    'plugins' => [
                        'legend' => ['position' => 'bottom']
                    ]
                ]"
            />
        </div>
        
        <div class="col-xl-6">
            <x-admin.chart-card 
                title="Denúncias por Categoria"
                subtitle="Últimos 90 dias"
                type="bar"
                :data="$denunciasPorCategoria"
                height="400px"
                :options="[
                    'plugins' => [
                        'legend' => ['display' => false]
                    ],
                    'scales' => [
                        'y' => ['beginAtZero' => true]
                    ]
                ]"
            />
        </div>
    </div>

    <!-- Gráfico de Tendência -->
    <div class="row mb-4">
        <div class="col-12">
            <x-admin.chart-card 
                title="Tendência de Denúncias"
                subtitle="Últimos 90 dias"
                type="line"
                :data="$denunciasPorPeriodo"
                height="400px"
                :options="[
                    'plugins' => [
                        'legend' => ['display' => false]
                    ],
                    'scales' => [
                        'y' => ['beginAtZero' => true]
                    ]
                ]"
            />
        </div>
    </div>

    <!-- Estatísticas Detalhadas -->
    <div class="row mb-4">
        <div class="col-xl-6">
            <x-admin.widget 
                title="Top Responsáveis"
                icon="fas fa-users"
                subtitle="Por denúncias pendentes"
                :refreshable="true"
            >
                <div class="list-group list-group-flush">
                    @forelse($estatisticasResponsavel as $responsavel)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">{{ $responsavel->name }}</h6>
                            <small class="text-muted">{{ $responsavel->email }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary rounded-pill">
                                {{ $responsavel->denuncias_responsavel_count }}
                            </span>
                            <small class="d-block text-muted">pendentes</small>
                        </div>
                    </div>
                    @empty
                    <div class="list-group-item text-center text-muted">
                        Nenhum responsável encontrado
                    </div>
                    @endforelse
                </div>
            </x-admin.widget>
        </div>
        
        <div class="col-xl-6">
            <x-admin.widget 
                title="Denúncias Recentes"
                icon="fas fa-list"
                subtitle="Últimas 10 denúncias"
                :refreshable="true"
            >
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Protocolo</th>
                                <th>Título</th>
                                <th>Status</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($denunciasRecentes as $denuncia)
                            <tr>
                                <td>
                                    <a href="{{ route('denuncias.show', $denuncia) }}" class="text-decoration-none">
                                        {{ $denuncia->protocolo }}
                                    </a>
                                </td>
                                <td>{{ Str::limit($denuncia->titulo, 25) }}</td>
                                <td>
                                    <x-admin.status-badge :status="$denuncia->status->nome" />
                                </td>
                                <td>{{ $denuncia->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Nenhuma denúncia recente
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-admin.widget>
        </div>
    </div>
</div>

<!-- Modal de Exportação -->
<div class="modal fade" id="modalExportacao" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Exportar Relatório</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formExportacao">
                    <div class="mb-3">
                        <label for="formato" class="form-label">Formato</label>
                        <select class="form-select" id="formato" name="formato" required>
                            <option value="pdf">PDF com Gráficos</option>
                            <option value="pdf-simple">PDF Simples</option>
                            <option value="excel">Excel</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="incluirGraficos" name="incluir_graficos" checked>
                            <label class="form-check-label" for="incluirGraficos">
                                Incluir gráficos visuais (apenas PDF)
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="periodoExport" class="form-label">Período</label>
                        <select class="form-select" id="periodoExport" name="periodo" required>
                            <option value="7">Últimos 7 dias</option>
                            <option value="30" selected>Últimos 30 dias</option>
                            <option value="90">Últimos 90 dias</option>
                            <option value="180">Últimos 6 meses</option>
                            <option value="365">Último ano</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="confirmarExportacao()">
                    <i class="fas fa-download me-2"></i>Exportar
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Filtros de relatório
document.getElementById('filtrosRelatorio').addEventListener('submit', function(e) {
    e.preventDefault();
    aplicarFiltros();
});

function aplicarFiltros() {
    const formData = new FormData(document.getElementById('filtrosRelatorio'));
    const params = new URLSearchParams(formData);
    
    // Atualizar dados via AJAX
    fetch(`/dashboard/api-dados?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            // Atualizar gráficos e métricas
            atualizarRelatorio(data);
        });
}

function limparFiltros() {
    document.getElementById('filtrosRelatorio').reset();
    aplicarFiltros();
}

function exportarRelatorio() {
    const modal = new bootstrap.Modal(document.getElementById('modalExportacao'));
    modal.show();
}

function confirmarExportacao() {
    const formData = new FormData(document.getElementById('formExportacao'));
    const formato = document.getElementById('formato').value;
    const incluirGraficos = document.getElementById('incluirGraficos').checked;
    
    // Ajustar formato baseado no checkbox
    let tipoFinal = formato;
    if (formato === 'pdf' && !incluirGraficos) {
        tipoFinal = 'pdf-simple';
    } else if (formato === 'pdf-simple' && incluirGraficos) {
        tipoFinal = 'pdf';
    }
    
    // Adicionar parâmetros
    const params = new URLSearchParams(formData);
    params.set('formato', tipoFinal);
    params.set('incluir_graficos', incluirGraficos);
    
    // Redirecionar para download
    window.open(`/dashboard/exportar?${params.toString()}`, '_blank');
    
    // Fechar modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalExportacao'));
    modal.hide();
}

function atualizarRelatorio(data) {
    // Atualizar métricas
    if (data.metrics) {
        // Implementar atualização das métricas
        console.log('Métricas atualizadas:', data.metrics);
    }
    
    // Atualizar gráficos
    if (data.denuncias_por_status && window.charts) {
        Object.keys(window.charts).forEach(chartId => {
            if (chartId.includes('status')) {
                window.charts[chartId].data = data.denuncias_por_status;
                window.charts[chartId].update();
            }
        });
    }
}
</script>
@endpush
@endsection 