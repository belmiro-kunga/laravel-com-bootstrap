@extends('layouts.app')

@section('title', 'Denúncia ' . $denuncia->protocolo . ' - Sistema de Denúncias')

@section('page-title', 'Denúncia ' . $denuncia->protocolo)

@section('breadcrumb')
    <x-admin.breadcrumb :items="[
        ['title' => 'Denúncias', 'url' => route('denuncias.index'), 'icon' => 'fas fa-exclamation-triangle'],
        ['title' => $denuncia->protocolo, 'icon' => 'fas fa-eye']
    ]" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Detalhes principais -->
        <div class="col-lg-8">
            <x-admin.card title="{{ $denuncia->titulo }}" subtitle="Protocolo: {{ $denuncia->protocolo }}">
                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <span class="badge bg-{{ $denuncia->status->cor ?? 'secondary' }} me-2">{{ $denuncia->status->nome ?? '-' }}</span>
                        <span class="badge bg-{{ $denuncia->prioridade_cor }}">{{ $denuncia->prioridade_label }}</span>
                        @if($denuncia->urgente)
                            <span class="badge bg-danger ms-1">Urgente</span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-2 text-end">
                        <span class="badge bg-primary">{{ $denuncia->categoria->nome ?? '-' }}</span>
                        @if($denuncia->responsavel)
                            <span class="badge bg-info ms-1">{{ $denuncia->responsavel->name }}</span>
                        @else
                            <span class="badge bg-secondary ms-1">Não atribuído</span>
                        @endif
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Data de Criação:</strong> {{ $denuncia->created_at->format('d/m/Y H:i') }}<br>
                    @if($denuncia->data_ocorrencia)
                        <strong>Data da Ocorrência:</strong> {{ $denuncia->data_ocorrencia->format('d/m/Y') }}<br>
                    @endif
                    @if($denuncia->local_ocorrencia)
                        <strong>Local:</strong> {{ $denuncia->local_ocorrencia }}<br>
                    @endif
                </div>
                <div class="mb-3">
                    <strong>Descrição:</strong>
                    <p class="mt-2">{{ $denuncia->descricao }}</p>
                </div>
                @if($denuncia->envolvidos)
                <div class="mb-3">
                    <strong>Envolvidos:</strong>
                    <p class="mt-2">{{ $denuncia->envolvidos }}</p>
                </div>
                @endif
                @if($denuncia->testemunhas)
                <div class="mb-3">
                    <strong>Testemunhas:</strong>
                    <p class="mt-2">{{ $denuncia->testemunhas }}</p>
                </div>
                @endif
                @if($denuncia->observacoes_internas)
                <div class="mb-3">
                    <strong>Observações Internas:</strong>
                    <div class="alert alert-info">
                        {{ $denuncia->observacoes_internas }}
                    </div>
                </div>
                @endif
                <div class="mb-3">
                    <strong>Tipo de Denúncia:</strong>
                    @if($denuncia->is_anonima)
                        <span class="badge bg-warning"><i class="fas fa-user-secret"></i> Anônima</span>
                    @else
                        <span class="badge bg-info"><i class="fas fa-user"></i> Identificada</span>
                        <small class="text-muted d-block mt-1">Denunciante: {{ $denuncia->nome_denunciante }} ({{ $denuncia->email_denunciante }})</small>
                    @endif
                </div>
                <!-- Workflow de status com modal para comentário -->
                <div class="mb-3 d-flex flex-wrap gap-2">
                    @foreach(['Recebida', 'Em Análise', 'Resolvida', 'Arquivada'] as $statusNome)
                        @php
                            $statusObj = \App\Models\Status::where('nome', $statusNome)->first();
                        @endphp
                        @if($statusObj && $denuncia->status_id !== $statusObj->id)
                        <button type="button" 
                                class="btn btn-outline-{{ $statusObj->cor ?? 'secondary' }} btn-sm"
                                data-bs-toggle="modal" 
                                data-bs-target="#modalAlterarStatus"
                                data-status-id="{{ $statusObj->id }}"
                                data-status-nome="{{ $statusObj->nome }}"
                                data-status-cor="{{ $statusObj->cor ?? 'secondary' }}">
                            {{ $statusObj->nome }}
                        </button>
                        @endif
                    @endforeach
                </div>
                <!-- Botão para modal de atribuição de responsável -->
                <button type="button" class="btn btn-outline-info btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#modalResponsavel">
                    <i class="fas fa-user-plus"></i> Atribuir/Alterar Responsável
                </button>
                <!-- Ações rápidas com confirmação -->
                <div class="d-flex gap-2 flex-wrap mb-3">
                    <!-- Botão removido: funcionalidade de marcar como urgente não implementada -->
                </div>
            </x-admin.card>

            <!-- Timeline de status com logs de auditoria -->
            <x-admin.card title="Histórico de Status e Auditoria" class="mb-4">
                <div class="timeline">
                    @foreach($denuncia->historicoStatus()->with(['statusAnterior', 'statusNovo', 'user'])->get() as $item)
                    <div class="timeline-item">
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between">
                                <div>
                                    @if($item->statusAnterior)
                                        <span class="badge bg-secondary me-1">{{ $item->statusAnterior->nome }}</span>
                                        <i class="fas fa-arrow-right text-muted me-1"></i>
                                    @endif
                                    <span class="badge bg-{{ $item->statusNovo->cor ?? 'secondary' }}">{{ $item->statusNovo->nome }}</span>
                                    <small class="text-muted ms-2">{{ $item->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <div>
                                    @if($item->user)
                                        <span class="text-muted"><i class="fas fa-user"></i> {{ $item->user->name }}</span>
                                    @else
                                        <span class="text-muted">Sistema</span>
                                    @endif
                                </div>
                            </div>
                            @if($item->comentario)
                            <div class="mt-2">
                                <div class="alert alert-light border">
                                    <i class="fas fa-comment text-muted me-1"></i>
                                    <strong>Comentário:</strong> {{ $item->comentario }}
                                </div>
                            </div>
                            @endif
                            <div class="mt-1">
                                <small class="text-muted">{{ $item->tempo_decorrido }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </x-admin.card>

            <!-- Comentários -->
            <x-admin.card title="Comentários">
                @if(Auth::user()->podeGerenciarDenuncias())
                <form action="{{ route('comentarios.store', $denuncia) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="mb-3">
                        <label for="comentario" class="form-label">Novo Comentário</label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="interno">Interno</option>
                                    <option value="publico">Público</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" id="importante" name="importante">
                                    <label class="form-check-label" for="importante">
                                        Marcar como importante
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Adicionar Comentário
                    </button>
                </form>
                @endif
                <div id="comentarios-lista">
                    @foreach($denuncia->comentarios()->with('user')->orderBy('created_at', 'desc')->get() as $comentario)
                    <div class="card mb-3 {{ $comentario->importante ? 'border-warning' : '' }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <strong>{{ $comentario->user->name }}</strong>
                                    <span class="badge bg-{{ $comentario->tipo_cor }} ms-2">{{ $comentario->tipo_label }}</span>
                                    @if($comentario->importante)
                                        <span class="badge bg-warning ms-1">Importante</span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ $comentario->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div>{{ $comentario->comentario }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </x-admin.card>
        </div>
        <!-- Galeria de evidências -->
        <div class="col-lg-4">
            <x-admin.card title="Evidências">
                <div class="row g-2">
                    @forelse($denuncia->evidencias as $evidencia)
                    <div class="col-6 col-md-12 mb-2">
                        <a href="{{ $evidencia->url }}" target="_blank">
                            <img src="{{ $evidencia->thumbnail_url ?? $evidencia->url }}" alt="Evidência" class="img-fluid rounded shadow-sm mb-1" style="max-height:120px;object-fit:cover;">
                        </a>
                        <div class="small text-muted text-truncate">{{ $evidencia->nome_arquivo }}</div>
                        <a href="{{ $evidencia->url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1"><i class="fas fa-search"></i> Ver</a>
                        <a href="{{ $evidencia->url }}" download class="btn btn-sm btn-outline-success mt-1"><i class="fas fa-download"></i> Baixar</a>
                    </div>
                    @empty
                    <div class="col-12 text-muted">Nenhuma evidência anexada.</div>
                    @endforelse
                </div>
            </x-admin.card>
        </div>
    </div>
</div>

<!-- Modal para alterar status com comentário -->
<div class="modal fade" id="modalAlterarStatus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alterar Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('denuncias.alterar-status', $denuncia) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="status_id" id="status_id">
                    <div class="mb-3">
                        <label class="form-label">Novo Status</label>
                        <div class="alert alert-info">
                            <span id="status_nome" class="badge bg-secondary"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="comentario_status" class="form-label">Comentário (opcional)</label>
                        <textarea class="form-control" id="comentario_status" name="comentario" rows="3" 
                                  placeholder="Descreva o motivo da alteração de status..."></textarea>
                        <div class="form-text">Este comentário será registrado no histórico de auditoria.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Confirmar Alteração
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de atribuição de responsável -->
<div class="modal fade" id="modalResponsavel" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atribuir Responsável</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('denuncias.atribuir-responsavel', $denuncia) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label for="responsavel_id" class="form-label">Selecione o responsável</label>
                    <select class="form-select" id="responsavel_id" name="responsavel_id" required>
                        <option value="">Selecione...</option>
                        @foreach(\App\Models\User::responsaveis()->orderBy('name')->get() as $user)
                            <option value="{{ $user->id }}" @selected($denuncia->responsavel_id == $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <div class="mb-3 mt-3">
                        <label for="comentario_responsavel" class="form-label">Comentário (opcional)</label>
                        <textarea class="form-control" id="comentario_responsavel" name="comentario" rows="2" 
                                  placeholder="Motivo da atribuição..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Atribuir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Formulário oculto para ações sensíveis -->
<form id="formAcaoSensivel" method="POST" style="display: none;">
    @csrf
</form>

@endsection

@push('scripts')
<script>
// Configurar modal de alteração de status
document.addEventListener('DOMContentLoaded', function() {
    const modalAlterarStatus = document.getElementById('modalAlterarStatus');
    if (modalAlterarStatus) {
        modalAlterarStatus.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const statusId = button.getAttribute('data-status-id');
            const statusNome = button.getAttribute('data-status-nome');
            const statusCor = button.getAttribute('data-status-cor');
            
            document.getElementById('status_id').value = statusId;
            document.getElementById('status_nome').textContent = statusNome;
            document.getElementById('status_nome').className = `badge bg-${statusCor}`;
        });
    }
});

// Função para confirmação de ações sensíveis
function confirmarAcaoSensivel(url, titulo, mensagem) {
    if (confirm(`${mensagem}\n\nAção: ${titulo}`)) {
        const form = document.getElementById('formAcaoSensivel');
        form.action = url;
        form.submit();
    }
}

// Adicionar confirmação para outras ações sensíveis
document.addEventListener('DOMContentLoaded', function() {
    // Confirmação para exclusão
    const btnExcluir = document.querySelector('.btn-excluir');
    if (btnExcluir) {
        btnExcluir.addEventListener('click', function(e) {
            if (!confirm('Tem certeza que deseja excluir esta denúncia? Esta ação não pode ser desfeita.')) {
                e.preventDefault();
            }
        });
    }
});
</script>
@endpush 