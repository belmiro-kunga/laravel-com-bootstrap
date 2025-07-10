<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoStatus extends Model
{
    use HasFactory;

    protected $table = 'historico_status';

    protected $fillable = [
        'denuncia_id',
        'status_anterior_id',
        'status_novo_id',
        'user_id',
        'comentario',
        'dados_anteriores'
    ];

    protected $casts = [
        'dados_anteriores' => 'array'
    ];

    // Relacionamentos
    public function denuncia()
    {
        return $this->belongsTo(Denuncia::class);
    }

    public function statusAnterior()
    {
        return $this->belongsTo(Status::class, 'status_anterior_id');
    }

    public function statusNovo()
    {
        return $this->belongsTo(Status::class, 'status_novo_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Acessors
    public function getDescricaoMudancaAttribute()
    {
        $anterior = $this->statusAnterior ? $this->statusAnterior->nome : 'Nenhum';
        $novo = $this->statusNovo ? $this->statusNovo->nome : 'Nenhum';
        
        return "Status alterado de '{$anterior}' para '{$novo}'";
    }

    public function getTempoDecorridoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    // Scopes
    public function scopePorDenuncia($query, $denunciaId)
    {
        return $query->where('denuncia_id', $denunciaId);
    }

    public function scopeRecentes($query, $dias = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($dias));
    }
}
