@extends('layouts.app')

@section('title', 'Detalhes do Log de Auditoria')

@section('page-title', 'Detalhes do Log')

@section('breadcrumb')
    <x-admin.breadcrumb :items="[
        ['title' => 'Auditoria', 'url' => route('audit.index'), 'icon' => 'fas fa-shield-alt'],
        ['title' => 'Detalhes do Log', 'icon' => 'fas fa-eye']
    ]" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <x-admin.card>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0"><i class="fas fa-eye"></i> Detalhes do Log #{{ $auditLog->id }}</h4>
                    <a href="{{ route('audit.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>

                <dl class="row">
                    <dt class="col-sm-4">Usuário:</dt>
                    <dd class="col-sm-8">{{ $auditLog->user ? $auditLog->user->name : 'Sistema' }}</dd>

                    <dt class="col-sm-4">Ação:</dt>
                    <dd class="col-sm-8">{{ $auditLog->action }}</dd>

                    <dt class="col-sm-4">Descrição:</dt>
                    <dd class="col-sm-8">{{ $auditLog->description }}</dd>

                    <dt class="col-sm-4">Endereço IP:</dt>
                    <dd class="col-sm-8">{{ $auditLog->ip_address }}</dd>

                    <dt class="col-sm-4">Data/Hora:</dt>
                    <dd class="col-sm-8">{{ $auditLog->created_at->format('d/m/Y H:i:s') }}</dd>

                    @if($auditLog->old_values)
                    <dt class="col-sm-4">Valores Anteriores:</dt>
                    <dd class="col-sm-8">
                        <pre class="bg-light p-2 rounded">{{ json_encode(\App\Helpers\AuditHelper::filterSensitiveFields($auditLog->old_values), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </dd>
                    @endif

                    @if($auditLog->new_values)
                    <dt class="col-sm-4">Valores Novos:</dt>
                    <dd class="col-sm-8">
                        <pre class="bg-light p-2 rounded">{{ json_encode(\App\Helpers\AuditHelper::filterSensitiveFields($auditLog->new_values), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </dd>
                    @endif
                </dl>
            </x-admin.card>
        </div>
    </div>
</div>
@endsection 