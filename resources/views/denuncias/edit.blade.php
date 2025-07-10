@extends('layouts.app')

@section('title', 'Tratar Denúncia')

@section('content')
<div class="container mt-5">
    <h1>Tratar Denúncia</h1>

    {{-- Mensagens de erro --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- 1. Formulário de edição dos dados da denúncia --}}
    <form action="{{ route('denuncias.update', $denuncia->id) }}" method="POST" class="mb-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" id="titulo" value="{{ old('titulo', $denuncia->titulo) }}" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" id="descricao" rows="4" required>{{ old('descricao', $denuncia->descricao) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoria</label>
            <select name="categoria_id" id="categoria_id" class="form-select" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ $denuncia->categoria_id == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="prioridade" class="form-label">Prioridade</label>
            <select name="prioridade" id="prioridade" class="form-select" required>
                <option value="baixa" {{ $denuncia->prioridade == 'baixa' ? 'selected' : '' }}>Baixa</option>
                <option value="media" {{ $denuncia->prioridade == 'media' ? 'selected' : '' }}>Média</option>
                <option value="alta" {{ $denuncia->prioridade == 'alta' ? 'selected' : '' }}>Alta</option>
                <option value="critica" {{ $denuncia->prioridade == 'critica' ? 'selected' : '' }}>Crítica</option>
            </select>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="urgente" id="urgente" value="1" {{ $denuncia->urgente ? 'checked' : '' }}>
            <label class="form-check-label" for="urgente">Urgente</label>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>

    {{-- 2. Formulário para alterar status --}}
    <form action="{{ route('denuncias.alterar-status', $denuncia->id) }}" method="POST" class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="status_id" class="form-label">Status</label>
            <select name="status_id" id="status_id" class="form-select" required>
                @foreach($status as $s)
                    <option value="{{ $s->id }}" {{ $denuncia->status_id == $s->id ? 'selected' : '' }}>
                        {{ $s->nome }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="comentario_status" class="form-label">Comentário (opcional)</label>
            <textarea name="comentario" id="comentario_status" class="form-control" rows="2"></textarea>
        </div>
        <button type="submit" class="btn btn-warning">Alterar Status</button>
    </form>

    {{-- 3. Formulário para atribuir responsável --}}
    <form action="{{ route('denuncias.atribuir-responsavel', $denuncia->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="responsavel_id" class="form-label">Atribuir a</label>
            <select name="responsavel_id" id="responsavel_id" class="form-select" required>
                <option value="">Selecione um responsável</option>
                @foreach($responsaveis as $resp)
                    <option value="{{ $resp->id }}" {{ $denuncia->responsavel_id == $resp->id ? 'selected' : '' }}>
                        {{ $resp->name }} ({{ $resp->email }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="comentario_responsavel" class="form-label">Comentário (opcional)</label>
            <textarea name="comentario" id="comentario_responsavel" class="form-control" rows="2"></textarea>
        </div>
        <button type="submit" class="btn btn-info">Atribuir Responsável</button>
    </form>

    <a href="{{ route('denuncias.index') }}" class="btn btn-secondary mt-3">Voltar</a>
</div>
@endsection 