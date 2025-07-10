<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailConfigUpdateRequest;
use App\Http\Requests\EmailTestRequest;
use App\Services\EmailConfigurationService;
use Illuminate\Http\JsonResponse;

class EmailConfigController extends Controller
{
    protected EmailConfigurationService $emailService;

    /**
     * Construtor - injetar dependências
     */
    public function __construct(EmailConfigurationService $emailService)
    {
        $this->emailService = $emailService;
        
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->hasPermission('system-config.menu')) {
                abort(403, 'Você não tem permissão para acessar a configuração de email.');
            }
            return $next($request);
        });
    }

    /**
     * Mostrar página de configuração de email
     */
    public function index()
    {
        $config = $this->emailService->getCurrentConfig();
        $popularConfigs = $this->emailService->getPopularConfigs();
        
        return view('email-config.index', compact('config', 'popularConfigs'));
    }

    /**
     * Atualizar configurações de email
     */
    public function update(EmailConfigUpdateRequest $request)
    {
        try {
            $data = $request->validated();
            
            // Validar configuração antes de salvar
            $issues = $this->emailService->validateConfig($data);
            if (!empty($issues)) {
                return back()->with('warning', 'Configuração salva, mas há problemas que podem afetar o envio de emails: ' . implode(', ', $issues))->withInput();
            }
            
            // Atualizar configuração
            $this->emailService->updateConfig($data, auth()->user());
            
            return back()->with('success', '✅ Configurações de email atualizadas com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', '❌ Erro ao atualizar configurações: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Testar configuração de email
     */
    public function test(EmailTestRequest $request)
    {
        $testEmail = $request->validated('test_email');
        
        $result = $this->emailService->testConfig($testEmail, auth()->user());
        
        if ($result['success']) {
            return back()->with('success', $result['message']);
        } else {
            $errorMessage = $result['message'];
            if (isset($result['suggestions'])) {
                $errorMessage .= "\n\n" . $result['suggestions'];
            }
            return back()->with('error', $errorMessage);
        }
    }

    /**
     * Validar configuração atual
     */
    public function validateCurrentConfig(): JsonResponse
    {
        $config = $this->emailService->getCurrentConfig();
        $issues = $this->emailService->validateConfig($config);
        
        return response()->json([
            'valid' => empty($issues),
            'issues' => $issues,
            'suggestions' => empty($issues) ? null : $this->emailService->getSuggestionsForIssues($issues)
        ]);
    }
}
