@extends('layouts.app')

@section('title', 'Nova Permissão')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-plus"></i> Nova Permissão</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" required maxlength="100">
                            <small class="form-text text-muted">Identificador único, ex: <code>denuncias.menu</code></small>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea name="description" id="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Categoria</label>
                            <select name="category" id="category" class="form-select" required>
                                <option value="menu" {{ old('category') == 'menu' ? 'selected' : '' }}>Menu</option>
                                <option value="function" {{ old('category') == 'function' ? 'selected' : '' }}>Funcionalidade</option>
                                <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>Geral</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="group" class="form-label">Grupo</label>
                            <input type="text" name="group" id="group" class="form-control" value="{{ old('group', 'general') }}" required maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label for="order" class="form-label">Ordem</label>
                            <input type="number" name="order" id="order" class="form-control" value="{{ old('order', 0) }}" min="0">
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="active" name="active" value="1" {{ old('active', 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">Ativa</label>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Salvar Permissão
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 