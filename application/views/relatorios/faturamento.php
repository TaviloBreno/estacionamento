<?php $this->load->view('layout/navbar'); ?>

<div class="page-wrap">
    <?php $this->load->view('layout/sidebar'); ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="<?php echo $icone_view; ?> bg-blue"></i>
                            <div class="d-inline">
                                <h5><?php echo $titulo; ?></h5>
                                <span><?php echo $subtitulo; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="page-header-toolbar">
                            <a href="<?php echo base_url('relatorios/exportar_pdf/faturamento?data_inicio=' . $data_inicio . '&data_fim=' . $data_fim); ?>" 
                               class="btn btn-outline-primary" target="_blank">
                                <i class="fa fa-file-pdf mr-1"></i> Exportar PDF
                            </a>
                            <a href="<?php echo base_url('relatorios'); ?>" class="btn btn-outline-secondary">
                                <i class="fa fa-arrow-left mr-1"></i> Voltar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fa fa-filter mr-2"></i>Filtros de Período
                    </h6>
                </div>
                <div class="card-body">
                    <form method="GET" id="filtroForm">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="data_inicio">Data Início:</label>
                                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                                           value="<?php echo $data_inicio; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="data_fim">Data Fim:</label>
                                    <input type="date" class="form-control" id="data_fim" name="data_fim" 
                                           value="<?php echo $data_fim; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-search mr-1"></i> Filtrar
                                        </button>
                                        <button type="button" class="btn btn-secondary" onclick="limparFiltros()">
                                            <i class="fa fa-eraser mr-1"></i> Limpar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Resumo Financeiro -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-success text-white shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Faturamento Total
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold">
                                        R$ <?php echo number_format($faturamento, 2, ',', '.'); ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-dollar-sign fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-info text-white shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Faturamento Médio/Dia
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold">
                                        R$ <?php 
                                        $dias = (strtotime($data_fim) - strtotime($data_inicio)) / (60 * 60 * 24) + 1;
                                        echo number_format($faturamento / $dias, 2, ',', '.'); 
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-calendar fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-warning text-white shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Período Analisado
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold">
                                        <?php echo $dias; ?> dias
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-clock fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="row mb-4">
                <!-- Faturamento por Categoria -->
                <div class="col-lg-6">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fa fa-chart-pie mr-2"></i>Faturamento por Categoria
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="faturamentoCategoriaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Evolução Diária -->
                <div class="col-lg-6">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fa fa-chart-line mr-2"></i>Evolução Diária do Faturamento
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="evolucaoDiariaChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela Detalhada por Categoria -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fa fa-table mr-2"></i>Detalhamento por Categoria
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Categoria</th>
                                    <th>Faturamento</th>
                                    <th>% do Total</th>
                                    <th>Movimentações</th>
                                    <th>Ticket Médio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($faturamento_categoria): ?>
                                    <?php foreach($faturamento_categoria as $cat): ?>
                                        <tr>
                                            <td>
                                                <span class="badge badge-primary">
                                                    <?php echo $cat->categoria; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong>R$ <?php echo number_format($cat->faturamento, 2, ',', '.'); ?></strong>
                                            </td>
                                            <td>
                                                <?php 
                                                $percentual = $faturamento > 0 ? ($cat->faturamento / $faturamento) * 100 : 0;
                                                echo number_format($percentual, 1, ',', '.') . '%';
                                                ?>
                                            </td>
                                            <td class="text-center" id="mov-<?php echo str_replace(' ', '_', strtolower($cat->categoria)); ?>">
                                                -
                                            </td>
                                            <td class="text-center" id="ticket-<?php echo str_replace(' ', '_', strtolower($cat->categoria)); ?>">
                                                -
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            <i class="fa fa-info-circle mr-2"></i>Nenhum faturamento encontrado no período selecionado.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Comparativo Mensal -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fa fa-chart-bar mr-2"></i>Comparativo com Mês Anterior
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center" id="comparativo-mensal">
                        <div class="col-md-4">
                            <div class="border-left-primary shadow h-100 py-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Mês Atual
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="faturamento-mes-atual">
                                    R$ -
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border-left-info shadow h-100 py-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Mês Anterior
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="faturamento-mes-anterior">
                                    R$ -
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border-left-success shadow h-100 py-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Variação
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="variacao-percentual">
                                    -%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Dados para os gráficos vindos do PHP
var faturamentoCategoria = <?php echo json_encode($faturamento_categoria); ?>;

$(document).ready(function() {
    initCharts();
    carregarComparativoMensal();
});

function initCharts() {
    // Gráfico de Faturamento por Categoria
    var ctx1 = document.getElementById('faturamentoCategoriaChart').getContext('2d');
    var categoriaChart = new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: faturamentoCategoria.map(item => item.categoria),
            datasets: [{
                data: faturamentoCategoria.map(item => parseFloat(item.faturamento)),
                backgroundColor: [
                    '#4e73df',
                    '#1cc88a',
                    '#36b9cc',
                    '#f6c23e',
                    '#e74a3b',
                    '#858796'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': R$ ' + context.parsed.toLocaleString('pt-BR', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    }
                }
            }
        }
    });

    // Simular dados para evolução diária (você pode implementar uma consulta específica)
    var ctx2 = document.getElementById('evolucaoDiariaChart').getContext('2d');
    var evolucaoChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['Dia 1', 'Dia 2', 'Dia 3', 'Dia 4', 'Dia 5', 'Dia 6', 'Dia 7'],
            datasets: [{
                label: 'Faturamento Diário (R$)',
                data: [450, 320, 680, 590, 720, 430, 550],
                borderColor: 'rgb(28, 200, 138)',
                backgroundColor: 'rgba(28, 200, 138, 0.1)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR');
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'R$ ' + context.parsed.y.toLocaleString('pt-BR', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    }
                }
            }
        }
    });
}

function carregarComparativoMensal() {
    // Simulação dos dados - você pode implementar via AJAX
    $('#faturamento-mes-atual').text('R$ 15.850,00');
    $('#faturamento-mes-anterior').text('R$ 12.340,00');
    $('#variacao-percentual').text('+28.4%').removeClass('text-gray-800').addClass('text-success');
}

function limparFiltros() {
    document.getElementById('data_inicio').value = '<?php echo date('Y-m-01'); ?>';
    document.getElementById('data_fim').value = '<?php echo date('Y-m-t'); ?>';
    document.getElementById('filtroForm').submit();
}
</script>

<style>
.text-xs {
    font-size: 0.7rem;
}

.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.chart-area, .chart-pie {
    position: relative;
    height: 300px;
    width: 100%;
}

.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.badge {
    font-size: 0.75rem;
}

.table th {
    border-top: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    color: #5a5c69;
}

.table td {
    border-top: 1px solid #e3e6f0;
    font-size: 0.85rem;
}
</style>
