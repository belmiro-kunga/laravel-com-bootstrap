@php
    use App\Helpers\ConfigHelper;
    $siteName = ConfigHelper::get('site_name', 'Sistema de Denúncias Corporativas');
    $pdfTitle = ConfigHelper::get('pdf_report_title', 'Relatório de Denúncia');
    $pdfFooter = ConfigHelper::get('pdf_report_footer', 'Confidencial - Uso interno');
    $primaryColor = ConfigHelper::get('pdf_report_primary_color', '#4361ee');
    $showTimeline = ConfigHelper::getBool('pdf_report_show_timeline', true);
    $showComments = ConfigHelper::getBool('pdf_report_show_comments', true);
    $showEvidences = ConfigHelper::getBool('pdf_report_show_evidences', true);
    $showPeople = ConfigHelper::getBool('pdf_report_show_people', true);
    $sectionsOrder = ConfigHelper::getJson('pdf_report_sections_order', ['info','description','people','timeline','comments','evidences']);
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $pdfTitle }} - {{ $denuncia->protocolo }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #222; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 18px; }
        .header h1 { color: {{ $primaryColor }}; font-size: 26px; margin-bottom: 2px; }
        .header .subtitle { font-size: 15px; color: #555; margin-bottom: 2px; }
        .header .generated { font-size: 12px; color: #888; margin-bottom: 10px; }
        .protocolo-box { background: #f4f7ff; border: 1px solid {{ $primaryColor }}; border-radius: 8px; padding: 12px 0; text-align: center; margin-bottom: 18px; }
        .protocolo-box .protocolo { font-size: 22px; font-weight: bold; color: {{ $primaryColor }}; }
        .status-table { width: 100%; margin-bottom: 18px; border-collapse: collapse; }
        .status-table td { padding: 6px 8px; font-size: 14px; }
        .status-label { font-weight: bold; color: #555; }
        .status-value { font-weight: bold; color: #fff; background: {{ $primaryColor }}; border-radius: 4px; padding: 2px 10px; }
        .section-title { background: #6c7ae0; color: #fff; font-weight: bold; padding: 6px 10px; border-radius: 6px; margin-top: 18px; margin-bottom: 8px; font-size: 15px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .info-table td { padding: 5px 8px; font-size: 14px; }
        .info-label { font-weight: bold; color: #333; width: 160px; }
        .desc-box { background: #f8f9fa; border-radius: 6px; padding: 10px; margin-bottom: 10px; }
        .people-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .people-table td { padding: 5px 8px; font-size: 14px; }
        .timeline { margin: 12px 0 18px 0; }
        .timeline-step { margin-bottom: 8px; }
        .timeline-step .step-title { font-weight: bold; }
        .timeline-step .step-status { font-size: 12px; color: #888; margin-left: 8px; }
        .comments-section, .evidence-section { margin-bottom: 18px; }
        .comment-box, .evidence-box { border: 1px solid #e0e0e0; border-radius: 6px; padding: 8px 10px; margin-bottom: 6px; background: #fafbff; }
        .comment-author { font-weight: bold; color: {{ $primaryColor }}; }
        .comment-date { font-size: 12px; color: #888; margin-left: 6px; }
        .evidence-title { font-weight: bold; color: #222; }
        .evidence-meta { font-size: 12px; color: #a33; margin-bottom: 2px; }
        .footer { text-align: center; color: #888; font-size: 12px; margin-top: 30px; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $siteName }}</h1>
        <div class="subtitle">{{ $pdfTitle }}</div>
        <div class="generated">Gerado em: {{ now()->format('d/m/Y H:i:s') }}</div>
    </div>
    <div class="protocolo-box">
        <div class="protocolo">{{ $denuncia->protocolo }}</div>
    </div>
    @foreach($sectionsOrder as $section)
        @if($section === 'info')
            <table class="status-table">
                <tr>
                    <td class="status-label">Status Atual:</td>
                    <td class="status-value" style="background: {{ $denuncia->status->cor ?? $primaryColor }};">{{ $denuncia->status->nome ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="status-label">Data de Criação:</td>
                    <td>{{ $denuncia->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td class="status-label">Última Atualização:</td>
                    <td>{{ $denuncia->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
            <div class="section-title">Informações da Denúncia</div>
            <table class="info-table">
                <tr><td class="info-label">Título:</td><td>{{ $denuncia->titulo }}</td></tr>
                <tr><td class="info-label">Categoria:</td><td>{{ $denuncia->categoria->nome ?? '-' }}</td></tr>
                <tr><td class="info-label">Prioridade:</td><td>{{ ucfirst($denuncia->prioridade) }}</td></tr>
                <tr><td class="info-label">Local da Ocorrência:</td><td>{{ $denuncia->local_ocorrencia ?? '-' }}</td></tr>
                <tr><td class="info-label">Data da Ocorrência:</td><td>{{ $denuncia->data_ocorrencia ? $denuncia->data_ocorrencia->format('d/m/Y') : '-' }}</td></tr>
                <tr><td class="info-label">Hora da Ocorrência:</td><td>{{ $denuncia->hora_ocorrencia ?? 'Não informada' }}</td></tr>
            </table>
        @elseif($section === 'description')
            <div class="section-title">Descrição da Ocorrência</div>
            <div class="desc-box">{{ $denuncia->descricao }}</div>
        @elseif($section === 'people' && $showPeople)
            <div class="section-title">Pessoas Envolvidas</div>
            <table class="people-table">
                <tr><td class="info-label">Envolvidos:</td><td>{{ $denuncia->envolvidos ?? '-' }}</td></tr>
                <tr><td class="info-label">Testemunhas:</td><td>{{ $denuncia->testemunhas ?? '-' }}</td></tr>
            </table>
        @elseif($section === 'timeline' && $showTimeline)
            <div class="section-title">Timeline de Status</div>
            <div class="timeline">
                @php
                    $historico = $denuncia->historicoStatus()->orderBy('created_at')->get();
                @endphp
                @if($historico->count())
                    @foreach($historico as $item)
                        <div class="timeline-step">
                            <span class="step-title">{{ $item->statusNovo->nome ?? '-' }}</span>
                            <span class="step-status">({{ $item->created_at->format('d/m/Y H:i') }})</span>
                            @if($item->comentario)
                                <div style="font-size:12px;color:#555;margin-left:10px;">{{ $item->comentario }}</div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="timeline-step">Nenhum histórico de status registrado.</div>
                @endif
            </div>
        @elseif($section === 'comments' && $showComments)
            <div class="section-title">Comentários e Atualizações</div>
            <div class="comments-section">
                @if($denuncia->comentarios && $denuncia->comentarios->count())
                    @foreach($denuncia->comentarios as $comentario)
                        <div class="comment-box">
                            <span class="comment-author">{{ $comentario->user->name ?? 'Anônimo' }}</span>
                            <span class="comment-date">({{ $comentario->created_at->format('d/m/Y H:i') }})</span><br>
                            {{ $comentario->comentario }}
                        </div>
                    @endforeach
                @else
                    <div class="comment-box">Nenhum comentário registrado.</div>
                @endif
            </div>
        @elseif($section === 'evidences' && $showEvidences)
            <div class="section-title">Evidências Anexadas</div>
            <div class="evidence-section">
                @if($denuncia->evidencias && $denuncia->evidencias->count())
                    @foreach($denuncia->evidencias as $evidencia)
                        <div class="evidence-box">
                            <div class="evidence-title">{{ $evidencia->nome_arquivo ?? $evidencia->nome_original }}</div>
                            <div class="evidence-meta">Tamanho: {{ $evidencia->tamanho_formatado ?? '-' }} | Tipo: {{ $evidencia->tipo_mime ?? '-' }} | {{ $evidencia->publico ? 'Público' : 'Confidencial' }}</div>
                            <div>{{ $evidencia->descricao ?? 'Comprovativo enviado pelo denunciante' }}</div>
                        </div>
                    @endforeach
                @else
                    <div class="evidence-box">Nenhuma evidência anexada.</div>
                @endif
            </div>
        @endif
    @endforeach
    <div class="footer">
        <div><strong>{{ $siteName }}</strong></div>
        <div>Este documento foi gerado automaticamente pelo sistema</div>
        <div>{{ $pdfFooter }}</div>
    </div>
</body>
</html> 