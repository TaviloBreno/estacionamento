<?php $this->load->view('layout/navbar'); ?>

<div class="page-wrap">
    <?php $this->load->view('layout/sidebar'); ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-12">
                        <div class="page-header-title">
                            <i class="ik ik-check-circle bg-success"></i>
                            <div class="d-inline">
                                <h5>Veículo Estacionado com Sucesso!</h5>
                                <span>Ticket gerado com sucesso</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card de Sucesso -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-success text-white text-center py-4">
                            <i class="fa fa-check-circle fa-3x mb-3"></i>
                            <h4 class="mb-0">Veículo Cadastrado!</h4>
                            <p class="mb-0">Ticket de entrada gerado com sucesso</p>
                        </div>
                        <div class="card-body p-4">
                            <!-- Informações do Ticket -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="ticket-info bg-light p-4 rounded">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="text-uppercase text-muted mb-3">
                                                    <i class="fa fa-ticket-alt mr-2"></i>Informações do Ticket
                                                </h6>
                                                <div class="info-item mb-2">
                                                    <strong>Ticket:</strong> 
                                                    <span class="badge badge-primary badge-lg ticket-code" title="Clique para copiar">
                                                        EST<?php echo str_pad($estacionado->estacionar_id, 6, '0', STR_PAD_LEFT); ?>
                                                    </span>
                                                </div>
                                                <div class="info-item mb-2">
                                                    <strong>Placa:</strong> 
                                                    <span class="text-dark font-weight-bold">
                                                        <?php echo strtoupper($estacionado->estacionar_placa_veiculo); ?>
                                                    </span>
                                                </div>
                                                <div class="info-item mb-2">
                                                    <strong>Vaga:</strong> 
                                                    <span class="badge badge-info">
                                                        <?php echo $estacionado->estacionar_numero_vaga; ?>
                                                    </span>
                                                </div>
                                                <div class="info-item mb-2">
                                                    <strong>Categoria:</strong> 
                                                    <span class="text-muted">
                                                        <?php echo $estacionado->precificacao_categoria; ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="text-uppercase text-muted mb-3">
                                                    <i class="fa fa-car mr-2"></i>Dados do Veículo
                                                </h6>
                                                <div class="info-item mb-2">
                                                    <strong>Marca:</strong> 
                                                    <span class="text-dark"><?php echo $estacionado->estacionar_marca_veiculo; ?></span>
                                                </div>
                                                <div class="info-item mb-2">
                                                    <strong>Modelo:</strong> 
                                                    <span class="text-dark"><?php echo $estacionado->estacionar_modelo_veiculo; ?></span>
                                                </div>
                                                <div class="info-item mb-2">
                                                    <strong>Entrada:</strong> 
                                                    <span class="text-success font-weight-bold">
                                                        <?php echo date('d/m/Y H:i', strtotime($estacionado->estacionar_data_entrada)); ?>
                                                    </span>
                                                </div>
                                                <div class="info-item mb-2">
                                                    <strong>Valor/Hora:</strong> 
                                                    <span class="text-warning font-weight-bold">
                                                        R$ <?php echo number_format($estacionado->estacionar_valor_hora, 2, ',', '.'); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- QR Code Visual -->
                            <div class="row mb-4">
                                <div class="col-12 text-center">
                                    <div class="qr-code-section bg-white border p-3 d-inline-block">
                                        <div class="qr-placeholder bg-light d-flex align-items-center justify-content-center" 
                                             style="width: 120px; height: 120px; border: 2px dashed #ccc;">
                                            <div class="text-center">
                                                <i class="fa fa-qrcode fa-2x text-muted mb-2"></i>
                                                <div class="small text-muted">Código do Ticket</div>
                                                <div class="small font-weight-bold">
                                                    EST<?php echo str_pad($estacionado->estacionar_id, 6, '0', STR_PAD_LEFT); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botões de Ação -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-center flex-wrap gap-3">
                                        <a href="<?php echo base_url('estacionar/ticket_entrada/' . $estacionado->estacionar_id); ?>" 
                                           id="print-ticket-btn"
                                           class="btn btn-success btn-lg shadow" target="_blank">
                                            <i class="fa fa-print mr-2"></i>Imprimir Ticket
                                        </a>
                                        <a href="<?php echo base_url('estacionar/acoes/' . $estacionado->estacionar_id); ?>" 
                                           class="btn btn-info btn-lg shadow">
                                            <i class="fa fa-cog mr-2"></i>Ações
                                        </a>
                                        <a href="<?php echo base_url('estacionar'); ?>" 
                                           class="btn btn-secondary btn-lg shadow">
                                            <i class="fa fa-list mr-2"></i>Ver Todos
                                        </a>
                                        <a href="<?php echo base_url('estacionar/core'); ?>" 
                                           class="btn btn-primary btn-lg shadow">
                                            <i class="fa fa-plus mr-2"></i>Novo Ticket
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Informações Importantes -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <h6 class="alert-heading">
                                            <i class="fa fa-info-circle mr-2"></i>Informações Importantes:
                                        </h6>
                                        <ul class="mb-0 small">
                                            <li>Mantenha o ticket para apresentar na saída</li>
                                            <li>Tolerância de 15 minutos sem cobrança</li>
                                            <li>Em caso de perda do ticket, será aplicada taxa adicional</li>
                                            <li>O estacionamento funciona 24 horas</li>
                                        </ul>
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
.info-item {
    padding: 5px 0;
    border-bottom: 1px solid #eee;
}

.info-item:last-child {
    border-bottom: none;
}

.ticket-info {
    border-left: 4px solid #28a745;
}

.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
}

.gap-3 > * {
    margin: 0.25rem !important;
}

.qr-code-section {
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.card {
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

@media (max-width: 768px) {
    .d-flex.justify-content-center.flex-wrap .btn {
        width: 100%;
        margin-bottom: 10px;
    }
}
</style>

<script src="<?php echo base_url('public/dist/js/estacionar-sucesso.js'); ?>"></script>
