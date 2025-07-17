<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class CheckInstallation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Se o sistema não está instalado e não está acessando o wizard
        if (!File::exists(storage_path('installed')) && !$request->is('install*')) {
            return redirect('/install');
        }

        // Se o sistema está instalado e está tentando acessar o wizard
        if (File::exists(storage_path('installed')) && $request->is('install*')) {
            return redirect('/')->with('error', 'O sistema já está instalado.');
        }

        return $next($request);
    }
} 