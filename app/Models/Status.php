<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'status';

    protected $fillable = [
        'nome',
        'descricao',
        'cor',
        'ordem',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'ordem' => 'integer',
    ];

    // Relacionamentos
    public function denuncias()
    {
        return $this->hasMany(Denuncia::class);
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('ordem')->orderBy('nome');
    }

    public function scopeFinalizadores($query)
    {
        return $query->whereIn('nome', ['Resolvida', 'Arquivada', 'Cancelada']);
    }

    // Acessors
    public function getDenunciasCountAttribute()
    {
        return $this->denuncias()->count();
    }

    public function getIsFinalizadorAttribute()
    {
        return in_array($this->nome, ['Resolvida', 'Arquivada', 'Cancelada']);
    }

    // Mutators
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = ucfirst(strtolower($value));
    }

    // Métodos
    public function isAtivo()
    {
        return $this->ativo;
    }

    public function isFinalizador()
    {
        return $this->is_finalizador;
    }

    public function getCorFormatadaAttribute()
    {
        return $this->cor ?? '#6c757d';
    }
}
