@extends('layouts.app')

@section('title', 'Configurações do Sistema')

@push('styles')
<style>
    .config-card {
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid rgba(0,0,0,.125);
        border-radius: 0.5rem;
    }
    .config-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .config-card .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,.125);
        padding: 1rem 1.25rem;
    }
    .config-card .card-title {
        margin-bottom: 0;
        font-weight: 600;
        font-size: 1.1rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .image-preview {
        max-width: 100%;
        height: auto;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        padding: 0.5rem;
        background: #fff;
        margin: 0 auto 1rem;
        display: block;
    }
    .section-title {
        position: relative;
        padding-bottom: 0.5rem;
        margin: 1.5rem 0 1rem;
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c3e50;
    }
    .section-title:before {
        content: '';
        position: absolute;
        left: 0;
        bottom: -1px;
        width: 60px;
        height: 3px;
        background: #3490dc;
        border-radius: 3px;
    }
    .badge-public {
        font-size: 0.7rem;
        vertical-align: middle;
        margin-left: 0.5rem;
        padding: 0.25em 0.5em;
    }
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #495057;
    }
    .form-text {
        font-size: 0.8rem;
        color: #6c757d !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
    @endif
    
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i> Erro ao processar o formulário</h5>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
    @endif
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-cogs text-primary me-2"></i> Configurações do Sistema
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Configurações</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('system-config.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Nova Configuração
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('system-config.update-multiple') }}" method="POST" enctype="multipart/form-data" id="systemConfigForm">
        @csrf
        
        <!-- Configurações Gerais -->
        @foreach($groups as $groupName => $groupConfigs)
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="section-title">
                    <i class="fas fa-folder-open text-primary me-2"></i> {{ ucfirst($groupName) }}
                </h4>
            </div>
            
            @foreach($groupConfigs as $config)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 config-card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="config_{{ $config->id }}" class="form-label fw-bold">
                                {{ str_replace('_', ' ', ucfirst($config->key)) }}
                                @if($config->is_public)
                                    <span class="badge bg-info badge-public">Público</span>
                                @endif
                            </label>
                            
                            @if($config->type === 'boolean')
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" role="switch" 
                                           id="config_{{ $config->id }}" 
                                           name="configs[{{ $config->id }}][value]" 
                                           value="1"
                                           {{ $config->value ? 'checked' : '' }}>
                                    <label class="form-check-label" for="config_{{ $config->id }}">
                                        {{ $config->value ? 'Ativado' : 'Desativado' }}
                                    </label>
                                </div>
                            @elseif($config->type === 'json')
                                <textarea class="form-control mt-2" 
                                          name="configs[{{ $config->id }}][value]" 
                                          rows="3"
                                          placeholder="Informe um JSON válido"
                                          style="font-family: 'Courier New', monospace;">{{ $config->value }}</textarea>
                            @else
                                <input type="text" 
                                       class="form-control mt-2" 
                                       name="configs[{{ $config->id }}][value]" 
                                       value="{{ $config->value }}"
                                       placeholder="Digite o valor">
                            @endif
                            
                            @if($config->description)
                                <small class="form-text text-muted mt-1 d-block">
                                    <i class="fas fa-info-circle"></i> {{ $config->description }}
                                </small>
                            @endif
                            
                            <input type="hidden" name="configs[{{ $config->id }}][id]" value="{{ $config->id }}">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
        
        <!-- Seção de Mídia -->
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="section-title">
                    <i class="fas fa-images text-primary me-2"></i> Configurações de Mídia
                </h4>
            </div>
            
            <!-- Logo do Sistema -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 config-card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-image text-primary me-2"></i> Logo do Sistema
                        </h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="text-center mb-3">
                            <label class="form-label fw-bold d-block mb-2">Logo Atual</label>
                            <img id="logoPreview" 
                                 src="{{ \App\Helpers\ConfigHelper::get('logo_url', '/images/logo.png') }}" 
                                 class="img-fluid rounded border p-2 bg-white" 
                                 style="max-height: 100px;"
                                 alt="Logo Atual"
                                 onerror="this.src='{{ asset('images/placeholder-200x100.png') }}'">
                        </div>
                        <div class="mt-auto">
                            <label for="logo_upload" class="form-label fw-bold">Alterar Logo</label>
                            <div class="custom-file">
                                <input type="file" 
                                       class="form-control" 
                                       id="logo_upload" 
                                       name="logo_upload" 
                                       accept="image/png,image/jpeg,image/svg+xml"
                                       data-max-size="1024"
                                       onchange="previewImage(this, 'logoPreview')">
                                <small class="form-text text-muted">Formatos: PNG, JPG, SVG • Máx. 1MB</small>
                                <div id="logoPreview-filename" class="small text-muted mt-1" style="display: none;"></div>
                                <div id="logoPreview-filesize" class="small text-muted" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Favicon do Sistema -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 config-card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-star text-warning me-2"></i> Favicon
                        </h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="text-center mb-3">
                            <label class="form-label fw-bold d-block mb-2">Favicon Atual</label>
                            <img id="faviconPreview" 
                                 src="{{ \App\Helpers\ConfigHelper::get('favicon_url', '/favicon.ico') }}" 
                                 class="img-fluid rounded border p-2 bg-white" 
                                 style="max-width: 64px; max-height: 64px;"
                                 alt="Favicon Atual"
                                 onerror="this.src='{{ asset('images/placeholder-64x64.png') }}'">
                        </div>
                        <div class="mt-auto">
                            <label for="favicon_upload" class="form-label fw-bold">Alterar Favicon</label>
                            <div class="custom-file">
                                <input type="file" 
                                       class="form-control" 
                                       id="favicon_upload" 
                                       name="favicon_upload" 
                                       accept="image/x-icon,image/png,image/svg+xml"
                                       data-max-size="256"
                                       onchange="previewImage(this, 'faviconPreview')">
                                <small class="form-text text-muted">Formatos: ICO, PNG, SVG • Máx. 256KB</small>
                                <div id="faviconPreview-filename" class="small text-muted mt-1" style="display: none;"></div>
                                <div id="faviconPreview-filesize" class="small text-muted" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Seção de Slider -->
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="section-title">
                    <i class="fas fa-sliders-h text-info me-2"></i> Imagens do Slider
                </h4>
            </div>
            
            @php
                $sliderImages = [
                    ['key' => 'home_slider_image_1', 'label' => 'Imagem do Slider 1'],
                    ['key' => 'home_slider_image_2', 'label' => 'Imagem do Slider 2'],
                    ['key' => 'home_slider_image_3', 'label' => 'Imagem do Slider 3'],
                ];
            @endphp
            
            @foreach($sliderImages as $idx => $img)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 config-card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-image text-info me-2"></i> {{ $img['label'] }}
                        </h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="text-center mb-3">
                            <label class="form-label fw-bold d-block mb-2">Imagem Atual</label>
                            <img id="sliderImagePreview{{ $idx+1 }}" 
                                 src="{{ \App\Helpers\ConfigHelper::get($img['key'], '/images/slider_default.jpg') }}" 
                                 class="img-fluid rounded border p-2 bg-white" 
                                 style="max-height: 150px; width: 100%; object-fit: contain;"
                                 alt="{{ $img['label'] }}"
                                 onerror="this.src='{{ asset('images/placeholder-800x400.png') }}'">
                        </div>
                        <div class="mt-auto">
                            <label for="slider_image_upload_{{ $idx+1 }}" class="form-label fw-bold">Alterar Imagem</label>
                            <input type="file" 
                                   class="form-control" 
                                   id="slider_image_upload_{{ $idx+1 }}" 
                                   name="slider_image_upload_{{ $idx+1 }}" 
                                   accept="image/*"
                                   onchange="previewImage(this, 'sliderImagePreview{{ $idx+1 }}')">
                            <small class="form-text text-muted">Formatos: JPG, PNG, SVG • Máx. 2MB</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Seção de Textos da Home -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-home"></i> Textos e Seções da Página Home
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @php
                                $homeTexts = [
                                    ['key' => 'home_main_title', 'label' => 'Título Principal'],
                                    ['key' => 'home_main_subtitle', 'label' => 'Subtítulo Principal'],
                                    ['key' => 'home_main_paragraph', 'label' => 'Parágrafo Principal'],
                                    ['key' => 'home_cta_button_text', 'label' => 'Texto do Botão Principal (Denúncia)'],
                                    ['key' => 'home_cta_button_secondary', 'label' => 'Texto do Botão Secundário (Rastreamento)'],
                                    ['key' => 'home_features_title', 'label' => 'Título da Seção Recursos'],
                                    ['key' => 'home_features_subtitle', 'label' => 'Subtítulo da Seção Recursos'],
                                    ['key' => 'home_feature_1_title', 'label' => 'Título do Recurso 1'],
                                    ['key' => 'home_feature_1_text', 'label' => 'Texto do Recurso 1'],
                                    ['key' => 'home_feature_2_title', 'label' => 'Título do Recurso 2'],
                                    ['key' => 'home_feature_2_text', 'label' => 'Texto do Recurso 2'],
                                    ['key' => 'home_feature_3_title', 'label' => 'Título do Recurso 3'],
                                    ['key' => 'home_feature_3_text', 'label' => 'Texto do Recurso 3'],
                                    ['key' => 'home_about_title', 'label' => 'Título da Seção Sobre'],
                                    ['key' => 'home_about_text', 'label' => 'Texto da Seção Sobre'],
                                    ['key' => 'home_footer_text', 'label' => 'Texto do Rodapé'],
                                    ['key' => 'home_testimonial_1', 'label' => 'Depoimento 1'],
                                    ['key' => 'home_testimonial_2', 'label' => 'Depoimento 2'],
                                    ['key' => 'home_testimonial_3', 'label' => 'Depoimento 3'],
                                ];
                            @endphp
                            @foreach($homeTexts as $text)
                            @php
                                $config = isset($groups['frontend']) ? $groups['frontend']->where('key', $text['key'])->first() : null;
                            @endphp
                            <div class="col-md-6 mb-3">
                                <div class="form-group mb-3">
                                    <label for="config_{{ $text['key'] }}" class="form-label fw-bold">
                                        {{ $text['label'] }}
                                        @if(isset($config) && $config->is_public)
                                            <span class="badge bg-info badge-public">Público</span>
                                        @endif
                                    </label>
                                    <textarea class="form-control" 
                                              name="configs[{{ $config->id ?? '' }}][value]" 
                                              id="config_{{ $text['key'] }}" 
                                              rows="{{ in_array($text['key'], ['home_about_text', 'home_footer_text']) ? 3 : 2 }}"
                                              placeholder="Digite o texto para {{ strtolower($text['label']) }}...">{{ $config->value ?? '' }}</textarea>
                                    @if(isset($config) && $config->description)
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle"></i> {{ $config->description }}
                                        </small>
                                    @endif
                                    <input type="hidden" name="configs[{{ $config->id ?? '' }}][id]" value="{{ $config->id ?? '' }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Voltar para o Dashboard
                        </a>
                    </div>
                    <div>
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-undo me-1"></i> Redefinir
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i> Salvar Todas as Configurações
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Desabilitar envio duplo do formulário
    document.getElementById('systemConfigForm').addEventListener('submit', function(e) {
        const submitButton = this.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Salvando...';
        }
    });
    
    // Mostrar preview da imagem antes do upload
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        const maxSize = input.getAttribute('data-max-size') * 1024; // Converter KB para bytes
        const allowedTypes = input.accept.split(',').map(type => type.trim());
        
        // Elementos de feedback
        const fileNameElement = document.getElementById(`${previewId}-filename`);
        const fileSizeElement = document.getElementById(`${previewId}-filesize`);
        
        // Resetar feedback
        if (fileNameElement) {
            fileNameElement.textContent = '';
            fileNameElement.style.display = 'none';
            fileNameElement.className = 'text-muted small mt-1';
        }
        
        if (fileSizeElement) {
            fileSizeElement.textContent = '';
            fileSizeElement.style.display = 'none';
            fileSizeElement.className = 'text-muted small';
        }
        
        if (!file) {
            preview.src = '';
            preview.style.display = 'none';
            return;
        }
        
        // Verificar tipo de arquivo
        const fileType = file.type;
        const isTypeValid = allowedTypes.some(type => {
            if (type === '*/*') return true;
            if (type.startsWith('.')) {
                return file.name.toLowerCase().endsWith(type.toLowerCase());
            }
            return fileType.match(new RegExp(type.replace('*', '.*')));
        });
        
        if (!isTypeValid) {
            alert(`Tipo de arquivo não suportado. Por favor, selecione um arquivo do tipo: ${allowedTypes.join(', ')}`);
            input.value = '';
            return;
        }
        
        // Verificar tamanho do arquivo
        if (file.size > maxSize) {
            const maxSizeKB = (maxSize / 1024).toFixed(1);
            alert(`O arquivo é muito grande. O tamanho máximo permitido é ${maxSizeKB}KB.`);
            input.value = '';
            return;
        }
        
        // Exibir informações do arquivo
        if (fileNameElement) {
            fileNameElement.textContent = `Arquivo: ${file.name}`;
            fileNameElement.style.display = 'block';
        }
        
        if (fileSizeElement) {
            const fileSizeKB = (file.size / 1024).toFixed(1);
            fileSizeElement.textContent = `Tamanho: ${fileSizeKB} KB`;
            fileSizeElement.style.display = 'block';
        }
        
        // Exibir pré-visualização da imagem
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            
            // Mostrar botão de limpar
            const clearBtn = input.parentElement.querySelector('button[type="button"]');
            if (clearBtn) {
                clearBtn.style.display = 'block';
            }
        };
        
        reader.onerror = function() {
            alert('Não foi possível carregar o arquivo. Por favor, tente novamente.');
            input.value = '';
            preview.style.display = 'none';
        };
        
        reader.readAsDataURL(file);
    }
    
    // Atualiza o texto do switch quando alterado
    document.addEventListener('DOMContentLoaded', function() {
        const switches = document.querySelectorAll('.form-check-input[type="checkbox"]');
        switches.forEach(sw => {
            sw.addEventListener('change', function() {
                const label = this.nextElementSibling;
                if (label && label.classList.contains('form-check-label')) {
                    label.textContent = this.checked ? 'Ativado' : 'Desativado';
                }
            });
        });
        
        // Inicializa os tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Adiciona botão de limpar para os campos de upload
        document.querySelectorAll('.custom-file input[type="file"]').forEach(input => {
            const parent = input.parentElement;
            const clearBtn = document.createElement('button');
            clearBtn.type = 'button';
            clearBtn.className = 'btn btn-sm btn-outline-secondary mt-2';
            clearBtn.innerHTML = '<i class="fas fa-times me-1"></i> Remover arquivo';
            clearBtn.style.display = 'none';
            
            clearBtn.addEventListener('click', function() {
                input.value = '';
                const previewId = input.getAttribute('onchange').match(/'([^']+)'/)[1];
                const preview = document.getElementById(previewId);
                
                if (preview) {
                    preview.src = input.getAttribute('data-default-src') || '';
                    if (preview.style) preview.style.display = 'none';
                }
                
                // Esconder informações do arquivo
                const fileNameDisplay = document.getElementById(`${previewId}-filename`);
                if (fileNameDisplay) fileNameDisplay.style.display = 'none';
                
                const fileSizeDisplay = document.getElementById(`${previewId}-filesize`);
                if (fileSizeDisplay) fileSizeDisplay.style.display = 'none';
                
                this.style.display = 'none';
            });
            
            parent.appendChild(clearBtn);
            
            // Armazenar a imagem padrão para restaurar quando limpar
            const previewId = input.getAttribute('onchange').match(/'([^']+)'/)[1];
            const preview = document.getElementById(previewId);
            if (preview) {
                input.setAttribute('data-default-src', preview.src);
            }
            
            // Mostrar/ocultar botão de limpar quando um arquivo for selecionado
            input.addEventListener('change', function() {
                clearBtn.style.display = this.files.length ? 'block' : 'none';
            });
        });
    });
</script>
@endpush
@endsection 