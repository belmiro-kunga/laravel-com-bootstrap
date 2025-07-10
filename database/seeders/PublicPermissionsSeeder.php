<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublicPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar se as permissões públicas já existem
        if (Permission::where('slug', 'denuncias.formulario-publico')->exists() && 
            Permission::where('slug', 'rastreamento.publico')->exists()) {
            $this->command->info('As permissões públicas já existem. Nenhuma ação foi realizada.');
            return;
        }

        // Desativar verificações de chave estrangeira para evitar erros
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Inserir permissões públicas
        $publicPermissions = [
            [
                'name' => 'Acesso ao Formulário Público de Denúncias',
                'slug' => 'denuncias.formulario-publico',
                'description' => 'Permite o acesso ao formulário público para envio de denúncias',
                'category' => 'public',
                'group' => 'denuncias',
                'order' => 100,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Acesso ao Rastreamento Público de Denúncias',
                'slug' => 'rastreamento.publico',
                'description' => 'Permite o acesso à página de rastreamento público de denúncias',
                'category' => 'public',
                'group' => 'denuncias',
                'order' => 101,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Inserir as permissões
        DB::table('permissions')->insert($publicPermissions);
        
        // Ativar verificações de chave estrangeira novamente
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->command->info('Permissões públicas criadas com sucesso!');
    }
}
