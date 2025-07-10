<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\ConfigHelper;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar se o sistema está em modo de manutenção
        if (ConfigHelper::isMaintenanceMode()) {
            // Permitir acesso a administradores
            if (auth()->check() && auth()->user()->hasPermission('system-config.menu')) {
                return $next($request);
            }

            // Retornar página de manutenção
            $message = ConfigHelper::getMaintenanceMessage();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Sistema em manutenção',
                    'message' => $message
                ], 503);
            }

            return response()->view('maintenance', [
                'message' => $message
            ], 503);
        }

        return $next($request);
    }
}
