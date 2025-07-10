@extends('layouts.app')

@section('page-title', 'Detalhes do Usuário - ' . $user->name)

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuários</a></li>
<li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user"></i>
                        Informações do Usuário
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nome:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Função:</strong> 
                                <span class="badge bg-{{ $user->role_cor }}">{{ $user->role_label }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong> 
                                @if($user->ativo)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </p>
                            <p><strong>Data de Criação:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Último Login:</strong> 
                                @if($user->last_login_at)
                                    {{ $user->last_login_at->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-muted">Nunca</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Denúncias como Responsável -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle"></i>
                        Denúncias como Responsável
                    </h5>
                </div>
                <div class="card-body">
                    @if($user->denunciasResponsavel->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Protocolo</th>
                                        <th>Título</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->denunciasResponsavel->take(5) as $denuncia)
                                    <tr>
                                        <td>{{ $denuncia->protocolo }}</td>
                                        <td>{{ Str::limit($denuncia->titulo, 40) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $denuncia->status->cor }}">
                                                {{ $denuncia->status->nome }}
                                            </span>
                                        </td>
                                        <td>{{ $denuncia->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($user->denunciasResponsavel->count() > 5)
                            <p class="text-muted small">
                                Mostrando 5 de {{ $user->denunciasResponsavel->count() }} denúncias
                            </p>
                        @endif
                    @else
                        <p class="text-muted">Nenhuma denúncia atribuída como responsável.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Ações -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs"></i>
                        Ações
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if(Auth::user()->hasPermission('usuarios.edit'))
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Editar Usuário
                        </a>
                        @endif
                        
                        @if(Auth::user()->hasPermission('usuarios.manage_permissions'))
                            <a href="{{ route('users.permissions', $user) }}" class="btn btn-info">
                                <i class="fas fa-key"></i> Gerenciar Permissões
                            </a>
                        @endif
                        
                        @if($user->id !== Auth::id())
                            <form action="{{ route('users.toggle-ativo', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-{{ $user->ativo ? 'warning' : 'success' }} w-100">
                                    <i class="fas fa-{{ $user->ativo ? 'ban' : 'check' }}"></i>
                                    {{ $user->ativo ? 'Desativar' : 'Ativar' }} Usuário
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Estatísticas -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar"></i>
                        Estatísticas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-primary">{{ $user->denuncias_responsavel_count }}</h4>
                            <small class="text-muted">Denúncias</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning">{{ $user->denuncias_pendentes_count }}</h4>
                            <small class="text-muted">Pendentes</small>
                        </div>
                    </div>
                    <div class="row text-center mt-3">
                        <div class="col-6">
                            <h4 class="text-danger">{{ $user->denuncias_atrasadas_count }}</h4>
                            <small class="text-muted">Atrasadas</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">{{ $user->comentarios->count() }}</h4>
                            <small class="text-muted">Comentários</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissões Ativas -->
            @if(Auth::user()->hasPermission('usuarios.manage_permissions'))
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-key"></i>
                        Permissões Ativas
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $grantedPermissions = $user->getGrantedPermissions();
                    @endphp
                    
                    @if($grantedPermissions->count() > 0)
                        <div class="mb-2">
                            @foreach($grantedPermissions->take(3) as $permission)
                                <span class="badge bg-success mb-1">{{ $permission->name }}</span>
                            @endforeach
                            @if($grantedPermissions->count() > 3)
                                <span class="badge bg-secondary">+{{ $grantedPermissions->count() - 3 }} mais</span>
                            @endif
                        </div>
                        <a href="{{ route('users.permissions', $user) }}" class="btn btn-sm btn-outline-info">
                            Ver Todas
                        </a>
                    @else
                        <p class="text-muted small">Nenhuma permissão personalizada concedida.</p>
                        <a href="{{ route('users.permissions', $user) }}" class="btn btn-sm btn-outline-primary">
                            Conceder Permissões
                        </a>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 