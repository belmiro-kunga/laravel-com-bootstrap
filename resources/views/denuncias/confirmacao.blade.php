<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denúncia Enviada - Sistema de Denúncias</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .confirmation-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .confirmation-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }
        
        .confirmation-body {
            padding: 2rem;
        }
        
        .protocol-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            margin: 1.5rem 0;
        }
        
        .protocol-number {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
            letter-spacing: 2px;
        }
        
        .btn {
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .success-icon {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 1rem;
        }
        
        .info-card {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            border-radius: 10px;
            padding: 1rem;
            margin: 1rem 0;
        }
        
        .warning-card {
            background: #fff3e0;
            border-left: 4px solid #ff9800;
            border-radius: 10px;
            padding: 1rem;
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="confirmation-container">
                    <!-- Header -->
                    <div class="confirmation-header">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2>Denúncia Enviada com Sucesso!</h2>
                        <p class="mb-0">Sua denúncia foi recebida e está sendo processada</p>
                    </div>
                    
                    <!-- Body -->
                    <div class="confirmation-body">
                        <!-- Protocolo -->
                        <div class="protocol-card">
                            <h5>Número do Protocolo</h5>
                            <div class="protocol-number">{{ $denuncia->protocolo }}</div>
                            <small class="text-muted">Guarde este número para acompanhamento</small>
                        </div>
                        
                        <!-- Informações da Denúncia -->
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Categoria:</strong>
                                <p>{{ $denuncia->categoria->nome }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Prioridade:</strong>
                                <p>{{ ucfirst($denuncia->prioridade) }}</p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <strong>Título:</strong>
                                <p>{{ $denuncia->titulo }}</p>
                            </div>
                        </div>
                        
                        <!-- Tipo de Denúncia -->
                        <div class="row">
                            <div class="col-12">
                                <strong>Tipo de Denúncia:</strong>
                                @if($denuncia->is_anonima)
                                    <p>
                                        <span class="badge bg-warning">
                                            <i class="fas fa-user-secret"></i> Anônima
                                        </span>
                                        <small class="text-muted d-block mt-1">
                                            Sua identidade não foi fornecida. Use o protocolo para acompanhar o andamento.
                                        </small>
                                    </p>
                                @else
                                    <p>
                                        <span class="badge bg-info">
                                            <i class="fas fa-user"></i> Identificada
                                        </span>
                                        <small class="text-muted d-block mt-1">
                                            Entraremos em contato através de: {{ $denuncia->email_denunciante }}
                                        </small>
                                    </p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Comprovativos Enviados -->
                        @if($denuncia->evidencias->count() > 0)
                        <div class="card mt-3">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-file-upload"></i> Comprovativos Enviados
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($denuncia->evidencias as $evidencia)
                                    <div class="col-md-6 mb-2">
                                        <div class="d-flex align-items-center p-2 border rounded">
                                            <i class="fas fa-file me-2 text-primary"></i>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold">{{ $evidencia->nome_original }}</div>
                                                <small class="text-muted">{{ $evidencia->tamanho_formatado }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> 
                                    {{ $denuncia->evidencias->count() }} comprovativo(s) anexado(s) com sucesso
                                </small>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Cards Informativos -->
                        <div class="info-card">
                            <h6><i class="fas fa-info-circle"></i> O que acontece agora?</h6>
                            <ul class="mb-0">
                                <li>Sua denúncia será analisada pela equipe responsável</li>
                                <li>Um responsável será designado para investigar o caso</li>
                                @if($denuncia->is_anonima)
                                    <li>Você pode acompanhar o andamento usando o número de protocolo</li>
                                @else
                                    <li>Você receberá atualizações sobre o andamento por email</li>
                                @endif
                            </ul>
                        </div>
                        
                        <div class="warning-card">
                            <h6><i class="fas fa-shield-alt"></i> Confidencialidade</h6>
                            <p class="mb-0">
                                @if($denuncia->is_anonima)
                                    Sua identidade não foi fornecida, garantindo total anonimato. 
                                    Apenas o número de protocolo permite o acompanhamento.
                                @else
                                    Sua identidade será mantida em sigilo. Apenas a equipe autorizada 
                                    terá acesso às informações da denúncia.
                                @endif
                            </p>
                        </div>
                        
                        <!-- Ações -->
                        <div class="text-center mt-4">
                            <a href="{{ route('rastreamento.publico') }}?protocolo={{ $denuncia->protocolo }}" class="btn btn-success btn-lg me-2 mb-2">
                                <i class="fas fa-search"></i> Rastrear Minha Denúncia
                            </a>
                            <br>
                            <a href="{{ route('denuncias.formulario-publico') }}" class="btn btn-primary me-2">
                                <i class="fas fa-plus"></i> Nova Denúncia
                            </a>
                            <a href="{{ route('rastreamento.publico.download', $denuncia->protocolo) }}" class="btn btn-warning btn-lg me-2 mb-2">
                                <i class="fas fa-download"></i> Download do Relatório
                            </a>
                        </div>
                        
                        <!-- Informações Adicionais -->
                        <div class="mt-4 text-center">
                            <small class="text-muted">
                                <i class="fas fa-clock"></i> 
                                Denúncia enviada em {{ $denuncia->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="text-center mt-4">
                    <p class="text-white mb-0">
                        <i class="fas fa-lock"></i> Sistema seguro e confidencial
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-print quando a página carrega (opcional)
        // window.onload = function() {
        //     window.print();
        // };
        
        // Copiar protocolo para clipboard
        function copyProtocol() {
            navigator.clipboard.writeText('{{ $denuncia->protocolo }}').then(function() {
                alert('Protocolo copiado para a área de transferência!');
            });
        }
    </script>
</body>
</html> 