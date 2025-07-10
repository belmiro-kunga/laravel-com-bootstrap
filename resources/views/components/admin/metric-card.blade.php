@props([
    'title' => '',
    'value' => 0,
    'subtitle' => '',
    'icon' => 'fas fa-chart-line',
    'variant' => 'primary', // primary, success, warning, danger, info
    'trend' => null, // positive, negative, neutral
    'trendValue' => null,
    'trendLabel' => '',
    'loading' => false,
    'class' => ''
])

@php
    $variantConfig = [
        'primary' => [
            'bg' => 'bg-primary',
            'text' => 'text-primary',
            'border' => 'border-primary',
            'iconBg' => 'bg-primary'
        ],
        'success' => [
            'bg' => 'bg-success',
            'text' => 'text-success',
            'border' => 'border-success',
            'iconBg' => 'bg-success'
        ],
        'warning' => [
            'bg' => 'bg-warning',
            'text' => 'text-warning',
            'border' => 'border-warning',
            'iconBg' => 'bg-warning'
        ],
        'danger' => [
            'bg' => 'bg-danger',
            'text' => 'text-danger',
            'border' => 'border-danger',
            'iconBg' => 'bg-danger'
        ],
        'info' => [
            'bg' => 'bg-info',
            'text' => 'text-info',
            'border' => 'border-info',
            'iconBg' => 'bg-info'
        ]
    ];
    
    $config = $variantConfig[$variant] ?? $variantConfig['primary'];
    
    $trendConfig = [
        'positive' => ['icon' => 'fas fa-arrow-up', 'class' => 'text-success'],
        'negative' => ['icon' => 'fas fa-arrow-down', 'class' => 'text-danger'],
        'neutral' => ['icon' => 'fas fa-minus', 'class' => 'text-muted']
    ];
    
    $trendInfo = $trend ? ($trendConfig[$trend] ?? $trendConfig['neutral']) : null;
@endphp

<div {{ $attributes->merge(['class' => 'metric-card ' . $class]) }}>
    <div class="d-flex align-items-center justify-content-between">
        <div class="flex-grow-1">
            <div class="d-flex align-items-center mb-2">
                <div class="{{ $config['iconBg'] }} rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                    <i class="{{ $icon }} text-white"></i>
                </div>
                <div>
                    <h6 class="mb-0 text-muted">{{ $title }}</h6>
                    @if($subtitle)
                        <small class="text-muted">{{ $subtitle }}</small>
                    @endif
                </div>
            </div>
            
            <div class="d-flex align-items-end">
                <h3 class="mb-0 me-2 {{ $loading ? 'placeholder-glow' : '' }}">
                    @if($loading)
                        <span class="placeholder col-4"></span>
                    @else
                        {{ number_format($value) }}
                    @endif
                </h3>
                
                @if($trend && $trendValue)
                    <div class="d-flex align-items-center">
                        <i class="{{ $trendInfo['icon'] }} me-1 {{ $trendInfo['class'] }}"></i>
                        <small class="{{ $trendInfo['class'] }}">
                            {{ $trendValue }}%
                        </small>
                        @if($trendLabel)
                            <small class="text-muted ms-1">{{ $trendLabel }}</small>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        
        @if($loading)
            <div class="spinner-border spinner-border-sm text-muted" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
        @endif
    </div>
</div> 