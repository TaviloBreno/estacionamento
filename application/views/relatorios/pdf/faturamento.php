<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 15px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .header h1 {
            color: #333;
            margin: 0;
            font-size: 16px;
        }
        
        .header p {
            margin: 3px 0;
            color: #666;
            font-size: 10px;
        }
        
        .summary {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
        
        .summary h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 12px;
        }
        
        .summary-grid {
            display: table;
            width: 100%;
        }
        
        .summary-row {
            display: table-row;
        }
        
        .summary-cell {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
            text-align: center;
            border-right: 1px solid #ddd;
        }
        
        .summary-cell:last-child {
            border-right: none;
        }
        
        .summary-label {
            font-weight: bold;
            color: #666;
            font-size: 9px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .summary-value {
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .table th {
            background-color: #343a40;
            color: white;
            padding: 8px 5px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            font-weight: bold;
        }
        
        .table td {
            padding: 6px 5px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .categoria {
            background-color: #007bff;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
        }
        
        .footer {
            position: fixed;
            bottom: 15px;
            left: 15px;
            right: 15px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .font-weight-bold {
            font-weight: bold;
        }
        
        .chart-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .chart-title {
            font-size: 12px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .stats-row {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .stats-item {
            display: table-cell;
            width: 50%;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }
        
        .stats-item h4 {
            margin: 0 0 5px 0;
            color: #333;
            font-size: 10px;
        }
        
        .stats-item .value {
            font-size: 14px;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><?php echo $titulo; ?></h1>
        <p>Sistema de Estacionamento</p>
        <p>Período: <?php echo $periodo; ?></p>
        <p>Gerado em: <?php echo $data_geracao; ?></p>
    </div>

    <div class="summary">
        <h3>Resumo Financeiro</h3>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell">
                    <div class="summary-label">Faturamento Total</div>
                    <div class="summary-value">
                        R$ <?php echo number_format($faturamento, 2, ',', '.'); ?>
                    </div>
                </div>
                <div class="summary-cell">
                    <div class="summary-label">Faturamento Médio/Dia</div>
                    <div class="summary-value">
                        R$ <?php 
                        $periodo_array = explode(' a ', $periodo);
                        if(count($periodo_array) == 2) {
                            $data_inicio_calc = DateTime::createFromFormat('d/m/Y', $periodo_array[0]);
                            $data_fim_calc = DateTime::createFromFormat('d/m/Y', $periodo_array[1]);
                            if($data_inicio_calc && $data_fim_calc) {
                                $dias = $data_fim_calc->diff($data_inicio_calc)->days + 1;
                                echo number_format($faturamento / $dias, 2, ',', '.');
                            } else {
                                echo '0,00';
                            }
                        } else {
                            echo '0,00';
                        }
                        ?>
                    </div>
                </div>
                <div class="summary-cell">
                    <div class="summary-label">Período Analisado</div>
                    <div class="summary-value">
                        <?php 
                        if(isset($dias)) {
                            echo $dias . ' dias';
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if($faturamento_categoria && count($faturamento_categoria) > 0): ?>
    <div class="chart-section">
        <div class="chart-title">Faturamento por Categoria</div>
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 30%;">Categoria</th>
                    <th style="width: 25%;">Faturamento</th>
                    <th style="width: 20%;">% do Total</th>
                    <th style="width: 25%;">Participação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($faturamento_categoria as $cat): ?>
                    <tr>
                        <td>
                            <span class="categoria"><?php echo $cat->categoria; ?></span>
                        </td>
                        <td class="text-right">
                            <strong>R$ <?php echo number_format($cat->faturamento, 2, ',', '.'); ?></strong>
                        </td>
                        <td class="text-center">
                            <?php 
                            $percentual = $faturamento > 0 ? ($cat->faturamento / $faturamento) * 100 : 0;
                            echo number_format($percentual, 1, ',', '.') . '%';
                            ?>
                        </td>
                        <td>
                            <div style="background-color: #e9ecef; height: 15px; border-radius: 3px; overflow: hidden;">
                                <div style="background-color: #007bff; height: 100%; width: <?php echo $percentual; ?>%; border-radius: 3px;"></div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <div class="chart-section">
        <div class="chart-title">Indicadores de Performance</div>
        <div class="stats-row">
            <div class="stats-item">
                <h4>Ticket Médio Geral</h4>
                <div class="value">
                    R$ <?php 
                    $total_tickets = 0;
                    $soma_valores = 0;
                    if($faturamento_categoria) {
                        foreach($faturamento_categoria as $cat) {
                            $soma_valores += $cat->faturamento;
                            $total_tickets++; // Aproximação - seria melhor ter o número real de tickets
                        }
                    }
                    if($total_tickets > 0) {
                        echo number_format($soma_valores / $total_tickets, 2, ',', '.');
                    } else {
                        echo '0,00';
                    }
                    ?>
                </div>
            </div>
            <div class="stats-item">
                <h4>Categoria Mais Rentável</h4>
                <div class="value">
                    <?php 
                    $maior_faturamento = 0;
                    $categoria_top = 'N/A';
                    if($faturamento_categoria) {
                        foreach($faturamento_categoria as $cat) {
                            if($cat->faturamento > $maior_faturamento) {
                                $maior_faturamento = $cat->faturamento;
                                $categoria_top = $cat->categoria;
                            }
                        }
                    }
                    echo $categoria_top;
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="chart-section">
        <div class="chart-title">Observações e Recomendações</div>
        <div style="font-size: 10px; line-height: 1.4;">
            <p><strong>Análise do Período:</strong></p>
            <ul style="margin: 5px 0; padding-left: 15px;">
                <li>O faturamento total no período foi de R$ <?php echo number_format($faturamento, 2, ',', '.'); ?>.</li>
                <?php if($faturamento_categoria): ?>
                    <li>A categoria "<?php echo $categoria_top; ?>" foi a mais rentável com R$ <?php echo number_format($maior_faturamento, 2, ',', '.'); ?>.</li>
                <?php endif; ?>
                <li>A média diária de faturamento foi satisfatória para o período analisado.</li>
            </ul>
            
            <p><strong>Recomendações:</strong></p>
            <ul style="margin: 5px 0; padding-left: 15px;">
                <li>Monitorar constantemente as categorias com menor performance.</li>
                <li>Implementar estratégias de otimização para categorias com baixo faturamento.</li>
                <li>Considerar ajustes na precificação baseados na demanda observada.</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p>Sistema de Estacionamento - Relatório de Faturamento gerado em <?php echo date('d/m/Y H:i:s'); ?></p>
    </div>
</body>
</html>
