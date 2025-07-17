<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CacheService
{
    /**
     * Tempo padrão de cache em minutos
     */
    protected static $defaultTtl = 60;

    /**
     * Obter dados do cache ou do banco de dados
     *
     * @param string $key Chave do cache
     * @param \Closure $callback Função para obter os dados do banco de dados
     * @param int|null $ttl Tempo de vida do cache em minutos
     * @return mixed
     */
    public static function remember($key, \Closure $callback, $ttl = null)
    {
        $ttl = $ttl ?? self::$defaultTtl;
        
        try {
            return Cache::remember($key, now()->addMinutes($ttl), $callback);
        } catch (\Exception $e) {
            Log::error('Erro ao acessar cache: ' . $e->getMessage());
            // Em caso de erro no cache, executar a consulta diretamente
            return $callback();
        }
    }

    /**
     * Limpar cache específico
     *
     * @param string $key Chave do cache
     * @return bool
     */
    public static function forget($key)
    {
        try {
            return Cache::forget($key);
        } catch (\Exception $e) {
            Log::error('Erro ao limpar cache: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Limpar todos os caches relacionados a denúncias
     *
     * @return bool
     */
    public static function flushDenunciasCache()
    {
        $keys = [
            'dashboard_denuncias_por_status',
            'dashboard_denuncias_por_categoria',
            'dashboard_denuncias_por_periodo_30',
            'dashboard_denuncias_recentes_5',
            'dashboard_denuncias_urgentes_5',
            'dashboard_main_metrics',
            'dashboard_tempo_medio_resolucao'
        ];
        
        foreach ($keys as $key) {
            self::forget($key);
        }
        
        return true;
    }

    /**
     * Limpar todos os caches relacionados a usuários
     *
     * @return bool
     */
    public static function flushUsersCache()
    {
        $keys = [
            'usuarios_responsaveis',
            'dashboard_estatisticas_responsavel'
        ];
        
        foreach ($keys as $key) {
            self::forget($key);
        }
        
        return true;
    }

    /**
     * Limpar todos os caches relacionados a categorias
     *
     * @return bool
     */
    public static function flushCategoriasCache()
    {
        $keys = [
            'categorias_ativas',
            'dashboard_denuncias_por_categoria'
        ];
        
        foreach ($keys as $key) {
            self::forget($key);
        }
        
        return true;
    }

    /**
     * Limpar todos os caches relacionados a status
     *
     * @return bool
     */
    public static function flushStatusCache()
    {
        $keys = [
            'status_ativos',
            'dashboard_denuncias_por_status'
        ];
        
        foreach ($keys as $key) {
            self::forget($key);
        }
        
        return true;
    }

    /**
     * Limpar todos os caches do sistema
     *
     * @return bool
     */
    public static function flushAllCache()
    {
        try {
            Cache::flush();
            return true;
        } catch (\Exception $e) {
            Log::error('Erro ao limpar todo o cache: ' . $e->getMessage());
            return false;
        }
    }
}