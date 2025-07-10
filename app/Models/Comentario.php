<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Comentario extends Model
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'comentarios';

    protected $fillable = [
        'denuncia_id',
        'user_id',
        'comentario',
        'tipo',
        'importante',
        'reply_to'
    ];

    protected $casts = [
        'importante' => 'boolean',
    ];

    // Relacionamentos
    public function denuncia()
    {
        return $this->belongsTo(Denuncia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento para comentário pai (se for uma resposta)
    public function parent()
    {
        return $this->belongsTo(Comentario::class, 'reply_to');
    }

    // Relacionamento para respostas deste comentário
    public function replies()
    {
        return $this->hasMany(Comentario::class, 'reply_to');
    }

    // Verificar se é uma resposta
    public function isReply()
    {
        return !is_null($this->reply_to);
    }

    // Verificar se tem respostas
    public function hasReplies()
    {
        return $this->replies()->count() > 0;
    }

    // Scopes
    public function scopeInternos($query)
    {
        return $query->where('tipo', 'interno');
    }

    public function scopePublicos($query)
    {
        return $query->where('tipo', 'publico');
    }

    public function scopeImportantes($query)
    {
        return $query->where('importante', true);
    }

    public function scopePorUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecentes($query, $dias = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($dias));
    }

    // Acessors
    public function getTempoDecorridoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getTipoLabelAttribute()
    {
        return $this->tipo === 'interno' ? 'Interno' : 'Público';
    }

    public function getTipoCorAttribute()
    {
        return $this->tipo === 'interno' ? 'warning' : 'info';
    }

    public function getIsInternoAttribute()
    {
        return $this->tipo === 'interno';
    }

    public function getIsPublicoAttribute()
    {
        return $this->tipo === 'publico';
    }

    public function getComentarioResumidoAttribute()
    {
        return strlen($this->comentario) > 100 
            ? substr($this->comentario, 0, 100) . '...' 
            : $this->comentario;
    }

    // Mutators
    public function setComentarioAttribute($value)
    {
        $this->attributes['comentario'] = trim($value);
    }

    public function setTipoAttribute($value)
    {
        $this->attributes['tipo'] = strtolower($value);
    }

    // Métodos
    public function podeSerEditado($user = null)
    {
        if (!$user) return false;

        // Apenas o autor pode editar (se não for importante)
        if ($this->user_id === $user->id && !$this->importante) {
            return true;
        }

        // Admins podem editar qualquer comentário
        return $user->is_admin ?? false;
    }

    public function podeSerExcluido($user = null)
    {
        if (!$user) return false;

        // Apenas o autor pode excluir (se não for importante)
        if ($this->user_id === $user->id && !$this->importante) {
            return true;
        }

        // Admins podem excluir qualquer comentário
        return $user->is_admin ?? false;
    }

    public function podeSerVisualizado($user = null)
    {
        // Comentários públicos podem ser vistos por qualquer um
        if ($this->is_publico) {
            return true;
        }

        // Comentários internos apenas por admins ou responsável pela denúncia
        if ($user) {
            return $user->is_admin || $this->denuncia->responsavel_id === $user->id;
        }

        return false;
    }

    public function marcarComoImportante()
    {
        $this->update(['importante' => true]);
        return $this;
    }

    public function desmarcarComoImportante()
    {
        $this->update(['importante' => false]);
        return $this;
    }

    public function alternarImportancia()
    {
        $this->update(['importante' => !$this->importante]);
        return $this;
    }

    public function tocarNotificacao()
    {
        // Aqui você pode implementar notificações
        // Por exemplo, enviar email para o responsável da denúncia
        return $this;
    }
}
