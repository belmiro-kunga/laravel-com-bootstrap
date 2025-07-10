@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Denúncias')

@section('page-title', 'Dashboard')

@section('breadcrumb')
    <x-admin.breadcrumb :items="[
        ['title' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt']
    ]" />
@endsection

@section('content')
<div class="container-fluid">
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
        <div class="col-xl-8 col-lg-7">
            <x-admin.chart-card 
                title="Denúncias por Período"
                subtitle="Últimos 30 dias"
                type="line"
                :data="$denunciasPorPeriodo"
                height="350px"
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
        
        <div class="col-xl-4 col-lg-5">
            <x-admin.chart-card 
                title="Denúncias por Status"
                subtitle="Distribuição atual"
                type="doughnut"
                :data="$denunciasPorStatus"
                height="350px"
                :options="[
                    'plugins' => [
                        'legend' => ['position' => 'bottom']
                    ]
                ]"
            />
        </div>
    </div>

    <!-- Widgets Adicionais -->
    <div class="row mb-4">
        <div class="col-xl-6 col-lg-6">
            <x-admin.widget 
                title="Denúncias Recentes"
                icon="fas fa-list"
                :refreshable="true"
                :collapsible="true"
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
                                <td>{{ Str::limit($denuncia->titulo, 30) }}</td>
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
        
        <div class="col-xl-6 col-lg-6">
            <x-admin.widget 
                title="Denúncias Urgentes"
                icon="fas fa-exclamation-triangle"
                variant="danger"
                :refreshable="true"
                :collapsible="true"
            >
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Protocolo</th>
                                <th>Título</th>
                                <th>Responsável</th>
                                <th>Prioridade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($denunciasUrgentes as $denuncia)
                            <tr>
                                <td>
                                    <a href="{{ route('denuncias.show', $denuncia) }}" class="text-decoration-none">
                                        {{ $denuncia->protocolo }}
                                    </a>
                                </td>
                                <td>{{ Str::limit($denuncia->titulo, 25) }}</td>
                                <td>
                                    @if($denuncia->responsavel)
                                        {{ $denuncia->responsavel->name }}
                                    @else
                                        <span class="text-muted">Não atribuído</span>
                                    @endif
                                </td>
                                <td>
                                    <x-admin.status-badge :status="$denuncia->prioridade" />
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Nenhuma denúncia urgente
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-admin.widget>
        </div>
    </div>

    <!-- Estatísticas por Responsável -->
    <div class="row mb-4">
        <div class="col-xl-6">
            <x-admin.chart-card 
                title="Denúncias por Categoria"
                subtitle="Últimos 30 dias"
                type="bar"
                :data="$denunciasPorCategoria"
                height="300px"
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
        
        <div class="col-xl-6">
            <x-admin.widget 
                title="Top Responsáveis"
                icon="fas fa-users"
                subtitle="Por denúncias pendentes"
            >
                <div class="list-group list-group-flush">
                    @forelse($estatisticasResponsavel as $responsavel)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">{{ $responsavel->name }}</h6>
                            <small class="text-muted">{{ $responsavel->email }}</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">
                            {{ $responsavel->denuncias_responsavel_count }}
                        </span>
                    </div>
                    @empty
                    <div class="list-group-item text-center text-muted">
                        Nenhum responsável encontrado
                    </div>
                    @endforelse
                </div>
            </x-admin.widget>
        </div>
    </div>

    <!-- Atividades Recentes -->
    <div class="row">
        <div class="col-12">
            <x-admin.widget 
                title="Atividades Recentes"
                icon="fas fa-history"
                subtitle="Últimas atividades do sistema"
                :refreshable="true"
            >
                <div class="timeline">
                    @forelse($atividadesRecentes as $atividade)
                    <div class="timeline-item">
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>{{ $atividade->action }}</strong>
                                    <p class="mb-0 text-muted">{{ $atividade->description }}</p>
                                </div>
                                <small class="text-muted">{{ $atividade->created_at->diffForHumans() }}</small>
                            </div>
                            @if($atividade->user)
                            <small class="text-muted">
                                Por: {{ $atividade->user->name }}
                            </small>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        Nenhuma atividade recente
                    </div>
                    @endforelse
                </div>
            </x-admin.widget>
        </div>
    </div>
</div>

<!-- Scripts para atualização automática -->
@push('scripts')
<script>
// Atualizar dados do dashboard a cada 5 minutos
setInterval(function() {
    atualizarDashboard();
}, 300000);

function atualizarDashboard() {
    // Atualizar métricas
    fetch('/dashboard/api-dados?tipo=metrics')
        .then(response => response.json())
        .then(data => {
            // Atualizar cards de métricas
            atualizarMetricas(data);
        });
    
    // Atualizar gráficos
    fetch('/dashboard/api-dados?tipo=status')
        .then(response => response.json())
        .then(data => {
            if (window.charts && window.charts['chart-status']) {
                window.charts['chart-status'].data = data;
                window.charts['chart-status'].update();
            }
        });
}

function atualizarMetricas(data) {
    // Implementar atualização das métricas
    console.log('Métricas atualizadas:', data);
}
</script>
@endpush
@endsection 