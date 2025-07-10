@extends('layouts.app')

@section('title', 'Dashboard de Auditoria')

@section('content')
<div class="container-fluid">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-chart-bar text-primary"></i>
                Dashboard de Auditoria
            </h1>
            <p class="text-muted">Visão geral das atividades do sistema</p>
        </div>
        <div>
            <a href="{{ route('audit.index') }}" class="btn btn-primary">
                <i class="fas fa-list"></i> Ver Todos os Logs
            </a>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total de Logs</h6>
                            <h3 class="mb-0">{{ number_format($stats['total_logs']) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-history fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Logs Hoje</h6>
                            <h3 class="mb-0">{{ number_format($stats['today_logs']) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-day fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Usuários Únicos</h6>
                            <h3 class="mb-0">{{ number_format($stats['unique_users']) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">IPs Únicos</h6>
                            <h3 class="mb-0">{{ number_format($stats['unique_ips']) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-network-wired fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gráfico de Eventos por Dia -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line"></i> Atividade dos Últimos 30 Dias
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="eventsChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Eventos -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-trophy"></i> Top Eventos
                    </h5>
                </div>
                <div class="card-body">
                    @if($topEvents->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($topEvents as $event)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($event->event) }}
                                        </span>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">{{ $event->count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Nenhum evento registrado.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Top Usuários -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-chart"></i> Usuários Mais Ativos
                    </h5>
                </div>
                <div class="card-body">
                    @if($topUsers->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($topUsers as $userLog)
                                @if($userLog->user)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                                {{ substr($userLog->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $userLog->user->name }}</div>
                                                <small class="text-muted">{{ $userLog->user->email }}</small>
                                            </div>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">{{ $userLog->count }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Nenhum usuário registrado.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Logs Recentes -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-clock"></i> Logs Recentes
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentLogs->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentLogs as $log)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-1">
                                                <span class="badge bg-secondary me-2">
                                                    <i class="{{ $log->event_icon }}"></i>
                                                    {{ $log->event_label }}
                                                </span>
                                                <small class="text-muted">{{ $log->time_ago }}</small>
                                            </div>
                                            <div class="text-truncate" style="max-width: 300px;" title="{{ $log->description }}">
                                                {{ $log->description }}
                                            </div>
                                            @if($log->user)
                                                <small class="text-muted">
                                                    <i class="fas fa-user"></i> {{ $log->user->name }}
                                                </small>
                                            @endif
                                        </div>
                                        <a href="{{ route('audit.show', $log) }}" class="btn btn-sm btn-outline-primary ms-2">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('audit.index') }}" class="btn btn-outline-primary">
                                Ver Todos os Logs
                            </a>
                        </div>
                    @else
                        <p class="text-muted">Nenhum log recente encontrado.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 14px;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dados para o gráfico
    const chartData = @json($eventsByDay);
    
    // Preparar dados para o Chart.js
    const labels = [];
    const datasets = {};
    
    // Processar dados
    Object.keys(chartData).forEach(date => {
        labels.push(new Date(date).toLocaleDateString('pt-BR'));
        
        chartData[date].forEach(event => {
            if (!datasets[event.event]) {
                datasets[event.event] = {
                    label: event.event.charAt(0).toUpperCase() + event.event.slice(1),
                    data: [],
                    borderColor: getRandomColor(),
                    backgroundColor: getRandomColor(0.2),
                    tension: 0.1
                };
            }
        });
    });
    
    // Preencher dados
    labels.forEach((label, index) => {
        Object.keys(datasets).forEach(event => {
            const eventData = chartData[Object.keys(chartData)[index]];
            const found = eventData.find(e => e.event === event);
            datasets[event].data.push(found ? found.count : 0);
        });
    });
    
    // Criar gráfico
    const ctx = document.getElementById('eventsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: Object.values(datasets)
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Atividade por Dia'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});

function getRandomColor(alpha = 1) {
    const colors = [
        'rgba(255, 99, 132, ' + alpha + ')',
        'rgba(54, 162, 235, ' + alpha + ')',
        'rgba(255, 206, 86, ' + alpha + ')',
        'rgba(75, 192, 192, ' + alpha + ')',
        'rgba(153, 102, 255, ' + alpha + ')',
        'rgba(255, 159, 64, ' + alpha + ')',
        'rgba(199, 199, 199, ' + alpha + ')',
        'rgba(83, 102, 255, ' + alpha + ')',
        'rgba(78, 252, 3, ' + alpha + ')',
        'rgba(252, 3, 244, ' + alpha + ')'
    ];
    return colors[Math.floor(Math.random() * colors.length)];
}
</script>
@endsection 