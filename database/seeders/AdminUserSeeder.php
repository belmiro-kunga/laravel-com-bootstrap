<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar se o usuário admin já existe
        if (User::where('email', 'admin@admin.com')->exists()) {
            $this->command->info('O usuário admin já existe. Nenhuma ação foi realizada.');
            return;
        }

        // Criar usuário admin
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'), // Senha padrão: password
            'role' => 'admin',
            'ativo' => true,
            'email_verified_at' => now(),
        ]);

        // Obter todas as permissões
        $permissions = Permission::all();
        
        // Atribuir todas as permissões ao usuário admin
        $permissionsData = [];
        $now = now();
        
        foreach ($permissions as $permission) {
            $permissionsData[$permission->id] = [
                'granted' => true,
                'granted_at' => $now,
                'granted_by' => $admin->id,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        
        $admin->permissions()->sync($permissionsData);
        
        $this->command->info('Usuário admin criado com sucesso!');
        $this->command->info('Email: admin@admin.com');
        $this->command->info('Senha: password');
    }
}
