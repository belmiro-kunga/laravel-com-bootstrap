@extends('layouts.app')

@section('title', 'Permissões do Sistema')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-key"></i> Permissões do Sistema
                    </h3>
                    <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nova Permissão
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover datatable">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Slug</th>
                                    <th>Descrição</th>
                                    <th>Categoria</th>
                                    <th>Grupo</th>
                                    <th>Ativa</th>
                                    <th>Ordem</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->id }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td><span class="badge bg-secondary">{{ $permission->slug }}</span></td>
                                        <td>{{ $permission->description }}</td>
                                        <td>{{ ucfirst($permission->category) }}</td>
                                        <td>{{ ucfirst($permission->group) }}</td>
                                        <td>
                                            @if($permission->active)
                                                <span class="badge bg-success">Sim</span>
                                            @else
                                                <span class="badge bg-danger">Não</span>
                                            @endif
                                        </td>
                                        <td>{{ $permission->order }}</td>
                                        <td>
                                            <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Tem certeza que deseja remover esta permissão?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Remover"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">Nenhuma permissão cadastrada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 