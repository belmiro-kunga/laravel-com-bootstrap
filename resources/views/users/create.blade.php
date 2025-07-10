@extends('layouts.app')

@section('title', 'Novo Usuário')
@section('page-title', 'Novo Usuário')

@section('breadcrumb')
    <x-admin.breadcrumb :items="[
        ['title' => 'Usuários', 'url' => route('users.index'), 'icon' => 'fas fa-users'],
        ['title' => 'Novo', 'icon' => 'fas fa-user-plus']
    ]" />
@endsection

@section('content')
<div class="container-fluid">
    <x-admin.card title="Novo Usuário" subtitle="Cadastre um novo usuário no sistema">
        <form method="POST" action="{{ route('users.store') }}" class="row g-3" enctype="multipart/form-data">
            @csrf

            <div class="col-md-6">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                <label for="role" class="form-label">Papel</label>
                <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="admin" @selected(old('role')=='admin')>Administrador</option>
                    <option value="responsavel" @selected(old('role')=='responsavel')>Responsável</option>
                    <option value="usuario" @selected(old('role')=='usuario')>Usuário</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                <label for="ativo" class="form-label">Status</label>
                <select name="ativo" id="ativo" class="form-select @error('ativo') is-invalid @enderror" required>
                    <option value="1" @selected(old('ativo', 1)==1)>Ativo</option>
                    <option value="0" @selected(old('ativo')==0)>Inativo</option>
                </select>
                @error('ativo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12 d-flex justify-content-between align-items-center mt-3">
                <div>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Cancelar
                    </a>
                </div>
                <div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-user-plus me-2"></i>Cadastrar Usuário
                    </button>
                </div>
            </div>
        </form>
    </x-admin.card>
</div>
@endsection 