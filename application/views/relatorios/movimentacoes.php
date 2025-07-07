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
                            <a href="<?php echo base_url('relatorios/exportar_pdf/movimentacoes?data_inicio=' . $data_inicio . '&data_fim=' . $data_fim); ?>" 
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

            <!-- Resumo -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Total Movimentações
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold">
                                        <?php echo count($movimentacoes); ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-exchange-alt fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card bg-success text-white shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Finalizadas
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold">
                                        <?php 
                                        $finalizadas = 0;
                                        foreach($movimentacoes as $mov) {
                                            if($mov->estacionar_status == 1) $finalizadas++;
                                        }
                                        echo $finalizadas;
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card bg-warning text-white shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Em Andamento
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold">
                                        <?php 
                                        $andamento = 0;
                                        foreach($movimentacoes as $mov) {
                                            if($mov->estacionar_status == 0) $andamento++;
                                        }
                                        echo $andamento;
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-clock fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card bg-info text-white shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Faturamento
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold">
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
                                <div class="col-auto">
                                    <i class="fa fa-dollar-sign fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela de Movimentações -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fa fa-table mr-2"></i>Detalhes das Movimentações
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Ticket</th>
                                    <th>Cliente</th>
                                    <th>Veículo</th>
                                    <th>Categoria</th>
                                    <th>Entrada</th>
                                    <th>Saída</th>
                                    <th>Valor</th>
                                    <th>Pagamento</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($movimentacoes): ?>
                                    <?php foreach($movimentacoes as $mov): ?>
                                        <tr>
                                            <td><?php echo str_pad($mov->estacionar_id, 6, '0', STR_PAD_LEFT); ?></td>
                                            <td><?php echo $mov->estacionar_cliente_nome; ?></td>
                                            <td>
                                                <small class="text-muted"><?php echo $mov->estacionar_veiculo_modelo; ?></small><br>
                                                <strong><?php echo $mov->estacionar_veiculo_placa; ?></strong>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary">
                                                    <?php echo $mov->precificacao_categoria; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small><?php echo date('d/m/Y', strtotime($mov->estacionar_data_entrada)); ?></small><br>
                                                <strong><?php echo date('H:i', strtotime($mov->estacionar_data_entrada)); ?></strong>
                                            </td>
                                            <td>
                                                <?php if($mov->estacionar_data_saida): ?>
                                                    <small><?php echo date('d/m/Y', strtotime($mov->estacionar_data_saida)); ?></small><br>
                                                    <strong><?php echo date('H:i', strtotime($mov->estacionar_data_saida)); ?></strong>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($mov->estacionar_valor_final > 0): ?>
                                                    <strong>R$ <?php echo number_format($mov->estacionar_valor_final, 2, ',', '.'); ?></strong>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($mov->forma_pagamento_nome): ?>
                                                    <span class="badge badge-info">
                                                        <?php echo $mov->forma_pagamento_nome; ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($mov->estacionar_status == 1): ?>
                                                    <span class="badge badge-success">
                                                        <i class="fa fa-check mr-1"></i>Finalizado
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">
                                                        <i class="fa fa-clock mr-1"></i>Em Andamento
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">
                                            <i class="fa fa-info-circle mr-2"></i>Nenhuma movimentação encontrada no período selecionado.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
        },
        "order": [[ 4, "desc" ]],
        "pageLength": 25,
        "responsive": true
    });
});

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

.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}
</style>
