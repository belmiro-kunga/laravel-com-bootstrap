@props([
    'title' => '',
    'subtitle' => '',
    'type' => 'line', // line, bar, pie, doughnut, area
    'data' => [],
    'options' => [],
    'height' => '300px',
    'loading' => false,
    'class' => '',
    'id' => null
])

@php
    $chartId = $id ?? 'chart-' . uniqid();
    
    $defaultOptions = [
        'responsive' => true,
        'maintainAspectRatio' => false,
        'plugins' => [
            'legend' => [
                'display' => true,
                'position' => 'top'
            ],
            'tooltip' => [
                'enabled' => true,
                'mode' => 'index',
                'intersect' => false
            ]
        ],
        'scales' => [
            'x' => [
                'display' => true,
                'grid' => [
                    'display' => false
                ]
            ],
            'y' => [
                'display' => true,
                'grid' => [
                    'color' => 'rgba(0,0,0,0.05)'
                ],
                'beginAtZero' => true
            ]
        ]
    ];
    
    $chartOptions = array_merge_recursive($defaultOptions, $options);
@endphp

<x-admin.card title="{{ $title }}" subtitle="{{ $subtitle }}" class="{{ $class }}">
    <div class="chart-container" style="height: {{ $height }}; position: relative;">
        @if($loading)
            <div class="d-flex align-items-center justify-content-center h-100">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Carregando gráfico...</span>
                </div>
            </div>
        @else
            <canvas id="{{ $chartId }}"></canvas>
        @endif
    </div>
    
    @if(!$loading)
        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('{{ $chartId }}').getContext('2d');
                
                const chart = new Chart(ctx, {
                    type: '{{ $type }}',
                    data: @json($data),
                    options: @json($chartOptions)
                });
                
                // Armazenar referência do gráfico para possível atualização
                window.charts = window.charts || {};
                window.charts['{{ $chartId }}'] = chart;
            });
        </script>
        @endpush
    @endif
</x-admin.card> 