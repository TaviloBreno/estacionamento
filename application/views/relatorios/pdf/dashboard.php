<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .header h1 {
            color: #333;
            margin: 0;
            font-size: 18px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .stats-row {
            display: table-row;
        }
        
        .stats-cell {
            display: table-cell;
            width: 25%;
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }
        
        .stats-label {
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            font-size: 10px;
            margin-bottom: 5px;
        }
        
        .stats-value {
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-cell {
            display: table-cell;
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        
        .info-label {
            font-weight: bold;
            width: 30%;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><?php echo $titulo; ?></h1>
        <p>Sistema de Estacionamento</p>
        <p>Gerado em: <?php echo $data_geracao; ?></p>
    </div>

    <div class="section">
        <div class="section-title">Estatísticas Gerais</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell">
                    <div class="stats-label">Total de Vagas</div>
                    <div class="stats-value"><?php echo isset($stats['total_vagas']) ? $stats['total_vagas'] : 0; ?></div>
                </div>
                <div class="stats-cell">
                    <div class="stats-label">Vagas Ocupadas</div>
                    <div class="stats-value"><?php echo isset($stats['vagas_ocupadas']) ? $stats['vagas_ocupadas'] : 0; ?></div>
                </div>
                <div class="stats-cell">
                    <div class="stats-label">Taxa de Ocupação</div>
                    <div class="stats-value"><?php echo isset($stats['taxa_ocupacao']) ? $stats['taxa_ocupacao'] : 0; ?>%</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-label">Faturamento Hoje</div>
                    <div class="stats-value">R$ <?php echo isset($stats['faturamento_hoje']) ? number_format($stats['faturamento_hoje'], 2, ',', '.') : '0,00'; ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Informações Adicionais</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell info-label">Movimentações Hoje:</div>
                <div class="info-cell"><?php echo isset($stats['movimentacoes_hoje']) ? $stats['movimentacoes_hoje'] : 0; ?> veículos</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Vagas Disponíveis:</div>
                <div class="info-cell">
                    <?php 
                    $disponiveis = (isset($stats['total_vagas']) ? $stats['total_vagas'] : 0) - (isset($stats['vagas_ocupadas']) ? $stats['vagas_ocupadas'] : 0);
                    echo $disponiveis;
                    ?> vagas
                </div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Status do Sistema:</div>
                <div class="info-cell">Operacional</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Última Atualização:</div>
                <div class="info-cell"><?php echo date('d/m/Y H:i:s'); ?></div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Observações</div>
        <p>• Este relatório apresenta um resumo executivo das principais métricas do sistema de estacionamento.</p>
        <p>• Os dados são atualizados em tempo real e refletem a situação atual do estacionamento.</p>
        <p>• Para informações mais detalhadas, consulte os relatórios específicos de movimentações e faturamento.</p>
    </div>

    <div class="footer">
        <p>Sistema de Estacionamento - Relatório gerado automaticamente em <?php echo date('d/m/Y H:i:s'); ?></p>
        <p>Página 1 de 1</p>
    </div>
</body>
</html>
