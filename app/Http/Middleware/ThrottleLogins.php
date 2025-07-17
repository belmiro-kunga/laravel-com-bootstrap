<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ThrottleLogins
{
    /**
     * The rate limiter instance.
     *
     * @var \Illuminate\Cache\RateLimiter
     */
    protected $limiter;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Cache\RateLimiter  $limiter
     * @return void
     */
    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $maxAttempts
     * @param  int  $decayMinutes
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $maxAttempts = 5, $decayMinutes = 1): Response
    {
        $key = $this->resolveRequestSignature($request);

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            event(new Lockout($request));

            $seconds = $this->limiter->availableIn($key);
            
            // Log tentativa de login bloqueada (apenas em caso de bloqueio)
            if ($seconds > 30) {
                Log::channel('security')->warning('Tentativa de login bloqueada por excesso de tentativas', [
                    'ip' => $request->ip(),
                    'email' => $request->input('email'),
                    'blocked_for_seconds' => $seconds
                ]);
            }

            return $this->buildResponse($request, $key, $maxAttempts, $seconds);
        }

        $response = $next($request);

        // Se a autenticação falhou, incrementar as tentativas
        if ($this->shouldIncrementAttempts($request, $response)) {
            $this->limiter->hit($key, $decayMinutes * 60);
            
            // Log tentativa de login falha (apenas após múltiplas tentativas)
            $attempts = $this->limiter->attempts($key);
            if ($attempts >= 3) {
                Log::channel('security')->info('Tentativa de login falha', [
                    'ip' => $request->ip(),
                    'email' => $request->input('email'),
                    'attempts' => $attempts
                ]);
            }
        } else if (Auth::check()) {
            // Se o login foi bem-sucedido, limpar as tentativas
            $this->limiter->clear($key);
        }

        return $response;
    }

    /**
     * Resolve o "signature" da requisição para o rate limiting.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function resolveRequestSignature(Request $request): string
    {
        // Usar email e IP para o rate limiting
        $email = Str::lower($request->input('email'));
        return sha1($email.'|'.$request->ip());
    }

    /**
     * Criar a resposta para quando o rate limit for excedido.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @param  int  $maxAttempts
     * @param  int  $seconds
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function buildResponse(Request $request, string $key, int $maxAttempts, int $seconds): Response
    {
        $message = Lang::get('auth.throttle', [
            'seconds' => $seconds,
            'minutes' => ceil($seconds / 60),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'seconds_remaining' => $seconds,
            ], 429);
        }

        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => $message]);
    }

    /**
     * Determinar se as tentativas devem ser incrementadas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return bool
     */
    protected function shouldIncrementAttempts(Request $request, Response $response): bool
    {
        // Se a resposta for um redirecionamento para a mesma página com erros, 
        // significa que a autenticação falhou
        if ($response->isRedirect() && $response->getTargetUrl() === $request->fullUrl()) {
            return session()->has('errors');
        }

        // Para respostas JSON, verificar se há erro de autenticação
        if ($request->expectsJson() && $response->getStatusCode() === 422) {
            return true;
        }

        return false;
    }
}