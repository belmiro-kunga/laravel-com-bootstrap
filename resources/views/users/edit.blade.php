@extends('layouts.app')

@section('title', 'Editar Usuário')
@section('page-title', 'Editar Usuário')

@section('breadcrumb')
    <x-admin.breadcrumb :items="[
        ['title' => 'Usuários', 'url' => route('users.index'), 'icon' => 'fas fa-users'],
        ['title' => 'Editar', 'icon' => 'fas fa-edit']
    ]" />
@endsection

@section('content')
<div class="container-fluid">
    <x-admin.card title="Editar Usuário" subtitle="Atualize as informações do usuário">
        <form method="POST" action="{{ route('users.update', $user) }}" class="row g-3" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="col-md-6">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                <label for="role" class="form-label">Papel</label>
                <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="admin" @selected(old('role', $user->role)=='admin')>Administrador</option>
                    <option value="responsavel" @selected(old('role', $user->role)=='responsavel')>Responsável</option>
                    <option value="usuario" @selected(old('role', $user->role)=='usuario')>Usuário</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                <label for="ativo" class="form-label">Status</label>
                <select name="ativo" id="ativo" class="form-select @error('ativo') is-invalid @enderror" required>
                    <option value="1" @selected(old('ativo', $user->ativo)==1)>Ativo</option>
                    <option value="0" @selected(old('ativo', $user->ativo)==0)>Inativo</option>
                </select>
                @error('ativo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                <label for="password" class="form-label">Nova Senha <small class="text-muted">(opcional)</small></label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12 d-flex justify-content-between align-items-center mt-3">
                <div>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Cancelar
                    </a>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salvar Alterações
                    </button>
                </div>
            </div>
        </form>
    </x-admin.card>
</div>
@endsection 