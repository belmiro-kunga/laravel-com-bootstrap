@extends('layouts.app')

@section('title', 'Detalhes da Denúncia')

@section('page-title', 'Detalhes da Denúncia')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('rastreamento.index') }}">Rastrear Denúncias</a>
</li>
<li class="breadcrumb-item active">{{ $denuncia->protocolo }}</li>
@endsection

@section('content')
<div class="row">
    <!-- Informações Principais -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt"></i> Denúncia {{ $denuncia->protocolo }}
                    </h5>
                    <div>
                        @if($denuncia->urgente)
                            <span class="badge bg-danger">Urgente</span>
                        @endif
                        <span class="badge" style="background-color: {{ $denuncia->status->cor }}">
                            {{ $denuncia->status->nome }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-heading"></i> Título</h6>
                        <p class="mb-3">{{ $denuncia->titulo }}</p>
                        
                        <h6><i class="fas fa-tag"></i> Categoria</h6>
                        <span class="badge mb-3" style="background-color: {{ $denuncia->categoria->cor }}">
                            {{ $denuncia->categoria->nome }}
                        </span>
                        
                        <h6><i class="fas fa-map-marker-alt"></i> Local da Ocorrência</h6>
                        <p class="mb-3">{{ $denuncia->local_ocorrencia ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-calendar"></i> Data da Ocorrência</h6>
                        <p class="mb-3">{{ $denuncia->data_ocorrencia ? \Carbon\Carbon::parse($denuncia->data_ocorrencia)->format('d/m/Y') : 'Não informada' }}</p>
                        
                        <h6><i class="fas fa-clock"></i> Hora da Ocorrência</h6>
                        <p class="mb-3">{{ $denuncia->hora_ocorrencia ?? 'Não informada' }}</p>
                        
                        <h6><i class="fas fa-exclamation-triangle"></i> Prioridade</h6>
                        <span class="badge bg-{{ $denuncia->prioridade == 'alta' ? 'danger' : ($denuncia->prioridade == 'media' ? 'warning' : 'info') }} mb-3">
                            {{ ucfirst($denuncia->prioridade) }}
                        </span>
                    </div>
                </div>
                
                <h6><i class="fas fa-align-left"></i> Descrição</h6>
                <p>{{ $denuncia->descricao }}</p>
                
                @if($denuncia->envolvidos)
                <h6><i class="fas fa-users"></i> Envolvidos</h6>
                <p>{{ $denuncia->envolvidos }}</p>
                @endif
                
                @if($denuncia->testemunhas)
                <h6><i class="fas fa-user-friends"></i> Testemunhas</h6>
                <p>{{ $denuncia->testemunhas }}</p>
                @endif
            </div>
        </div>

        <!-- Timeline de Status -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history"></i> Timeline de Status
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @foreach($historicoStatus as $status)
                    <div class="timeline-item">
                        <div class="timeline-marker {{ $status->ordem <= $denuncia->status->ordem ? 'active' : '' }}" 
                             style="background-color: {{ $status->cor }}">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="timeline-content">
                            <h6>{{ $status->nome }}</h6>
                            <p class="text-muted">{{ $status->descricao }}</p>
                            @if($status->ordem <= $denuncia->status->ordem)
                                <small class="text-success">
                                    <i class="fas fa-check-circle"></i> Concluído
                                </small>
                            @else
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> Pendente
                                </small>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Histórico real de mudanças de status -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list"></i> Histórico de Mudanças de Status
                </h5>
            </div>
            <div class="card-body">
                @php
                    $historico = $denuncia->historicoStatus()->orderBy('created_at')->get();
                @endphp
                @if($historico->count())
                    <ul class="list-group">
                        @foreach($historico as $item)
                            <li class="list-group-item">
                                <strong>{{ $item->statusAnterior->nome ?? '-' }}</strong>
                                <i class="fas fa-arrow-right mx-2"></i>
                                <strong>{{ $item->statusNovo->nome ?? '-' }}</strong>
                                <span class="text-muted ms-2">em {{ $item->created_at->format('d/m/Y H:i') }}</span>
                                @if($item->user)
                                    <span class="text-muted ms-2">por {{ $item->user->name }}</span>
                                @endif
                                @if($item->comentario)
                                    <br><em>{{ $item->comentario }}</em>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Nenhuma mudança de status registrada.</p>
                @endif
            </div>
        </div>

        <!-- Mensagens e Comentários -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-comments"></i> Mensagens e Atualizações
                </h5>
            </div>
            <div class="card-body">
                @if($denuncia->comentarios->where('tipo', 'publico')->count() > 0)
                    @foreach($denuncia->comentarios->where('tipo', 'publico')->whereNull('reply_to')->sortBy('created_at') as $comentario)
                    <div class="message mb-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $comentario->user->name }}</h6>
                                        <span class="badge bg-info">Mensagem</span>
                                    </div>
                                    <small class="text-muted">{{ $comentario->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <div class="message-content p-3 bg-light rounded mt-2">
                                    <p class="mb-0">{{ $comentario->comentario }}</p>
                                </div>
                                @if($comentario->importante)
                                    <span class="badge bg-warning text-dark mt-2">
                                        <i class="fas fa-star"></i> Importante
                                    </span>
                                @endif
                                
                                <!-- Respostas -->
                                @if($comentario->replies->count() > 0)
                                    <div class="replies mt-3">
                                        @foreach($comentario->replies->sortBy('created_at') as $resposta)
                                        <div class="reply ms-4 mb-2">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                                        <i class="fas fa-reply"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <small class="fw-bold">{{ $resposta->user->name }}</small>
                                                            <span class="badge bg-success ms-1">Resposta</span>
                                                        </div>
                                                        <small class="text-muted">{{ $resposta->created_at->format('d/m/Y H:i') }}</small>
                                                    </div>
                                                    <div class="reply-content p-2 bg-white border rounded mt-1">
                                                        <small>{{ $resposta->comentario }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <!-- Formulário de Resposta -->
                                @if(Auth::check() && ($denuncia->user_id === Auth::id() || $denuncia->email_denunciante === Auth::user()->email))
                                <div class="reply-form mt-3">
                                    <form action="{{ route('comentarios.responder', $comentario) }}" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <textarea class="form-control" name="resposta" rows="2" 
                                                      placeholder="Digite sua resposta..." required></textarea>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-reply"></i> Responder
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-comment-slash fa-2x text-muted mb-2"></i>
                        <p class="text-muted">Nenhuma mensagem ainda.</p>
                        <!-- Debug temporário -->
                        <small class="text-muted">
                            Total de comentários: {{ $denuncia->comentarios->count() }}<br>
                            Comentários públicos: {{ $denuncia->comentarios->where('tipo', 'publico')->count() }}<br>
                            Comentários sem reply_to: {{ $denuncia->comentarios->where('tipo', 'publico')->whereNull('reply_to')->count() }}
                        </small>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Informações do Responsável -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-user-tie"></i> Responsável
                </h6>
            </div>
            <div class="card-body text-center">
                @if($denuncia->responsavel)
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-user fa-2x"></i>
                    </div>
                    <h6>{{ $denuncia->responsavel->name }}</h6>
                    <p class="text-muted">{{ $denuncia->responsavel->email }}</p>
                    <span class="badge bg-info">{{ ucfirst($denuncia->responsavel->role) }}</span>
                @else
                    <i class="fas fa-user-slash fa-2x text-muted mb-2"></i>
                    <p class="text-muted">Não atribuído</p>
                @endif
            </div>
        </div>

        <!-- Datas Importantes -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-calendar-alt"></i> Datas Importantes
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Criada em:</strong><br>
                    <small class="text-muted">{{ $denuncia->created_at->format('d/m/Y H:i') }}</small>
                </div>
                <div class="mb-3">
                    <strong>Última atualização:</strong><br>
                    <small class="text-muted">{{ $denuncia->updated_at->format('d/m/Y H:i') }}</small>
                </div>
                @if($denuncia->data_limite)
                <div class="mb-3">
                    <strong>Data limite:</strong><br>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($denuncia->data_limite)->format('d/m/Y') }}</small>
                </div>
                @endif
            </div>
        </div>

        <!-- Evidências -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-paperclip"></i> Evidências
                </h6>
            </div>
            <div class="card-body">
                @if($denuncia->evidencias->count() > 0)
                    @foreach($denuncia->evidencias as $evidencia)
                    <div class="evidence-item mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file me-2"></i>
                            <div class="flex-grow-1">
                                <small>{{ $evidencia->nome_original }}</small><br>
                                <small class="text-muted">{{ number_format($evidencia->tamanho / 1024, 2) }} KB</small>
                            </div>
                            <a href="{{ route('evidencias.download', $evidencia->id) }}" 
                               class="btn btn-sm btn-outline-primary" title="Download">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center mb-0">Nenhuma evidência anexada.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    background-color: #6c757d;
}

.timeline-marker.active {
    background-color: #28a745;
}

.timeline-content {
    padding-left: 20px;
}

.message {
    border-left: 3px solid #007bff;
    padding-left: 15px;
}

.message-content {
    border-left: 3px solid #007bff;
}

.reply {
    border-left: 2px solid #28a745;
    padding-left: 10px;
}

.reply-content {
    border-left: 2px solid #28a745;
}

.reply-form {
    border-top: 1px solid #e9ecef;
    padding-top: 15px;
}

.evidence-item {
    padding: 10px;
    border: 1px solid #e9ecef;
    border-radius: 5px;
}
</style>
@endsection 