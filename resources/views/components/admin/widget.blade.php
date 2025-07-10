@props([
    'title' => '',
    'subtitle' => '',
    'icon' => null,
    'variant' => 'default',
    'collapsible' => false,
    'collapsed' => false,
    'refreshable' => false,
    'loading' => false,
    'class' => '',
    'header' => null,
    'footer' => null
])

@php
    $widgetId = 'widget-' . uniqid();
    $variantClasses = [
        'default' => '',
        'primary' => 'border-primary',
        'success' => 'border-success',
        'warning' => 'border-warning',
        'danger' => 'border-danger',
        'info' => 'border-info'
    ];
    
    $widgetClass = 'widget ' . ($variantClasses[$variant] ?? '') . ' ' . $class;
@endphp

<div {{ $attributes->merge(['class' => $widgetClass, 'id' => $widgetId]) }}>
    @if($header)
        <div class="widget-header">
            {{ $header }}
        </div>
    @elseif($title)
        <div class="widget-header">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    @if($icon)
                        <i class="{{ $icon }} me-2 text-muted"></i>
                    @endif
                    <div>
                        <h6 class="widget-title mb-0">{{ $title }}</h6>
                        @if($subtitle)
                            <small class="text-muted">{{ $subtitle }}</small>
                        @endif
                    </div>
                </div>
                
                <div class="widget-actions">
                    @if($refreshable)
                        <button class="btn btn-sm btn-outline-secondary" onclick="refreshWidget('{{ $widgetId }}')" title="Atualizar">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    @endif
                    
                    @if($collapsible)
                        <button class="btn btn-sm btn-outline-secondary" onclick="toggleWidget('{{ $widgetId }}')" title="{{ $collapsed ? 'Expandir' : 'Recolher' }}">
                            <i class="fas fa-{{ $collapsed ? 'expand' : 'compress' }}"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif
    
    <div class="widget-content {{ $collapsed ? 'd-none' : '' }}">
        @if($loading)
            <div class="d-flex align-items-center justify-content-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
            </div>
        @else
            {{ $slot }}
        @endif
    </div>
    
    @if($footer)
        <div class="widget-footer">
            {{ $footer }}
        </div>
    @endif
</div>

@if($collapsible || $refreshable)
    @push('scripts')
    <script>
        function toggleWidget(widgetId) {
            const widget = document.getElementById(widgetId);
            const content = widget.querySelector('.widget-content');
            const button = widget.querySelector('.widget-actions button:last-child i');
            
            if (content.classList.contains('d-none')) {
                content.classList.remove('d-none');
                button.className = 'fas fa-compress';
                button.parentElement.title = 'Recolher';
            } else {
                content.classList.add('d-none');
                button.className = 'fas fa-expand';
                button.parentElement.title = 'Expandir';
            }
        }
        
        function refreshWidget(widgetId) {
            const widget = document.getElementById(widgetId);
            const content = widget.querySelector('.widget-content');
            const button = widget.querySelector('.widget-actions button i.fa-sync-alt');
            
            // Adicionar classe de rotação
            button.classList.add('fa-spin');
            
            // Simular carregamento (substitua por chamada AJAX real)
            setTimeout(() => {
                button.classList.remove('fa-spin');
                // Aqui você pode adicionar lógica para atualizar o conteúdo
            }, 1000);
        }
    </script>
    @endpush
@endif 