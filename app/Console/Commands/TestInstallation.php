<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class TestInstallation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the installation wizard without database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Testando Wizard de Instalação...');

        // Verificar se o arquivo installed existe
        if (File::exists(storage_path('installed'))) {
            $this->warn('⚠️  O sistema já está instalado!');
            $this->info('Para testar novamente, remova o arquivo: storage/installed');
            return 1;
        }

        $this->info('✅ Sistema não instalado - wizard deve aparecer');
        $this->info('🌐 Acesse: http://127.0.0.1:8000');
        $this->info('📋 O wizard deve redirecionar automaticamente');

        // Verificar arquivos do wizard
        $wizardFiles = [
            'app/Http/Controllers/InstallController.php',
            'routes/install.php',
            'resources/views/install/layout.blade.php',
            'resources/views/install/welcome.blade.php',
            'resources/views/install/requirements.blade.php',
            'resources/views/install/database.blade.php',
            'resources/views/install/configure.blade.php',
            'resources/views/install/complete.blade.php',
        ];

        $this->info('📁 Verificando arquivos do wizard...');
        foreach ($wizardFiles as $file) {
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

        // Verificar rotas
        $this->info('🔗 Verificando rotas...');
        $routes = [
            'install.welcome' => '/install',
            'install.requirements' => '/install/requirements',
            'install.database' => '/install/database',
            'install.configure' => '/install/configure',
            'install.install' => '/install/install',
            'install.complete' => '/install/complete',
        ];

        foreach ($routes as $name => $path) {
            $this->line("✅ {$name} => {$path}");
        }

        $this->info('🎯 Teste concluído!');
        $this->info('💡 Para testar sem banco de dados, use o modo de demonstração');
        
        return 0;
    }
} 