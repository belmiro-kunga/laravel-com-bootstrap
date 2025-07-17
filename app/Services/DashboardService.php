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
        try {
            $now = Carbon::now();
            $lastMonth = $now->copy()->subMonth();
            
            // Total de denúncias
            $totalDenuncias = Denuncia::count();
            $denunciasMesAtual = Denuncia::whereMonth('created_at', $now->month)->count();
            $denunciasMesAnterior = Denuncia::whereMonth('created_at', $lastMonth->month)->count();
            
            // Calcular tendência
            $tendenciaDenuncias = $denunciasMesAnterior > 0 
                ? round((($denunciasMesAtual - $denunciasMesAnterior) / $denunciasMesAnterior) * 100, 1)
                : 0;
            
            // Denúncias pendentes (Recebida e Em Análise)
            $statusPendentes = Status::whereIn('nome', ['Recebida', 'Em Análise'])->pluck('id');
            $denunciasPendentes = Denuncia::whereIn('status_id', $statusPendentes)->count();
            
            // Denúncias urgentes
            $denunciasUrgentes = Denuncia::where('urgente', true)->count();
            
            // Denúncias resolvidas
            $statusResolvidas = Status::whereIn('nome', ['Resolvida'])->pluck('id');
            $denunciasResolvidas = Denuncia::whereIn('status_id', $statusResolvidas)->count();
            
            // Usuários ativos
            $usuariosAtivos = User::where('ativo', true)->count();
            
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
    }
    
    /**
     * Obter dados para gráfico de denúncias por status
     */
    public function getDenunciasPorStatus()
    {
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
    }
    
    /**
     * Obter dados para gráfico de denúncias por categoria
     */
    public function getDenunciasPorCategoria()
    {
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
    }
    
    /**
     * Obter dados para gráfico de denúncias por período
     */
    public function getDenunciasPorPeriodo($periodo = 30)
    {
        try {
            $dados = Denuncia::selectRaw('DATE(created_at) as data, COUNT(*) as total')
                ->where('created_at', '>=', Carbon::now()->subDays($periodo))
                ->groupBy('data')
                ->orderBy('data')
                ->get();
            
            $datas = [];
            $valores = [];
            
            for ($i = $periodo; $i >= 0; $i--) {
                $data = Carbon::now()->subDays($i)->format('Y-m-d');
                $datas[] = Carbon::parse($data)->format('d/m');
                $valor = $dados->where('data', $data)->first();
                $valores[] = $valor ? $valor->total : 0;
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
    }
    
    /**
     * Obter tempo médio de resolução em dias
     */
    private function getTempoMedioResolucao()
    {
        try {
            $statusResolvida = Status::where('nome', 'Resolvida')->first();
            if (!$statusResolvida) return 0;
            
            $denunciasResolvidas = Denuncia::where('status_id', $statusResolvida->id)
                ->whereNotNull('updated_at')
                ->get();
            
            if ($denunciasResolvidas->isEmpty()) return 0;
            
            $totalDias = 0;
            foreach ($denunciasResolvidas as $denuncia) {
                $totalDias += $denuncia->created_at->diffInDays($denuncia->updated_at);
            }
            
            return round($totalDias / $denunciasResolvidas->count(), 1);
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    /**
     * Obter denúncias recentes
     */
    public function getDenunciasRecentes($limit = 5)
    {
        try {
            return Denuncia::with(['categoria', 'status', 'responsavel'])
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }
    
    /**
     * Obter denúncias urgentes
     */
    public function getDenunciasUrgentes($limit = 5)
    {
        try {
            return Denuncia::with(['categoria', 'status', 'responsavel'])
                ->where('urgente', true)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }
    
    /**
     * Obter atividades recentes
     */
    public function getAtividadesRecentes($limit = 10)
    {
        try {
            return AuditLog::with('user')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }
    
    /**
     * Obter estatísticas por responsável
     */
    public function getEstatisticasPorResponsavel()
    {
        try {
            return User::withCount(['denunciasResponsavel' => function ($query) {
                $query->whereIn('status_id', Status::whereIn('nome', ['Recebida', 'Em Análise'])->pluck('id'));
            }])
            ->where('ativo', true)
            ->orderBy('denuncias_responsavel_count', 'desc')
            ->limit(5)
            ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }
} 