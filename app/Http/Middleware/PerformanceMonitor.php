<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PerformanceMonitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Registrar tempo de início
        $startTime = microtime(true);
        $startMemory = memory_get_usage();
        
        // Processar a requisição
        $response = $next($request);
        
        // Calcular métricas de performance
        $endTime = microtime(true);
        $endMemory = memory_get_usage();
        
        $executionTime = round(($endTime - $startTime) * 1000, 2); // em milissegundos
        $memoryUsage = round((($endMemory - $startMemory) / 1024 / 1024), 2); // em MB
        
        // Registrar métricas apenas para requisições lentas (> 500ms) ou com alto uso de memória (> 10MB)
        if ($executionTime > 500 || $memoryUsage > 10) {
            $route = $request->route() ? $request->route()->getName() : $request->path();
            
            Log::channel('performance')->warning('Requisição lenta detectada', [
                'route' => $route,
                'method' => $request->method(),
                'execution_time_ms' => $executionTime,
                'memory_usage_mb' => $memoryUsage,
                'user_id' => $request->user() ? $request->user()->id : null,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'query_params' => $request->query(),
                'timestamp' => now()->toIso8601String()
            ]);
            
            // Adicionar header com tempo de execução (apenas em ambiente não-produção)
            if (app()->environment('local', 'development', 'staging')) {
                $response->headers->set('X-Execution-Time', $executionTime . 'ms');
                $response->headers->set('X-Memory-Usage', $memoryUsage . 'MB');
            }
        }
        
        return $response;
    }
}