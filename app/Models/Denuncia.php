<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Traits\Auditable;
use App\Notifications\StatusChangedNotification;

class Denuncia extends Model
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'denuncias';

    protected $fillable = [
        'protocolo',
        'categoria_id',
        'status_id',
        'titulo',
        'descricao',
        'local_ocorrencia',
        'data_ocorrencia',
        'hora_ocorrencia',
        'nome_denunciante',
        'email_denunciante',
        'telefone_denunciante',
        'departamento_denunciante',
        'envolvidos',
        'testemunhas',
        'prioridade',
        'urgente',
        'responsavel_id',
        'data_limite',
        'observacoes_internas',
        'ip_denunciante',
        'user_agent'
    ];

    protected $casts = [
        'data_ocorrencia' => 'date',
        'hora_ocorrencia' => 'datetime:H:i',
        'data_limite' => 'date',
        'urgente' => 'boolean',
    ];

    // Relacionamentos
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function evidencias()
    {
        return $this->hasMany(Evidencia::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function comentariosInternos()
    {
        return $this->hasMany(Comentario::class)->where('tipo', 'interno');
    }

    public function comentariosPublicos()
    {
        return $this->hasMany(Comentario::class)->where('tipo', 'publico');
    }

    public function historicoStatus()
    {
        return $this->hasMany(HistoricoStatus::class)->orderBy('created_at', 'desc');
    }

    // Scopes
    public function scopePorStatus($query, $statusId)
    {
        return $query->where('status_id', $statusId);
    }

    public function scopePorCategoria($query, $categoriaId)
    {
        return $query->where('categoria_id', $categoriaId);
    }

    public function scopeUrgentes($query)
    {
        return $query->where('urgente', true);
    }

    public function scopePorPrioridade($query, $prioridade)
    {
        return $query->where('prioridade', $prioridade);
    }

    public function scopePorResponsavel($query, $responsavelId)
    {
        return $query->where('responsavel_id', $responsavelId);
    }

    public function scopeSemResponsavel($query)
    {
        return $query->whereNull('responsavel_id');
    }

    public function scopeAtrasadas($query)
    {
        return $query->whereNotNull('data_limite')
                    ->where('data_limite', '<', now())
                    ->whereNotIn('status_id', Status::finalizadores()->pluck('id'));
    }

    public function scopeRecentes($query, $dias = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($dias));
    }

    // Acessors
    public function getIsAnonimaAttribute()
    {
        return empty($this->nome_denunciante) && empty($this->email_denunciante);
    }

    public function getIsAtrasadaAttribute()
    {
        return $this->data_limite && $this->data_limite < now() && !$this->status->is_finalizador;
    }

    public function getDiasAtrasoAttribute()
    {
        if (!$this->is_atrasada) return 0;
        return $this->data_limite->diffInDays(now());
    }

    public function getTempoDecorridoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getPrioridadeLabelAttribute()
    {
        $labels = [
            'baixa' => 'Baixa',
            'media' => 'Média',
            'alta' => 'Alta',
            'critica' => 'Crítica'
        ];
        return $labels[$this->prioridade] ?? 'Média';
    }

    public function getPrioridadeCorAttribute()
    {
        $cores = [
            'baixa' => 'success',
            'media' => 'info',
            'alta' => 'warning',
            'critica' => 'danger'
        ];
        return $cores[$this->prioridade] ?? 'info';
    }

    // Mutators
    public function setTituloAttribute($value)
    {
        $this->attributes['titulo'] = ucfirst($value);
    }

    public function setDescricaoAttribute($value)
    {
        $this->attributes['descricao'] = ucfirst($value);
    }

    // Métodos
    public function gerarProtocolo()
    {
        $data = now();
        $dataFormatada = $data->format('Ymd'); // AAAAMMDD
        
        // Buscar o último protocolo do dia
        $ultimoProtocolo = self::whereDate('created_at', $data->toDateString())
                              ->orderBy('id', 'desc')
                              ->first();

        if ($ultimoProtocolo) {
            // Extrair o número sequencial do último protocolo do dia
            $partes = explode('-', $ultimoProtocolo->protocolo);
            if (count($partes) == 2 && $partes[0] == $dataFormatada) {
                $numero = (int) $partes[1] + 1;
            } else {
                $numero = 1;
            }
        } else {
            $numero = 1;
        }

        return sprintf('%s-%05d', $dataFormatada, $numero);
    }

    public function podeSerEditada()
    {
        return !in_array($this->status->nome, ['Resolvida', 'Arquivada', 'Cancelada']);
    }

    public function podeSerExcluida()
    {
        return $this->status->nome === 'Recebida' && $this->comentarios()->count() === 0;
    }

    public function adicionarComentario($comentario, $userId, $tipo = 'interno')
    {
        return $this->comentarios()->create([
            'user_id' => $userId,
            'comentario' => $comentario,
            'tipo' => $tipo
        ]);
    }

    public function alterarStatus($statusId, $userId = null, $comentario = null)
    {
        $statusAnterior = $this->status_id;
        $statusAnteriorObj = $this->status;
        $statusNovoObj = \App\Models\Status::find($statusId);
        $userResponsavel = $userId ? \App\Models\User::find($userId) : null;
        
        $this->update(['status_id' => $statusId]);
        $this->refresh();
        
        // Registrar no histórico
        $this->historicoStatus()->create([
            'status_anterior_id' => $statusAnterior,
            'status_novo_id' => $statusId,
            'user_id' => $userId,
            'comentario' => $comentario,
            'dados_anteriores' => [
                'status_anterior' => $statusAnteriorObj ? $statusAnteriorObj->nome : null,
                'status_novo' => $this->status->nome
            ]
        ]);

        // Adicionar comentário se fornecido
        if ($comentario && $userId) {
            $this->adicionarComentario(
                "Status alterado de '{$statusAnteriorObj->nome}' para '{$this->status->nome}'. {$comentario}",
                $userId,
                'interno'
            );
        }

        // Notificação por email
        $notificados = collect();
        // Notificar responsável, se houver e se preferir
        if ($this->responsavel && $this->responsavel->email_notifications && $this->responsavel->status_change_notifications) {
            $this->responsavel->notify(new StatusChangedNotification($this, $statusNovoObj, $statusAnteriorObj, $userResponsavel, $comentario));
            $notificados->push($this->responsavel->id);
        }
        // Notificar todos admins (exceto duplicados)
        $admins = \App\Models\User::where('role', 'admin')
            ->where('email_notifications', true)
            ->where('status_change_notifications', true)
            ->whereNotIn('id', $notificados)
            ->get();
        foreach ($admins as $admin) {
            $admin->notify(new StatusChangedNotification($this, $statusNovoObj, $statusAnteriorObj, $userResponsavel, $comentario));
            $notificados->push($admin->id);
        }
        // (Opcional) Notificar denunciante identificado
        if ($this->email_denunciante && filter_var($this->email_denunciante, FILTER_VALIDATE_EMAIL)) {
            // Aqui pode-se criar um notifiable customizado se desejar
        }

        return $this;
    }

    public function atribuirResponsavel($responsavelId, $userId = null, $comentario = null)
    {
        $responsavelAnterior = $this->responsavel_id;
        $this->update(['responsavel_id' => $responsavelId]);

        if ($comentario && $userId) {
            $responsavel = User::find($responsavelId);
            $this->adicionarComentario(
                "Responsável atribuído: {$responsavel->name}. {$comentario}",
                $userId,
                'interno'
            );
        }

        return $this;
    }

    // Boot method para gerar protocolo automaticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($denuncia) {
            if (empty($denuncia->protocolo)) {
                $denuncia->protocolo = $denuncia->gerarProtocolo();
            }
        });
    }
}
