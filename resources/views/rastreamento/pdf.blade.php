<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denúncia {{ $denuncia->protocolo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #667eea;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #667eea;
            margin: 0;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .protocol-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .protocol-number {
            font-size: 18px;
            font-weight: bold;
            color: #667eea;
            text-align: center;
            margin-bottom: 10px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            width: 30%;
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        
        .info-value {
            display: table-cell;
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        
        .status-badge {
            background: {{ $denuncia->status->cor }};
            color: white;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            background: #667eea;
            color: white;
            padding: 8px 12px;
            font-weight: bold;
            border-radius: 3px;
            margin-bottom: 10px;
        }
        
        .timeline {
            margin: 15px 0;
        }
        
        .timeline-item {
            margin-bottom: 15px;
            padding-left: 20px;
            position: relative;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 5px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: {{ $denuncia->status->ordem >= 1 ? '#28a745' : '#6c757d' }};
        }
        
        .timeline-item:nth-child(2)::before {
            background: {{ $denuncia->status->ordem >= 2 ? '#28a745' : '#6c757d' }};
        }
        
        .timeline-item:nth-child(3)::before {
            background: {{ $denuncia->status->ordem >= 3 ? '#28a745' : '#6c757d' }};
        }
        
        .timeline-item:nth-child(4)::before {
            background: {{ $denuncia->status->ordem >= 4 ? '#28a745' : '#6c757d' }};
        }
        
        .timeline-item:nth-child(5)::before {
            background: {{ $denuncia->status->ordem >= 5 ? '#28a745' : '#6c757d' }};
        }
        
        .timeline-title {
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .timeline-status {
            font-size: 10px;
            color: #666;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .urgent-badge {
            background: #dc3545;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .priority-badge {
            background: {{ $denuncia->prioridade == 'alta' ? '#dc3545' : ($denuncia->prioridade == 'media' ? '#ffc107' : '#17a2b8') }};
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <div class="header">
        <h1>Sistema de Denúncias Corporativas</h1>
        <p>Relatório de Denúncia</p>
        <p>Gerado em: {{ date('d/m/Y H:i:s') }}</p>
    </div>
    
    <!-- Informações do Protocolo -->
    <div class="protocol-info">
        <div class="protocol-number">{{ $denuncia->protocolo }}</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Status Atual:</div>
                <div class="info-value">
                    <span class="status-badge">{{ $denuncia->status->nome }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Data de Criação:</div>
                <div class="info-value">{{ $denuncia->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Última Atualização:</div>
                <div class="info-value">{{ $denuncia->updated_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>
    
    <!-- Informações da Denúncia -->
    <div class="section">
        <div class="section-title">Informações da Denúncia</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Título:</div>
                <div class="info-value">{{ $denuncia->titulo }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Categoria:</div>
                <div class="info-value">{{ $denuncia->categoria->nome }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Prioridade:</div>
                <div class="info-value">
                    <span class="priority-badge">{{ ucfirst($denuncia->prioridade) }}</span>
                    @if($denuncia->urgente)
                        <span class="urgent-badge">URGENTE</span>
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Local da Ocorrência:</div>
                <div class="info-value">{{ $denuncia->local_ocorrencia ?? 'Não informado' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Data da Ocorrência:</div>
                <div class="info-value">{{ $denuncia->data_ocorrencia ? \Carbon\Carbon::parse($denuncia->data_ocorrencia)->format('d/m/Y') : 'Não informada' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Hora da Ocorrência:</div>
                <div class="info-value">{{ $denuncia->hora_ocorrencia ?? 'Não informada' }}</div>
            </div>
        </div>
    </div>
    
    <!-- Descrição -->
    <div class="section">
        <div class="section-title">Descrição da Ocorrência</div>
        <p style="text-align: justify; margin: 10px 0;">{{ $denuncia->descricao }}</p>
    </div>
    
    <!-- Envolvidos e Testemunhas -->
    @if($denuncia->envolvidos || $denuncia->testemunhas)
    <div class="section">
        <div class="section-title">Pessoas Envolvidas</div>
        @if($denuncia->envolvidos)
        <div style="margin-bottom: 10px;">
            <strong>Envolvidos:</strong><br>
            {{ $denuncia->envolvidos }}
        </div>
        @endif
        @if($denuncia->testemunhas)
        <div>
            <strong>Testemunhas:</strong><br>
            {{ $denuncia->testemunhas }}
        </div>
        @endif
    </div>
    @endif
    
    <!-- Responsável -->
    @if($denuncia->responsavel)
    <div class="section">
        <div class="section-title">Responsável</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nome:</div>
                <div class="info-value">{{ $denuncia->responsavel->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">E-mail:</div>
                <div class="info-value">{{ $denuncia->responsavel->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Função:</div>
                <div class="info-value">{{ ucfirst($denuncia->responsavel->role) }}</div>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Timeline de Status -->
    <div class="section">
        <div class="section-title">Timeline de Status</div>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-title">1. Denúncia Recebida</div>
                <div class="timeline-status">
                    @if($denuncia->status->ordem >= 1)
                        ✅ Concluído em {{ $denuncia->created_at->format('d/m/Y H:i') }}
                    @else
                        ⏳ Pendente
                    @endif
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-title">2. Em Análise</div>
                <div class="timeline-status">
                    @if($denuncia->status->ordem >= 2)
                        ✅ Concluído
                    @else
                        ⏳ Pendente
                    @endif
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-title">3. Em Investigação</div>
                <div class="timeline-status">
                    @if($denuncia->status->ordem >= 3)
                        ✅ Concluído
                    @else
                        ⏳ Pendente
                    @endif
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-title">4. Aguardando Decisão</div>
                <div class="timeline-status">
                    @if($denuncia->status->ordem >= 4)
                        ✅ Concluído
                    @else
                        ⏳ Pendente
                    @endif
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-title">5. Concluída</div>
                <div class="timeline-status">
                    @if($denuncia->status->ordem >= 5)
                        ✅ Concluído
                    @else
                        ⏳ Pendente
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Comentários -->
    @if($denuncia->comentarios->count() > 0)
    <div class="section">
        <div class="section-title">Comentários e Atualizações</div>
        @foreach($denuncia->comentarios->sortBy('created_at') as $comentario)
        <div style="margin-bottom: 15px; padding: 10px; border: 1px solid #dee2e6; border-radius: 3px;">
            <div style="font-weight: bold; margin-bottom: 5px;">
                {{ $comentario->user->name }} 
                <span style="font-size: 10px; color: #666; font-weight: normal;">
                    ({{ $comentario->created_at->format('d/m/Y H:i') }})
                </span>
                @if($comentario->importante)
                    <span style="background: #ffc107; color: #000; padding: 1px 4px; border-radius: 2px; font-size: 9px;">IMPORTANTE</span>
                @endif
            </div>
            <div>{{ $comentario->comentario }}</div>
        </div>
        @endforeach
    </div>
    @endif
    
    <!-- Evidências -->
    @if($denuncia->evidencias->count() > 0)
    <div class="section">
        <div class="section-title">Evidências Anexadas</div>
        @foreach($denuncia->evidencias as $evidencia)
        <div style="margin-bottom: 10px; padding: 8px; border: 1px solid #dee2e6; border-radius: 3px;">
            <div style="font-weight: bold;">{{ $evidencia->nome_original }}</div>
            <div style="font-size: 10px; color: #666;">
                Tamanho: {{ number_format($evidencia->tamanho / 1024, 2) }} KB | 
                Tipo: {{ $evidencia->tipo_mime }}
                @if($evidencia->publico)
                    | <span style="color: #28a745;">Público</span>
                @else
                    | <span style="color: #dc3545;">Confidencial</span>
                @endif
            </div>
            @if($evidencia->descricao)
            <div style="margin-top: 5px; font-size: 11px;">{{ $evidencia->descricao }}</div>
            @endif
        </div>
        @endforeach
    </div>
    @endif
    
    <!-- Informações do Denunciante -->
    @if($denuncia->nome_denunciante || $denuncia->email_denunciante)
    <div class="section">
        <div class="section-title">Informações do Denunciante</div>
        <div class="info-grid">
            @if($denuncia->nome_denunciante)
            <div class="info-row">
                <div class="info-label">Nome:</div>
                <div class="info-value">{{ $denuncia->nome_denunciante }}</div>
            </div>
            @endif
            @if($denuncia->email_denunciante)
            <div class="info-row">
                <div class="info-label">E-mail:</div>
                <div class="info-value">{{ $denuncia->email_denunciante }}</div>
            </div>
            @endif
            @if($denuncia->telefone_denunciante)
            <div class="info-row">
                <div class="info-label">Telefone:</div>
                <div class="info-value">{{ $denuncia->telefone_denunciante }}</div>
            </div>
            @endif
            @if($denuncia->departamento_denunciante)
            <div class="info-row">
                <div class="info-label">Departamento:</div>
                <div class="info-value">{{ $denuncia->departamento_denunciante }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif
    
    <!-- Rodapé -->
    <div class="footer">
        <p><strong>Sistema de Denúncias Corporativas</strong></p>
        <p>Este documento foi gerado automaticamente pelo sistema</p>
        <p>Confidencial - Uso interno</p>
    </div>
</body>
</html> 