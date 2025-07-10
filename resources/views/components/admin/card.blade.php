@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'variant' => 'default', // default, primary, success, warning, danger, info
    'hover' => true,
    'class' => '',
    'header' => null,
    'footer' => null,
    'bodyClass' => ''
])

@php
    $cardClasses = 'card';
    $cardClasses .= $hover ? ' card-hover' : '';
    $cardClasses .= $class ? ' ' . $class : '';
    
    $headerClasses = 'card-header';
    $bodyClasses = 'card-body' . ($bodyClass ? ' ' . $bodyClass : '');
    
    $variantClasses = [
        'default' => '',
        'primary' => 'border-primary',
        'success' => 'border-success',
        'warning' => 'border-warning',
        'danger' => 'border-danger',
        'info' => 'border-info'
    ];
    
    $cardClasses .= ' ' . ($variantClasses[$variant] ?? '');
@endphp

<div {{ $attributes->merge(['class' => $cardClasses]) }}>
    @if($header)
        <div class="{{ $headerClasses }}">
            {{ $header }}
        </div>
    @elseif($title)
        <div class="{{ $headerClasses }}">
            <div class="d-flex align-items-center">
                @if($icon)
                    <i class="{{ $icon }} me-2"></i>
                @endif
                <h5 class="card-title mb-0">{{ $title }}</h5>
            </div>
            @if($subtitle)
                <small class="text-muted">{{ $subtitle }}</small>
            @endif
        </div>
    @endif
    
    <div class="{{ $bodyClasses }}">
        {{ $slot }}
    </div>
    
    @if($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div> 