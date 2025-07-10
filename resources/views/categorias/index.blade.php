@extends('layouts.app')

@section('title', 'Categorias - Sistema de Denúncias')

@section('page-title', 'Gerenciar Categorias')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Categorias</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-tags"></i> Categorias de Denúncias
                </h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCategoria">
                    <i class="fas fa-plus"></i> Nova Categoria
                </button>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Cor</th>
                                <th>Ordem</th>
                                <th>Status</th>
                                <th>Denúncias</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categorias as $categoria)
                            <tr>
                                <td>
                                    <strong>{{ $categoria->nome }}</strong>
                                </td>
                                <td>{{ Str::limit($categoria->descricao, 50) }}</td>
                                <td>
                                    <span class="badge" style="background-color: {{ $categoria->cor }}">
                                        {{ $categoria->cor }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $categoria->ordem }}</span>
                                </td>
                                <td>
                                    @if($categoria->ativo)
                                        <span class="badge bg-success">Ativa</span>
                                    @else
                                        <span class="badge bg-danger">Inativa</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $categoria->denuncias_count }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                onclick="editarCategoria({{ $categoria->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if($categoria->denuncias_count == 0)
                                            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" 
                                                  style="display: inline;" 
                                                  onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-secondary" disabled 
                                                    title="Não é possível excluir categoria com denúncias">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    <i class="fas fa-tags fa-2x mb-2"></i>
                                    <br>Nenhuma categoria encontrada
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($categorias->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $categorias->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal para Criar/Editar Categoria -->
<div class="modal fade" id="modalCategoria" tabindex="-1" aria-labelledby="modalCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formCategoria" method="POST" action="{{ route('categorias.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCategoriaLabel">Nova Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome *</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" name="nome" required maxlength="100">
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                  id="descricao" name="descricao" rows="3" maxlength="255"></textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cor" class="form-label">Cor *</label>
                        <input type="color" class="form-control @error('cor') is-invalid @enderror" 
                               id="cor" name="cor" required value="#007bff">
                        @error('cor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ordem" class="form-label">Ordem</label>
                        <input type="number" class="form-control @error('ordem') is-invalid @enderror" 
                               id="ordem" name="ordem" min="1" value="1">
                        @error('ordem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" checked>
                            <label class="form-check-label" for="ativo">
                                Categoria ativa
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function editarCategoria(id) {
    // Buscar dados da categoria via AJAX
    fetch(`/categorias/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const categoria = data.categoria;
                // Preencher o formulário
                document.getElementById('nome').value = categoria.nome;
                document.getElementById('descricao').value = categoria.descricao || '';
                document.getElementById('cor').value = categoria.cor;
                document.getElementById('ordem').value = categoria.ordem || 1;
                document.getElementById('ativo').checked = categoria.ativo;
                // Atualizar modal
                document.getElementById('modalCategoriaLabel').textContent = 'Editar Categoria';
                document.getElementById('formCategoria').action = `/categorias/${id}`;
                // Adicionar método PUT
                let methodInput = document.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    document.getElementById('formCategoria').appendChild(methodInput);
                }
                methodInput.value = 'PUT';
                // Abrir modal
                new bootstrap.Modal(document.getElementById('modalCategoria')).show();
            } else {
                alert('Erro ao carregar dados da categoria');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao carregar dados da categoria');
        });
}
// Resetar formulário quando modal for fechado
if (document.getElementById('modalCategoria')) {
    document.getElementById('modalCategoria').addEventListener('hidden.bs.modal', function () {
        document.getElementById('formCategoria').reset();
        document.getElementById('modalCategoriaLabel').textContent = 'Nova Categoria';
        document.getElementById('formCategoria').action = '{{ route("categorias.store") }}';
        document.getElementById('cor').value = '#007bff';
        document.getElementById('ordem').value = '1';
        document.getElementById('ativo').checked = true;
        // Remover método PUT se existir
        const methodInput = document.querySelector('input[name="_method"]');
        if (methodInput) {
            methodInput.remove();
        }
    });
}
</script>
@endpush 