<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class FixPermissions extends Command
{
    protected $signature = 'permissions:fix';
    protected $description = 'Criar permissões e conceder aos usuários admin';

    public function handle()
    {
        $this->info('🔧 Verificando e corrigindo permissões...');

        // 1. Criar permissões se não existirem
        $this->info('�� Criando permissões...');
        $seeder = new PermissionsSeeder();
        $seeder->run();

        // 2. Verificar se as permissões foram criadas
        $permissionsCount = Permission::count();
        $this->info("✅ {$permissionsCount} permissões encontradas no banco");

        // 3. Conceder permissões aos usuários admin
        $this->info('�� Concedendo permissões aos usuários admin...');
        $adminUsers = User::where('role', 'admin')->get();
        
        foreach ($adminUsers as $user) {
            $this->info("   - Concedendo permissões para: {$user->name} ({$user->email})");
            
            // Conceder todas as permissões disponíveis
            $permissions = Permission::all();
            foreach ($permissions as $permission) {
                $user->grantPermission($permission->slug);
            }
        }

        // 4. Verificar se o usuário compliance tem permissões
        $complianceUser = User::where('email', 'compliance@empresa.com')->first();
        if ($complianceUser) {
            $hasEditPermission = $complianceUser->hasPermission('usuarios.edit');
            $this->info("�� Usuário compliance tem permissão 'usuarios.edit': " . ($hasEditPermission ? 'SIM' : 'NÃO'));
            
            if (!$hasEditPermission) {
                $this->error('❌ PROBLEMA: Usuário compliance não tem permissão para editar usuários!');
                $this->info('�� Concedendo permissão manualmente...');
                $complianceUser->grantPermission('usuarios.edit');
                $this->info('✅ Permissão concedida!');
            }
        }

        $this->info('🎉 Permissões corrigidas com sucesso!');
        $this->info('💡 Agora você pode tentar editar usuários novamente.');
    }
} 