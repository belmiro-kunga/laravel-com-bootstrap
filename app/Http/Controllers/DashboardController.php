<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use App\Models\Categoria;
use App\Models\Status;
use App\Models\User;
use App\Services\DashboardService;
use App\Services\DashboardMetricsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    protected $dashboardService;
    protected $metricsService;

    public function __construct(DashboardService $dashboardService, DashboardMetricsService $metricsService)
    {
        $this->dashboardService = $dashboardService;
        $this->metricsService = $metricsService;
    }

    /**
     * Display dashboard principal
     */
    public function index()
    {
        $user = Auth::user();
        
        // Obter métricas principais
        $metrics = $this->dashboardService->getMainMetrics();
        
        // Novas métricas inteligentes
        $intelligentMetrics = $this->metricsService->getGeneralMetrics();
        $statusMetrics = $this->metricsService->getStatusMetrics();
        $responsavelMetrics = $this->metricsService->getResponsavelMetrics();
        $alertsAndRecommendations = $this->metricsService->getAlertsAndRecommendations();
        $trends = $this->metricsService->getTrends();
        
        // Dados para gráficos
        $denunciasPorStatus = $this->dashboardService->getDenunciasPorStatus();
        $denunciasPorCategoria = $this->dashboardService->getDenunciasPorCategoria();
        $denunciasPorPeriodo = $this->dashboardService->getDenunciasPorPeriodo(30);
        
        // Dados adicionais
        $denunciasRecentes = $this->dashboardService->getDenunciasRecentes(5);
        $denunciasUrgentes = $this->dashboardService->getDenunciasUrgentes(5);
        $atividadesRecentes = $this->dashboardService->getAtividadesRecentes(10);
        $estatisticasResponsavel = $this->dashboardService->getEstatisticasPorResponsavel();

        return view('dashboard.index', compact(
            'metrics',
            'intelligentMetrics',
            'statusMetrics',
            'responsavelMetrics',
            'alertsAndRecommendations',
            'trends',
            'denunciasPorStatus',
            'denunciasPorCategoria',
            'denunciasPorPeriodo',
            'denunciasRecentes',
            'denunciasUrgentes',
            'atividadesRecentes',
            'estatisticasResponsavel'
        ));
    }

    /**
     * Relatórios
     */
    public function relatorios(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->podeVerRelatorios()) {
            abort(403, 'Acesso negado.');
        }

        // Obter métricas principais
        $metrics = $this->dashboardService->getMainMetrics();
        
        // Novas métricas inteligentes
        $intelligentMetrics = $this->metricsService->getGeneralMetrics();
        $statusMetrics = $this->metricsService->getStatusMetrics();
        $responsavelMetrics = $this->metricsService->getResponsavelMetrics();
        $alertsAndRecommendations = $this->metricsService->getAlertsAndRecommendations();
        $trends = $this->metricsService->getTrends();

        // Dados para gráficos
        $denunciasPorStatus = $this->dashboardService->getDenunciasPorStatus();
        $denunciasPorCategoria = $this->dashboardService->getDenunciasPorCategoria();
        $denunciasPorPeriodo = $this->dashboardService->getDenunciasPorPeriodo(90);
        
        // Dados adicionais
        $denunciasRecentes = $this->dashboardService->getDenunciasRecentes(10);
        $estatisticasResponsavel = $this->dashboardService->getEstatisticasPorResponsavel();

        return view('dashboard.relatorios', compact(
            'metrics',
            'intelligentMetrics',
            'statusMetrics',
            'responsavelMetrics',
            'alertsAndRecommendations',
            'trends',
            'denunciasPorStatus',
            'denunciasPorCategoria',
            'denunciasPorPeriodo',
            'denunciasRecentes',
            'estatisticasResponsavel'
        ));
    }

    /**
     * Exportar relatório
     */
    public function exportarRelatorio(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->podeVerRelatorios()) {
            abort(403, 'Acesso negado.');
        }

        $tipo = $request->get('formato', 'pdf');
        $periodo = $request->get('periodo', 30);
        $incluirGraficos = $request->boolean('incluir_graficos', true);
        
        // Obter dados para exportação
        $metrics = $this->dashboardService->getMainMetrics();
        $intelligentMetrics = $this->metricsService->getGeneralMetrics();
        $statusMetrics = $this->metricsService->getStatusMetrics();
        $responsavelMetrics = $this->metricsService->getResponsavelMetrics();
        $alertsAndRecommendations = $this->metricsService->getAlertsAndRecommendations();
        $trends = $this->metricsService->getTrends();
        
        $denunciasPorStatus = $this->dashboardService->getDenunciasPorStatus();
        $denunciasPorCategoria = $this->dashboardService->getDenunciasPorCategoria();
        $denunciasPorPeriodo = $this->dashboardService->getDenunciasPorPeriodo($periodo);
        
        if ($tipo === 'pdf' || $tipo === 'pdf-simple') {
            return $this->exportarPDF($metrics, $intelligentMetrics, $statusMetrics, $responsavelMetrics, $alertsAndRecommendations, $trends, $denunciasPorStatus, $denunciasPorCategoria, $denunciasPorPeriodo, $incluirGraficos);
        } else {
            return $this->exportarExcel($metrics, $intelligentMetrics, $statusMetrics, $responsavelMetrics, $alertsAndRecommendations, $trends, $denunciasPorStatus, $denunciasPorCategoria, $denunciasPorPeriodo);
        }
    }

    /**
     * Exportar PDF
     */
    private function exportarPDF($metrics, $intelligentMetrics, $statusMetrics, $responsavelMetrics, $alertsAndRecommendations, $trends, $denunciasPorStatus, $denunciasPorCategoria, $denunciasPorPeriodo, $incluirGraficos = true)
    {
        // Verificar se a extensão GD está disponível
        if (!extension_loaded('gd')) {
            \Log::warning('Extensão GD não disponível, gerando PDF sem gráficos');
            $incluirGraficos = false;
        }
        
        // Gerar gráficos base64 apenas se solicitado e se GD estiver disponível
        $statusChart = null;
        $trendsChart = null;
        $responsavelChart = null;
        
        if ($incluirGraficos && extension_loaded('gd')) {
            try {
                $statusChart = $this->generateStatusChart($statusMetrics);
                $trendsChart = $this->generateTrendsChart($trends);
                $responsavelChart = $this->generateResponsavelChart($responsavelMetrics);
            } catch (\Exception $e) {
                \Log::error('Erro ao gerar gráficos: ' . $e->getMessage());
                $incluirGraficos = false;
            }
        }

        $data = compact(
            'metrics',
            'intelligentMetrics',
            'statusMetrics',
            'responsavelMetrics',
            'alertsAndRecommendations',
            'trends',
            'denunciasPorStatus',
            'denunciasPorCategoria',
            'denunciasPorPeriodo',
            'statusChart',
            'trendsChart',
            'responsavelChart',
            'incluirGraficos'
        );
        
        try {
            $pdf = Pdf::loadView('dashboard.pdf', $data)->setPaper('a4', 'portrait');
            return $pdf->download('relatorio-dashboard-'.now()->format('Ymd_His').'.pdf');
        } catch (\Exception $e) {
            \Log::error('Erro ao gerar PDF: ' . $e->getMessage());
            
            // Fallback: retornar JSON com os dados
            return response()->json([
                'error' => 'Erro ao gerar PDF',
                'message' => $e->getMessage(),
                'data' => $data
            ], 500);
        }
    }

    /**
     * Gerar gráfico de pizza para status
     */
    private function generateStatusChart($statusMetrics)
    {
        $labels = [];
        $data = [];
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];

        foreach ($statusMetrics as $index => $status) {
            $labels[] = $status['status'];
            $data[] = $status['count'];
        }

        $chartConfig = [
            'type' => 'pie',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'data' => $data,
                    'backgroundColor' => array_slice($colors, 0, count($data))
                ]]
            ],
            'options' => [
                'title' => [
                    'display' => true,
                    'text' => 'Distribuição por Status'
                ],
                'legend' => [
                    'position' => 'bottom'
                ]
            ]
        ];

        return $this->generateChartImage($chartConfig);
    }

    /**
     * Gerar gráfico de barras para tendências
     */
    private function generateTrendsChart($trends)
    {
        $labels = [];
        $data = [];

        foreach ($trends as $trend) {
            $labels[] = $trend['date'];
            $data[] = $trend['count'];
        }

        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => 'Denúncias',
                    'data' => $data,
                    'borderColor' => '#36A2EB',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.1)',
                    'fill' => true
                ]]
            ],
            'options' => [
                'title' => [
                    'display' => true,
                    'text' => 'Tendência dos Últimos 30 Dias'
                ],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true
                    ]
                ]
            ]
        ];

        return $this->generateChartImage($chartConfig);
    }

    /**
     * Gerar gráfico de barras para responsáveis
     */
    private function generateResponsavelChart($responsavelMetrics)
    {
        $labels = [];
        $data = [];

        foreach ($responsavelMetrics as $resp) {
            $labels[] = $resp['user'];
            $data[] = $resp['denuncias_ativas'];
        }

        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => 'Denúncias Ativas',
                    'data' => $data,
                    'backgroundColor' => '#FF6384'
                ]]
            ],
            'options' => [
                'title' => [
                    'display' => true,
                    'text' => 'Carga de Trabalho por Responsável'
                ],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true
                    ]
                ]
            ]
        ];

        return $this->generateChartImage($chartConfig);
    }

    /**
     * Gerar imagem do gráfico usando QuickChart API
     */
    private function generateChartImage($chartConfig)
    {
        try {
            // Usar cURL em vez de file_get_contents para melhor controle
            $ch = curl_init();
            $chartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig)) . '&width=500&height=300';
            
            curl_setopt($ch, CURLOPT_URL, $chartUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Laravel-Dashboard/1.0');
            
            $imageData = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode === 200 && $imageData && strlen($imageData) > 100) {
                return 'data:image/png;base64,' . base64_encode($imageData);
            }
            
            // Log do erro para debug
            \Log::warning('Falha ao gerar gráfico', [
                'http_code' => $httpCode,
                'data_length' => strlen($imageData ?? ''),
                'chart_config' => $chartConfig
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Erro ao gerar gráfico: ' . $e->getMessage());
        }
        
        return null;
    }

    /**
     * Exportar Excel
     */
    private function exportarExcel($metrics, $intelligentMetrics, $statusMetrics, $responsavelMetrics, $alertsAndRecommendations, $trends, $denunciasPorStatus, $denunciasPorCategoria, $denunciasPorPeriodo)
    {
        // Implementar exportação Excel
        // Por enquanto, retornar JSON
        return response()->json([
            'metrics' => $metrics,
            'intelligent_metrics' => $intelligentMetrics,
            'status_metrics' => $statusMetrics,
            'responsavel_metrics' => $responsavelMetrics,
            'alerts_and_recommendations' => $alertsAndRecommendations,
            'trends' => $trends,
            'denuncias_por_status' => $denunciasPorStatus,
            'denuncias_por_categoria' => $denunciasPorCategoria,
            'denuncias_por_periodo' => $denunciasPorPeriodo
        ]);
    }

    /**
     * API para dados do dashboard (AJAX)
     */
    public function apiDados(Request $request)
    {
        $user = Auth::user();
        
        $tipo = $request->get('tipo', 'metrics');
        
        switch ($tipo) {
            case 'metrics':
                $dados = $this->dashboardService->getMainMetrics();
                break;
            case 'intelligent_metrics':
                $dados = $this->metricsService->getGeneralMetrics();
                break;
            case 'status_metrics':
                $dados = $this->metricsService->getStatusMetrics();
                break;
            case 'responsavel_metrics':
                $dados = $this->metricsService->getResponsavelMetrics();
                break;
            case 'alerts':
                $dados = $this->metricsService->getAlertsAndRecommendations();
                break;
            case 'trends':
                $dados = $this->metricsService->getTrends();
                break;
            case 'status':
                $dados = $this->dashboardService->getDenunciasPorStatus();
                break;
            case 'categoria':
                $dados = $this->dashboardService->getDenunciasPorCategoria();
                break;
            case 'periodo':
                $periodo = $request->get('periodo', 30);
                $dados = $this->dashboardService->getDenunciasPorPeriodo($periodo);
                break;
            case 'recentes':
                $dados = $this->dashboardService->getDenunciasRecentes(5);
                break;
            case 'urgentes':
                $dados = $this->dashboardService->getDenunciasUrgentes(5);
                break;
            default:
                $dados = [];
        }
        
        return response()->json($dados);
    }
}
