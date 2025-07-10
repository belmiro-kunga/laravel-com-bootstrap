<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Services\AuditService;

class EmailConfigurationService
{
    /**
     * Obter configuração atual de email
     */
    public function getCurrentConfig(): array
    {
        return [
            'MAIL_MAILER' => config('mail.default'),
            'MAIL_HOST' => config('mail.mailers.smtp.host'),
            'MAIL_PORT' => config('mail.mailers.smtp.port'),
            'MAIL_USERNAME' => config('mail.mailers.smtp.username'),
            'MAIL_PASSWORD' => config('mail.mailers.smtp.password') ? '***configurada***' : '',
            'MAIL_ENCRYPTION' => config('mail.mailers.smtp.encryption'),
            'MAIL_FROM_ADDRESS' => config('mail.from.address'),
            'MAIL_FROM_NAME' => config('mail.from.name'),
        ];
    }

    /**
     * Validar configuração de email
     */
    public function validateConfig(array $data): array
    {
        $issues = [];
        
        // Verificar configurações básicas
        if (empty($data['MAIL_FROM_ADDRESS']) || $data['MAIL_FROM_ADDRESS'] === 'hello@example.com') {
            $issues[] = 'Email remetente não configurado ou ainda é o padrão';
        }
        
        if (empty($data['MAIL_FROM_NAME']) || $data['MAIL_FROM_NAME'] === 'Laravel') {
            $issues[] = 'Nome remetente não configurado ou ainda é o padrão';
        }
        
        // Verificar configurações SMTP se necessário
        if ($data['MAIL_MAILER'] === 'smtp') {
            if (empty($data['MAIL_HOST']) || $data['MAIL_HOST'] === 'smtp.mailgun.org') {
                $issues[] = 'Host SMTP não configurado ou ainda é o padrão';
            }
            
            if (empty($data['MAIL_USERNAME'])) {
                $issues[] = 'Usuário SMTP não configurado';
            }
            
            if (empty($data['MAIL_PASSWORD'])) {
                $issues[] = 'Senha SMTP não configurada';
            }
            
            if (empty($data['MAIL_PORT'])) {
                $issues[] = 'Porta SMTP não configurada';
            }
        }
        
        return $issues;
    }

    /**
     * Atualizar configuração de email
     */
    public function updateConfig(array $data, $user = null): bool
    {
        try {
            // Filtrar dados vazios
            $data = array_filter($data, function($value) {
                return $value !== null && $value !== '';
            });
            
            // Atualizar arquivo .env
            $this->updateEnvFile($data);
            
            // Limpar cache
            $this->clearConfigCache();
            
            // Log da alteração
            if ($user) {
                AuditService::log($user, 'email_config_updated', 'Configuração de email atualizada', [
                    'changed_fields' => array_keys($data)
                ]);
            }
            
            Log::info('Email configuration updated', [
                'user_id' => $user?->id,
                'changed_fields' => array_keys($data)
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to update email configuration', [
                'error' => $e->getMessage(),
                'user_id' => $user?->id,
                'data' => $data
            ]);
            
            throw $e;
        }
    }

    /**
     * Testar configuração de email
     */
    public function testConfig(string $testEmail, $user = null): array
    {
        try {
            // Validar configuração atual
            $currentConfig = $this->getCurrentConfig();
            $issues = $this->validateConfig($currentConfig);
            
            if (!empty($issues)) {
                return [
                    'success' => false,
                    'message' => 'Configuração incompleta',
                    'issues' => $issues,
                    'suggestions' => $this->getSuggestionsForIssues($issues)
                ];
            }
            
            // Enviar email de teste
            Mail::raw($this->getTestEmailContent(), function ($message) use ($testEmail) {
                $message->to($testEmail)
                        ->subject('🧪 Teste de Email - Sistema de Denúncias')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            // Log do teste bem-sucedido
            if ($user) {
                AuditService::log($user, 'email_test_success', 'Teste de email realizado com sucesso', [
                    'test_email' => $testEmail
                ]);
            }
            
            Log::info('Email test successful', [
                'user_id' => $user?->id,
                'test_email' => $testEmail
            ]);
            
            return [
                'success' => true,
                'message' => 'Email de teste enviado com sucesso! Verifique sua caixa de entrada.'
            ];
            
        } catch (\Exception $e) {
            // Log do erro
            if ($user) {
                AuditService::log($user, 'email_test_failed', 'Falha no teste de email', [
                    'test_email' => $testEmail,
                    'error' => $e->getMessage()
                ]);
            }
            
            Log::error('Email test failed', [
                'user_id' => $user?->id,
                'test_email' => $testEmail,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'suggestions' => $this->getErrorSuggestions($e->getMessage())
            ];
        }
    }

    /**
     * Obter configurações populares
     */
    public function getPopularConfigs(): array
    {
        return [
            'gmail' => [
                'name' => 'Gmail',
                'host' => 'smtp.gmail.com',
                'port' => 587,
                'encryption' => 'tls',
                'note' => 'Use uma senha de app se 2FA estiver ativado',
                'instructions' => '1. Ative 2FA na conta Google\n2. Gere senha de app em myaccount.google.com/apppasswords\n3. Use a senha de app no campo MAIL_PASSWORD'
            ],
            'outlook' => [
                'name' => 'Outlook/Hotmail',
                'host' => 'smtp-mail.outlook.com',
                'port' => 587,
                'encryption' => 'tls',
                'note' => 'Use sua senha normal',
                'instructions' => '1. Use sua senha normal da conta\n2. Verifique se SMTP está habilitado\n3. Pode precisar desativar 2FA temporariamente'
            ],
            'yahoo' => [
                'name' => 'Yahoo',
                'host' => 'smtp.mail.yahoo.com',
                'port' => 587,
                'encryption' => 'tls',
                'note' => 'Use uma senha de app',
                'instructions' => '1. Ative 2FA na conta Yahoo\n2. Gere senha de app nas configurações\n3. Use a senha de app no campo MAIL_PASSWORD'
            ],
            'protonmail' => [
                'name' => 'ProtonMail',
                'host' => '127.0.0.1',
                'port' => 1025,
                'encryption' => null,
                'note' => 'Configuração especial necessária',
                'instructions' => '1. Requer configuração especial\n2. Consulte documentação do ProtonMail\n3. Pode precisar de bridge local'
            ]
        ];
    }

    /**
     * Atualizar arquivo .env
     */
    private function updateEnvFile(array $data): void
    {
        $envPath = base_path('.env');
        
        if (!file_exists($envPath)) {
            throw new \Exception('Arquivo .env não encontrado');
        }

        $envContent = file_get_contents($envPath);
        
        foreach ($data as $key => $value) {
            // Escapar aspas duplas na senha
            if ($key === 'MAIL_PASSWORD') {
                $value = '"' . str_replace('"', '\"', $value) . '"';
            }
            
            // Procurar e substituir a linha existente
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}={$value}";
            
            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                // Se não existir, adicionar no final
                $envContent .= "\n{$key}={$value}";
            }
        }

        file_put_contents($envPath, $envContent);
    }

    /**
     * Limpar cache de configuração
     */
    private function clearConfigCache(): void
    {
        Artisan::call('config:clear');
        Artisan::call('config:cache');
    }

    /**
     * Obter conteúdo do email de teste
     */
    private function getTestEmailContent(): string
    {
        return "Este é um email de teste do Sistema de Denúncias Corporativas.\n\n" .
               "Data/Hora: " . now()->format('d/m/Y H:i:s') . "\n" .
               "Sistema: " . config('app.name') . "\n" .
               "Versão: " . config('app.version', '1.0.0') . "\n\n" .
               "Se você recebeu este email, a configuração SMTP está funcionando corretamente!\n\n" .
               "Agora o sistema pode enviar:\n" .
               "• Notificações de novas denúncias\n" .
               "• Alertas de mudança de status\n" .
               "• Relatórios e atualizações\n" .
               "• Mensagens para usuários\n\n" .
               "---\n" .
               "Sistema de Denúncias Corporativas\n" .
               "Este é um email automático, não responda.";
    }

    /**
     * Obter sugestões para problemas de configuração
     */
    public function getSuggestionsForIssues(array $issues): string
    {
        $suggestions = "🔧 Para resolver os problemas encontrados:\n\n";
        
        foreach ($issues as $issue) {
            if (strpos($issue, 'Email remetente') !== false) {
                $suggestions .= "• Configure um email remetente válido (não use hello@example.com)\n";
            } elseif (strpos($issue, 'Nome remetente') !== false) {
                $suggestions .= "• Configure um nome remetente personalizado (não use 'Laravel')\n";
            } elseif (strpos($issue, 'Host SMTP') !== false) {
                $suggestions .= "• Configure o host SMTP correto (ex: smtp.gmail.com)\n";
            } elseif (strpos($issue, 'Usuário SMTP') !== false) {
                $suggestions .= "• Configure o usuário SMTP (seu email)\n";
            } elseif (strpos($issue, 'Senha SMTP') !== false) {
                $suggestions .= "• Configure a senha SMTP (use senha de app para Gmail)\n";
            } elseif (strpos($issue, 'Porta SMTP') !== false) {
                $suggestions .= "• Configure a porta SMTP (587 para TLS, 465 para SSL)\n";
            }
        }
        
        return $suggestions;
    }

    /**
     * Obter sugestões de solução baseadas no erro
     */
    private function getErrorSuggestions(string $errorMessage): string
    {
        $suggestions = "🔧 Sugestões de correção:\n\n";
        
        // Erros de autenticação
        if (stripos($errorMessage, 'authentication') !== false || stripos($errorMessage, '535') !== false) {
            $suggestions .= "• Verifique se o usuário e senha SMTP estão corretos\n";
            $suggestions .= "• Para Gmail: Use uma senha de app (não sua senha normal)\n";
            $suggestions .= "• Para Outlook: Verifique se a conta permite acesso SMTP\n";
            $suggestions .= "• Para Yahoo: Use uma senha de app se 2FA estiver ativado\n\n";
        }
        
        // Erros de conexão
        if (stripos($errorMessage, 'connection') !== false || stripos($errorMessage, 'timeout') !== false) {
            $suggestions .= "• Verifique se o host SMTP está correto\n";
            $suggestions .= "• Teste se a porta não está bloqueada pelo firewall\n";
            $suggestions .= "• Tente portas alternativas: 587 (TLS), 465 (SSL), 25\n";
            $suggestions .= "• Verifique sua conexão com a internet\n\n";
        }
        
        // Erros de SSL/TLS
        if (stripos($errorMessage, 'ssl') !== false || stripos($errorMessage, 'tls') !== false) {
            $suggestions .= "• Verifique se a criptografia está configurada corretamente\n";
            $suggestions .= "• Tente alternar entre TLS e SSL\n";
            $suggestions .= "• Para Gmail/Outlook: Use TLS na porta 587\n";
            $suggestions .= "• Para alguns provedores: Use SSL na porta 465\n\n";
        }
        
        // Erros de porta
        if (stripos($errorMessage, 'port') !== false || stripos($errorMessage, 'refused') !== false) {
            $suggestions .= "• Verifique se a porta SMTP está correta\n";
            $suggestions .= "• Gmail: 587 (TLS) ou 465 (SSL)\n";
            $suggestions .= "• Outlook: 587 (TLS)\n";
            $suggestions .= "• Yahoo: 587 (TLS) ou 465 (SSL)\n";
            $suggestions .= "• Verifique se o firewall não está bloqueando\n\n";
        }
        
        // Erros de from address
        if (stripos($errorMessage, 'from') !== false || stripos($errorMessage, 'sender') !== false) {
            $suggestions .= "• Verifique se o email remetente está configurado corretamente\n";
            $suggestions .= "• O email remetente deve ser o mesmo da conta SMTP\n";
            $suggestions .= "• Alguns provedores não permitem emails de domínios diferentes\n\n";
        }
        
        // Erros genéricos
        if (stripos($errorMessage, 'stream') !== false || stripos($errorMessage, 'socket') !== false) {
            $suggestions .= "• Verifique se o servidor SMTP está acessível\n";
            $suggestions .= "• Teste a conectividade: ping smtp.gmail.com\n";
            $suggestions .= "• Verifique se não há bloqueio por antivírus/firewall\n\n";
        }
        
        // Sugestões gerais
        $suggestions .= "📋 Verificações gerais:\n";
        $suggestions .= "• Confirme se o provedor de email permite SMTP\n";
        $suggestions .= "• Verifique se não há limite de envio atingido\n";
        $suggestions .= "• Teste com configurações de outro provedor\n";
        $suggestions .= "• Use o modo 'log' para debug: MAIL_MAILER=log\n\n";
        
        $suggestions .= "💡 Dica: Use o comando 'php artisan test:email seu@email.com' para testar via terminal.";
        
        return $suggestions;
    }
} 