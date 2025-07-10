<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Denuncia;
use App\Models\User;
use App\Services\NotificationService;

class TestNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notifications {--type=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testar notificações do sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->option('type');
        
        // Buscar uma denúncia de teste
        $denuncia = Denuncia::with(['categoria', 'status', 'responsavel'])->first();
        
        if (!$denuncia) {
            $this->error('Nenhuma denúncia encontrada no sistema.');
            return 1;
        }

        $this->info("Testando notificações com denúncia: {$denuncia->protocolo}");

        if ($type === 'all' || $type === 'nova') {
            $this->info('Testando notificação de nova denúncia...');
            try {
                // Buscar usuários admin e moderadores
                $usuarios = User::where('ativo', true)
                    ->whereIn('role', ['admin', 'moderator'])
                    ->get();

                if ($usuarios->isNotEmpty()) {
                    // Criar notificação apenas no banco (sem email)
                    foreach ($usuarios as $usuario) {
                        $usuario->notifications()->create([
                            'id' => \Illuminate\Support\Str::uuid(),
                            'type' => 'App\Notifications\NovaDenunciaNotification',
                            'notifiable_type' => 'App\Models\User',
                            'notifiable_id' => $usuario->id,
                            'data' => [
                                'denuncia_id' => $denuncia->id,
                                'protocolo' => $denuncia->protocolo,
                                'titulo' => $denuncia->titulo,
                                'categoria' => $denuncia->categoria->nome,
                                'tipo' => 'nova_denuncia',
                                'mensagem' => "Nova denúncia recebida: {$denuncia->protocolo}",
                                'data' => $denuncia->created_at->toISOString(),
                            ],
                            'read_at' => null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                    $this->info("✅ {$usuarios->count()} notificação(ões) de nova denúncia criada(s) no banco!");
                } else {
                    $this->warn('Nenhum usuário admin ou moderador encontrado.');
                }
            } catch (\Exception $e) {
                $this->error('❌ Erro ao criar notificação de nova denúncia: ' . $e->getMessage());
            }
        }

        if ($type === 'all' || $type === 'finalizada') {
            $this->info('Testando notificação de denúncia finalizada...');
            try {
                // Buscar apenas usuários admin
                $admins = User::where('ativo', true)
                    ->where('role', 'admin')
                    ->get();

                if ($admins->isNotEmpty()) {
                    // Criar notificação apenas no banco (sem email)
                    foreach ($admins as $admin) {
                        $admin->notifications()->create([
                            'id' => \Illuminate\Support\Str::uuid(),
                            'type' => 'App\Notifications\DenunciaFinalizadaNotification',
                            'notifiable_type' => 'App\Models\User',
                            'notifiable_id' => $admin->id,
                            'data' => [
                                'denuncia_id' => $denuncia->id,
                                'protocolo' => $denuncia->protocolo,
                                'titulo' => $denuncia->titulo,
                                'responsavel' => $denuncia->responsavel ? $denuncia->responsavel->name : 'Não atribuído',
                                'tipo' => 'denuncia_finalizada',
                                'mensagem' => "Denúncia finalizada: {$denuncia->protocolo}",
                                'data' => $denuncia->updated_at->toISOString(),
                            ],
                            'read_at' => null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                    $this->info("✅ {$admins->count()} notificação(ões) de denúncia finalizada criada(s) no banco!");
                } else {
                    $this->warn('Nenhum usuário admin encontrado.');
                }
            } catch (\Exception $e) {
                $this->error('❌ Erro ao criar notificação de denúncia finalizada: ' . $e->getMessage());
            }
        }

        // Mostrar estatísticas
        $admins = User::where('role', 'admin')->where('ativo', true)->count();
        $moderadores = User::where('role', 'moderator')->where('ativo', true)->count();
        
        $this->info("\n📊 Estatísticas:");
        $this->info("• Admins ativos: {$admins}");
        $this->info("• Moderadores ativos: {$moderadores}");
        $this->info("• Total de destinatários para nova denúncia: " . ($admins + $moderadores));
        $this->info("• Total de destinatários para denúncia finalizada: {$admins}");

        // Mostrar notificações criadas
        $totalNotifications = \Illuminate\Notifications\DatabaseNotification::count();
        $unreadNotifications = \Illuminate\Notifications\DatabaseNotification::whereNull('read_at')->count();
        
        $this->info("\n📋 Notificações no Sistema:");
        $this->info("• Total de notificações: {$totalNotifications}");
        $this->info("• Notificações não lidas: {$unreadNotifications}");

        return 0;
    }
}
