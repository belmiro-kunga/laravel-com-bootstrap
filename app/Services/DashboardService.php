<?php

namespace App\Services;

use App\Models\Denuncia;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Status;
use App\Models\AuditLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    /**
     * Obter métricas principais do dashboard
     */
    public function getMainMetrics()
    {
        // Usar cache para melhorar performance
        return Cache::remember('dashboard_main_metrics', now()->addMinutes(15), function () {
            try {
                $now = Carbon::now();
                $lastMonth = $now->copy()->subMonth();
                
                // Total de denúncias - Usar consultas otimizadas
                $totalDenuncias = DB::table('denuncias')->count();
                $denunciasMesAtual = DB::table('denuncias')
                    ->whereMonth('created_at', $now->month)
                    ->whereYear('created_at', $now->year)
                    ->count();
                $denunciasMesAnterior = DB::table('denuncias')
                    ->whereMonth('created_at', $lastMonth->month)
                    ->whereYear('created_at', $lastMonth->year)
                    ->count();
                
                // Calcular tendência
                $tendenciaDenuncias = $denunciasMesAnterior > 0 
                    ? round((($denunciasMesAtual - $denunciasMesAnterior) / $denunciasMesAnterior) * 100, 1)
                    : 0;
                
                // Obter IDs de status em uma única consulta
                $statusMap = DB::table('status')
                    ->whereIn('nome', ['Recebida', 'Em Análise', 'Resolvida'])
                    ->pluck('id', 'nome')
                    ->toArray();
                
                $statusPendentes = array_filter($statusMap, function($key) {
                    return in_array($key, ['Recebida', 'Em Análise']);
                }, ARRAY_FILTER_USE_KEY);
                
                $statusResolvidas = array_filter($statusMap, function($key) {
                    return $key === 'Resolvida';
                }, ARRAY_FILTER_USE_KEY);
                
                // Denúncias pendentes (Recebida e Em Análise)
                $denunciasPendentes = DB::table('denuncias')
                    ->whereIn('status_id', array_values($statusPendentes))
                    ->count();
                
                // Denúncias urgentes
                $denunciasUrgentes = DB::table('denuncias')
                    ->where('urgente', true)
                    ->count();
                
                // Denúncias resolvidas
                $denunciasResolvidas = DB::table('denuncias')
                    ->whereIn('status_id', array_values($statusResolvidas))
                    ->count();
                
                // Usuários ativos
                $usuariosAtivos = DB::table('users')
                    ->where('ativo', true)
                    ->count();
                
                // Tempo médio de resolução (em dias)
                $tempoMedioResolucao = $this->getTempoMedioResolucao();
                
                return [
                    'total_denuncias' => [
                        'value' => $totalDenuncias,
                        'trend' => $tendenciaDenuncias > 0 ? 'positive' : ($tendenciaDenuncias < 0 ? 'negative' : 'neutral'),
                        'trend_value' => abs($tendenciaDenuncias),
                        'trend_label' => 'vs mês anterior'
                    ],
                    'denuncias_pendentes' => [
                        'value' => $denunciasPendentes,
                        'trend' => null
                    ],
                    'denuncias_urgentes' => [
                        'value' => $denunciasUrgentes,
                        'trend' => null
                    ],
                    'denuncias_resolvidas' => [
                        'value' => $denunciasResolvidas,
                        'trend' => null
                    ],
                    'usuarios_ativos' => [
                        'value' => $usuariosAtivos,
                        'trend' => null
                    ],
                    'tempo_medio_resolucao' => [
                        'value' => $tempoMedioResolucao,
                        'trend' => null
                    ]
                ];
            } catch (\Exception $e) {
                return [
                    'total_denuncias' => ['value' => 0, 'trend' => 'neutral', 'trend_value' => 0],
                    'denuncias_pendentes' => ['value' => 0, 'trend' => null],
                    'denuncias_urgentes' => ['value' => 0, 'trend' => null],
                    'denuncias_resolvidas' => ['value' => 0, 'trend' => null],
                    'usuarios_ativos' => ['value' => 0, 'trend' => null],
                    'tempo_medio_resolucao' => ['value' => 0, 'trend' => null]
                ];
            }
        });
    }
    
    /**
     * Obter dados para gráfico de denúncias por status
     */
    public function getDenunciasPorStatus()
    {
        // Usar cache para melhorar performance
        return Cache::remember('dashboard_denuncias_por_status', now()->addMinutes(15), function () {
            try {
                $dados = Status::withCount('denuncias')
                    ->where('ativo', true)
                    ->orderBy('ordem')
                    ->get()
                    ->map(function ($status) {
                        return [
                            'label' => $status->nome,
                            'value' => $status->denuncias_count,
                            'color' => $status->cor
                        ];
                    });
                
                return [
                    'labels' => $dados->pluck('label')->toArray(),
                    'datasets' => [
                        [
                            'data' => $dados->pluck('value')->toArray(),
                            'backgroundColor' => $dados->pluck('color')->toArray(),
                            'borderWidth' => 2,
                            'borderColor' => '#fff'
                        ]
                    ]
                ];
            } catch (\Exception $e) {
                return [
                    'labels' => [],
                    'datasets' => [
                        [
                            'data' => [],
                            'backgroundColor' => [],
                            'borderWidth' => 2,
                            'borderColor' => '#fff'
                        ]
                    ]
                ];
            }
        });
    }
    
    /**
     * Obter dados para gráfico de denúncias por categoria
     */
    public function getDenunciasPorCategoria()
    {
        // Usar cache para melhorar performance
        return Cache::remember('dashboard_denuncias_por_categoria', now()->addMinutes(15), function () {
            try {
                $dados = Categoria::withCount('denuncias')
                    ->where('ativo', true)
                    ->orderBy('ordem')
                    ->limit(10)
                    ->get()
                    ->map(function ($categoria) {
                        return [
                            'label' => $categoria->nome,
                            'value' => $categoria->denuncias_count
                        ];
                    });
                
                return [
                    'labels' => $dados->pluck('label')->toArray(),
                    'datasets' => [
                        [
                            'label' => 'Denúncias',
                            'data' => $dados->pluck('value')->toArray(),
                            'backgroundColor' => 'rgba(78, 115, 223, 0.8)',
                            'borderColor' => 'rgba(78, 115, 223, 1)',
                            'borderWidth' => 2
                        ]
                    ]
                ];
            } catch (\Exception $e) {
                return [
                    'labels' => [],
                    'datasets' => [
                        [
                            'label' => 'Denúncias',
                            'data' => [],
                            'backgroundColor' => 'rgba(78, 115, 223, 0.8)',
                            'borderColor' => 'rgba(78, 115, 223, 1)',
                            'borderWidth' => 2
                        ]
                    ]
                ];
            }
        });
    }
    
    /**
     * Obter dados para gráfico de denúncias por período
     */
    public function getDenunciasPorPeriodo($periodo = 30)
    {
        // Usar cache para melhorar performance
        $cacheKey = "dashboard_denuncias_por_periodo_{$periodo}";
        return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($periodo) {
            try {
                // Usar DB::table para consulta mais eficiente
                $dados = DB::table('denuncias')
                    ->selectRaw('DATE(created_at) as data, COUNT(*) as total')
                    ->where('created_at', '>=', Carbon::now()->subDays($periodo))
                    ->groupBy('data')
                    ->orderBy('data')
                    ->get();
                
                $datas = [];
                $valores = [];
                
                // Pré-calcular todas as datas para evitar processamento em loop
                $dataMap = $dados->pluck('total', 'data')->toArray();
                
                for ($i = $periodo; $i >= 0; $i--) {
                    $data = Carbon::now()->subDays($i)->format('Y-m-d');
                    $datas[] = Carbon::parse($data)->format('d/m');
                    $valores[] = $dataMap[$data] ?? 0;
                }
                
                return [
                    'labels' => $datas,
                    'datasets' => [
                        [
                            'label' => 'Denúncias',
                            'data' => $valores,
                            'backgroundColor' => 'rgba(78, 115, 223, 0.1)',
                            'borderColor' => 'rgba(78, 115, 223, 1)',
                            'borderWidth' => 2,
                            'fill' => true,
                            'tension' => 0.4
                        ]
                    ]
                ];
            } catch (\Exception $e) {
                return [
                    'labels' => [],
                    'datasets' => [
                        [
                            'label' => 'Denúncias',
                            'data' => [],
                            'backgroundColor' => 'rgba(78, 115, 223, 0.1)',
                            'borderColor' => 'rgba(78, 115, 223, 1)',
                            'borderWidth' => 2,
                            'fill' => true,
                            'tension' => 0.4
                        ]
                    ]
                ];
            }
        });
    }
    
    /**
     * Obter tempo médio de resolução em dias
     */
    private function getTempoMedioResolucao()
    {
        // Usar cache para melhorar performance
        return Cache::remember('dashboard_tempo_medio_resolucao', now()->addHours(1), function () {
            try {
                // Usar consulta SQL direta para melhor performance
                $statusResolvida = DB::table('status')->where('nome', 'Resolvida')->first();
                if (!$statusResolvida) return 0;
                
                // Usar SQL para calcular a média diretamente no banco de dados
                $result = DB::select("
                    SELECT AVG(DATEDIFF(updated_at, created_at)) as media_dias
                    FROM denuncias
                    WHERE status_id = ? AND updated_at IS NOT NULL
                ", [$statusResolvida->id]);
                
                if (empty($result) || is_null($result[0]->media_dias)) return 0;
                
                return round($result[0]->media_dias, 1);
            } catch (\Exception $e) {
                \Log::error('Erro ao calcular tempo médio de resolução: ' . $e->getMessage());
                return 0;
            }
        });
    }
    
    /**
     * Obter denúncias recentes
     */
    public function getDenunciasRecentes($limit = 5)
    {
        // Usar cache para melhorar performance
        $cacheKey = "dashboard_denuncias_recentes_{$limit}";
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($limit) {
            try {
                return Denuncia::with(['categoria', 'status', 'responsavel'])
                    ->orderBy('created_at', 'desc')
                    ->limit($limit)
                    ->get();
            } catch (\Exception $e) {
                \Log::error('Erro ao obter denúncias recentes: ' . $e->getMessage());
                return collect();
            }
        });
    }
    
    /**
     * Obter denúncias urgentes
     */
    public function getDenunciasUrgentes($limit = 5)
    {
        // Usar cache para melhorar performance
        $cacheKey = "dashboard_denuncias_urgentes_{$limit}";
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($limit) {
            try {
                return Denuncia::with(['categoria', 'status', 'responsavel'])
                    ->where('urgente', true)
                    ->orderBy('created_at', 'desc')
                    ->limit($limit)
                    ->get();
            } catch (\Exception $e) {
                \Log::error('Erro ao obter denúncias urgentes: ' . $e->getMessage());
                return collect();
            }
        });
    }
    
    /**
     * Obter atividades recentes
     */
    public function getAtividadesRecentes($limit = 10)
    {
        // Usar cache para melhorar performance
        $cacheKey = "dashboard_atividades_recentes_{$limit}";
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($limit) {
            try {
                return AuditLog::with('user')
                    ->orderBy('created_at', 'desc')
                    ->limit($limit)
                    ->get();
            } catch (\Exception $e) {
                \Log::error('Erro ao obter atividades recentes: ' . $e->getMessage());
                return collect();
            }
        });
    }
    
    /**
     * Obter estatísticas por responsável
     */
    public function getEstatisticasPorResponsavel()
    {
        // Usar cache para melhorar performance
        return Cache::remember('dashboard_estatisticas_responsavel', now()->addMinutes(15), function () {
            try {
                // Otimizar a consulta para evitar problema N+1
                // Primeiro, obter os IDs de status em uma única consulta
                $statusIds = DB::table('status')
                    ->whereIn('nome', ['Recebida', 'Em Análise'])
                    ->pluck('id')
                    ->toArray();
                
                return User::withCount(['denunciasResponsavel' => function ($query) use ($statusIds) {
                    $query->whereIn('status_id', $statusIds);
                }])
                ->where('ativo', true)
                ->orderBy('denuncias_responsavel_count', 'desc')
                ->limit(5)
                ->get();
            } catch (\Exception $e) {
                \Log::error('Erro ao obter estatísticas por responsável: ' . $e->getMessage());
                return collect();
            }
        });
    }
} 