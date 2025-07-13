<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = [
            [
                'nome' => 'Recebida',
                'descricao' => 'Denúncia recebida e aguardando análise inicial',
                'cor' => '#007bff',
                'ordem' => 1,
                'ativo' => true,
                'is_finalizador' => false
            ],
            [
                'nome' => 'Em Análise',
                'descricao' => 'Denúncia em processo de análise e investigação',
                'cor' => '#ffc107',
                'ordem' => 2,
                'ativo' => true,
                'is_finalizador' => false
            ],
            [
                'nome' => 'Em Investigação',
                'descricao' => 'Denúncia em processo de investigação detalhada',
                'cor' => '#fd7e14',
                'ordem' => 3,
                'ativo' => true,
                'is_finalizador' => false
            ],
            [
                'nome' => 'Aguardando Informações',
                'descricao' => 'Aguardando informações adicionais para prosseguir',
                'cor' => '#6f42c1',
                'ordem' => 4,
                'ativo' => true,
                'is_finalizador' => false
            ],
            [
                'nome' => 'Em Tratamento',
                'descricao' => 'Denúncia em processo de tratamento e correção',
                'cor' => '#20c997',
                'ordem' => 5,
                'ativo' => true,
                'is_finalizador' => false
            ],
            [
                'nome' => 'Resolvida',
                'descricao' => 'Denúncia foi resolvida com sucesso',
                'cor' => '#28a745',
                'ordem' => 6,
                'ativo' => true,
                'is_finalizador' => true
            ],
            [
                'nome' => 'Arquivada',
                'descricao' => 'Denúncia arquivada por falta de evidências ou improcedência',
                'cor' => '#6c757d',
                'ordem' => 7,
                'ativo' => true,
                'is_finalizador' => true
            ],
            [
                'nome' => 'Cancelada',
                'descricao' => 'Denúncia cancelada pelo denunciante',
                'cor' => '#dc3545',
                'ordem' => 8,
                'ativo' => true,
                'is_finalizador' => true
            ]
        ];

        foreach ($status as $st) {
            Status::updateOrCreate(
                ['nome' => $st['nome']],
                $st
            );
        }

        $this->command->info('Status criados com sucesso!');
    }
} 