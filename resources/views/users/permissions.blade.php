@extends('layouts.app')

@section('title', 'Permissões de ' . $user->name)
@section('page-title', 'Permissões de Usuário')

@push('styles')
<style>
    .permission-group {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        margin-bottom: 1rem;
        overflow: hidden;
    }
    .permission-group-header {
        background-color: #f8f9fa;
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid #dee2e6;
        cursor: pointer;
    }
    .permission-group-body {
        padding: 1rem;
    }
    .permission-item {
        padding: 0.5rem 0;
        border-bottom: 1px dashed #eee;
    }
    .permission-item:last-child {
        border-bottom: none;
    }
    .nav-tabs .nav-link {
        font-weight: 500;
    }
</style>
@endpush

@section('breadcrumb')
    <x-admin.breadcrumb :items="[
        ['title' => 'Usuários', 'url' => route('users.index'), 'icon' => 'fas fa-users'],
        ['title' => 'Permissões', 'icon' => 'fas fa-key']
    ]" />
@endsection

@section('content')
<div class="container-fluid">
    <x-admin.card title="Permissões de {{ $user->name }}" subtitle="Gerencie as permissões deste usuário">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="badge bg-{{ $user->role_cor }} me-2">{{ $user->role_label }}</span>
                <span class="text-muted">{{ $user->email }}</span>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary" id="selectAll">
                    <i class="fas fa-check-double me-1"></i>Selecionar Tudo
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAll">
                    <i class="fas fa-times me-1"></i>Desmarcar Tudo
                </button>
            </div>
        </div>

        @if(session('success'))
            <x-admin.alert type="success">{{ session('success') }}</x-admin.alert>
        @endif
        @if(session('error'))
            <x-admin.alert type="danger">{{ session('error') }}</x-admin.alert>
        @endif

        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar permissões...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" id="categoryFilter">
                            <option value="">Todas as categorias</option>
                            @foreach($categories as $category => $count)
                                <option value="{{ $category }}">{{ ucfirst($category) }} ({{ $count }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('users.permissions.update', $user) }}" method="POST" id="permissionsForm">
            @csrf
            
            <ul class="nav nav-tabs mb-3" id="permissionTabs" role="tablist">
                @foreach($groupedPermissions as $category => $groups)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                id="tab-{{ Str::slug($category) }}" 
                                data-bs-toggle="tab" 
                                data-bs-target="#{{ Str::slug($category) }}" 
                                type="button" 
                                role="tab">
                            {{ ucfirst($category) }}
                            <span class="badge bg-secondary ms-1">{{ count($groups) }}</span>
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content" id="permissionTabsContent">
                @foreach($groupedPermissions as $category => $groups)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                         id="{{ Str::slug($category) }}" 
                         role="tabpanel" 
                         aria-labelledby="tab-{{ Str::slug($category) }}">
                        
                        @foreach($groups as $group => $permissions)
                            <div class="permission-group mb-4">
                                <div class="permission-group-header d-flex justify-content-between align-items-center" 
                                     data-bs-toggle="collapse" 
                                     href="#group-{{ Str::slug($category) }}-{{ Str::slug($group) }}">
                                    <h6 class="mb-0">
                                        <i class="fas fa-folder-open me-2"></i>
                                        {{ $group ?: 'Geral' }}
                                        <span class="badge bg-primary ms-2">{{ count($permissions) }}</span>
                                    </h6>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="permission-group-body collapse show" id="group-{{ Str::slug($category) }}-{{ Str::slug($group) }}">
                                    @foreach($permissions as $permission)
                                        <div class="permission-item d-flex align-items-center">
                                            <div class="form-check form-switch flex-grow-1">
                                                <input class="form-check-input permission-checkbox" 
                                                       type="checkbox" 
                                                       name="permissions[]" 
                                                       value="{{ $permission->id }}" 
                                                       id="perm_{{ $permission->id }}"
                                                       data-category="{{ $permission->category }}"
                                                       {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}>
                                                <label class="form-check-label ms-3" for="perm_{{ $permission->id }}">
                                                    <div class="d-flex flex-column">
                                                        <strong class="permission-name">{{ $permission->name }}</strong>
                                                        <small class="text-muted permission-description">{{ $permission->description }}</small>
                                                        <small class="text-primary">{{ $permission->slug }}</small>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar
                </a>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary" id="resetForm">
                        <i class="fas fa-undo me-2"></i>Reverter
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Salvar Permissões
                    </button>
                </div>
            </div>
        </form>
    </x-admin.card>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtro de busca
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const checkboxes = document.querySelectorAll('.permission-checkbox');
    
    // Função para filtrar permissões
    function filterPermissions() {
        const searchTerm = searchInput.value.toLowerCase();
        const category = categoryFilter.value;
        
        checkboxes.forEach(checkbox => {
            const permissionItem = checkbox.closest('.permission-item');
            const permissionName = checkbox.nextElementSibling.querySelector('.permission-name').textContent.toLowerCase();
            const permissionDesc = checkbox.nextElementSibling.querySelector('.permission-description').textContent.toLowerCase();
            const permissionCategory = checkbox.dataset.category;
            
            const matchesSearch = permissionName.includes(searchTerm) || permissionDesc.includes(searchTerm);
            const matchesCategory = !category || permissionCategory === category;
            
            if (matchesSearch && matchesCategory) {
                permissionItem.style.display = 'flex';
                // Mostrar o grupo pai se algum item for exibido
                permissionItem.closest('.permission-group-body').style.display = 'block';
                permissionItem.closest('.permission-group').style.display = 'block';
            } else {
                permissionItem.style.display = 'none';
                // Verificar se ainda há itens visíveis no grupo
                const group = permissionItem.closest('.permission-group-body');
                if (group) {
                    const visibleItems = group.querySelectorAll('.permission-item[style!="display: none;"]');
                    if (visibleItems.length === 0) {
                        group.style.display = 'none';
                        group.previousElementSibling.style.display = 'none';
                    }
                }
            }
        });
    }
    
    // Event listeners
    searchInput.addEventListener('input', filterPermissions);
    categoryFilter.addEventListener('change', filterPermissions);
    
    // Selecionar/desmarcar tudo
    document.getElementById('selectAll').addEventListener('click', function() {
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.checked = true;
        });
    });
    
    document.getElementById('deselectAll').addEventListener('click', function() {
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
    });
    
    // Reverter alterações
    document.getElementById('resetForm').addEventListener('click', function() {
        if (confirm('Tem certeza que deseja descartar todas as alterações feitas?')) {
            window.location.reload();
        }
    });
    
    // Atualizar contagem de selecionados
    function updateSelectedCount() {
        const selected = document.querySelectorAll('.permission-checkbox:checked').length;
        const total = checkboxes.length;
        document.getElementById('selectedCount').textContent = `${selected} de ${total} selecionadas`;
    }
    
    // Atualizar contagem quando as caixas de seleção forem alteradas
    document.getElementById('permissionsForm').addEventListener('change', updateSelectedCount);
    updateSelectedCount();
});
</script>
@endpush