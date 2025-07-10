<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class TestPermissions extends Command
{
    protected $signature = 'test:permissions';
    protected $description = 'Testar permissões do usuário admin';

    public function handle()
    {
        $this->info('🧪 Testando permissões do usuário admin...');

        // Buscar usuário compliance
        $user = User::where('email', 'compliance@empresa.com')->first();
        
        if (!$user) {
            $this->error('❌ Usuário compliance não encontrado!');
            return;
        }

        $this->info("✅ Usuário: {$user->name} ({$user->email})");
        $this->info(" Role: {$user->role}");

        // Testar permissões específicas
        $permissions = [
            'usuarios.view',
            'usuarios.create', 
            'usuarios.edit',
            'usuarios.delete',
            'usuarios.manage_permissions'
        ];

        foreach ($permissions as $permission) {
            $hasPermission = $user->hasPermission($permission);
            $status = $hasPermission ? '✅' : '❌';
            $this->line("   {$status} {$permission}: " . ($hasPermission ? 'SIM' : 'NÃO'));
        }

        // Testar se é admin
        $isAdmin = $user->is_admin;
        $this->info(" É admin: " . ($isAdmin ? 'SIM' : 'NÃO'));

        if ($isAdmin) {
            $this->info('🎉 Usuário admin tem todas as permissões automaticamente!');
        }

        $this->info('✅ Teste concluído!');
    }
} 