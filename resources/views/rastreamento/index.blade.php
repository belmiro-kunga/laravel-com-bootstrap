@extends('layouts.app')

@section('title', 'Rastrear Denúncias')

@section('page-title', 'Rastrear Minhas Denúncias')

@section('breadcrumb')
<li class="breadcrumb-item active">Rastrear Denúncias</li>
@endsection

@section('content')
<div class="row">
    <!-- Estatísticas -->
    <div class="col-md-12 mb-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $totalDenuncias }}</h4>
                                <small>Total de Denúncias</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-exclamation-triangle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $denunciasEmAnalise }}</h4>
                                <small>Em Análise</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-search fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $denunciasConcluidas }}</h4>
                                <small>Concluídas</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $denunciasUrgentes }}</h4>
                                <small>Urgentes</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-fire fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Busca por Protocolo -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-search"></i> Buscar por Protocolo
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('rastreamento.buscar') }}" method="GET" class="row g-3">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="protocolo" 
                               placeholder="Digite o número do protocolo (ex: DEN-2024-001)" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Lista de Denúncias -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list"></i> Minhas Denúncias
                </h5>
                <a href="{{ route('denuncias.formulario-publico') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nova Denúncia
                </a>
            </div>
            <div class="card-body">
                @if($denuncias->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Protocolo</th>
                                    <th>Título</th>
                                    <th>Categoria</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                    <th>Prioridade</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($denuncias as $denuncia)
                                <tr>
                                    <td>
                                        <strong>{{ $denuncia->protocolo }}</strong>
                                        @if($denuncia->urgente)
                                            <span class="badge bg-danger ms-1">Urgente</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($denuncia->titulo, 50) }}</td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $denuncia->categoria->cor }}">
                                            {{ $denuncia->categoria->nome }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $denuncia->status->cor }}">
                                            {{ $denuncia->status->nome }}
                                        </span>
                                    </td>
                                    <td>{{ $denuncia->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $denuncia->prioridade == 'alta' ? 'danger' : ($denuncia->prioridade == 'media' ? 'warning' : 'info') }}">
                                            {{ ucfirst($denuncia->prioridade) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('rastreamento.show', $denuncia->protocolo) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Ver Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-info" 
                                                onclick="verificarStatus('{{ $denuncia->protocolo }}')" 
                                                title="Verificar Status">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginação -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $denuncias->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Nenhuma denúncia encontrada</h5>
                        <p class="text-muted">Você ainda não fez nenhuma denúncia ou elas foram removidas.</p>
                        <a href="{{ route('denuncias.formulario-publico') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Fazer Primeira Denúncia
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal para Status -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Status da Denúncia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="statusModalBody">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <p class="mt-2">Verificando status...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function verificarStatus(protocolo) {
    const modal = new bootstrap.Modal(document.getElementById('statusModal'));
    modal.show();
    
    fetch(`/rastreamento/${protocolo}/status`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('statusModalBody').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> ${data.error}
                    </div>
                `;
            } else {
                document.getElementById('statusModalBody').innerHTML = `
                    <div class="row">
                        <div class="col-12">
                            <h6>Protocolo: ${data.protocolo}</h6>
                            <h5>${data.titulo}</h5>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <strong>Status:</strong><br>
                                    <span class="badge" style="background-color: ${data.status_cor}">${data.status}</span>
                                </div>
                                <div class="col-6">
                                    <strong>Categoria:</strong><br>
                                    ${data.categoria}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <strong>Data de Criação:</strong><br>
                                    ${data.data_criacao}
                                </div>
                                <div class="col-6">
                                    <strong>Última Atualização:</strong><br>
                                    ${data.ultima_atualizacao}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <strong>Responsável:</strong><br>
                                    ${data.responsavel}
                                </div>
                                <div class="col-6">
                                    <strong>Prioridade:</strong><br>
                                    ${data.prioridade}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            document.getElementById('statusModalBody').innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> Erro ao verificar status. Tente novamente.
                </div>
            `;
        });
}
</script>
@endpush 