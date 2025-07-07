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
                </div>
            </div>

            <?php if($message = $this->session->flashdata('sucesso')): ?>
                <div class="alert bg-success alert-dismissible fade show text-white" role="alert">
                    <strong><?php echo $message; ?></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <?php endif; ?>

            <!-- Cards de navegação -->
            <div class="row mb-4">
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fa fa-chart-line fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Dashboard Executivo</h5>
                            <p class="card-text">Visão geral com gráficos e estatísticas principais do sistema.</p>
                            <a href="<?php echo base_url('relatorios/dashboard'); ?>" class="btn btn-primary">
                                <i class="fa fa-eye mr-1"></i> Visualizar
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fa fa-exchange-alt fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Movimentações</h5>
                            <p class="card-text">Relatório detalhado de todas as movimentações de veículos.</p>
                            <a href="<?php echo base_url('relatorios/movimentacoes'); ?>" class="btn btn-success">
                                <i class="fa fa-list mr-1"></i> Visualizar
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fa fa-dollar-sign fa-3x text-warning mb-3"></i>
                            <h5 class="card-title">Faturamento</h5>
                            <p class="card-text">Análise financeira com gráficos de faturamento por período.</p>
                            <a href="<?php echo base_url('relatorios/faturamento'); ?>" class="btn btn-warning">
                                <i class="fa fa-chart-bar mr-1"></i> Visualizar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Relatórios Rápidos -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fa fa-download mr-2"></i>Exportar Relatórios</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Exporte relatórios em formato PDF para impressão ou arquivo.</p>
                            
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <a href="<?php echo base_url('relatorios/exportar_pdf/dashboard'); ?>" 
                                       class="btn btn-outline-primary btn-block" target="_blank">
                                        <i class="fa fa-file-pdf mr-2"></i>Dashboard PDF
                                    </a>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <a href="<?php echo base_url('relatorios/exportar_pdf/movimentacoes'); ?>" 
                                       class="btn btn-outline-success btn-block" target="_blank">
                                        <i class="fa fa-file-pdf mr-2"></i>Movimentações PDF
                                    </a>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <a href="<?php echo base_url('relatorios/exportar_pdf/faturamento'); ?>" 
                                       class="btn btn-outline-warning btn-block" target="_blank">
                                        <i class="fa fa-file-pdf mr-2"></i>Faturamento PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estatísticas Rápidas -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fa fa-tachometer-alt mr-2"></i>Resumo do Dia</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center" id="estatisticas-rapidas">
                                <div class="col-md-3">
                                    <div class="stat-card">
                                        <div class="stat-icon text-primary">
                                            <i class="fa fa-car fa-2x"></i>
                                        </div>
                                        <div class="stat-content">
                                            <h4 class="stat-number" id="vagas-ocupadas">-</h4>
                                            <p class="stat-label">Vagas Ocupadas</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card">
                                        <div class="stat-icon text-success">
                                            <i class="fa fa-dollar-sign fa-2x"></i>
                                        </div>
                                        <div class="stat-content">
                                            <h4 class="stat-number" id="faturamento-hoje">R$ -</h4>
                                            <p class="stat-label">Faturamento Hoje</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card">
                                        <div class="stat-icon text-info">
                                            <i class="fa fa-clock fa-2x"></i>
                                        </div>
                                        <div class="stat-content">
                                            <h4 class="stat-number" id="movimentacoes-hoje">-</h4>
                                            <p class="stat-label">Movimentações</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card">
                                        <div class="stat-icon text-warning">
                                            <i class="fa fa-percentage fa-2x"></i>
                                        </div>
                                        <div class="stat-content">
                                            <h4 class="stat-number" id="taxa-ocupacao">-</h4>
                                            <p class="stat-label">Taxa Ocupação</p>
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

<style>
.stat-card {
    padding: 20px;
    border-left: 4px solid #e3e6f0;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    transition: all 0.3s;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.25rem 2rem 0 rgba(58, 59, 69, 0.2);
}

.stat-icon {
    margin-bottom: 10px;
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.stat-label {
    color: #5a5c69;
    font-size: 0.9rem;
    font-weight: 500;
    text-transform: uppercase;
    margin-bottom: 0;
}

.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}
</style>

<script>
$(document).ready(function() {
    // Carregar estatísticas rápidas via AJAX
    carregarEstatisticasRapidas();
});

function carregarEstatisticasRapidas() {
    $.ajax({
        url: '<?php echo base_url("relatorios/ajax_dados_grafico"); ?>',
        type: 'POST',
        data: { tipo: 'estatisticas_rapidas' },
        dataType: 'json',
        success: function(response) {
            if(response) {
                $('#vagas-ocupadas').text(response.vagas_ocupadas || '-');
                $('#faturamento-hoje').text('R$ ' + (response.faturamento_hoje || '0,00'));
                $('#movimentacoes-hoje').text(response.movimentacoes_hoje || '-');
                $('#taxa-ocupacao').text((response.taxa_ocupacao || '0') + '%');
            }
        },
        error: function() {
            console.log('Erro ao carregar estatísticas');
        }
    });
}
</script>
