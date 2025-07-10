@props([
    'id' => 'dataTable',
    'class' => '',
    'responsive' => true,
    'searching' => true,
    'ordering' => true,
    'paging' => true,
    'pageLength' => 25,
    'lengthMenu' => '[10, 25, 50, 100]',
    'language' => 'pt-BR',
    'dom' => '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
    'buttons' => false,
    'exportButtons' => false,
    'customButtons' => null
])

@php
    $tableClasses = 'table table-striped table-hover';
    $tableClasses .= $responsive ? ' responsive' : '';
    $tableClasses .= $class ? ' ' . $class : '';
    
    $domConfig = $dom;
    if ($buttons) {
        $domConfig = '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f><"col-sm-12"B>>rtip';
    }
@endphp

<div class="table-responsive">
    <table id="{{ $id }}" class="{{ $tableClasses }}" style="width:100%">
        {{ $slot }}
    </table>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    const tableConfig = {
        responsive: {{ $responsive ? 'true' : 'false' }},
        searching: {{ $searching ? 'true' : 'false' }},
        ordering: {{ $ordering ? 'true' : 'false' }},
        paging: {{ $paging ? 'true' : 'false' }},
        pageLength: {{ $pageLength }},
        lengthMenu: {!! $lengthMenu !!},
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/{{ $language }}.json'
        },
        dom: '{!! $domConfig !!}',
        @if($buttons)
        buttons: [
            @if($exportButtons)
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copiar',
                className: 'btn btn-outline-secondary btn-sm'
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-outline-secondary btn-sm'
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-outline-secondary btn-sm'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-outline-secondary btn-sm'
            },
            @endif
            @if($customButtons)
            {!! $customButtons !!}
            @endif
        ],
        @endif
        initComplete: function() {
            // Adicionar classes Bootstrap aos elementos do DataTable
            $('.dataTables_length select').addClass('form-select form-select-sm');
            $('.dataTables_filter input').addClass('form-control form-control-sm');
            $('.dataTables_paginate .paginate_button').addClass('btn btn-sm');
        }
    };
    
    $('#{{ $id }}').DataTable(tableConfig);
});
</script>
@endpush 