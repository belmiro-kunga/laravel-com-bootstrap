<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Denuncia;
use App\Models\Status;
use App\Models\User;

class StatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $denuncia;
    public $statusAnterior;
    public $statusNovo;
    public $userResponsavel;
    public $comentario;

    /**
     * Create a new notification instance.
     */
    public function __construct(Denuncia $denuncia, Status $statusNovo, Status $statusAnterior = null, User $userResponsavel = null, $comentario = null)
    {
        $this->denuncia = $denuncia;
        $this->statusAnterior = $statusAnterior;
        $this->statusNovo = $statusNovo;
        $this->userResponsavel = $userResponsavel;
        $this->comentario = $comentario;
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
        $statusAnteriorNome = $this->statusAnterior ? $this->statusAnterior->nome : 'Nenhum';
        $userResponsavelNome = $this->userResponsavel ? $this->userResponsavel->name : 'Sistema';
        
        $url = route('denuncias.show', $this->denuncia);

        return (new MailMessage)
            ->subject("Status Alterado - Denúncia {$this->denuncia->protocolo}")
            ->greeting("Olá {$notifiable->name}!")
            ->line("O status da denúncia **{$this->denuncia->protocolo}** foi alterado.")
            ->line("**Título:** {$this->denuncia->titulo}")
            ->line("**Status Anterior:** {$statusAnteriorNome}")
            ->line("**Novo Status:** {$this->statusNovo->nome}")
            ->line("**Alterado por:** {$userResponsavelNome}")
            ->when($this->comentario, function ($message) {
                return $message->line("**Comentário:** {$this->comentario}");
            })
            ->action('Ver Denúncia', $url)
            ->line("Esta notificação foi enviada automaticamente pelo sistema.")
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
            'status_anterior' => $this->statusAnterior ? $this->statusAnterior->nome : null,
            'status_novo' => $this->statusNovo->nome,
            'user_responsavel_id' => $this->userResponsavel ? $this->userResponsavel->id : null,
            'user_responsavel_nome' => $this->userResponsavel ? $this->userResponsavel->name : 'Sistema',
            'comentario' => $this->comentario,
            'tipo' => 'status_changed',
            'url' => route('denuncias.show', $this->denuncia)
        ];
    }
}
