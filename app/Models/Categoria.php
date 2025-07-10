<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Categoria extends Model
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'categorias';

    protected $fillable = [
        'nome',
        'descricao',
        'cor',
        'ordem',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    // Relacionamentos
    public function denuncias()
    {
        return $this->hasMany(Denuncia::class);
    }

    // Scopes
    public function scopeAtivas($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenadas($query)
    {
        return $query->orderBy('nome');
    }

    // Acessors
    public function getDenunciasCountAttribute()
    {
        return $this->denuncias()->count();
    }

    // Mutators
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = ucfirst(strtolower($value));
    }

    // Métodos
    public function isAtiva()
    {
        return $this->ativo;
    }

    public function getCorFormatadaAttribute()
    {
        return $this->cor ?? '#007bff';
    }
}
