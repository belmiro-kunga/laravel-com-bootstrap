<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Denúncia Corporativa - Sistema de Denúncias</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --border-radius: 10px;
            --box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #2d3748;
            line-height: 1.6;
        }
        
        .form-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            margin: 2rem 0;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .form-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 2.5rem 2rem;
            position: relative;
            overflow: visible;
        }
        
        .form-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            transform: rotate(30deg);
        }
        
        .form-body {
            padding: 2.5rem;
        }
        
        /* Estilos dos campos do formulário */
        .form-control, .form-select, .form-textarea {
            border: 2px solid #e1e5ee;
            border-radius: var(--border-radius);
            padding: 0.8rem 1.2rem;
            font-size: 1rem;
            transition: var(--transition);
            box-shadow: none;
        }
        
        .form-control:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }
        
        .form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        /* Botões */
        .btn {
            border-radius: var(--border-radius);
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
        }
        
        .btn-primary:hover, .btn-primary:focus {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
            color: white;
        }
        
        .btn-outline-secondary {
            border: 2px solid var(--secondary-color);
            color: var(--secondary-color);
            background: transparent;
        }
        
        .btn-outline-secondary:hover {
            background: var(--secondary-color);
            color: white;
        }
        
        /* Indicador de etapas */
        .step-indicator-container {
            padding: 2rem 2rem 1.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
            position: relative;
        }
        
        .step-indicator {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin: 0;
            padding: 0;
            counter-reset: step;
        }
        
        .step-indicator::before {
            content: '';
            position: absolute;
            top: 25px;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #e9ecef 0%, #dee2e6 100%);
            border-radius: 2px;
            z-index: 1;
        }
        
        .step-indicator::after {
            content: '';
            position: absolute;
            top: 25px;
            left: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 2px;
            z-index: 2;
            transition: width 0.6s ease;
            width: 0%;
        }
        
        .step {
            position: relative;
            z-index: 3;
            text-align: center;
            flex: 1;
            max-width: 150px;
        }
        
        .step:not(:last-child) {
            margin-right: 10px;
        }
        
        .step-number {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.75rem;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border: 3px solid #e9ecef;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .step.active .step-number {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            transform: scale(1.15);
            border-color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }
        
        .step.completed .step-number {
            background: linear-gradient(135deg, var(--success-color) 0%, #20c997 100%);
            color: white;
            border-color: var(--success-color);
        }
        
        .step.completed .step-number::after {
            content: '\f00c';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            font-size: 1.2rem;
        }
        
        .step-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 0.25rem;
            transition: all 0.3s ease;
        }
        
        .step.active .step-label {
            color: var(--primary-color);
            font-weight: 700;
        }
        
        .step.completed .step-label {
            color: var(--success-color);
        }
        
        .step-description {
            font-size: 0.75rem;
            color: #adb5bd;
            line-height: 1.2;
        }
        
        .step.active .step-description {
            color: var(--primary-color);
        }
        
        /* Animações das seções */
        .form-section {
            display: none;
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .form-section.active {
            display: block;
            opacity: 1;
            transform: translateX(0);
        }
        
        .form-section.animate__fadeIn {
            animation: fadeInSlide 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        
        .form-section.animate__fadeOut {
            animation: fadeOutSlide 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        
        @keyframes fadeInSlide {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeOutSlide {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(-30px);
            }
        }
        
        /* Botões de navegação */
        .wizard-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem 0 1rem;
            border-top: 1px solid #e9ecef;
            margin-top: 2rem;
        }
        
        .btn-wizard {
            padding: 0.875rem 2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            min-width: 140px;
        }
        
        .btn-wizard::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-wizard:hover::before {
            left: 100%;
        }
        
        .btn-wizard:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }
        
        .btn-wizard:not(:disabled):hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .btn-wizard.btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            color: white;
        }
        
        .btn-wizard.btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-hover) 0%, #5a6268 100%);
        }
        
        .btn-wizard.btn-outline-secondary {
            border: 2px solid var(--secondary-color);
            color: var(--secondary-color);
            background: transparent;
        }
        
        .btn-wizard.btn-outline-secondary:hover {
            background: var(--secondary-color);
            color: white;
        }
        
        .btn-wizard.btn-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #20c997 100%);
            border: none;
            color: white;
        }
        
        .btn-wizard.btn-success:hover {
            background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
        }
        
        /* Indicador de progresso */
        .progress-indicator {
            position: absolute;
            top: 0;
            left: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 2px;
            z-index: 2;
            transition: width 0.6s ease;
        }
        
        /* Validação em tempo real */
        .form-control.is-valid {
            border-color: var(--success-color);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        .form-control.is-invalid {
            border-color: var(--danger-color);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 2.4 2.4m0-2.4L5.8 7'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        /* Loading state para botões */
        .btn-loading {
            position: relative;
            color: transparent !important;
        }
        
        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Responsividade */
        @media (max-width: 768px) {
            .step-indicator {
                flex-direction: column;
                gap: 1rem;
            }
            
            .step-indicator::before,
            .step-indicator::after {
                display: none;
            }
            
            .step {
                max-width: none;
                margin-right: 0;
            }
            
            .step-number {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            .wizard-buttons {
                flex-direction: column;
                gap: 1rem;
            }
            
            .btn-wizard {
                width: 100%;
                min-width: auto;
            }
        }
        
        /* Cards de opção */
        .option-card {
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: var(--transition);
            background: white;
        }
        
        .option-card:hover {
            border-color: var(--primary-color);
            background: #f8f9ff;
        }
        
        .option-card.selected {
            border-color: var(--primary-color);
            background: rgba(67, 97, 238, 0.05);
        }
        
        .option-card i {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: block;
        }
        
        /* Notificações e alertas */
        .privacy-notice {
            background: #f8f9fa;
            border-left: 4px solid var(--primary-color);
            border-radius: var(--border-radius);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }
        
        .privacy-notice h6 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }
        
        .privacy-notice h6 i {
            margin-right: 0.5rem;
        }
        
        /* Upload de arquivos */
        .file-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: var(--border-radius);
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            background: #f8f9fa;
            margin-bottom: 1.5rem;
        }
        
        .file-upload-area:hover {
            border-color: var(--primary-color);
            background: rgba(67, 97, 238, 0.05);
        }
        
        .file-upload-area i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: block;
        }
        
        /* Preview de arquivos */
        .file-preview {
            margin-top: 1rem;
        }
        
        .file-preview-item {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border-radius: 6px;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            transition: var(--transition);
        }
        
        .file-preview-item:hover {
            background: #f1f3f9;
        }
        
        .file-preview-item i {
            margin-right: 0.75rem;
            color: #6c757d;
            font-size: 1.2rem;
        }
        
        .file-preview-item .file-info {
            flex: 1;
            min-width: 0;
        }
        
        .file-preview-item .file-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: 500;
            margin-bottom: 0.2rem;
        }
        
        .file-preview-item .file-size {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .file-preview-item .remove-file {
            color: var(--danger-color);
            cursor: pointer;
            margin-left: 1rem;
            font-size: 1.1rem;
            transition: var(--transition);
            padding: 0.3rem;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .file-preview-item .remove-file:hover {
            background: rgba(220, 53, 69, 0.1);
        }
        
        /* Validação */
        .is-invalid {
            border-color: var(--danger-color) !important;
        }
        
        .is-valid {
            border-color: var(--success-color) !important;
        }
        
        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }
        
        .required-field::after {
            content: " *";
            color: var(--danger-color);
        }
        
        /* Estilos para a área de upload de arquivos */
        .file-upload-container {
            margin-bottom: 1.5rem;
        }
        
        .file-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: var(--border-radius);
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        
        .file-upload-area:hover, .file-upload-area.highlight {
            border-color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.05);
            transform: scale(1.02);
        }
        
        .file-upload-area.highlight {
            border-color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.1);
            box-shadow: 0 0 20px rgba(67, 97, 238, 0.2);
        }
        
        .file-upload-area i {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .file-preview-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-top: 1rem;
        }
        
        .file-preview-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            background-color: #f8f9fa;
            border-radius: var(--border-radius);
            border: 1px solid #e9ecef;
            transition: all 0.2s ease;
        }
        
        .file-preview-item:hover {
            background-color: #f1f3f5;
        }
        
        .file-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
        }
        
        .file-name {
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300px;
        }
        
        .file-size {
            color: #6c757d;
            font-size: 0.85rem;
            white-space: nowrap;
        }
        
        .remove-file {
            color: #dc3545;
            background: none;
            border: none;
            padding: 0.25rem 0.5rem;
            border-radius: 50%;
            transition: all 0.2s ease;
        }
        
        .remove-file:hover {
            background-color: rgba(220, 53, 69, 0.1);
        }
        
        /* Estilos para os botões de navegação */
        .btn-outline-secondary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* Estilos para os campos de formulário */
        .form-control:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }
        
        .form-control.is-invalid, .form-select.is-invalid, .form-check-input.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }
        
        .form-text {
            color: #6c757d;
            font-size: 0.875em;
        }
        
        /* Estilos para os passos do formulário */
        .form-section {
            display: none;
            animation-duration: 0.3s;
        }
        
        .form-section.active {
            display: block;
            animation-name: fadeIn;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Estilos para a seção de identificação */
        .identification-toggle {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .identification-option {
            flex: 1;
            text-align: center;
            padding: 1rem;
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .identification-option:hover {
            border-color: var(--primary-color);
        }
        
        .identification-option.active {
            border-color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        .identification-option i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }
        
        .identification-option.active i {
            color: var(--primary-color);
        }
        
        /* Estilos para responsividade */
        @media (max-width: 768px) {
            .file-name {
                max-width: 200px;
            }
            
            .identification-toggle {
                flex-direction: column;
                gap: 0.75rem;
            }
        }
        
        /* Garantir que o botão Voltar ao Início seja clicável */
        .btn-outline-light {
            position: relative !important;
            z-index: 1000 !important;
            cursor: pointer !important;
            pointer-events: auto !important;
        }
        
        .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
        }
        
        @media (max-width: 576px) {
            .file-name {
                max-width: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="container py-5">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-container">
                    <!-- Header -->
                    <div class="form-header">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h2 class="mb-1">
                                    <i class="fas fa-shield-alt me-2"></i>
                                    Sistema de Denúncias Corporativas
                                </h2>
                                <p class="mb-0">Canal seguro e confidencial para denúncias</p>
                            </div>
                            <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm" style="position: relative; z-index: 1000; cursor: pointer;" onclick="window.location.href='{{ route('home') }}'">
                                <i class="fas fa-arrow-left me-1"></i> Voltar ao Início
                            </a>
                        </div>
                        
                        <!-- Indicador de Etapas -->
                        <div class="step-indicator-container">
                            <div class="step-indicator">
                                <div class="step active" data-step="1">
                                    <div class="step-number">1</div>
                                    <div class="step-label">Informações Básicas</div>
                                    <div class="step-description">Categoria e título</div>
                                </div>
                                <div class="step" data-step="2">
                                    <div class="step-number">2</div>
                                    <div class="step-label">Detalhes</div>
                                    <div class="step-description">Descrição completa</div>
                                </div>
                                <div class="step" data-step="3">
                                    <div class="step-number">3</div>
                                    <div class="step-label">Anexos</div>
                                    <div class="step-description">Documentos (opcional)</div>
                                </div>
                                <div class="step" data-step="4">
                                    <div class="step-number">4</div>
                                    <div class="step-label">Identificação</div>
                                    <div class="step-description">Anônimo ou identificado</div>
                                </div>
                            </div>
                            <div class="progress-indicator" id="progressIndicator"></div>
                        </div>
                    </div>
                    
                    <!-- Form Body -->
                    <div class="form-body">
                        @if($errors->any())
                        <div class="alert alert-danger animate__animated animate__fadeIn">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <h6 class="mb-0">Erro no formulário</h6>
                            </div>
                            <ul class="mb-0 mt-2 ps-4">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        
                        @if(session('success'))
                        <div class="alert alert-success animate__animated animate__fadeIn">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                <span class="fw-bold">{{ session('success') }}</span>
                            </div>
                        </div>
                        @endif
                        
                        <form action="{{ route('denuncias.salvar-publica') }}" method="POST" id="denunciaForm" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            
                            <!-- Step 1: Informações Básicas -->
                            <div class="form-section active" id="step1">
                                <h4 class="mb-4">
                                    <i class="fas fa-info-circle text-primary me-2"></i>
                                    Informações Básicas
                                </h4>
                                
                                <div class="mb-4">
                                    <label for="categoria_id" class="form-label required-field">Categoria da Denúncia</label>
                                    <select class="form-select" id="categoria_id" name="categoria_id" required>
                                        <option value="" selected disabled>Selecione uma categoria...</option>
                                        @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nome }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Por favor, selecione uma categoria.</div>
                                    <div class="form-text mt-1">Selecione a categoria que melhor descreve sua denúncia.</div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="titulo" class="form-label required-field">Título da Denúncia</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" 
                                           value="{{ old('titulo') }}" required 
                                           placeholder="Ex: Atraso no pagamento de salários"
                                           minlength="10" maxlength="100">
                                    <div class="invalid-feedback">Por favor, insira um título para a denúncia (mínimo 10 caracteres).</div>
                                    <div class="form-text mt-1">Seja claro e objetivo no título.</div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="prioridade" class="form-label required-field">Prioridade</label>
                                    <select class="form-select" id="prioridade" name="prioridade" required>
                                        <option value="" selected disabled>Selecione a prioridade...</option>
                                        <option value="baixa" {{ old('prioridade') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                                        <option value="media" {{ old('prioridade') == 'media' ? 'selected' : '' }}>Média</option>
                                        <option value="alta" {{ old('prioridade') == 'alta' ? 'selected' : '' }}>Alta</option>
                                        <option value="critica" {{ old('prioridade') == 'critica' ? 'selected' : '' }}>Crítica</option>
                                    </select>
                                    <div class="invalid-feedback">Por favor, selecione a prioridade da denúncia.</div>
                                    <div class="form-text mt-1">Avalie a urgência da sua denúncia.</div>
                                </div>
                                
                                <div class="wizard-buttons">
                                    <div>
                                        <button type="button" class="btn btn-wizard btn-outline-secondary" disabled>
                                            <i class="fas fa-arrow-left me-2"></i> Voltar
                                        </button>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-wizard btn-primary" onclick="nextStep()">
                                            Próximo <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Step 2: Detalhes -->
                            <div class="form-section" id="step2">
                                <h4 class="mb-4">
                                    <i class="fas fa-clipboard-list text-primary me-2"></i>
                                    Detalhes da Ocorrência
                                </h4>
                                
                                <div class="mb-3">
                                    <label for="descricao" class="form-label required-field">Descrição Detalhada</label>
                                    <textarea class="form-control" id="descricao" name="descricao" rows="5" required 
                                              placeholder="Descreva detalhadamente o que aconteceu, incluindo datas, locais, pessoas envolvidas...">{{ old('descricao') }}</textarea>
                                    <div class="invalid-feedback">Por favor, forneça uma descrição detalhada.</div>
                                    <div class="form-text mt-1">Seja o mais detalhado possível para facilitar a análise.</div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="local_ocorrencia" class="form-label">Local da Ocorrência</label>
                                            <input type="text" class="form-control" id="local_ocorrencia" name="local_ocorrencia" 
                                                   value="{{ old('local_ocorrencia') }}" 
                                                   placeholder="Departamento, sala, etc.">
                                            <div class="form-text mt-1">Onde o fato ocorreu?</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="data_ocorrencia" class="form-label">Data da Ocorrência</label>
                                            <input type="date" class="form-control" id="data_ocorrencia" name="data_ocorrencia" 
                                                   value="{{ old('data_ocorrencia') }}">
                                            <div class="form-text mt-1">Quando o fato ocorreu?</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="envolvidos" class="form-label">Pessoas Envolvidas</label>
                                    <textarea class="form-control" id="envolvidos" name="envolvidos" rows="2" 
                                              placeholder="Nomes das pessoas envolvidas (se souber)">{{ old('envolvidos') }}</textarea>
                                    <div class="form-text mt-1">Se souber, informe os nomes das pessoas envolvidas.</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="testemunhas" class="form-label">Testemunhas</label>
                                    <textarea class="form-control" id="testemunhas" name="testemunhas" rows="2" 
                                              placeholder="Nomes de possíveis testemunhas">{{ old('testemunhas') }}</textarea>
                                    <div class="form-text mt-1">Se houver testemunhas, informe seus nomes.</div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                                    <div>
                                        <button type="button" class="btn btn-outline-secondary" onclick="prevStep()">
                                            <i class="fas fa-arrow-left me-2"></i> Voltar
                                        </button>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-primary" onclick="nextStep()">
                                            Próximo <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Step 3: Anexos -->
                            <div class="form-section" id="step3">
                                <h4 class="mb-4">
                                    <i class="fas fa-paperclip text-primary me-2"></i>
                                    Anexos (Opcional)
                                </h4>
                                
                                <div class="file-upload-container mb-4">
                                    <div class="file-upload-area" id="dropArea">
                                        <i class="fas fa-cloud-upload-alt fa-3x mb-3 text-muted"></i>
                                        <h5>Arraste e solte arquivos aqui</h5>
                                        <p class="text-muted mb-3">ou</p>
                                        <label for="comprovativos" class="btn btn-outline-primary">
                                            <i class="fas fa-folder-open me-2"></i>Selecionar Arquivos
                                            <input type="file" id="comprovativos" name="comprovativos[]" multiple class="d-none" onchange="previewFiles(this)">
                                        </label>
                                        <p class="small text-muted mt-2">Formatos aceitos: .pdf, .doc, .docx, .jpg, .jpeg, .png (Máx. 10MB por arquivo)</p>
                                    </div>
                                    
                                    <div id="filePreview" class="mt-4">
                                        <h6 class="mb-3">Arquivos selecionados:</h6>
                                        <div id="fileList" class="file-preview-list">
                                            <!-- Lista de arquivos será exibida aqui -->
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <label for="descricao_comprovativos" class="form-label">
                                            <i class="fas fa-comment me-1"></i>Descrição dos Comprovativos (Opcional)
                                        </label>
                                        <textarea class="form-control" id="descricao_comprovativos" name="descricao_comprovativos" 
                                                  rows="3" placeholder="Descreva brevemente o conteúdo dos arquivos anexados...">{{ old('descricao_comprovativos') }}</textarea>
                                        <div class="form-text">
                                            Forneça uma breve descrição dos documentos anexados para facilitar a análise.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                                    <div>
                                        <button type="button" class="btn btn-outline-secondary" onclick="prevStep()">
                                            <i class="fas fa-arrow-left me-2"></i> Voltar
                                        </button>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-primary" onclick="nextStep()">
                                            Próximo <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Step 4: Identificação -->
                            <div class="form-section" id="step4">
                                <h4 class="mb-4">
                                    <i class="fas fa-user-shield text-primary me-2"></i>
                                    Identificação
                                </h4>
                                
                                <div class="privacy-notice mb-4">
                                    <div class="alert alert-info">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <h6 class="mb-0">Política de Privacidade</h6>
                                        </div>
                                        <p class="mb-0 mt-2">
                                            Sua privacidade é importante para nós. Você pode optar por se identificar ou permanecer anônimo. 
                                            Em ambos os casos, todas as informações fornecidas serão tratadas com total sigilo.
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label required-field">Deseja se identificar?</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipo_denuncia" id="anonima" value="anonima" checked>
                                            <label class="form-check-label" for="anonima">
                                                <i class="fas fa-user-secret me-1"></i> Manter-me anônimo
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipo_denuncia" id="identificada" value="identificada">
                                            <label class="form-check-label" for="identificada">
                                                <i class="fas fa-id-card me-1"></i> Quero me identificar
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="camposIdentificacao" style="display: none;">
                                    <div class="alert alert-info mb-4">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Fornecer seus dados permite que entremos em contato para solicitar informações adicionais 
                                        e para acompanhar o andamento da sua denúncia.
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nome_denunciante" class="form-label">Nome Completo</label>
                                            <input type="text" class="form-control" id="nome_denunciante" name="nome_denunciante" 
                                                   value="{{ old('nome_denunciante') }}" placeholder="Seu nome completo">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email_denunciante" class="form-label">E-mail</label>
                                            <input type="email" class="form-control" id="email_denunciante" name="email_denunciante" 
                                                   value="{{ old('email_denunciante') }}" placeholder="seu@email.com">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="telefone_denunciante" class="form-label">Telefone</label>
                                            <input type="tel" class="form-control" id="telefone_denunciante" name="telefone_denunciante" 
                                                   value="{{ old('telefone_denunciante') }}" placeholder="(00) 00000-0000">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="departamento_denunciante" class="form-label">Departamento/Setor (opcional)</label>
                                            <input type="text" class="form-control" id="departamento_denunciante" name="departamento_denunciante" 
                                                   value="{{ old('departamento_denunciante') }}" placeholder="Ex: Recursos Humanos">
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="infoAnonimato" class="alert alert-warning mt-4">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Atenção:</strong> Ao escolher permanecer anônimo, não será possível entrar em contato 
                                    para obter informações adicionais ou fornecer atualizações sobre o andamento da sua denúncia.
                                </div>
                                
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="termos" name="termos" required>
                                    <label class="form-check-label" for="termos">
                                        Li e concordo com os <a href="#" data-bs-toggle="modal" data-bs-target="#termosModal">Termos de Uso</a> 
                                        e <a href="#" data-bs-toggle="modal" data-bs-target="#privacidadeModal">Política de Privacidade</a>
                                    </label>
                                    <div class="invalid-feedback">
                                        Você deve concordar com os termos para enviar a denúncia.
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                                    <div>
                                        <button type="button" class="btn btn-outline-secondary" onclick="prevStep()">
                                            <i class="fas fa-arrow-left me-2"></i> Voltar
                                        </button>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-paper-plane me-2"></i> Enviar Denúncia
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="text-center mt-4">
                    <p class="text-white mb-2">
                        <i class="fas fa-lock"></i> Sistema seguro e confidencial
                    </p>
                    <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-home"></i> Voltar à Página Inicial
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Termos de Uso -->
    <div class="modal fade" id="termosModal" tabindex="-1" aria-labelledby="termosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termosModalLabel">
                        <i class="fas fa-file-contract me-2"></i>Termos de Uso
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <h6>1. Aceitação dos Termos</h6>
                    <p>Ao utilizar este canal de denúncias, você concorda com estes Termos de Uso e com nossa Política de Privacidade.</p>
                    
                    <h6 class="mt-4">2. Uso Adequado</h6>
                    <p>Este canal destina-se exclusivamente ao envio de denúncias relacionadas a irregularidades e violações de conduta no ambiente de trabalho ou relacionadas às atividades da empresa.</p>
                    
                    <h6 class="mt-4">3. Responsabilidades</h6>
                    <p>O denunciante é responsável pela veracidade das informações fornecidas. Denúncias falsas ou de má-fé podem resultar em responsabilização legal.</p>
                    
                    <h6 class="mt-4">4. Sigilo</h6>
                    <p>Todas as denúncias serão tratadas com absoluto sigilo, conforme estabelecido em nossa Política de Privacidade.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Política de Privacidade -->
    <div class="modal fade" id="privacidadeModal" tabindex="-1" aria-labelledby="privacidadeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="privacidadeModalLabel">
                        <i class="fas fa-shield-alt me-2"></i>Política de Privacidade
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <h6>1. Coleta de Dados</h6>
                    <p>Coletamos apenas os dados estritamente necessários para o processamento da denúncia, que podem incluir informações de identificação, quando fornecidas voluntariamente.</p>
                    
                    <h6 class="mt-4">2. Uso das Informações</h6>
                    <p>As informações fornecidas serão utilizadas exclusivamente para apuração da denúncia e tomada das providências cabíveis.</p>
                    
                    <h6 class="mt-4">3. Sigilo e Segurança</h6>
                    <p>Todas as informações são tratadas com absoluto sigilo e armazenadas em ambiente seguro, com acesso restrito a pessoas previamente autorizadas.</p>
                    
                    <h6 class="mt-4">4. Retenção de Dados</h6>
                    <p>Os dados serão mantidos pelo tempo necessário para cumprimento de obrigações legais e regulatórias.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS e Dependências -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    
    <script>
        // Máscaras para campos de formulário
        $(document).ready(function() {
            $('#telefone_denunciante').mask('000 000 000'); // Padrão Angola: 923 456 789
        });
        
        // Controle das etapas do formulário
        let currentStep = 1;
        const totalSteps = 4;
        
        // Função para validar e-mail
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        
        // Função para validar telefone angolano
        function isValidAngolaPhone(phone) {
            // Aceita 923 456 789 ou +244 923 456 789
            const regex = /^(\+244\s?)?9\d{2}\s?\d{3}\s?\d{3}$/;
            return regex.test(phone.replace(/\s+/g, ''));
        }
        
        // Função para exibir uma etapa específica do formulário
        function showStep(step) {
            // Esconde todas as seções
            document.querySelectorAll('.form-section').forEach(section => {
                section.classList.remove('active', 'animate__fadeIn');
            });
            
            // Mostra a seção atual
            const currentSection = document.getElementById('step' + step);
            if (currentSection) {
                currentSection.classList.add('active', 'animate__animated', 'animate__fadeIn');
            }
            
            // Atualiza o indicador de etapas
            updateStepIndicator();
            updateProgressBar();
        }
        
        // Função para atualizar a barra de progresso
        function updateProgressBar() {
            const progressIndicator = document.getElementById('progressIndicator');
            if (progressIndicator) {
                const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
                progressIndicator.style.width = progress + '%';
            }
        }
        
        // Exibir apenas a primeira etapa ao carregar a página
        document.addEventListener('DOMContentLoaded', function() {
            showStep(currentStep);
            updateProgressBar();
            
            // Inicializar tooltips do Bootstrap
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Validação em tempo real
            initializeRealTimeValidation();
        });
        
        // Validação em tempo real
        function initializeRealTimeValidation() {
            const form = document.getElementById('denunciaForm');
            if (!form) return;
            
            // Validar campos quando o usuário digita
            form.addEventListener('input', function(e) {
                validateField(e.target);
            });
            
            // Validar campos quando perdem o foco
            form.addEventListener('blur', function(e) {
                validateField(e.target);
            }, true);
        }
        
        // Validar campo individual
        function validateField(field) {
            if (!field) return;
            
            // Remover classes de validação anteriores
            field.classList.remove('is-valid', 'is-invalid');
            
            // Validar campo obrigatório
            if (field.hasAttribute('required')) {
                let isValid = false;
                
                // Validação específica para checkboxes
                if (field.type === 'checkbox') {
                    isValid = field.checked;
                } else {
                    isValid = field.value.trim() !== '';
                }
                
                if (!isValid) {
                    field.classList.add('is-invalid');
                    return false;
                }
            }
            
            // Validação específica por tipo
            if (field.type === 'email' && field.value.trim()) {
                if (!isValidEmail(field.value)) {
                    field.classList.add('is-invalid');
                    return false;
                }
            }
            
            // Validação de comprimento mínimo
            if (field.hasAttribute('minlength')) {
                const minLength = parseInt(field.getAttribute('minlength'));
                if (field.value.length < minLength) {
                    field.classList.add('is-invalid');
                    return false;
                }
            }
            
            // Se passou por todas as validações
            if (field.type === 'checkbox' ? field.checked : field.value.trim()) {
                field.classList.add('is-valid');
            }
            
            return true;
        }
        
        function nextStep() {
            console.log('nextStep chamada, currentStep:', currentStep); // Debug
            if (validateStep(currentStep)) {
                if (currentStep < totalSteps) {
                    // Adiciona animação de saída
                    const currentSection = document.getElementById('step' + currentStep);
                    if (currentSection) {
                        currentSection.classList.remove('animate__fadeIn');
                        currentSection.classList.add('animate__fadeOut');
                        
                        // Aguarda a animação terminar antes de trocar de seção
                        setTimeout(() => {
                            currentSection.classList.remove('active', 'animate__fadeOut');
                            currentStep++;
                            const nextSection = document.getElementById('step' + currentStep);
                            if (nextSection) {
                                nextSection.classList.add('active', 'animate__animated', 'animate__fadeIn');
                                updateStepIndicator();
                                updateProgressBar();
                                updateNavigationButtons();
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                                
                                // Se for a última etapa, rola para o topo do formulário
                                if (currentStep === totalSteps) {
                                    const form = document.getElementById('denunciaForm');
                                    if (form) {
                                        form.scrollIntoView({ behavior: 'smooth' });
                                    }
                                }
                            }
                        }, 300);
                    }
                }
            }
        }
        
        function prevStep() {
            if (currentStep > 1) {
                const currentSection = document.getElementById('step' + currentStep);
                if (currentSection) {
                    currentSection.classList.remove('active');
                }
                currentStep--;
                const prevSection = document.getElementById('step' + currentStep);
                if (prevSection) {
                    prevSection.classList.add('active');
                }
                updateStepIndicator();
                updateProgressBar();
                updateNavigationButtons();
            }
        }
        
        function updateNavigationButtons() {
            const prevButtons = document.querySelectorAll('.btn-wizard.btn-outline-secondary');
            const nextButtons = document.querySelectorAll('.btn-wizard.btn-primary');
            const submitButtons = document.querySelectorAll('.btn-wizard.btn-success');
            
            // Atualizar botão "Voltar"
            prevButtons.forEach(btn => {
                if (currentStep === 1) {
                    btn.disabled = true;
                } else {
                    btn.disabled = false;
                }
            });
            
            // Atualizar botão "Próximo" ou "Enviar"
            if (currentStep === totalSteps) {
                nextButtons.forEach(btn => btn.style.display = 'none');
                submitButtons.forEach(btn => btn.style.display = 'inline-block');
            } else {
                nextButtons.forEach(btn => btn.style.display = 'inline-block');
                submitButtons.forEach(btn => btn.style.display = 'none');
            }
        }
        
        function updateStepIndicator() {
            const steps = document.querySelectorAll('.step');
            steps.forEach((step, index) => {
                step.classList.remove('active', 'completed');
                if (index + 1 < currentStep) {
                    step.classList.add('completed');
                } else if (index + 1 === currentStep) {
                    step.classList.add('active');
                }
            });
        }
        
        function validateStep(step) {
            let isValid = true;
            const currentSection = document.getElementById('step' + step);
            if (!currentSection) {
                console.error('Seção step' + step + ' não encontrada');
                return false;
            }
            
            // Validação específica para o step 4 (identificação)
            if (step === 4) {
                const tipoDenuncia = document.querySelector('input[name="tipo_denuncia"]:checked');
                if (!tipoDenuncia) {
                    alert('Por favor, selecione se deseja se identificar ou permanecer anônimo.');
                    return false;
                }
                
                // Se for identificada, validar campos obrigatórios
                if (tipoDenuncia.value === 'identificada') {
                    const nomeDenunciante = document.getElementById('nome_denunciante');
                    const emailDenunciante = document.getElementById('email_denunciante');
                    
                    if (!nomeDenunciante.value.trim()) {
                        nomeDenunciante.classList.add('is-invalid');
                        isValid = false;
                    }
                    
                    if (!emailDenunciante.value.trim() || !isValidEmail(emailDenunciante.value)) {
                        emailDenunciante.classList.add('is-invalid');
                        isValid = false;
                    }
                    
                    const telefoneDenunciante = document.getElementById('telefone_denunciante');
                    if (telefoneDenunciante && telefoneDenunciante.value.trim() && !isValidAngolaPhone(telefoneDenunciante.value.trim())) {
                        telefoneDenunciante.classList.add('is-invalid');
                        isValid = false;
                    }
                }
            }
            
            const requiredFields = currentSection.querySelectorAll('[required]');
            
            // Validar todos os campos obrigatórios da seção atual
            requiredFields.forEach(field => {
                if (!validateField(field)) {
                    isValid = false;
                }
            });
            
            // Se há campos inválidos, rolar até o primeiro
            if (!isValid) {
                const invalidField = currentSection.querySelector('.is-invalid');
                if (invalidField) {
                    invalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    invalidField.focus();
                }
            }
            
            return isValid;
        }
        
        function previewFiles(input) {
            const fileList = document.getElementById('fileList');
            const filePreview = document.getElementById('filePreview');
            
            fileList.innerHTML = '';
            
            if (input.files.length > 0) {
                filePreview.style.display = 'block';
                
                Array.from(input.files).forEach((file, index) => {
                    // Validar tipo de arquivo
                    const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    const isValidType = allowedTypes.includes(file.type);
                    
                    // Validar tamanho (10MB = 10 * 1024 * 1024 bytes)
                    const maxSize = 10 * 1024 * 1024;
                    const isValidSize = file.size <= maxSize;
                    
                    const fileItem = document.createElement('div');
                    fileItem.className = `list-group-item d-flex justify-content-between align-items-center ${!isValidType || !isValidSize ? 'border-danger' : ''}`;
                    
                    const fileInfo = document.createElement('div');
                    fileInfo.innerHTML = `
                        <div class="d-flex align-items-center">
                            <i class="fas ${getFileIcon(file.type)} me-2 ${!isValidType || !isValidSize ? 'text-danger' : 'text-primary'}"></i>
                            <div>
                                <strong class="${!isValidType || !isValidSize ? 'text-danger' : ''}">${file.name}</strong>
                                <br>
                                <small class="text-muted">${formatFileSize(file.size)}</small>
                                ${!isValidType ? '<br><small class="text-danger">Tipo de arquivo não suportado</small>' : ''}
                                ${!isValidSize ? '<br><small class="text-danger">Arquivo muito grande (máx. 10MB)</small>' : ''}
                            </div>
                        </div>
                    `;
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-sm btn-outline-danger';
                    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                    removeBtn.onclick = function() {
                        removeFile(index);
                    };
                    
                    fileItem.appendChild(fileInfo);
                    fileItem.appendChild(removeBtn);
                    fileList.appendChild(fileItem);
                });
                
                // Mostrar resumo
                const totalFiles = input.files.length;
                const totalSize = Array.from(input.files).reduce((sum, file) => sum + file.size, 0);
                
                const summary = document.createElement('div');
                summary.className = 'alert alert-info mt-3';
                summary.innerHTML = `
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>${totalFiles}</strong> arquivo(s) selecionado(s) - Total: ${formatFileSize(totalSize)}
                `;
                
                // Remover resumo anterior se existir
                const existingSummary = filePreview.querySelector('.alert');
                if (existingSummary) {
                    existingSummary.remove();
                }
                
                filePreview.appendChild(summary);
            } else {
                filePreview.style.display = 'none';
            }
        }
        
        function getFileIcon(mimeType) {
            switch(mimeType) {
                case 'application/pdf':
                    return 'fa-file-pdf';
                case 'application/msword':
                case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                    return 'fa-file-word';
                case 'image/jpeg':
                case 'image/jpg':
                case 'image/png':
                case 'image/gif':
                    return 'fa-file-image';
                default:
                    return 'fa-file';
            }
        }
        
        function removeFile(index) {
            const input = document.getElementById('comprovativos');
            const dt = new DataTransfer();
            
            Array.from(input.files).forEach((file, i) => {
                if (i !== index) {
                    dt.items.add(file);
                }
            });
            
            input.files = dt.files;
            previewFiles(input);
        }
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        // Remove validation styling when user starts typing
        document.addEventListener('input', function(e) {
            if (e.target.hasAttribute('required')) {
                e.target.classList.remove('is-invalid');
            }
        });
        
        // Controlar exibição dos campos de identificação
        document.addEventListener('DOMContentLoaded', function() {
            const tipoDenunciaRadios = document.querySelectorAll('input[name="tipo_denuncia"]');
            const camposIdentificacao = document.getElementById('camposIdentificacao');
            const infoAnonimato = document.getElementById('infoAnonimato');
            const nomeDenunciante = document.getElementById('nome_denunciante');
            const emailDenunciante = document.getElementById('email_denunciante');
            const telefoneDenunciante = document.getElementById('telefone_denunciante');
            const departamentoDenunciante = document.getElementById('departamento_denunciante');
            const anonimaRadio = document.getElementById('anonima');
            
            function toggleCamposIdentificacao() {
                // Verificar se os elementos existem antes de usar
                if (!anonimaRadio || !camposIdentificacao || !infoAnonimato) {
                    console.warn('Elementos de identificação não encontrados');
                    return;
                }
                
                const isAnonima = anonimaRadio.checked;
                
                if (isAnonima) {
                    // Denúncia anônima
                    if (camposIdentificacao) camposIdentificacao.style.display = 'none';
                    if (infoAnonimato) infoAnonimato.style.display = 'block';
                    
                    // Remover required dos campos (se existirem)
                    if (nomeDenunciante) nomeDenunciante.removeAttribute('required');
                    if (emailDenunciante) emailDenunciante.removeAttribute('required');
                    
                    // Limpar campos (se existirem)
                    if (nomeDenunciante) nomeDenunciante.value = '';
                    if (emailDenunciante) emailDenunciante.value = '';
                    if (telefoneDenunciante) telefoneDenunciante.value = '';
                    if (departamentoDenunciante) departamentoDenunciante.value = '';
                    
                } else {
                    // Denúncia identificada
                    if (camposIdentificacao) camposIdentificacao.style.display = 'block';
                    if (infoAnonimato) infoAnonimato.style.display = 'none';
                    
                    // Adicionar required aos campos obrigatórios (se existirem)
                    if (nomeDenunciante) nomeDenunciante.setAttribute('required', 'required');
                    if (emailDenunciante) emailDenunciante.setAttribute('required', 'required');
                }
            }
            
            // Adicionar event listeners aos radio buttons
            tipoDenunciaRadios.forEach(radio => {
                radio.addEventListener('change', toggleCamposIdentificacao);
            });
            
            // Executar na carga inicial (apenas se os elementos existirem)
            if (anonimaRadio) {
                toggleCamposIdentificacao();
            }
            
            // Inicializar funcionalidade de drag and drop
            initializeDragAndDrop();
        });
        
        // Função para inicializar drag and drop
        function initializeDragAndDrop() {
            const dropArea = document.getElementById('dropArea');
            const fileInput = document.getElementById('comprovativos');
            
            if (!dropArea || !fileInput) return;
            
            // Prevenir comportamento padrão do navegador
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });
            
            // Destacar área de drop
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });
            
            // Processar arquivos soltos
            dropArea.addEventListener('drop', handleDrop, false);
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            function highlight(e) {
                dropArea.classList.add('highlight');
            }
            
            function unhighlight(e) {
                dropArea.classList.remove('highlight');
            }
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                // Adicionar arquivos ao input
                const dataTransfer = new DataTransfer();
                Array.from(fileInput.files).forEach(file => dataTransfer.items.add(file));
                Array.from(files).forEach(file => dataTransfer.items.add(file));
                fileInput.files = dataTransfer.files;
                
                // Atualizar preview
                previewFiles(fileInput);
            }
        }
        
        // Função para mostrar loading state
        function showLoadingState(button) {
            button.classList.add('btn-loading');
            button.disabled = true;
            button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';
        }
        
        // Função para remover loading state
        function removeLoadingState(button, originalText) {
            button.classList.remove('btn-loading');
            button.disabled = false;
            button.innerHTML = originalText;
        }
        
        // Interceptar envio do formulário
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('denunciaForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const submitButton = form.querySelector('button[type="submit"]');
                    if (submitButton) {
                        const originalText = submitButton.innerHTML;
                        showLoadingState(submitButton);
                        
                        // Se a validação falhar, remover loading state
                        if (!validateStep(currentStep)) {
                            removeLoadingState(submitButton, originalText);
                            e.preventDefault();
                        }
                    }
                });
            }
        });
    </script>
</body>
</html> 