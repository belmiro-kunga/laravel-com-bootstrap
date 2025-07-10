<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Denuncia;

class DenunciaFinalizadaNotification extends Notification implements ShouldQueue
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
        $responsavel = $this->denuncia->responsavel ? $this->denuncia->responsavel->name : 'Não atribuído';
        $dataFinalizacao = $this->denuncia->updated_at->format('d/m/Y H:i');
        $tempoResolucao = $this->denuncia->created_at->diffInDays($this->denuncia->updated_at);

        return (new MailMessage)
            ->subject("✅ Denúncia Finalizada - Protocolo: {$protocolo}")
            ->greeting("Olá {$notifiable->name}!")
            ->line("Uma denúncia foi finalizada no sistema.")
            ->line("**Detalhes da Denúncia:**")
            ->line("• **Protocolo:** {$protocolo}")
            ->line("• **Título:** {$titulo}")
            ->line("• **Responsável:** {$responsavel}")
            ->line("• **Data de Finalização:** {$dataFinalizacao}")
            ->line("• **Tempo de Resolução:** {$tempoResolucao} dias")
            ->action('Ver Denúncia', url("/denuncias/{$this->denuncia->id}"))
            ->line('Esta denúncia foi marcada como resolvida e não requer mais atenção.')
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
            'responsavel' => $this->denuncia->responsavel ? $this->denuncia->responsavel->name : 'Não atribuído',
            'tipo' => 'denuncia_finalizada',
            'mensagem' => "Denúncia finalizada: {$this->denuncia->protocolo}",
            'data' => $this->denuncia->updated_at->toISOString(),
        ];
    }
}
