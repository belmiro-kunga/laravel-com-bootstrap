<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'event',
        'auditable_type',
        'auditable_id',
        'user_id',
        'user_type',
        'ip_address',
        'user_agent',
        'old_values',
        'new_values',
        'description',
        'url',
        'method',
        'metadata'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'metadata' => 'array',
    ];

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function auditable()
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeByEvent($query, $event)
    {
        return $query->where('event', $event);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAuditable($query, $type, $id = null)
    {
        $query->where('auditable_type', $type);
        if ($id) {
            $query->where('auditable_id', $id);
        }
        return $query;
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Acessors
    public function getEventLabelAttribute()
    {
        $labels = [
            'created' => 'Criado',
            'updated' => 'Atualizado',
            'deleted' => 'Excluído',
            'restored' => 'Restaurado',
            'login' => 'Login',
            'logout' => 'Logout',
            'password_changed' => 'Senha Alterada',
            'permission_granted' => 'Permissão Concedida',
            'permission_revoked' => 'Permissão Revogada',
            'file_uploaded' => 'Arquivo Enviado',
            'file_downloaded' => 'Arquivo Baixado',
            'comment_added' => 'Comentário Adicionado',
            'status_changed' => 'Status Alterado',
            'responsible_assigned' => 'Responsável Atribuído'
        ];
        return $labels[$this->event] ?? ucfirst($this->event);
    }

    public function getEventIconAttribute()
    {
        $icons = [
            'created' => 'fas fa-plus-circle text-success',
            'updated' => 'fas fa-edit text-primary',
            'deleted' => 'fas fa-trash text-danger',
            'restored' => 'fas fa-undo text-warning',
            'login' => 'fas fa-sign-in-alt text-success',
            'logout' => 'fas fa-sign-out-alt text-secondary',
            'password_changed' => 'fas fa-key text-warning',
            'permission_granted' => 'fas fa-check-circle text-success',
            'permission_revoked' => 'fas fa-times-circle text-danger',
            'file_uploaded' => 'fas fa-upload text-info',
            'file_downloaded' => 'fas fa-download text-info',
            'comment_added' => 'fas fa-comment text-primary',
            'status_changed' => 'fas fa-exchange-alt text-warning',
            'responsible_assigned' => 'fas fa-user-tie text-primary'
        ];
        return $icons[$this->event] ?? 'fas fa-info-circle text-secondary';
    }

    public function getAuditableTypeLabelAttribute()
    {
        $labels = [
            'App\\Models\\User' => 'Usuário',
            'App\\Models\\Denuncia' => 'Denúncia',
            'App\\Models\\Categoria' => 'Categoria',
            'App\\Models\\Status' => 'Status',
            'App\\Models\\Comentario' => 'Comentário',
            'App\\Models\\Evidencia' => 'Evidência',
            'App\\Models\\Permission' => 'Permissão'
        ];
        return $labels[$this->auditable_type] ?? class_basename($this->auditable_type);
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    // Métodos
    public function getChangesSummary()
    {
        if (empty($this->old_values) && empty($this->new_values)) {
            return null;
        }

        $changes = [];
        
        if ($this->old_values && $this->new_values) {
            foreach ($this->new_values as $field => $newValue) {
                $oldValue = $this->old_values[$field] ?? null;
                if ($oldValue !== $newValue) {
                    $changes[] = "Campo '{$field}' alterado de '{$oldValue}' para '{$newValue}'";
                }
            }
        }

        return $changes;
    }

    public function hasAuditChanges()
    {
        return !empty($this->old_values) || !empty($this->new_values);
    }
}
