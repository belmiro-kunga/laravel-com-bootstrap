<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheStaticAssets
{
    /**
     * Lista de extensões de arquivos estáticos
     */
    protected $staticExtensions = [
        'css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'webp',
        'woff', 'woff2', 'ttf', 'eot', 'ico', 'pdf'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Verificar se é um arquivo estático
        $path = $request->getPathInfo();
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if (in_array(strtolower($extension), $this->staticExtensions)) {
            // Adicionar headers de cache para assets estáticos
            $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
            $response->headers->set('Pragma', 'public');
            $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
        } elseif ($request->isMethod('GET') && !$request->ajax()) {
            // Para páginas HTML normais, usar cache mais conservador
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }

        return $response;
    }
}