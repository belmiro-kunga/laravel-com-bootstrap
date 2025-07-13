<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nome' => 'Assédio Moral',
                'descricao' => 'Denúncias relacionadas a assédio moral no ambiente de trabalho',
                'cor' => '#dc3545',
                'ordem' => 1,
                'ativo' => true
            ],
            [
                'nome' => 'Assédio Sexual',
                'descricao' => 'Denúncias relacionadas a assédio sexual no ambiente de trabalho',
                'cor' => '#fd7e14',
                'ordem' => 2,
                'ativo' => true
            ],
            [
                'nome' => 'Discriminação',
                'descricao' => 'Denúncias relacionadas a discriminação por raça, gênero, idade, etc.',
                'cor' => '#6f42c1',
                'ordem' => 3,
                'ativo' => true
            ],
            [
                'nome' => 'Corrupção',
                'descricao' => 'Denúncias relacionadas a atos de corrupção ou desvio de recursos',
                'cor' => '#e83e8c',
                'ordem' => 4,
                'ativo' => true
            ],
            [
                'nome' => 'Irregularidades Trabalhistas',
                'descricao' => 'Denúncias relacionadas a irregularidades nas relações de trabalho',
                'cor' => '#20c997',
                'ordem' => 5,
                'ativo' => true
            ],
            [
                'nome' => 'Segurança do Trabalho',
                'descricao' => 'Denúncias relacionadas a condições inseguras de trabalho',
                'cor' => '#ffc107',
                'ordem' => 6,
                'ativo' => true
            ],
            [
                'nome' => 'Meio Ambiente',
                'descricao' => 'Denúncias relacionadas a danos ambientais ou não conformidade',
                'cor' => '#28a745',
                'ordem' => 7,
                'ativo' => true
            ],
            [
                'nome' => 'Qualidade',
                'descricao' => 'Denúncias relacionadas a problemas de qualidade em produtos ou serviços',
                'cor' => '#17a2b8',
                'ordem' => 8,
                'ativo' => true
            ],
            [
                'nome' => 'Outros',
                'descricao' => 'Outras denúncias não categorizadas',
                'cor' => '#6c757d',
                'ordem' => 9,
                'ativo' => true
            ]
        ];

        foreach ($categorias as $categoria) {
            Categoria::updateOrCreate(
                ['nome' => $categoria['nome']],
                $categoria
            );
        }

        $this->command->info('Categorias criadas com sucesso!');
    }
} 