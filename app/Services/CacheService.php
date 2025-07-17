<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class CacheService
{
    /**
     * Tempo padrão de cache em minutos
     */
    protected $defaultTtl = 60;
    
    /**
     * Prefixo para as chaves de cache
     */
    protected $prefix = 'app_cache_';
    
    /**
     * Obter ou armazenar um valor em cache
     */
    public function remember($key, $callback, $ttl = null)
    {
        $ttl = $ttl ?: $this->defaultTtl;
        $cacheKey = $this->prefix . $key;
        
        return Cache::remember($cacheKey, $ttl * 60, $callback);
    }
    
    /**
     * Obter ou armazenar um valor em cache por um dia
     */
    public function rememberDay($key, $callback)
    {
        return $this->remember($key, $callback, 60 * 24);
    }
    
    /**
     * Obter ou armazenar um valor em cache por uma hora
     */
    public function rememberHour($key, $callback)
    {
        return $this->remember($key, $callback, 60);
    }
    
    /**
     * Obter ou armazenar um valor em cache por 5 minutos
     */
    public function rememberShort($key, $callback)
    {
        return $this->remember($key, $callback, 5);
    }
    
    /**
     * Limpar um item específico do cache
     */
    public function forget($key)
    {
        $cacheKey = $this->prefix . $key;
        return Cache::forget($cacheKey);
    }
    
    /**
     * Limpar todos os itens de cache relacionados ao dashboard
     */
    public function flushDashboard()
    {
        $keys = [
            'dashboard_main_metrics',
            'dashboard_denuncias_por_status',
            'dashboard_denuncias_por_categoria',
            'dashboard_tempo_medio_resolucao',
            'dashboard_denuncias_recentes',
            'dashboard_denuncias_urgentes',
            'dashboard_atividades_recentes',
            'dashboard_estatisticas_responsavel'
        ];
        
        foreach ($keys as $key) {
            $this->forget($key);
        }
        
        return true;
    }
    
    /**
     * Limpar todos os itens de cache relacionados às denúncias
     */
    public function flushDenuncias()
    {
        $keys = [
            'denuncias_count',
            'denuncias_pendentes_count',
            'denuncias_urgentes_count',
            'denuncias_resolvidas_count',
            'dashboard_denuncias_por_status',
            'dashboard_denuncias_por_categoria',
            'dashboard_tempo_medio_resolucao',
            'dashboard_denuncias_recentes',
            'dashboard_denuncias_urgentes'
        ];
        
        foreach ($keys as $key) {
            $this->forget($key);
        }
        
        return true;
    }
}