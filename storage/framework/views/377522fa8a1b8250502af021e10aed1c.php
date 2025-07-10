<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório do Dashboard</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        h1, h2, h3 { color: #1a237e; margin-bottom: 0.5em; }
        .metrics { display: flex; flex-wrap: wrap; gap: 16px; margin-bottom: 24px; }
        .metric-card { background: #f5f5f5; border-radius: 8px; padding: 16px; min-width: 160px; box-shadow: 0 1px 2px #eee; }
        .metric-title { font-size: 13px; color: #555; }
        .metric-value { font-size: 22px; font-weight: bold; color: #1a237e; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        th, td { border: 1px solid #bbb; padding: 6px 8px; text-align: left; }
        th { background: #e3e6f3; }
        .alert { padding: 8px 12px; border-radius: 4px; margin-bottom: 8px; }
        .alert-danger { background: #ffebee; color: #b71c1c; }
        .alert-warning { background: #fffde7; color: #f57c00; }
        .alert-info { background: #e3f2fd; color: #1565c0; }
        .section { margin-bottom: 32px; }
        .chart-img { display: block; margin: 0 auto 16px auto; max-width: 400px; }
    </style>
</head>
<body>
    <h1>Relatório do Dashboard</h1>
    <p>Gerado em: <?php echo e(now()->format('d/m/Y H:i')); ?></p>

    <div class="section">
        <h2>Métricas Gerais</h2>
        <div class="metrics">
            <div class="metric-card">
                <div class="metric-title">Total de Denúncias</div>
                <div class="metric-value"><?php echo e($intelligentMetrics['total_denuncias'] ?? '-'); ?></div>
            </div>
            <div class="metric-card">
                <div class="metric-title">Denúncias Hoje</div>
                <div class="metric-value"><?php echo e($intelligentMetrics['denuncias_hoje'] ?? '-'); ?></div>
            </div>
            <div class="metric-card">
                <div class="metric-title">Urgentes</div>
                <div class="metric-value"><?php echo e($intelligentMetrics['denuncias_urgentes'] ?? '-'); ?></div>
            </div>
            <div class="metric-card">
                <div class="metric-title">Atrasadas</div>
                <div class="metric-value"><?php echo e($intelligentMetrics['denuncias_atrasadas'] ?? '-'); ?></div>
            </div>
            <div class="metric-card">
                <div class="metric-title">Taxa de Crescimento</div>
                <div class="metric-value"><?php echo e($intelligentMetrics['taxa_crescimento'] ?? '-'); ?>%</div>
            </div>
            <div class="metric-card">
                <div class="metric-title">Tempo Médio de Resolução</div>
                <div class="metric-value"><?php echo e($intelligentMetrics['tempo_medio_resolucao'] ?? '-'); ?> dias</div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Status das Denúncias</h2>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Quantidade</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $statusMetrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($status['status']); ?></td>
                    <td><?php echo e($status['count']); ?></td>
                    <td><?php echo e($status['percentage']); ?>%</td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Performance dos Responsáveis</h2>
        <table>
            <thead>
                <tr>
                    <th>Responsável</th>
                    <th>Ativas</th>
                    <th>Resolvidas</th>
                    <th>Taxa de Resolução</th>
                    <th>Carga de Trabalho</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $responsavelMetrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($resp['user']); ?></td>
                    <td><?php echo e($resp['denuncias_ativas']); ?></td>
                    <td><?php echo e($resp['denuncias_resolvidas']); ?></td>
                    <td><?php echo e($resp['taxa_resolucao']); ?>%</td>
                    <td><?php echo e($resp['carga_trabalho']['level']); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Alertas e Recomendações</h2>
        <?php $__currentLoopData = $alertsAndRecommendations['alerts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="alert alert-<?php echo e($alert['type']); ?>">
                <strong><i class="<?php echo e($alert['icon']); ?>"></i> <?php echo e($alert['message']); ?></strong>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $alertsAndRecommendations['recommendations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="alert alert-<?php echo e($rec['type']); ?>">
                <strong><i class="<?php echo e($rec['icon']); ?>"></i> <?php echo e($rec['message']); ?></strong>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="section">
        <h2>Tendência dos Últimos 30 Dias</h2>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Denúncias</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $trends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($trend['date']); ?></td>
                    <td><?php echo e($trend['count']); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <!-- Gráficos -->
    <?php if($incluirGraficos): ?>
    <div class="charts-section" style="margin-top: 30px;">
        <h3 style="color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; margin-bottom: 20px;">
            📊 Gráficos e Visualizações
        </h3>

        <!-- Gráfico de Status -->
        <?php if($statusChart): ?>
        <div class="chart-container" style="margin-bottom: 30px; text-align: center;">
            <h4 style="color: #34495e; margin-bottom: 15px;">Distribuição por Status</h4>
            <img src="<?php echo e($statusChart); ?>" alt="Gráfico de Status" style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 8px;">
        </div>
        <?php endif; ?>

        <!-- Gráfico de Tendências -->
        <?php if($trendsChart): ?>
        <div class="chart-container" style="margin-bottom: 30px; text-align: center;">
            <h4 style="color: #34495e; margin-bottom: 15px;">Tendência dos Últimos 30 Dias</h4>
            <img src="<?php echo e($trendsChart); ?>" alt="Gráfico de Tendências" style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 8px;">
        </div>
        <?php endif; ?>

        <!-- Gráfico de Responsáveis -->
        <?php if($responsavelChart): ?>
        <div class="chart-container" style="margin-bottom: 30px; text-align: center;">
            <h4 style="color: #34495e; margin-bottom: 15px;">Carga de Trabalho por Responsável</h4>
            <img src="<?php echo e($responsavelChart); ?>" alt="Gráfico de Responsáveis" style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 8px;">
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Tabelas Detalhadas -->
    <div class="tables-section" style="margin-top: 30px;">
        <h3 style="color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; margin-bottom: 20px;">
            📋 Tabelas Detalhadas
        </h3>

        <h4 style="color: #34495e; margin-bottom: 15px;">Status das Denúncias</h4>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Quantidade</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $statusMetrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($status['status']); ?></td>
                    <td><?php echo e($status['count']); ?></td>
                    <td><?php echo e($status['percentage']); ?>%</td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <h4 style="color: #34495e; margin-bottom: 15px;">Performance dos Responsáveis</h4>
        <table>
            <thead>
                <tr>
                    <th>Responsável</th>
                    <th>Ativas</th>
                    <th>Resolvidas</th>
                    <th>Taxa de Resolução</th>
                    <th>Carga de Trabalho</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $responsavelMetrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($resp['user']); ?></td>
                    <td><?php echo e($resp['denuncias_ativas']); ?></td>
                    <td><?php echo e($resp['denuncias_resolvidas']); ?></td>
                    <td><?php echo e($resp['taxa_resolucao']); ?>%</td>
                    <td><?php echo e($resp['carga_trabalho']['level']); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <footer style="margin-top: 32px; text-align: center; color: #888; font-size: 11px;">
        Relatório gerado automaticamente pelo Sistema de Denúncias - <?php echo e(now()->format('d/m/Y H:i')); ?>

    </footer>
</body>
</html> <?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/dashboard/pdf.blade.php ENDPATH**/ ?>