<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Denuncia;

class DenunciaOverdueNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $denuncia;
    public $isEscalation;

    /**
     * Create a new notification instance.
     */
    public function __construct(Denuncia $denuncia, $isEscalation = false)
    {
        $this->denuncia = $denuncia;
        $this->isEscalation = $isEscalation;
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
        $url = route('denuncias.show', $this->denuncia);
        $diasAtraso = $this->denuncia->dias_atraso;

        if ($this->isEscalation) {
            // Notificação para admins (escalonamento)
            return (new MailMessage)
                ->subject("🚨 ESCALONAMENTO - Denúncia Atrasada {$this->denuncia->protocolo}")
                ->greeting("Atenção {$notifiable->name}!")
                ->line("Uma denúncia foi escalonada para sua atenção por estar **{$diasAtraso} dias atrasada**.")
                ->line("**Protocolo:** {$this->denuncia->protocolo}")
                ->line("**Título:** {$this->denuncia->titulo}")
                ->line("**Status Atual:** {$this->denuncia->status->nome}")
                ->line("**Data Limite:** " . ($this->denuncia->data_limite ? $this->denuncia->data_limite->format('d/m/Y') : 'Não definida'))
                ->line("**Responsável:** " . ($this->denuncia->responsavel ? $this->denuncia->responsavel->name : 'Não atribuído'))
                ->action('Ver Denúncia', $url)
                ->line("Esta denúncia requer atenção imediata.")
                ->salutation('Sistema de Denúncias - Escalonamento Automático');
        } else {
            // Notificação para responsável
            return (new MailMessage)
                ->subject("⚠️ Lembrete - Denúncia Atrasada {$this->denuncia->protocolo}")
                ->greeting("Olá {$notifiable->name}!")
                ->line("A denúncia sob sua responsabilidade está **{$diasAtraso} dias atrasada**.")
                ->line("**Protocolo:** {$this->denuncia->protocolo}")
                ->line("**Título:** {$this->denuncia->titulo}")
                ->line("**Status Atual:** {$this->denuncia->status->nome}")
                ->line("**Data Limite:** " . ($this->denuncia->data_limite ? $this->denuncia->data_limite->format('d/m/Y') : 'Não definida'))
                ->action('Ver Denúncia', $url)
                ->line("Por favor, atualize o status ou solicite prorrogação se necessário.")
                ->salutation('Sistema de Denúncias - Lembrete Automático');
        }
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
            'dias_atraso' => $this->denuncia->dias_atraso,
            'status_atual' => $this->denuncia->status->nome,
            'data_limite' => $this->denuncia->data_limite ? $this->denuncia->data_limite->format('d/m/Y') : null,
            'responsavel' => $this->denuncia->responsavel ? $this->denuncia->responsavel->name : null,
            'is_escalation' => $this->isEscalation,
            'tipo' => 'denuncia_overdue',
            'url' => route('denuncias.show', $this->denuncia)
        ];
    }
}
