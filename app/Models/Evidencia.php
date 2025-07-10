<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Evidencia extends Model
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'evidencias';

    protected $fillable = [
        'denuncia_id',
        'user_id',
        'nome_original',
        'nome_arquivo',
        'caminho',
        'tipo_mime',
        'tamanho',
        'extensao',
        'descricao',
        'publico'
    ];

    protected $casts = [
        'tamanho' => 'integer',
        'publico' => 'boolean',
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

    // Scopes
    public function scopePublicas($query)
    {
        return $query->where('publico', true);
    }

    public function scopePrivadas($query)
    {
        return $query->where('publico', false);
    }

    public function scopePorTipo($query, $extensao)
    {
        return $query->where('extensao', strtolower($extensao));
    }

    public function scopeImagens($query)
    {
        return $query->whereIn('extensao', ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
    }

    public function scopeDocumentos($query)
    {
        return $query->whereIn('extensao', ['pdf', 'doc', 'docx', 'txt', 'rtf']);
    }

    public function scopeVideos($query)
    {
        return $query->whereIn('extensao', ['mp4', 'avi', 'mov', 'wmv', 'flv']);
    }

    public function scopeAudios($query)
    {
        return $query->whereIn('extensao', ['mp3', 'wav', 'ogg', 'aac']);
    }

    // Acessors
    public function getTamanhoFormatadoAttribute()
    {
        $bytes = $this->tamanho;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->caminho);
    }

    public function getIsImagemAttribute()
    {
        return in_array($this->extensao, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
    }

    public function getIsVideoAttribute()
    {
        return in_array($this->extensao, ['mp4', 'avi', 'mov', 'wmv', 'flv']);
    }

    public function getIsAudioAttribute()
    {
        return in_array($this->extensao, ['mp3', 'wav', 'ogg', 'aac']);
    }

    public function getIsDocumentoAttribute()
    {
        return in_array($this->extensao, ['pdf', 'doc', 'docx', 'txt', 'rtf']);
    }

    public function getIconeAttribute()
    {
        if ($this->is_imagem) return 'fas fa-image';
        if ($this->is_video) return 'fas fa-video';
        if ($this->is_audio) return 'fas fa-music';
        if ($this->is_documento) return 'fas fa-file-alt';
        return 'fas fa-file';
    }

    public function getCorAttribute()
    {
        if ($this->is_imagem) return 'success';
        if ($this->is_video) return 'danger';
        if ($this->is_audio) return 'warning';
        if ($this->is_documento) return 'primary';
        return 'secondary';
    }

    // Mutators
    public function setNomeOriginalAttribute($value)
    {
        $this->attributes['nome_original'] = $value;
        $this->attributes['extensao'] = strtolower(pathinfo($value, PATHINFO_EXTENSION));
    }

    public function setExtensaoAttribute($value)
    {
        $this->attributes['extensao'] = strtolower($value);
    }

    // Métodos
    public function podeSerVisualizada($user = null)
    {
        // Se é pública, qualquer um pode ver
        if ($this->publico) {
            return true;
        }

        // Se não é pública, apenas admins ou responsável pela denúncia
        if ($user) {
            return $user->is_admin || $this->denuncia->responsavel_id === $user->id;
        }

        return false;
    }

    public function podeSerExcluida($user = null)
    {
        if (!$user) return false;

        // Apenas admins ou responsável pela denúncia podem excluir
        return $user->is_admin || $this->denuncia->responsavel_id === $user->id;
    }

    public function excluirArquivo()
    {
        $caminhoCompleto = storage_path('app/public/' . $this->caminho);
        
        if (file_exists($caminhoCompleto)) {
            unlink($caminhoCompleto);
        }

        return $this->delete();
    }

    // Boot method para excluir arquivo quando o registro for deletado
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($evidencia) {
            $evidencia->excluirArquivo();
        });
    }
}
