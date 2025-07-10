@props([
    'type' => 'info', // success, warning, danger, info
    'title' => null,
    'dismissible' => true,
    'icon' => null,
    'class' => ''
])

@php
    $alertConfig = [
        'success' => [
            'class' => 'alert-success',
            'icon' => 'fas fa-check-circle',
            'title' => 'Sucesso!'
        ],
        'warning' => [
            'class' => 'alert-warning',
            'icon' => 'fas fa-exclamation-triangle',
            'title' => 'Atenção!'
        ],
        'danger' => [
            'class' => 'alert-danger',
            'icon' => 'fas fa-exclamation-circle',
            'title' => 'Erro!'
        ],
        'info' => [
            'class' => 'alert-info',
            'icon' => 'fas fa-info-circle',
            'title' => 'Informação'
        ]
    ];
    
    $config = $alertConfig[$type] ?? $alertConfig['info'];
    $alertClass = 'alert ' . $config['class'];
    $alertClass .= $dismissible ? ' alert-dismissible fade show' : '';
    $alertClass .= $class ? ' ' . $class : '';
    
    $icon = $icon ?? $config['icon'];
    $title = $title ?? $config['title'];
@endphp

<div {{ $attributes->merge(['class' => $alertClass, 'role' => 'alert']) }}>
    <div class="d-flex align-items-start">
        <i class="{{ $icon }} me-2 mt-1"></i>
        <div class="flex-grow-1">
            @if($title)
                <strong>{{ $title }}</strong>
                @if($slot->isNotEmpty())
                    <br>
                @endif
            @endif
            {{ $slot }}
        </div>
    </div>
    
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    @endif
</div> 