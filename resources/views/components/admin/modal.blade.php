@props([
    'id' => 'modal',
    'title' => null,
    'size' => 'modal-lg', // modal-sm, modal-lg, modal-xl
    'centered' => true,
    'scrollable' => false,
    'staticBackdrop' => false,
    'class' => '',
    'header' => null,
    'footer' => null,
    'closeButton' => true,
    'closeButtonText' => 'Fechar',
    'saveButton' => false,
    'saveButtonText' => 'Salvar',
    'saveButtonClass' => 'btn-primary'
])

@php
    $modalClasses = 'modal fade';
    $modalClasses .= $centered ? ' modal-dialog-centered' : '';
    $modalClasses .= $scrollable ? ' modal-dialog-scrollable' : '';
    $modalClasses .= $staticBackdrop ? ' modal-static' : '';
    $modalClasses .= $class ? ' ' . $class : '';
@endphp

<div {{ $attributes->merge(['class' => $modalClasses, 'id' => $id, 'tabindex' => '-1']) }}>
    <div class="modal-dialog {{ $size }}">
        <div class="modal-content">
            @if($header)
                <div class="modal-header">
                    {{ $header }}
                </div>
            @elseif($title)
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    @if($closeButton)
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    @endif
                </div>
            @endif
            
            <div class="modal-body">
                {{ $slot }}
            </div>
            
            @if($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @elseif($saveButton || $closeButton)
                <div class="modal-footer">
                    @if($closeButton)
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ $closeButtonText }}
                        </button>
                    @endif
                    @if($saveButton)
                        <button type="button" class="btn {{ $saveButtonClass }}" id="save-{{ $id }}">
                            {{ $saveButtonText }}
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div> 