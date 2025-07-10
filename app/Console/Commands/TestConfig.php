<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\ConfigHelper;
use App\Models\SystemConfig;

class TestConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'config:test {key} {value?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testar configurações do sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $key = $this->argument('key');
        $value = $this->argument('value');

        if ($value) {
            // Definir valor
            ConfigHelper::set($key, $value, 'string', 'frontend', 'Teste');
            $this->info("Configuração '{$key}' definida como '{$value}'");
        }

        // Buscar valor
        $retrievedValue = ConfigHelper::get($key);
        $this->info("Valor recuperado para '{$key}': '{$retrievedValue}'");

        // Verificar no banco
        $config = SystemConfig::where('key', $key)->first();
        if ($config) {
            $this->info("Valor no banco para '{$key}': '{$config->value}'");
        } else {
            $this->error("Configuração '{$key}' não encontrada no banco");
        }

        // Listar todas as configurações de frontend
        $this->info("\nConfigurações de frontend:");
        $frontendConfigs = SystemConfig::where('group', 'frontend')->get();
        foreach ($frontendConfigs as $config) {
            $this->line("- {$config->key}: {$config->value}");
        }
    }
} 