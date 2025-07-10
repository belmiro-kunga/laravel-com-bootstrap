@props(['user' => null])

@php
    $user = $user ?? auth()->user();
    
    $menuItems = [
        [
            'title' => 'Dashboard',
            'route' => 'dashboard.index',
            'icon' => 'fas fa-tachometer-alt',
            'permission' => null
        ],
        [
            'title' => 'Denúncias',
            'route' => 'denuncias.index',
            'icon' => 'fas fa-exclamation-triangle',
            'permission' => 'denuncias.menu'
        ],
        [
            'title' => 'Categorias',
            'route' => 'categorias.index',
            'icon' => 'fas fa-tags',
            'permission' => 'categorias.menu'
        ],
        [
            'title' => 'Relatórios',
            'route' => 'dashboard.relatorios',
            'icon' => 'fas fa-chart-bar',
            'permission' => 'relatorios.menu'
        ],
        [
            'title' => 'Usuários',
            'route' => 'users.index',
            'icon' => 'fas fa-users',
            'permission' => 'usuarios.menu'
        ],
        [
            'title' => 'Auditoria',
            'route' => 'audit.index',
            'icon' => 'fas fa-history',
            'permission' => 'auditoria.menu'
        ],
        [
            'title' => 'Configurações',
            'route' => 'system-config.index',
            'icon' => 'fas fa-cogs',
            'permission' => 'system-config.menu'
        ],
        [
            'title' => 'Configuração de Email',
            'route' => 'email-config.index',
            'icon' => 'fas fa-envelope',
            'permission' => 'system-config.menu'
        ],
        [
            'title' => 'Permissões',
            'route' => 'permissions.index',
            'icon' => 'fas fa-key',
            'permission' => 'manage-system-config'
        ]
    ];
@endphp

<nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="text-center mb-4">
            <h4 class="text-white">
                <i class="fas fa-shield-alt"></i>
                {{ \App\Helpers\ConfigHelper::get('site_name', 'Sistema de Denúncias') }}
            </h4>
            <small class="text-white-50">{{ \App\Helpers\ConfigHelper::get('site_description', 'Corporativas') }}</small>
        </div>
        
        <ul class="nav flex-column">
            @foreach($menuItems as $item)
                @if(!$item['permission'] || $user->hasPermission($item['permission']))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs($item['route'] . '*') ? 'active' : '' }}" 
                           href="{{ route($item['route']) }}">
                            <i class="{{ $item['icon'] }}"></i>
                            {{ $item['title'] }}
                        </a>
                    </li>
                @endif
            @endforeach
            
            <li class="nav-item mt-4">
                <a class="nav-link" href="{{ route('denuncias.formulario-publico') }}" target="_blank">
                    <i class="fas fa-plus-circle"></i>
                    Nova Denúncia
                </a>
            </li>
        </ul>
        
        @auth
        <hr class="text-white-50">
        
        <div class="px-3">
            <small class="text-white-50">Usuário</small>
            <div class="d-flex align-items-center mt-2">
                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-user text-primary"></i>
                </div>
                <div class="ms-3">
                    <div class="text-white">{{ $user->name }}</div>
                    <small class="text-white-50">{{ $user->role_label }}</small>
                </div>
            </div>
            
            <div class="mt-3">
                <a href="{{ route('users.perfil') }}" class="btn btn-outline-light btn-sm w-100 mb-2">
                    <i class="fas fa-user-edit"></i> Meu Perfil
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="redirect_to" value="{{ url('/admin') }}">
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-outline-light btn-sm w-100">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </a>
            </div>
        </div>
        @else
        <hr class="text-white-50">
        
        <div class="px-3">
            <div class="mt-3">
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm w-100">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </a>
            </div>
        </div>
        @endauth
    </div>
</nav> 