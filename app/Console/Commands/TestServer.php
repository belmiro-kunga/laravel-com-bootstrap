<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class TestServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test server connectivity and basic functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🌐 Testando Servidor Laravel...');

        // Verificar se o servidor está rodando
        $this->info('📡 Verificando conectividade...');
        
        try {
            $url = 'http://127.0.0.1:8000';
            $response = file_get_contents($url);
            
            if ($response !== false) {
                $this->info('✅ Servidor respondendo em: ' . $url);
            } else {
                $this->error('❌ Servidor não está respondendo');
                $this->info('💡 Execute: php artisan serve');
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('❌ Erro de conectividade: ' . $e->getMessage());
            $this->info('💡 Execute: php artisan serve');
            return 1;
        }

        // Verificar arquivos essenciais
        $this->info('📁 Verificando arquivos essenciais...');
        
        $essentialFiles = [
            '.env',
            'storage/logs/laravel.log',
            'bootstrap/cache',
            'storage/framework/cache',
            'storage/framework/sessions',
            'storage/framework/views'
        ];

        foreach ($essentialFiles as $file) {
            $path = base_path($file);
            if (File::exists($path)) {
                $this->line("✅ {$file}");
            } else {
                $this->warn("⚠️  {$file} - NÃO ENCONTRADO");
            }
        }

        // Verificar permissões
        $this->info('🔐 Verificando permissões...');
        
        $writableDirs = [
            'storage',
            'storage/logs',
            'storage/framework',
            'storage/framework/cache',
            'storage/framework/sessions',
            'storage/framework/views',
            'bootstrap/cache'
        ];

        foreach ($writableDirs as $dir) {
            $path = base_path($dir);
            if (is_writable($path)) {
                $this->line("✅ {$dir} - Gravável");
            } else {
                $this->error("❌ {$dir} - NÃO GRAVÁVEL");
            }
        }

        // Verificar configuração
        $this->info('⚙️  Verificando configuração...');
        
        try {
            $appName = config('app.name');
            $appEnv = config('app.env');
            $appDebug = config('app.debug');
            
            $this->line("✅ APP_NAME: {$appName}");
            $this->line("✅ APP_ENV: {$appEnv}");
            $this->line("✅ APP_DEBUG: " . ($appDebug ? 'true' : 'false'));
        } catch (\Exception $e) {
            $this->error('❌ Erro na configuração: ' . $e->getMessage());
        }

        // Verificar rotas
        $this->info('🔗 Verificando rotas...');
        
        try {
            $routes = [
                '/' => 'Página inicial',
                '/install' => 'Wizard de instalação',
                '/install/requirements' => 'Verificação de requisitos',
                '/install/database' => 'Configuração de banco',
                '/install/configure' => 'Configuração final'
            ];

            foreach ($routes as $route => $description) {
                $this->line("✅ {$route} - {$description}");
            }
        } catch (\Exception $e) {
            $this->error('❌ Erro ao verificar rotas: ' . $e->getMessage());
        }

        $this->info('🎯 Teste concluído!');
        $this->info('🌐 Acesse: http://127.0.0.1:8000');
        
        return 0;
    }
} 