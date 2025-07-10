<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Permission;

class GrantDefaultPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:grant-defaults {--user-id= : ID específico do usuário}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Conceder permissões padrão aos usuários baseadas em seus roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user-id');
        
        if ($userId) {
            $users = User::where('id', $userId)->get();
        } else {
            $users = User::all();
        }

        $this->info("Concedendo permissões padrão para {$users->count()} usuário(s)...");

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            $this->grantDefaultPermissions($user);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Permissões concedidas com sucesso!');
    }

    private function grantDefaultPermissions(User $user)
    {
        // Definir permissões padrão baseadas no role
        $defaultPermissions = $this->getDefaultPermissionsByRole($user->role);
        
        // Conceder permissões
        foreach ($defaultPermissions as $permissionSlug) {
            $user->grantPermission($permissionSlug);
        }
    }

    private function getDefaultPermissionsByRole($role)
    {
        switch ($role) {
            case 'admin':
                return [
                    // Menus
                    'dashboard.view',
                    'denuncias.menu',
                    'categorias.menu',
                    'relatorios.menu',
                    'usuarios.menu',
                    'rastreamento.menu',
                    
                    // Funcionalidades - Denúncias
                    'denuncias.view',
                    'denuncias.create',
                    'denuncias.edit',
                    'denuncias.delete',
                    'denuncias.view_all',
                    'denuncias.change_status',
                    'denuncias.assign_responsible',
                    
                    // Funcionalidades - Categorias
                    'categorias.view',
                    'categorias.create',
                    'categorias.edit',
                    'categorias.delete',
                    
                    // Funcionalidades - Usuários
                    'usuarios.view',
                    'usuarios.create',
                    'usuarios.edit',
                    'usuarios.delete',
                    'usuarios.manage_permissions',
                    
                    // Funcionalidades - Relatórios
                    'relatorios.view',
                    'relatorios.export',
                    
                    // Funcionalidades - Comentários
                    'comentarios.view_internal',
                    'comentarios.create',
                    'comentarios.edit',
                    'comentarios.delete',
                    
                    // Funcionalidades - Evidências
                    'evidencias.view_private',
                    'evidencias.upload',
                    'evidencias.download',
                ];
                
            case 'responsavel':
                return [
                    // Menus
                    'dashboard.view',
                    'denuncias.menu',
                    'relatorios.menu',
                    'rastreamento.menu',
                    
                    // Funcionalidades - Denúncias
                    'denuncias.view',
                    'denuncias.create',
                    'denuncias.edit',
                    'denuncias.change_status',
                    'denuncias.assign_responsible',
                    
                    // Funcionalidades - Relatórios
                    'relatorios.view',
                    'relatorios.export',
                    
                    // Funcionalidades - Comentários
                    'comentarios.view_internal',
                    'comentarios.create',
                    'comentarios.edit',
                    'comentarios.delete',
                    
                    // Funcionalidades - Evidências
                    'evidencias.view_private',
                    'evidencias.upload',
                    'evidencias.download',
                ];
                
            case 'usuario':
                return [
                    // Menus
                    'dashboard.view',
                    'rastreamento.menu',
                    
                    // Funcionalidades básicas
                    'denuncias.view',
                    'comentarios.create',
                ];
                
            default:
                return [];
        }
    }
}
