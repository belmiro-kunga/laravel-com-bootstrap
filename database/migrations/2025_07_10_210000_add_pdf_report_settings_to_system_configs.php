<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\SystemConfig;

return new class extends Migration
{
    public function up()
    {
        // Adiciona configurações apenas se não existirem
        $defaults = [
            ['key' => 'pdf_report_title', 'value' => 'Relatório de Denúncia', 'type' => 'string', 'group' => 'pdf', 'description' => 'Título do relatório PDF', 'is_public' => false],
            ['key' => 'pdf_report_footer', 'value' => 'Confidencial - Uso interno', 'type' => 'string', 'group' => 'pdf', 'description' => 'Rodapé do relatório PDF', 'is_public' => false],
            ['key' => 'pdf_report_show_timeline', 'value' => '1', 'type' => 'boolean', 'group' => 'pdf', 'description' => 'Exibir timeline de status', 'is_public' => false],
            ['key' => 'pdf_report_show_comments', 'value' => '1', 'type' => 'boolean', 'group' => 'pdf', 'description' => 'Exibir comentários', 'is_public' => false],
            ['key' => 'pdf_report_show_evidences', 'value' => '1', 'type' => 'boolean', 'group' => 'pdf', 'description' => 'Exibir evidências', 'is_public' => false],
            ['key' => 'pdf_report_show_people', 'value' => '1', 'type' => 'boolean', 'group' => 'pdf', 'description' => 'Exibir pessoas envolvidas', 'is_public' => false],
            ['key' => 'pdf_report_sections_order', 'value' => json_encode(['info','description','people','timeline','comments','evidences']), 'type' => 'json', 'group' => 'pdf', 'description' => 'Ordem das seções do PDF', 'is_public' => false],
            ['key' => 'pdf_report_primary_color', 'value' => '#4361ee', 'type' => 'string', 'group' => 'pdf', 'description' => 'Cor primária do PDF', 'is_public' => false],
        ];
        foreach ($defaults as $config) {
            if (!SystemConfig::where('key', $config['key'])->exists()) {
                SystemConfig::create($config);
            }
        }
    }

    public function down()
    {
        $keys = [
            'pdf_report_title',
            'pdf_report_footer',
            'pdf_report_show_timeline',
            'pdf_report_show_comments',
            'pdf_report_show_evidences',
            'pdf_report_show_people',
            'pdf_report_sections_order',
            'pdf_report_primary_color',
        ];
        \App\Models\SystemConfig::whereIn('key', $keys)->delete();
    }
}; 