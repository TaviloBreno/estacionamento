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
                            <a href="<?php echo base_url('relatorios/exportar_pdf/dashboard'); ?>" 
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

            <!-- Cards de Estatísticas -->
            <div class="row mb-4">
                <div class="col-xl-3 col-lg-6">
                    <div class="card bg-primary text-white shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Total de Vagas
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold">
                                        <?php echo isset($stats['total_vagas']) ? $stats['total_vagas'] : 0; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-parking fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card bg-success text-white shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Vagas Ocupadas
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold">
                                        <?php echo isset($stats['vagas_ocupadas']) ? $stats['vagas_ocupadas'] : 0; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-car fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card bg-info text-white shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Taxa de Ocupação
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold">
                                        <?php echo isset($stats['taxa_ocupacao']) ? $stats['taxa_ocupacao'] : 0; ?>%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-percentage fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card bg-warning text-white shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Faturamento Hoje
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold">
                                        R$ <?php echo isset($stats['faturamento_hoje']) ? number_format($stats['faturamento_hoje'], 2, ',', '.') : '0,00'; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-dollar-sign fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="row">
                <!-- Fluxo Diário -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fa fa-chart-area mr-2"></i>Fluxo de Entradas dos Últimos 7 Dias
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="fluxoDiarioChart" height="80"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ocupação por Categoria -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fa fa-chart-pie mr-2"></i>Ocupação por Categoria
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="ocupacaoCategoriaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Faturamento Mensal -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fa fa-chart-bar mr-2"></i>Faturamento dos Últimos 6 Meses
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-bar">
                                <canvas id="faturamentoMensalChart" height="80"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clientes por Dia -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fa fa-chart-line mr-2"></i>Clientes Únicos (30 dias)
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-line">
                                <canvas id="clientesPorDiaChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Movimentações Hoje -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fa fa-clock mr-2"></i>Movimentações de Hoje
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <div class="border-left-primary shadow h-100 py-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Movimentações
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo isset($stats['movimentacoes_hoje']) ? $stats['movimentacoes_hoje'] : 0; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border-left-success shadow h-100 py-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Entradas
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="entradas-hoje">
                                            -
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border-left-info shadow h-100 py-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Saídas
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="saidas-hoje">
                                            -
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border-left-warning shadow h-100 py-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Tempo Médio
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="tempo-medio">
                                            -
                                        </div>
                                    </div>
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
var fluxoDiario = <?php echo json_encode($fluxo_diario); ?>;
var ocupacaoCategoria = <?php echo json_encode($ocupacao_por_categoria); ?>;
var faturamentoMensal = <?php echo json_encode($faturamento_mensal); ?>;
var clientesPorDia = <?php echo json_encode($clientes_por_dia); ?>;

$(document).ready(function() {
    initCharts();
    carregarMovimentacoesHoje();
});

function initCharts() {
    // Gráfico de Fluxo Diário
    var ctx1 = document.getElementById('fluxoDiarioChart').getContext('2d');
    var fluxoChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: fluxoDiario.map(item => {
                var date = new Date(item.data);
                return date.toLocaleDateString('pt-BR');
            }),
            datasets: [{
                label: 'Entradas',
                data: fluxoDiario.map(item => item.entradas),
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de Ocupação por Categoria
    var ctx2 = document.getElementById('ocupacaoCategoriaChart').getContext('2d');
    var ocupacaoChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ocupacaoCategoria.map(item => item.categoria),
            datasets: [{
                data: ocupacaoCategoria.map(item => item.ocupadas),
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
                }
            }
        }
    });

    // Gráfico de Faturamento Mensal
    var ctx3 = document.getElementById('faturamentoMensalChart').getContext('2d');
    var faturamentoChart = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: faturamentoMensal.map(item => {
                var date = new Date(item.mes + '-01');
                return date.toLocaleDateString('pt-BR', {month: 'short', year: 'numeric'});
            }),
            datasets: [{
                label: 'Faturamento (R$)',
                data: faturamentoMensal.map(item => parseFloat(item.faturamento)),
                backgroundColor: 'rgba(28, 200, 138, 0.8)',
                borderColor: 'rgba(28, 200, 138, 1)',
                borderWidth: 1
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

    // Gráfico de Clientes por Dia
    var ctx4 = document.getElementById('clientesPorDiaChart').getContext('2d');
    var clientesChart = new Chart(ctx4, {
        type: 'line',
        data: {
            labels: clientesPorDia.map(item => {
                var date = new Date(item.data);
                return date.toLocaleDateString('pt-BR');
            }),
            datasets: [{
                label: 'Clientes Únicos',
                data: clientesPorDia.map(item => item.clientes_unicos),
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function carregarMovimentacoesHoje() {
    // Simular dados - você pode fazer uma chamada AJAX aqui
    $('#entradas-hoje').text('25');
    $('#saidas-hoje').text('18');
    $('#tempo-medio').text('2h 30min');
}
</script>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.chart-area, .chart-bar, .chart-pie, .chart-line {
    position: relative;
    height: 400px;
    width: 100%;
}

.text-xs {
    font-size: 0.7rem;
}

.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}
</style>
