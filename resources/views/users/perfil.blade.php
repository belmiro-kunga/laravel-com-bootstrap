@extends('layouts.app')

@section('title', 'Meu Perfil - Sistema de Denúncias')

@section('page-title', 'Meu Perfil')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Meu Perfil</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-edit"></i> Informações do Perfil
                </h5>
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

                <form action="{{ route('users.atualizar-perfil') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nome *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">Alterar Senha (opcional)</h6>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="password_atual" class="form-label">Senha Atual</label>
                            <input type="password" class="form-control @error('password_atual') is-invalid @enderror" 
                                   id="password_atual" name="password_atual">
                            @error('password_atual')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="password" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" minlength="8">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" minlength="8">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Atualizar Perfil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle"></i> Informações da Conta
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="avatar-lg mx-auto mb-3">
                        <div class="avatar-title bg-{{ $user->role_cor }} rounded-circle" style="width: 80px; height: 80px; font-size: 2rem;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                    <h5>{{ $user->name }}</h5>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>

                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-primary">{{ $user->denuncias_responsavel_count ?? 0 }}</h4>
                            <small class="text-muted">Denúncias</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">{{ $user->denuncias_pendentes_count ?? 0 }}</h4>
                        <small class="text-muted">Pendentes</small>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <strong>Função:</strong>
                    <span class="badge bg-{{ $user->role_cor }}">{{ $user->role_label }}</span>
                </div>

                <div class="mb-3">
                    <strong>Status:</strong>
                    @if($user->ativo)
                        <span class="badge bg-success">Ativo</span>
                    @else
                        <span class="badge bg-danger">Inativo</span>
                    @endif
                </div>

                <div class="mb-3">
                    <strong>Membro desde:</strong>
                    <br>
                    <small class="text-muted">{{ $user->created_at->format('d/m/Y') }}</small>
                </div>

                @if($user->last_login_at)
                <div class="mb-3">
                    <strong>Último acesso:</strong>
                    <br>
                    <small class="text-muted">{{ $user->last_login_at->format('d/m/Y H:i') }}</small>
                </div>
                @endif

                <div class="mb-3">
                    <strong>Permissões:</strong>
                    <ul class="list-unstyled mt-2">
                        @if($user->podeGerenciarDenuncias())
                            <li><i class="fas fa-check text-success"></i> Gerenciar Denúncias</li>
                        @endif
                        @if($user->podeVerTodasDenuncias())
                            <li><i class="fas fa-check text-success"></i> Ver Todas Denúncias</li>
                        @endif
                        @if($user->podeGerenciarUsuarios())
                            <li><i class="fas fa-check text-success"></i> Gerenciar Usuários</li>
                        @endif
                        @if($user->podeGerenciarCategorias())
                            <li><i class="fas fa-check text-success"></i> Gerenciar Categorias</li>
                        @endif
                        @if($user->podeVerRelatorios())
                            <li><i class="fas fa-check text-success"></i> Ver Relatórios</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 