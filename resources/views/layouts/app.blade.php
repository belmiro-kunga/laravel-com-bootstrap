<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', \App\Helpers\ConfigHelper::get('site_name', 'Sistema de Denúncias Corporativas'))</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    
    <!-- Admin CSS -->
    <link href="{{ asset('css/admin/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/components.css') }}" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: {{ \App\Helpers\ConfigHelper::get('primary_color', '#4e73df') }};
        }
    </style>
    
    @stack('styles')
    <link rel="icon" type="image/x-icon" href="{{ \App\Helpers\ConfigHelper::get('favicon_url', '/favicon.ico') }}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <x-admin.sidebar />
            
            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Top navbar -->
                <x-admin.navbar />
                
                <!-- Breadcrumb -->
                @hasSection('breadcrumb')
                    @yield('breadcrumb')
                @endif
                
                <!-- Alerts -->
                @if(session('success'))
                    <x-admin.alert type="success">
                        {{ session('success') }}
                    </x-admin.alert>
                @endif
                
                @if(session('error'))
                    <x-admin.alert type="danger">
                        {{ session('error') }}
                    </x-admin.alert>
                @endif
                
                @if(session('warning'))
                    <x-admin.alert type="warning">
                        {{ session('warning') }}
                    </x-admin.alert>
                @endif
                
                @if(session('info'))
                    <x-admin.alert type="info">
                        {{ session('info') }}
                    </x-admin.alert>
                @endif
                
                <!-- Main content -->
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom JS -->
    <script>
        // CSRF Token para AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Inicializar Select2
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
            
            // Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Auto-hide alerts
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
            
            // Sidebar toggle para mobile
            $('.navbar-toggler').on('click', function() {
                $('.sidebar').toggleClass('show');
            });
            
            // Fechar sidebar ao clicar fora (mobile)
            $(document).on('click', function(e) {
                if ($(window).width() <= 768) {
                    if (!$(e.target).closest('.sidebar, .navbar-toggler').length) {
                        $('.sidebar').removeClass('show');
                    }
                }
            });
        });
    </script>
    
    @stack('scripts')
    @stack('modals')
</body>
</html> 