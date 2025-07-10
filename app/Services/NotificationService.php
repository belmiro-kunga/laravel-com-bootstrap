<?php

namespace App\Services;

use App\Models\User;
use App\Models\Denuncia;
use App\Notifications\NovaDenunciaNotification;
use App\Notifications\DenunciaFinalizadaNotification;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    /**
     * Notificar admins e moderadores sobre nova denúncia
     */
    public static function notificarNovaDenuncia(Denuncia $denuncia)
    {
        // Buscar todos os usuários admin e moderadores
        $usuarios = User::where('ativo', true)
            ->whereIn('role', ['admin', 'moderator'])
            ->get();

        if ($usuarios->isNotEmpty()) {
            Notification::send($usuarios, new NovaDenunciaNotification($denuncia));
        }
    }

    /**
     * Notificar apenas admins sobre denúncia finalizada
     */
    public static function notificarDenunciaFinalizada(Denuncia $denuncia)
    {
        // Buscar apenas usuários admin
        $admins = User::where('ativo', true)
            ->where('role', 'admin')
            ->get();

        if ($admins->isNotEmpty()) {
            Notification::send($admins, new DenunciaFinalizadaNotification($denuncia));
        }
    }

    /**
     * Notificar responsável sobre atribuição de denúncia
     */
    public static function notificarAtribuicao(Denuncia $denuncia, User $responsavel)
    {
        // Implementar notificação para o responsável
        // Por enquanto, apenas log
        \Log::info("Denúncia {$denuncia->protocolo} atribuída para {$responsavel->name}");
    }

    /**
     * Verificar se usuário deve receber notificações
     */
    public static function deveNotificar(User $user, string $tipo): bool
    {
        // Verificar preferências do usuário (implementar depois)
        return true;
    }
} 