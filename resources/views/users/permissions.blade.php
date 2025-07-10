@extends('layouts.app')

@section('title', 'Permissões de ' . $user->name)
@section('page-title', 'Permissões de Usuário')

@section('breadcrumb')
    <x-admin.breadcrumb :items="[
        ['title' => 'Usuários', 'url' => route('users.index'), 'icon' => 'fas fa-users'],
        ['title' => 'Permissões', 'icon' => 'fas fa-key']
    ]" />
@endsection

@section('content')
<div class="container-fluid">
    <x-admin.card title="Permissões de {{ $user->name }}" subtitle="Gerencie as permissões deste usuário">
        <div class="mb-3">
            <span class="badge bg-{{ $user->role_cor }} me-2">{{ $user->role_label }}</span>
            <span class="text-muted">{{ $user->email }}</span>
        </div>
        @if(session('success'))
            <x-admin.alert type="success">{{ session('success') }}</x-admin.alert>
        @endif
        @if(session('error'))
            <x-admin.alert type="danger">{{ session('error') }}</x-admin.alert>
        @endif
        <form action="{{ route('users.permissions.update', $user) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Permissões disponíveis:</label>
                <div class="row">
                    @foreach($permissions as $permission)
                        <div class="col-md-6 mb-2">
                            <div class="form-switch">
                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="perm_{{ $permission->id }}"
                                    {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}>
                                <label class="form-check-label ms-2" for="perm_{{ $permission->id }}">
                                    <strong>{{ $permission->name }}</strong>
                                    <span class="badge bg-secondary ms-1">{{ $permission->slug }}</span>
                                    <br>
                                    <small class="text-muted">{{ $permission->description }}</small>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Salvar Permissões
                </button>
            </div>
        </form>
    </x-admin.card>
</div>
@endsection 