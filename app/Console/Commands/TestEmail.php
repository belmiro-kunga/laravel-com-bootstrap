<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {email?} {--config}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testar configuração de email SMTP';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $showConfig = $this->option('config');

        if ($showConfig) {
            $this->showEmailConfig();
            return 0;
        }

        if (!$email) {
            // Buscar primeiro usuário admin
            $user = User::where('role', 'admin')->where('ativo', true)->first();
            if ($user) {
                $email = $user->email;
                $this->info("Usando email do admin: {$email}");
            } else {
                $this->error('Nenhum usuário admin encontrado. Especifique um email: php artisan test:email seu@email.com');
                return 1;
            }
        }

        $this->info("🧪 Testando envio de email para: {$email}");
        $this->info("📧 Configuração atual:");
        $this->showEmailConfig();

        try {
            // Verificar se as configurações básicas estão definidas
            $this->validateBasicConfig();
            
            // Enviar email de teste
            Mail::raw("Este é um email de teste do Sistema de Denúncias.\n\nData/Hora: " . now()->format('d/m/Y H:i:s') . "\n\nSe você recebeu este email, a configuração SMTP está funcionando corretamente!", function ($message) use ($email) {
                $message->to($email)
                        ->subject('🧪 Teste de Email - Sistema de Denúncias')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            $this->info('✅ Email enviado com sucesso!');
            $this->info('📬 Verifique sua caixa de entrada (e pasta de spam) para confirmar o recebimento.');

        } catch (\Exception $e) {
            $this->error('❌ Erro ao enviar email:');
            $this->error($e->getMessage());
            
            $this->showErrorSuggestions($e->getMessage());
            
            return 1;
        }

        return 0;
    }

    /**
     * Validar configurações básicas
     */
    private function validateBasicConfig()
    {
        $this->info('🔍 Validando configurações...');
        
        $issues = [];
        
        if (config('mail.from.address') === 'hello@example.com') {
            $issues[] = 'Email remetente ainda é o padrão (hello@example.com)';
        }
        
        if (config('mail.from.name') === 'Laravel') {
            $issues[] = 'Nome remetente ainda é o padrão (Laravel)';
        }
        
        if (config('mail.mailers.smtp.host') === 'smtp.mailgun.org') {
            $issues[] = 'Host SMTP ainda é o padrão (smtp.mailgun.org)';
        }
        
        if (empty(config('mail.mailers.smtp.username'))) {
            $issues[] = 'Usuário SMTP não configurado';
        }
        
        if (empty(config('mail.mailers.smtp.password'))) {
            $issues[] = 'Senha SMTP não configurada';
        }
        
        if (!empty($issues)) {
            $this->warn('⚠️  Problemas encontrados:');
            foreach ($issues as $issue) {
                $this->warn("   • {$issue}");
            }
            $this->warn('💡 Configure estas opções antes de testar o envio.');
        } else {
            $this->info('✅ Configurações básicas OK');
        }
    }

    /**
     * Mostrar sugestões de solução baseadas no erro
     */
    private function showErrorSuggestions($errorMessage)
    {
        $this->info("\n🔧 Sugestões de correção:");
        
        // Erros de autenticação
        if (stripos($errorMessage, 'authentication') !== false || stripos($errorMessage, '535') !== false) {
            $this->info("• Verifique se o usuário e senha SMTP estão corretos");
            $this->info("• Para Gmail: Use uma senha de app (não sua senha normal)");
            $this->info("• Para Outlook: Verifique se a conta permite acesso SMTP");
            $this->info("• Para Yahoo: Use uma senha de app se 2FA estiver ativado");
        }
        
        // Erros de conexão
        if (stripos($errorMessage, 'connection') !== false || stripos($errorMessage, 'timeout') !== false) {
            $this->info("• Verifique se o host SMTP está correto");
            $this->info("• Teste se a porta não está bloqueada pelo firewall");
            $this->info("• Tente portas alternativas: 587 (TLS), 465 (SSL), 25");
            $this->info("• Verifique sua conexão com a internet");
        }
        
        // Erros de SSL/TLS
        if (stripos($errorMessage, 'ssl') !== false || stripos($errorMessage, 'tls') !== false) {
            $this->info("• Verifique se a criptografia está configurada corretamente");
            $this->info("• Tente alternar entre TLS e SSL");
            $this->info("• Para Gmail/Outlook: Use TLS na porta 587");
            $this->info("• Para alguns provedores: Use SSL na porta 465");
        }
        
        // Erros de porta
        if (stripos($errorMessage, 'port') !== false || stripos($errorMessage, 'refused') !== false) {
            $this->info("• Verifique se a porta SMTP está correta");
            $this->info("• Gmail: 587 (TLS) ou 465 (SSL)");
            $this->info("• Outlook: 587 (TLS)");
            $this->info("• Yahoo: 587 (TLS) ou 465 (SSL)");
            $this->info("• Verifique se o firewall não está bloqueando");
        }
        
        $this->info("\n📋 Verificações gerais:");
        $this->info("• Confirme se o provedor de email permite SMTP");
        $this->info("• Verifique se não há limite de envio atingido");
        $this->info("• Teste com configurações de outro provedor");
        $this->info("• Use o modo 'log' para debug: MAIL_MAILER=log");
        
        $this->info("\n🌐 Acesse a interface web para configurar:");
        $this->info("   /email-config");
    }

    /**
     * Mostrar configuração atual de email
     */
    private function showEmailConfig()
    {
        $this->info("\n📧 Configuração de Email Atual:");
        $this->info("• Driver: " . config('mail.default'));
        $this->info("• Host: " . config('mail.mailers.smtp.host'));
        $this->info("• Porta: " . config('mail.mailers.smtp.port'));
        $this->info("• Criptografia: " . config('mail.mailers.smtp.encryption'));
        $this->info("• Usuário: " . config('mail.mailers.smtp.username'));
        $this->info("• Senha: " . (config('mail.mailers.smtp.password') ? '***configurada***' : 'não configurada'));
        $this->info("• From Address: " . config('mail.from.address'));
        $this->info("• From Name: " . config('mail.from.name'));
    }
}
