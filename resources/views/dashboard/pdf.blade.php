<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório do Dashboard</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        h1, h2, h3 { color: #1a237e; margin-bottom: 0.5em; }
        .metrics { display: flex; flex-wrap: wrap; gap: 16px; margin-bottom: 24px; }
        .metric-card { background: #f5f5f5; border-radius: 8px; padding: 16px; min-width: 160px; box-shadow: 0 1px 2px #eee; }
        .metric-title { font-size: 13px; color: #555; }
        .metric-value { font-size: 22px; font-weight: bold; color: #1a237e; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        th, td { border: 1px solid #bbb; padding: 6px 8px; text-align: left; }
        th { background: #e3e6f3; }
        .alert { padding: 8px 12px; border-radius: 4px; margin-bottom: 8px; }
        .alert-danger { background: #ffebee; color: #b71c1c; }
        .alert-warning { background: #fffde7; color: #f57c00; }
        .alert-info { background: #e3f2fd; color: #1565c0; }
        .section { margin-bottom: 32px; }
        .chart-img { display: block; margin: 0 auto 16px auto; max-width: 400px; }
    </style>
</head>
<body>
    <h1>Relatório do Dashboard</h1>
    <p>Gerado em: {{ now()->format('d/m/Y H:i') }}</p>

    <div class="section">
        <h2>Métricas Gerais</h2>
        <div class="metrics">
            <div class="metric-card">
                <div class="metric-title">Total de Denúncias</div>
                <div class="metric-value">{{ $intelligentMetrics['total_denuncias'] ?? '-' }}</div>
            </div>
            <div class="metric-card">
                <div class="metric-title">Denúncias Hoje</div>
                <div class="metric-value">{{ $intelligentMetrics['denuncias_hoje'] ?? '-' }}</div>
            </div>
            <div class="metric-card">
                <div class="metric-title">Urgentes</div>
                <div class="metric-value">{{ $intelligentMetrics['denuncias_urgentes'] ?? '-' }}</div>
            </div>
            <div class="metric-card">
                <div class="metric-title">Atrasadas</div>
                <div class="metric-value">{{ $intelligentMetrics['denuncias_atrasadas'] ?? '-' }}</div>
            </div>
            <div class="metric-card">
                <div class="metric-title">Taxa de Crescimento</div>
                <div class="metric-value">{{ $intelligentMetrics['taxa_crescimento'] ?? '-' }}%</div>
            </div>
            <div class="metric-card">
                <div class="metric-title">Tempo Médio de Resolução</div>
                <div class="metric-value">{{ $intelligentMetrics['tempo_medio_resolucao'] ?? '-' }} dias</div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Status das Denúncias</h2>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Quantidade</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statusMetrics as $status)
                <tr>
                    <td>{{ $status['status'] }}</td>
                    <td>{{ $status['count'] }}</td>
                    <td>{{ $status['percentage'] }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Performance dos Responsáveis</h2>
        <table>
            <thead>
                <tr>
                    <th>Responsável</th>
                    <th>Ativas</th>
                    <th>Resolvidas</th>
                    <th>Taxa de Resolução</th>
                    <th>Carga de Trabalho</th>
                </tr>
            </thead>
            <tbody>
                @foreach($responsavelMetrics as $resp)
                <tr>
                    <td>{{ $resp['user'] }}</td>
                    <td>{{ $resp['denuncias_ativas'] }}</td>
                    <td>{{ $resp['denuncias_resolvidas'] }}</td>
                    <td>{{ $resp['taxa_resolucao'] }}%</td>
                    <td>{{ $resp['carga_trabalho']['level'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Alertas e Recomendações</h2>
        @foreach($alertsAndRecommendations['alerts'] as $alert)
            <div class="alert alert-{{ $alert['type'] }}">
                <strong><i class="{{ $alert['icon'] }}"></i> {{ $alert['message'] }}</strong>
            </div>
        @endforeach
        @foreach($alertsAndRecommendations['recommendations'] as $rec)
            <div class="alert alert-{{ $rec['type'] }}">
                <strong><i class="{{ $rec['icon'] }}"></i> {{ $rec['message'] }}</strong>
            </div>
        @endforeach
    </div>

    <div class="section">
        <h2>Tendência dos Últimos 30 Dias</h2>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Denúncias</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trends as $trend)
                <tr>
                    <td>{{ $trend['date'] }}</td>
                    <td>{{ $trend['count'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Gráficos -->
    @if($incluirGraficos)
    <div class="charts-section" style="margin-top: 30px;">
        <h3 style="color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; margin-bottom: 20px;">
            📊 Gráficos e Visualizações
        </h3>

        <!-- Gráfico de Status -->
        @if($statusChart)
        <div class="chart-container" style="margin-bottom: 30px; text-align: center;">
            <h4 style="color: #34495e; margin-bottom: 15px;">Distribuição por Status</h4>
            <img src="{{ $statusChart }}" alt="Gráfico de Status" style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 8px;">
        </div>
        @endif

        <!-- Gráfico de Tendências -->
        @if($trendsChart)
        <div class="chart-container" style="margin-bottom: 30px; text-align: center;">
            <h4 style="color: #34495e; margin-bottom: 15px;">Tendência dos Últimos 30 Dias</h4>
            <img src="{{ $trendsChart }}" alt="Gráfico de Tendências" style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 8px;">
        </div>
        @endif

        <!-- Gráfico de Responsáveis -->
        @if($responsavelChart)
        <div class="chart-container" style="margin-bottom: 30px; text-align: center;">
            <h4 style="color: #34495e; margin-bottom: 15px;">Carga de Trabalho por Responsável</h4>
            <img src="{{ $responsavelChart }}" alt="Gráfico de Responsáveis" style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 8px;">
        </div>
        @endif
    </div>
    @endif

    <!-- Tabelas Detalhadas -->
    <div class="tables-section" style="margin-top: 30px;">
        <h3 style="color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; margin-bottom: 20px;">
            📋 Tabelas Detalhadas
        </h3>

        <h4 style="color: #34495e; margin-bottom: 15px;">Status das Denúncias</h4>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Quantidade</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statusMetrics as $status)
                <tr>
                    <td>{{ $status['status'] }}</td>
                    <td>{{ $status['count'] }}</td>
                    <td>{{ $status['percentage'] }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h4 style="color: #34495e; margin-bottom: 15px;">Performance dos Responsáveis</h4>
        <table>
            <thead>
                <tr>
                    <th>Responsável</th>
                    <th>Ativas</th>
                    <th>Resolvidas</th>
                    <th>Taxa de Resolução</th>
                    <th>Carga de Trabalho</th>
                </tr>
            </thead>
            <tbody>
                @foreach($responsavelMetrics as $resp)
                <tr>
                    <td>{{ $resp['user'] }}</td>
                    <td>{{ $resp['denuncias_ativas'] }}</td>
                    <td>{{ $resp['denuncias_resolvidas'] }}</td>
                    <td>{{ $resp['taxa_resolucao'] }}%</td>
                    <td>{{ $resp['carga_trabalho']['level'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <footer style="margin-top: 32px; text-align: center; color: #888; font-size: 11px;">
        Relatório gerado automaticamente pelo Sistema de Denúncias - {{ now()->format('d/m/Y H:i') }}
    </footer>
</body>
</html> 