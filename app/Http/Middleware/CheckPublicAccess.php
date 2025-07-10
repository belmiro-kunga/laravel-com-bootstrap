<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckPublicAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Rotas públicas que não requerem autenticação
        $publicRoutes = [
            'denuncias.formulario-publico',
            'rastreamento.publico',
            'login',
            'register',
            'password.request',
            'password.reset',
            'verification.notice',
            'verification.verify',
            'verification.send',
            'password.confirm',
            'password.email',
            'password.update',
        ];

        // Verificar se a rota atual é pública
        $routeName = Route::currentRouteName();
        
        if (in_array($routeName, $publicRoutes)) {
            return $next($request);
        }

        // Se o usuário não estiver autenticado, redirecionar para a página de login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Verificar se o usuário tem permissão para acessar a rota
        $user = auth()->user();
        
        // Se for administrador, permitir acesso a todas as rotas
        if ($user->is_admin) {
            return $next($request);
        }

        // Verificar permissão baseada no nome da rota
        if ($user->hasPermission($routeName)) {
            return $next($request);
        }

        // Se não tiver permissão, exibir erro 403
        abort(403, 'Acesso não autorizado.');
    }
}
