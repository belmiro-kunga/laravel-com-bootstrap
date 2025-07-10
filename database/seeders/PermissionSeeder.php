<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Desativar verificações de chave estrangeira para evitar erros
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Limpar a tabela de permissões
        DB::table('permissions')->truncate();
        
        // Ativar verificações de chave estrangeira novamente
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Permissões de Usuários
        $this->createPermission(
            'Gerenciar Usuários', 
            'usuarios.gerenciar', 
            'Gerenciar usuários do sistema', 
            'usuarios', 
            'administracao'
        );

        $this->createPermission(
            'Visualizar Usuários', 
            'usuarios.visualizar', 
            'Visualizar lista de usuários', 
            'usuarios', 
            'administracao'
        );

        $this->createPermission(
            'Criar Usuários', 
            'usuarios.criar', 
            'Criar novos usuários', 
            'usuarios', 
            'administracao'
        );

        $this->createPermission(
            'Editar Usuários', 
            'usuarios.editar', 
            'Editar usuários existentes', 
            'usuarios', 
            'administracao'
        );

        $this->createPermission(
            'Excluir Usuários', 
            'usuarios.excluir', 
            'Excluir usuários', 
            'usuarios', 
            'administracao'
        );

        // Permissões de Permissões
        $this->createPermission(
            'Gerenciar Permissões', 
            'permissoes.gerenciar', 
            'Gerenciar permissões do sistema', 
            'permissoes', 
            'administracao'
        );

        // Permissões de Denúncias
        $this->createPermission(
            'Visualizar Todas as Denúncias', 
            'denuncias.visualizar_todas', 
            'Visualizar todas as denúncias do sistema', 
            'denuncias', 
            'operacional'
        );

        $this->createPermission(
            'Gerenciar Denúncias', 
            'denuncias.gerenciar', 
            'Gerenciar denúncias', 
            'denuncias', 
            'operacional'
        );

        $this->createPermission(
            'Criar Denúncias', 
            'denuncias.criar', 
            'Criar novas denúncias', 
            'denuncias', 
            'operacional'
        );

        $this->createPermission(
            'Editar Denúncias', 
            'denuncias.editar', 
            'Editar denúncias existentes', 
            'denuncias', 
            'operacional'
        );

        $this->createPermission(
            'Excluir Denúncias', 
            'denuncias.excluir', 
            'Excluir denúncias', 
            'denuncias', 
            'administracao'
        );

        // Permissões de Categorias
        $this->createPermission(
            'Gerenciar Categorias', 
            'categorias.gerenciar', 
            'Gerenciar categorias de denúncias', 
            'categorias', 
            'configuracoes'
        );

        // Permissões de Status
        $this->createPermission(
            'Gerenciar Status', 
            'status.gerenciar', 
            'Gerenciar status de denúncias', 
            'status', 
            'configuracoes'
        );

        // Permissões de Relatórios
        $this->createPermission(
            'Visualizar Relatórios', 
            'relatorios.visualizar', 
            'Visualizar relatórios do sistema', 
            'relatorios', 
            'administracao'
        );

        // Permissões de Configurações
        $this->createPermission(
            'Gerenciar Configurações', 
            'configuracoes.gerenciar', 
            'Gerenciar configurações do sistema', 
            'configuracoes', 
            'administracao'
        );
    }

    /**
     * Cria uma nova permissão
     */
    private function createPermission(string $name, string $slug, string $description, string $group, string $category, int $order = 0): void
    {
        Permission::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'group' => $group,
            'category' => $category,
            'order' => $order,
            'active' => true,
        ]);
    }
}
