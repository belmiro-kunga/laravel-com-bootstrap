<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HistoricoStatus;
use App\Models\Denuncia;

class ShowAuditLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audit:logs {--denuncia= : ID da denúncia específica} {--limit=10 : Limite de registros}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mostra logs de auditoria das denúncias';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $denunciaId = $this->option('denuncia');
        $limit = $this->option('limit');

        $query = HistoricoStatus::with(['denuncia', 'statusAnterior', 'statusNovo', 'user']);

        if ($denunciaId) {
            $query->where('denuncia_id', $denunciaId);
            $denuncia = Denuncia::find($denunciaId);
            if (!$denuncia) {
                $this->error("Denúncia com ID {$denunciaId} não encontrada!");
                return 1;
            }
            $this->info("Logs de auditoria para denúncia: {$denuncia->protocolo}");
        }

        $logs = $query->orderBy('created_at', 'desc')->limit($limit)->get();

        if ($logs->isEmpty()) {
            $this->warn('Nenhum log de auditoria encontrado.');
            return 0;
        }

        $this->table(
            ['ID', 'Protocolo', 'Status Anterior', 'Status Novo', 'Usuário', 'Comentário', 'Data'],
            $logs->map(function ($log) {
                return [
                    $log->id,
                    $log->denuncia->protocolo,
                    $log->statusAnterior ? $log->statusAnterior->nome : 'Nenhum',
                    $log->statusNovo->nome,
                    $log->user ? $log->user->name : 'Sistema',
                    $log->comentario ?: '-',
                    $log->created_at->format('d/m/Y H:i:s')
                ];
            })
        );

        $this->info("Total de registros: {$logs->count()}");
        return 0;
    }
}
