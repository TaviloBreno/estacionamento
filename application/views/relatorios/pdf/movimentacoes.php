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
            width: 25%;
            padding: 8px;
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
        }
        
        .summary-value {
            font-size: 14px;
            font-weight: bold;
            color: #007bff;
            margin-top: 3px;
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
        
        .status-finalizado {
            background-color: #28a745;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
        }
        
        .status-andamento {
            background-color: #ffc107;
            color: #333;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
        }
        
        .categoria {
            background-color: #6c757d;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
        }
        
        .pagamento {
            background-color: #17a2b8;
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
        <h3>Resumo do Período</h3>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell">
                    <div class="summary-label">Total Movimentações</div>
                    <div class="summary-value"><?php echo count($movimentacoes); ?></div>
                </div>
                <div class="summary-cell">
                    <div class="summary-label">Finalizadas</div>
                    <div class="summary-value">
                        <?php 
                        $finalizadas = 0;
                        foreach($movimentacoes as $mov) {
                            if($mov->estacionar_status == 1) $finalizadas++;
                        }
                        echo $finalizadas;
                        ?>
                    </div>
                </div>
                <div class="summary-cell">
                    <div class="summary-label">Em Andamento</div>
                    <div class="summary-value">
                        <?php 
                        $andamento = 0;
                        foreach($movimentacoes as $mov) {
                            if($mov->estacionar_status == 0) $andamento++;
                        }
                        echo $andamento;
                        ?>
                    </div>
                </div>
                <div class="summary-cell">
                    <div class="summary-label">Faturamento</div>
                    <div class="summary-value">
                        R$ <?php 
                        $total_faturamento = 0;
                        foreach($movimentacoes as $mov) {
                            if($mov->estacionar_status == 1) {
                                $total_faturamento += $mov->estacionar_valor_final;
                            }
                        }
                        echo number_format($total_faturamento, 2, ',', '.');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 8%;">Ticket</th>
                <th style="width: 20%;">Cliente</th>
                <th style="width: 15%;">Veículo</th>
                <th style="width: 12%;">Categoria</th>
                <th style="width: 12%;">Entrada</th>
                <th style="width: 12%;">Saída</th>
                <th style="width: 10%;">Valor</th>
                <th style="width: 11%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if($movimentacoes): ?>
                <?php foreach($movimentacoes as $mov): ?>
                    <tr>
                        <td class="text-center font-weight-bold">
                            <?php echo str_pad($mov->estacionar_id, 6, '0', STR_PAD_LEFT); ?>
                        </td>
                        <td><?php echo $mov->estacionar_cliente_nome; ?></td>
                        <td>
                            <div style="font-size: 9px; color: #666;"><?php echo $mov->estacionar_veiculo_modelo; ?></div>
                            <div class="font-weight-bold"><?php echo $mov->estacionar_veiculo_placa; ?></div>
                        </td>
                        <td>
                            <span class="categoria"><?php echo $mov->precificacao_categoria; ?></span>
                        </td>
                        <td class="text-center">
                            <div style="font-size: 9px;"><?php echo date('d/m/Y', strtotime($mov->estacionar_data_entrada)); ?></div>
                            <div class="font-weight-bold"><?php echo date('H:i', strtotime($mov->estacionar_data_entrada)); ?></div>
                        </td>
                        <td class="text-center">
                            <?php if($mov->estacionar_data_saida): ?>
                                <div style="font-size: 9px;"><?php echo date('d/m/Y', strtotime($mov->estacionar_data_saida)); ?></div>
                                <div class="font-weight-bold"><?php echo date('H:i', strtotime($mov->estacionar_data_saida)); ?></div>
                            <?php else: ?>
                                <span style="color: #999;">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-right">
                            <?php if($mov->estacionar_valor_final > 0): ?>
                                <strong>R$ <?php echo number_format($mov->estacionar_valor_final, 2, ',', '.'); ?></strong>
                            <?php else: ?>
                                <span style="color: #999;">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if($mov->estacionar_status == 1): ?>
                                <span class="status-finalizado">Finalizado</span>
                            <?php else: ?>
                                <span class="status-andamento">Em Andamento</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center" style="color: #999; padding: 20px;">
                        Nenhuma movimentação encontrada no período selecionado.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Sistema de Estacionamento - Relatório de Movimentações gerado em <?php echo date('d/m/Y H:i:s'); ?></p>
    </div>
</body>
</html>
