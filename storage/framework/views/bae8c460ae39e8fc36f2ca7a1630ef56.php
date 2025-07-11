<?php
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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo e($pdfTitle); ?> - <?php echo e($denuncia->protocolo); ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #222; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 18px; }
        .header h1 { color: <?php echo e($primaryColor); ?>; font-size: 26px; margin-bottom: 2px; }
        .header .subtitle { font-size: 15px; color: #555; margin-bottom: 2px; }
        .header .generated { font-size: 12px; color: #888; margin-bottom: 10px; }
        .protocolo-box { background: #f4f7ff; border: 1px solid <?php echo e($primaryColor); ?>; border-radius: 8px; padding: 12px 0; text-align: center; margin-bottom: 18px; }
        .protocolo-box .protocolo { font-size: 22px; font-weight: bold; color: <?php echo e($primaryColor); ?>; }
        .status-table { width: 100%; margin-bottom: 18px; border-collapse: collapse; }
        .status-table td { padding: 6px 8px; font-size: 14px; }
        .status-label { font-weight: bold; color: #555; }
        .status-value { font-weight: bold; color: #fff; background: <?php echo e($primaryColor); ?>; border-radius: 4px; padding: 2px 10px; }
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
        .comment-author { font-weight: bold; color: <?php echo e($primaryColor); ?>; }
        .comment-date { font-size: 12px; color: #888; margin-left: 6px; }
        .evidence-title { font-weight: bold; color: #222; }
        .evidence-meta { font-size: 12px; color: #a33; margin-bottom: 2px; }
        .footer { text-align: center; color: #888; font-size: 12px; margin-top: 30px; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1><?php echo e($siteName); ?></h1>
        <div class="subtitle"><?php echo e($pdfTitle); ?></div>
        <div class="generated">Gerado em: <?php echo e(now()->format('d/m/Y H:i:s')); ?></div>
    </div>
    <div class="protocolo-box">
        <div class="protocolo"><?php echo e($denuncia->protocolo); ?></div>
    </div>
    <?php $__currentLoopData = $sectionsOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($section === 'info'): ?>
            <table class="status-table">
                <tr>
                    <td class="status-label">Status Atual:</td>
                    <td class="status-value" style="background: <?php echo e($denuncia->status->cor ?? $primaryColor); ?>;"><?php echo e($denuncia->status->nome ?? '-'); ?></td>
                </tr>
                <tr>
                    <td class="status-label">Data de Criação:</td>
                    <td><?php echo e($denuncia->created_at->format('d/m/Y H:i')); ?></td>
                </tr>
                <tr>
                    <td class="status-label">Última Atualização:</td>
                    <td><?php echo e($denuncia->updated_at->format('d/m/Y H:i')); ?></td>
                </tr>
            </table>
            <div class="section-title">Informações da Denúncia</div>
            <table class="info-table">
                <tr><td class="info-label">Título:</td><td><?php echo e($denuncia->titulo); ?></td></tr>
                <tr><td class="info-label">Categoria:</td><td><?php echo e($denuncia->categoria->nome ?? '-'); ?></td></tr>
                <tr><td class="info-label">Prioridade:</td><td><?php echo e(ucfirst($denuncia->prioridade)); ?></td></tr>
                <tr><td class="info-label">Local da Ocorrência:</td><td><?php echo e($denuncia->local_ocorrencia ?? '-'); ?></td></tr>
                <tr><td class="info-label">Data da Ocorrência:</td><td><?php echo e($denuncia->data_ocorrencia ? $denuncia->data_ocorrencia->format('d/m/Y') : '-'); ?></td></tr>
                <tr><td class="info-label">Hora da Ocorrência:</td><td><?php echo e($denuncia->hora_ocorrencia ?? 'Não informada'); ?></td></tr>
            </table>
        <?php elseif($section === 'description'): ?>
            <div class="section-title">Descrição da Ocorrência</div>
            <div class="desc-box"><?php echo e($denuncia->descricao); ?></div>
        <?php elseif($section === 'people' && $showPeople): ?>
            <div class="section-title">Pessoas Envolvidas</div>
            <table class="people-table">
                <tr><td class="info-label">Envolvidos:</td><td><?php echo e($denuncia->envolvidos ?? '-'); ?></td></tr>
                <tr><td class="info-label">Testemunhas:</td><td><?php echo e($denuncia->testemunhas ?? '-'); ?></td></tr>
            </table>
        <?php elseif($section === 'timeline' && $showTimeline): ?>
            <div class="section-title">Timeline de Status</div>
            <div class="timeline">
                <?php
                    $historico = $denuncia->historicoStatus()->orderBy('created_at')->get();
                ?>
                <?php if($historico->count()): ?>
                    <?php $__currentLoopData = $historico; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="timeline-step">
                            <span class="step-title"><?php echo e($item->statusNovo->nome ?? '-'); ?></span>
                            <span class="step-status">(<?php echo e($item->created_at->format('d/m/Y H:i')); ?>)</span>
                            <?php if($item->comentario): ?>
                                <div style="font-size:12px;color:#555;margin-left:10px;"><?php echo e($item->comentario); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="timeline-step">Nenhum histórico de status registrado.</div>
                <?php endif; ?>
            </div>
        <?php elseif($section === 'comments' && $showComments): ?>
            <div class="section-title">Comentários e Atualizações</div>
            <div class="comments-section">
                <?php if($denuncia->comentarios && $denuncia->comentarios->count()): ?>
                    <?php $__currentLoopData = $denuncia->comentarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comentario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="comment-box">
                            <span class="comment-author"><?php echo e($comentario->user->name ?? 'Anônimo'); ?></span>
                            <span class="comment-date">(<?php echo e($comentario->created_at->format('d/m/Y H:i')); ?>)</span><br>
                            <?php echo e($comentario->comentario); ?>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="comment-box">Nenhum comentário registrado.</div>
                <?php endif; ?>
            </div>
        <?php elseif($section === 'evidences' && $showEvidences): ?>
            <div class="section-title">Evidências Anexadas</div>
            <div class="evidence-section">
                <?php if($denuncia->evidencias && $denuncia->evidencias->count()): ?>
                    <?php $__currentLoopData = $denuncia->evidencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evidencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="evidence-box">
                            <div class="evidence-title"><?php echo e($evidencia->nome_arquivo ?? $evidencia->nome_original); ?></div>
                            <div class="evidence-meta">Tamanho: <?php echo e($evidencia->tamanho_formatado ?? '-'); ?> | Tipo: <?php echo e($evidencia->tipo_mime ?? '-'); ?> | <?php echo e($evidencia->publico ? 'Público' : 'Confidencial'); ?></div>
                            <div><?php echo e($evidencia->descricao ?? 'Comprovativo enviado pelo denunciante'); ?></div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="evidence-box">Nenhuma evidência anexada.</div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <div class="footer">
        <div><strong><?php echo e($siteName); ?></strong></div>
        <div>Este documento foi gerado automaticamente pelo sistema</div>
        <div><?php echo e($pdfFooter); ?></div>
    </div>
</body>
</html> <?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/rastreamento/pdf-publico.blade.php ENDPATH**/ ?>