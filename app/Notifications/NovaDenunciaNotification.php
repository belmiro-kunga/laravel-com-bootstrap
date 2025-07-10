<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Denuncia;

class NovaDenunciaNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $denuncia;

    /**
     * Create a new notification instance.
     */
    public function __construct(Denuncia $denuncia)
    {
        $this->denuncia = $denuncia;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $protocolo = $this->denuncia->protocolo;
        $titulo = $this->denuncia->titulo;
        $categoria = $this->denuncia->categoria->nome;
        $data = $this->denuncia->created_at->format('d/m/Y H:i');

        return (new MailMessage)
            ->subject("🚨 Nova Denúncia Recebida - Protocolo: {$protocolo}")
            ->greeting("Olá {$notifiable->name}!")
            ->line("Uma nova denúncia foi registrada no sistema e requer sua atenção.")
            ->line("**Detalhes da Denúncia:**")
            ->line("• **Protocolo:** {$protocolo}")
            ->line("• **Título:** {$titulo}")
            ->line("• **Categoria:** {$categoria}")
            ->line("• **Data/Hora:** {$data}")
            ->action('Ver Denúncia', url("/denuncias/{$this->denuncia->id}"))
            ->line('Esta denúncia está aguardando análise e possível atribuição de responsável.')
            ->salutation('Atenciosamente, Sistema de Denúncias');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'denuncia_id' => $this->denuncia->id,
            'protocolo' => $this->denuncia->protocolo,
            'titulo' => $this->denuncia->titulo,
            'categoria' => $this->denuncia->categoria->nome,
            'tipo' => 'nova_denuncia',
            'mensagem' => "Nova denúncia recebida: {$this->denuncia->protocolo}",
            'data' => $this->denuncia->created_at->toISOString(),
        ];
    }
}
