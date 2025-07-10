@props(['status' => '', 'class' => ''])

@php
    $statusConfig = [
        'Recebida' => [
            'class' => 'status-badge recebida',
            'icon' => 'fas fa-inbox'
        ],
        'Em Análise' => [
            'class' => 'status-badge em-analise',
            'icon' => 'fas fa-search'
        ],
        'Resolvida' => [
            'class' => 'status-badge resolvida',
            'icon' => 'fas fa-check'
        ],
        'Arquivada' => [
            'class' => 'status-badge arquivada',
            'icon' => 'fas fa-archive'
        ],
        'Urgente' => [
            'class' => 'status-badge urgente',
            'icon' => 'fas fa-exclamation-triangle'
        ],
        'Alta' => [
            'class' => 'status-badge urgente',
            'icon' => 'fas fa-exclamation-circle'
        ],
        'Média' => [
            'class' => 'status-badge em-analise',
            'icon' => 'fas fa-minus-circle'
        ],
        'Baixa' => [
            'class' => 'status-badge recebida',
            'icon' => 'fas fa-arrow-down'
        ]
    ];
    
    $config = $statusConfig[$status] ?? [
        'class' => 'status-badge recebida',
        'icon' => 'fas fa-circle'
    ];
@endphp

<span {{ $attributes->merge(['class' => $config['class'] . ' ' . $class]) }}>
    <i class="{{ $config['icon'] }} me-1"></i>
    {{ $status }}
</span> 