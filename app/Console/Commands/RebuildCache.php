<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CacheService;
use App\Services\DashboardService;
use App\Models\Categoria;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class RebuildCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:rebuild {--type=all : Tipo de cache a ser reconstruído (all, denuncias, users, categorias, status)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpa e reconstrói o cache do sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->option('type');
        
        $this->info('Iniciando reconstrução do cache...');
        
        switch ($type) {
            case 'denuncias':
                $this->rebuildDenunciasCache();
                break;
            case 'users':
                $this->rebuildUsersCache();
                break;
            case 'categorias':
                $this->rebuildCategoriasCache();
                break;
            case 'status':
                $this->rebuildStatusCache();
                break;
            case 'all':
            default:
                $this->rebuildAllCache();
                break;
        }
        
        $this->info('Cache reconstruído com sucesso!');
        
        return 0;
    }
    
    /**
     * Reconstruir cache de denúncias
     */
    protected function rebuildDenunciasCache()
    {
        $this->info('Limpando cache de denúncias...');
        CacheService::flushDenunciasCache();
        
        $this->info('Reconstruindo cache de denúncias...');
        $dashboardService = app(DashboardService::class);
        
        // Pré-carregar dados para o cache
        $dashboardService->getMainMetrics();
        $dashboardService->getDenunciasPorStatus();
        $dashboardService->getDenunciasPorCategoria();
        $dashboardService->getDenunciasPorPeriodo(30);
        $dashboardService->getDenunciasRecentes(5);
        $dashboardService->getDenunciasUrgentes(5);
        
        $this->info('Cache de denúncias reconstruído.');
    }
    
    /**
     * Reconstruir cache de usuários
     */
    protected function rebuildUsersCache()
    {
        $this->info('Limpando cache de usuários...');
        CacheService::flushUsersCache();
        
        $this->info('Reconstruindo cache de usuários...');
        Cache::remember('usuarios_responsaveis', now()->addHours(6), function() {
            return User::responsaveis()->ativos()->get();
        });
        
        $dashboardService = app(DashboardService::class);
        $dashboardService->getEstatisticasPorResponsavel();
        
        $this->info('Cache de usuários reconstruído.');
    }
    
    /**
     * Reconstruir cache de categorias
     */
    protected function rebuildCategoriasCache()
    {
        $this->info('Limpando cache de categorias...');
        CacheService::flushCategoriasCache();
        
        $this->info('Reconstruindo cache de categorias...');
        Cache::remember('categorias_ativas', now()->addHours(6), function() {
            return Categoria::ativas()->ordenadas()->get();
        });
        
        $dashboardService = app(DashboardService::class);
        $dashboardService->getDenunciasPorCategoria();
        
        $this->info('Cache de categorias reconstruído.');
    }
    
    /**
     * Reconstruir cache de status
     */
    protected function rebuildStatusCache()
    {
        $this->info('Limpando cache de status...');
        CacheService::flushStatusCache();
        
        $this->info('Reconstruindo cache de status...');
        Cache::remember('status_ativos', now()->addHours(6), function() {
            return Status::ativos()->ordenados()->get();
        });
        
        $dashboardService = app(DashboardService::class);
        $dashboardService->getDenunciasPorStatus();
        
        $this->info('Cache de status reconstruído.');
    }
    
    /**
     * Reconstruir todo o cache
     */
    protected function rebuildAllCache()
    {
        $this->info('Limpando todo o cache...');
        CacheService::flushAllCache();
        
        $this->rebuildDenunciasCache();
        $this->rebuildUsersCache();
        $this->rebuildCategoriasCache();
        $this->rebuildStatusCache();
    }
}