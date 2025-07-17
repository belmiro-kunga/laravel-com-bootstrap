<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SecurityCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'security:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executa verificações básicas de segurança no sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando verificação de segurança...');
        $issues = [];
        
        // Verificar configurações do .env
        $this->info('Verificando configurações do .env...');
        if (env('APP_DEBUG') === true) {
            $issues[] = 'APP_DEBUG está habilitado em produção. Isso pode expor informações sensíveis.';
        }
        
        if (env('APP_ENV') !== 'production') {
            $issues[] = 'APP_ENV não está configurado para produção.';
        }
        
        if (!str_starts_with(env('APP_URL'), 'https://')) {
            $issues[] = 'APP_URL não está usando HTTPS.';
        }
        
        if (empty(env('DB_PASSWORD')) || env('DB_PASSWORD') === 'null') {
            $issues[] = 'Senha do banco de dados não está configurada.';
        }
        
        if (env('SESSION_SECURE_COOKIE') !== true) {
            $issues[] = 'SESSION_SECURE_COOKIE não está habilitado.';
        }
        
        // Verificar permissões de diretórios
        $this->info('Verificando permissões de diretórios...');
        $storagePath = storage_path();
        $permissions = substr(sprintf('%o', fileperms($storagePath)), -4);
        if ($permissions > '0755') {
            $issues[] = "Permissões do diretório storage são muito permissivas: {$permissions}";
        }
        
        // Verificar usuários admin
        $this->info('Verificando usuários admin...');
        try {
            $adminCount = DB::table('users')->where('role', 'admin')->count();
            if ($adminCount > 3) {
                $issues[] = "Número elevado de usuários admin: {$adminCount}";
            }
        } catch (\Exception $e) {
            $this->error('Erro ao verificar usuários admin: ' . $e->getMessage());
        }
        
        // Verificar arquivos de log
        $this->info('Verificando arquivos de log...');
        $logFiles = File::glob(storage_path('logs/*.log'));
        foreach ($logFiles as $logFile) {
            $size = File::size($logFile) / 1024 / 1024; // MB
            if ($size > 100) {
                $issues[] = "Arquivo de log muito grande: " . basename($logFile) . " ({$size} MB)";
            }
        }
        
        // Verificar configurações de CORS
        $this->info('Verificando configurações de CORS...');
        $corsConfig = config('cors.allowed_origins');
        if (in_array('*', $corsConfig)) {
            $issues[] = "CORS está configurado para permitir qualquer origem (*)";
        }
        
        // Verificar se o diretório .git está acessível publicamente
        $this->info('Verificando exposição do diretório .git...');
        if (File::exists(public_path('.git'))) {
            $issues[] = "Diretório .git está acessível publicamente";
        }
        
        // Exibir resultados
        if (count($issues) > 0) {
            $this->error('Problemas de segurança encontrados:');
            foreach ($issues as $issue) {
                $this->warn("- {$issue}");
            }
            
            // Registrar no log de segurança
            Log::channel('security')->warning('Problemas de segurança encontrados', [
                'issues' => $issues,
                'timestamp' => now()->toIso8601String()
            ]);
            
            return 1;
        } else {
            $this->info('Nenhum problema de segurança encontrado!');
            Log::channel('security')->info('Verificação de segurança concluída sem problemas');
            return 0;
        }
    }
}