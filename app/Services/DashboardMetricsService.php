<?php

namespace App\Services;

use App\Models\Denuncia;
use App\Models\User;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardMetricsService
{
    /**
     * Obter métricas gerais do dashboard
     */
    public function getGeneralMetrics()
    {
        $totalDenuncias = Denuncia::count();
        $denunciasHoje = Denuncia::whereDate('created_at', today())->count();
        $denunciasUrgentes = Denuncia::urgentes()->count();
        $denunciasAtrasadas = Denuncia::atrasadas()->count();

        return [
            'total_denuncias' => $totalDenuncias,
            'denuncias_hoje' => $denunciasHoje,
            'denuncias_urgentes' => $denunciasUrgentes,
            'denuncias_atrasadas' => $denunciasAtrasadas,
            'taxa_crescimento' => $this->calculateGrowthRate(),
            'tempo_medio_resolucao' => $this->getAverageResolutionTime(),
            'satisfacao_media' => $this->getAverageSatisfaction(),
        ];
    }

    /**
     * Obter métricas por status
     */
    public function getStatusMetrics()
    {
        $statusMetrics = Status::withCount(['denuncias' => function($query) {
            $query->whereNotIn('status_id', Status::finalizadores()->pluck('id'));
        }])->get();

        return $statusMetrics->map(function($status) {
            return [
                'status' => $status->nome,
                'count' => $status->denuncias_count,
                'percentage' => $this->calculatePercentage($status->denuncias_count),
                'color' => $status->cor ?? 'secondary'
            ];
        });
    }

    /**
     * Obter métricas de performance por responsável
     */
    public function getResponsavelMetrics()
    {
        $responsaveis = User::responsaveis()
            ->withCount(['denuncias' => function($query) {
                $query->whereNotIn('status_id', Status::finalizadores()->pluck('id'));
            }])
            ->withCount(['denuncias as resolvidas_count' => function($query) {
                $query->whereIn('status_id', Status::finalizadores()->pluck('id'));
            }])
            ->get();

        return $responsaveis->map(function($user) {
            $total = $user->denuncias_count + $user->resolvidas_count;
            $taxaResolucao = $total > 0 ? round(($user->resolvidas_count / $total) * 100, 1) : 0;

            return [
                'user' => $user->name,
                'denuncias_ativas' => $user->denuncias_count,
                'denuncias_resolvidas' => $user->resolvidas_count,
                'taxa_resolucao' => $taxaResolucao,
                'carga_trabalho' => $this->getWorkloadLevel($user->denuncias_count)
            ];
        });
    }

    /**
     * Obter alertas e recomendações
     */
    public function getAlertsAndRecommendations()
    {
        $alerts = [];
        $recommendations = [];

        // Alertas - buscar denúncias muito atrasadas
        $denunciasMuitoAtrasadas = Denuncia::atrasadas()
            ->where('data_limite', '<', now()->subDays(7))
            ->count();
        if ($denunciasMuitoAtrasadas > 0) {
            $alerts[] = [
                'type' => 'danger',
                'message' => "{$denunciasMuitoAtrasadas} denúncia(s) muito atrasada(s) (>7 dias)",
                'icon' => 'fas fa-exclamation-triangle'
            ];
        }

        $denunciasSemResponsavel = Denuncia::semResponsavel()->count();
        if ($denunciasSemResponsavel > 5) {
            $alerts[] = [
                'type' => 'warning',
                'message' => "{$denunciasSemResponsavel} denúncia(s) sem responsável atribuído",
                'icon' => 'fas fa-user-times'
            ];
        }

        $denunciasUrgentes = Denuncia::urgentes()->count();
        if ($denunciasUrgentes > 10) {
            $alerts[] = [
                'type' => 'warning',
                'message' => "{$denunciasUrgentes} denúncia(s) marcada(s) como urgente",
                'icon' => 'fas fa-bolt'
            ];
        }

        // Recomendações
        $responsaveisSobrecarregados = User::responsaveis()
            ->withCount(['denuncias' => function($query) {
                $query->whereNotIn('status_id', Status::finalizadores()->pluck('id'));
            }])
            ->having('denuncias_count', '>', 10)
            ->get();

        if ($responsaveisSobrecarregados->count() > 0) {
            $recommendations[] = [
                'type' => 'info',
                'message' => 'Considere redistribuir denúncias entre responsáveis',
                'icon' => 'fas fa-balance-scale'
            ];
        }

        $tempoMedioAlto = $this->getAverageResolutionTime();
        if ($tempoMedioAlto > 30) {
            $recommendations[] = [
                'type' => 'info',
                'message' => 'Tempo médio de resolução está alto. Revise processos.',
                'icon' => 'fas fa-clock'
            ];
        }

        return [
            'alerts' => $alerts,
            'recommendations' => $recommendations
        ];
    }

    /**
     * Obter tendências dos últimos 30 dias
     */
    public function getTrends()
    {
        $trends = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = Denuncia::whereDate('created_at', $date)->count();
            
            $trends[] = [
                'date' => $date->format('d/m'),
                'count' => $count
            ];
        }

        return $trends;
    }

    /**
     * Calcular taxa de crescimento
     */
    private function calculateGrowthRate()
    {
        $hoje = Denuncia::whereDate('created_at', today())->count();
        $ontem = Denuncia::whereDate('created_at', today()->subDay())->count();
        
        if ($ontem == 0) return $hoje > 0 ? 100 : 0;
        
        return round((($hoje - $ontem) / $ontem) * 100, 1);
    }

    /**
     * Calcular tempo médio de resolução
     */
    private function getAverageResolutionTime()
    {
        $denunciasResolvidas = Denuncia::whereIn('status_id', Status::finalizadores()->pluck('id'))
            ->whereNotNull('updated_at')
            ->get();

        if ($denunciasResolvidas->isEmpty()) return 0;

        $totalDias = $denunciasResolvidas->sum(function($denuncia) {
            return $denuncia->created_at->diffInDays($denuncia->updated_at);
        });

        return round($totalDias / $denunciasResolvidas->count(), 1);
    }

    /**
     * Calcular satisfação média (placeholder para futuras implementações)
     */
    private function getAverageSatisfaction()
    {
        // Placeholder - pode ser implementado quando houver sistema de avaliação
        return 85; // Valor fictício
    }

    /**
     * Calcular porcentagem
     */
    private function calculatePercentage($count)
    {
        $total = Denuncia::count();
        return $total > 0 ? round(($count / $total) * 100, 1) : 0;
    }

    /**
     * Obter nível de carga de trabalho
     */
    private function getWorkloadLevel($count)
    {
        if ($count <= 3) return ['level' => 'Baixa', 'color' => 'success'];
        if ($count <= 7) return ['level' => 'Média', 'color' => 'warning'];
        return ['level' => 'Alta', 'color' => 'danger'];
    }
} 