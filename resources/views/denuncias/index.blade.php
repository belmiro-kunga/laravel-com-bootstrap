@extends('layouts.app')

@section('title', 'Denúncias')
@section('page-title', 'Denúncias')

@section('breadcrumb')
    <x-admin.breadcrumb :items="[
        ['title' => 'Denúncias', 'icon' => 'fas fa-exclamation-triangle']
    ]" />
@endsection

@section('content')
<div class="container-fluid">
    <x-admin.card title="Gerenciamento de Denúncias" subtitle="Acompanhe e administre as denúncias do sistema">
        <form method="GET" class="row g-2 mb-3 align-items-end">
            <div class="col-md-3">
                <label for="busca" class="form-label">Buscar</label>
                <input type="text" name="busca" id="busca" class="form-control" value="{{ request('busca') }}" placeholder="Protocolo, título ou descrição">
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Todos</option>
                    @foreach(\App\Models\Status::orderBy('ordem')->get() as $status)
                        <option value="{{ $status->id }}" @selected(request('status')==$status->id)>{{ $status->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="categoria" class="form-label">Categoria</label>
                <select name="categoria" id="categoria" class="form-select">
                    <option value="">Todas</option>
                    @foreach(\App\Models\Categoria::orderBy('nome')->get() as $categoria)
                        <option value="{{ $categoria->id }}" @selected(request('categoria')==$categoria->id)>{{ $categoria->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="responsavel" class="form-label">Responsável</label>
                <select name="responsavel" id="responsavel" class="form-select">
                    <option value="">Todos</option>
                    @foreach(\App\Models\User::orderBy('name')->get() as $user)
                        <option value="{{ $user->id }}" @selected(request('responsavel')==$user->id)>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <label for="urgente" class="form-label">Urgente</label>
                <select name="urgente" id="urgente" class="form-select">
                    <option value="">Todos</option>
                    <option value="1" @selected(request('urgente')==='1')>Sim</option>
                    <option value="0" @selected(request('urgente')==='0')>Não</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-2"></i>Filtrar
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Protocolo</th>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Status</th>
                        <th>Prioridade</th>
                        <th>Responsável</th>
                        <th>Data</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($denuncias as $denuncia)
                    <tr>
                        <td>
                            <a href="{{ route('denuncias.show', $denuncia) }}" class="text-decoration-none fw-bold">
                                {{ $denuncia->protocolo }}
                            </a>
                            @if($denuncia->urgente)
                                <span class="badge bg-danger ms-1">Urgente</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($denuncia->titulo, 30) }}</td>
                        <td>
                            @if($denuncia->categoria)
                                <span class="badge" style="background-color: {{ $denuncia->categoria->cor }}">{{ $denuncia->categoria->nome }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <x-admin.status-badge :status="$denuncia->status->nome ?? '-'" />
                        </td>
                        <td>
                            @if($denuncia->prioridade)
                                <span class="badge bg-{{ $denuncia->prioridade === 'Alta' ? 'danger' : ($denuncia->prioridade === 'Média' ? 'warning' : 'info') }}">
                                    {{ $denuncia->prioridade }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($denuncia->responsavel)
                                <span class="badge bg-primary">{{ $denuncia->responsavel->name }}</span>
                            @else
                                <span class="text-muted">Não atribuído</span>
                            @endif
                        </td>
                        <td>{{ $denuncia->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('denuncias.show', $denuncia) }}" class="btn btn-sm btn-outline-primary" title="Ver Detalhes">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('denuncias.edit', $denuncia) }}" class="btn btn-sm btn-outline-secondary" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <!-- Botão para abrir modal de alteração de status -->
                            <button type="button"
                                class="btn btn-sm btn-outline-warning"
                                title="Alterar Status"
                                data-bs-toggle="modal"
                                data-bs-target="#modalAlterarStatus"
                                data-denuncia-id="{{ $denuncia->id }}">
                                <i class="fas fa-random"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Nenhuma denúncia encontrada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $denuncias->withQueryString()->links() }}
        </div>
    </x-admin.card>
</div>
@endsection

@push('modals')
<!-- Modal de alteração de status -->
<div class="modal fade" id="modalAlterarStatus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAlterarStatus" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Alterar Status da Denúncia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="novo_status" class="form-label">Novo Status</label>
                        <select name="status_id" id="novo_status" class="form-select" required>
                            @foreach(\App\Models\Status::ativos()->ordenados()->get() as $status)
                                <option value="{{ $status->id }}">{{ $status->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="comentario_status" class="form-label">Comentário (opcional)</label>
                        <textarea name="comentario" id="comentario_status" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar Alteração</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('modalAlterarStatus');
    if (modal) {
        modal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var denunciaId = button.getAttribute('data-denuncia-id');
            var form = document.getElementById('formAlterarStatus');
            form.action = '/denuncias/' + denunciaId + '/alterar-status';
        });
    }
});
</script>
@endpush 