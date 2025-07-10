<?php

namespace App\Traits;

use App\Services\AuditService;

trait Auditable
{
    /**
     * Boot the trait
     */
    protected static function bootAuditable()
    {
        // Evento de criação
        static::created(function ($model) {
            AuditService::logCreated($model);
        });

        // Evento de atualização
        static::updated(function ($model) {
            $changes = $model->getChanges();
            $original = $model->getOriginal();
            
            // Filtrar apenas campos que realmente mudaram
            $oldValues = [];
            foreach ($changes as $field => $newValue) {
                if (array_key_exists($field, $original)) {
                    $oldValues[$field] = $original[$field];
                }
            }
            
            if (!empty($oldValues)) {
                AuditService::logUpdated($model, $oldValues);
            }
        });

        // Evento de exclusão
        static::deleted(function ($model) {
            AuditService::logDeleted($model);
        });

        // Evento de restauração (soft delete) - apenas se o modelo usar SoftDeletes
        if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive(static::class))) {
            static::restored(function ($model) {
                AuditService::logRestored($model);
            });
        }
    }

    /**
     * Obter logs de auditoria deste modelo
     */
    public function auditLogs()
    {
        return $this->morphMany(\App\Models\AuditLog::class, 'auditable');
    }

    /**
     * Obter logs de auditoria por evento
     */
    public function auditLogsByEvent($event)
    {
        return $this->auditLogs()->where('event', $event);
    }

    /**
     * Obter logs de auditoria recentes
     */
    public function recentAuditLogs($days = 30)
    {
        return $this->auditLogs()->recent($days);
    }

    /**
     * Verificar se o modelo tem logs de auditoria
     */
    public function hasAuditLogs()
    {
        return $this->auditLogs()->exists();
    }

    /**
     * Obter o último log de auditoria
     */
    public function lastAuditLog()
    {
        return $this->auditLogs()->latest()->first();
    }

    /**
     * Obter logs de auditoria por usuário
     */
    public function auditLogsByUser($userId)
    {
        return $this->auditLogs()->where('user_id', $userId);
    }

    /**
     * Obter histórico de mudanças de um campo específico
     */
    public function getFieldHistory($field)
    {
        return $this->auditLogs()
            ->where('event', 'updated')
            ->where(function ($query) use ($field) {
                $query->whereJsonContains('old_values', [$field => null])
                      ->orWhereJsonContains('new_values', [$field => null])
                      ->orWhereRaw("JSON_EXTRACT(old_values, '$.{$field}') IS NOT NULL")
                      ->orWhereRaw("JSON_EXTRACT(new_values, '$.{$field}') IS NOT NULL");
            })
            ->orderBy('created_at', 'desc');
    }
} 