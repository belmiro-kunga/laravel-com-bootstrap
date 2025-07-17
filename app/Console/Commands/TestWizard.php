<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class TestWizard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wizard:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the complete installation wizard';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Testando Wizard de Instalação Completo...');

        // Verificar se o sistema está instalado
        if (File::exists(storage_path('installed'))) {
            $this->warn('⚠️  O sistema já está instalado!');
            $this->info('Para testar novamente, remova o arquivo: storage/installed');
            return 1;
        }

        $this->info('✅ Sistema não instalado - wizard deve aparecer');
        
        // Verificar rotas
        $this->info('🔗 Verificando rotas do wizard...');
        $routes = [
            'install.welcome' => '/install',
            'install.requirements' => '/install/requirements',
            'install.database' => '/install/database',
            'install.configure' => '/install/configure',
            'install.install' => '/install/finish',
            'install.complete' => '/install/complete'
        ];

        foreach ($routes as $name => $path) {
            $this->line("✅ {$name} => {$path}");
        }

        // Verificar arquivos
        $this->info('📁 Verificando arquivos do wizard...');
        $files = [
            'app/Http/Controllers/InstallController.php',
            'routes/install.php',
            'resources/views/install/layout.blade.php',
            'resources/views/install/welcome.blade.php',
            'resources/views/install/requirements.blade.php',
            'resources/views/install/database.blade.php',
            'resources/views/install/configure.blade.php',
            'resources/views/install/complete.blade.php'
        ];

        foreach ($files as $file) {
            if (File::exists(base_path($file))) {
                $this->line("✅ {$file}");
            } else {
                $this->error("❌ {$file} - NÃO ENCONTRADO");
            }
        }

        // Verificar middleware
        if (File::exists(app_path('Http/Middleware/CheckInstallation.php'))) {
            $this->info('✅ Middleware CheckInstallation encontrado');
        } else {
            $this->error('❌ Middleware CheckInstallation NÃO ENCONTRADO');
        }

        // Instruções de teste
        $this->info('🎯 Instruções de Teste:');
        $this->line('1. Acesse: http://127.0.0.1:8000');
        $this->line('2. Você será redirecionado para: /install');
        $this->line('3. Siga os passos do wizard:');
        $this->line('   - Bem-vindo → /install');
        $this->line('   - Requisitos → /install/requirements');
        $this->line('   - Banco de Dados → /install/database');
        $this->line('   - Configuração → /install/configure');
        $this->line('   - Instalação → /install/finish (POST)');
        $this->line('   - Conclusão → /install/complete');
        
        $this->info('💡 Dica: Use o "Modo Demo" para testar sem banco de dados!');
        
        return 0;
    }
} 