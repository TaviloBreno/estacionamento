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
						<nav class="breadcrumb-container" aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item">
									<a title="Home" href="<?php echo base_url('/'); ?>"><i class="ik ik-home"></i></a>
								</li>
								<li class="breadcrumb-item">
									<a title="Listar Mensalidades" href="<?php echo base_url('mensalidades'); ?>">
										Listar Mensalidades
									</a>
								</li>
								<li class="breadcrumb-item active" aria-current="page"><?php echo $titulo; ?></li>
							</ol>
						</nav>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<?php echo (isset($mensalidade) ? "<i class='ik ik-calendar'></i> Última alteração: " . formata_data_banco_com_hora($mensalidade->mensalidade_data_alteracao) : ''); ?>
						</div>
						<div class="card-body">

							<form class="forms-sample" name="form_core" method="POST" action="<?php echo base_url($this->router->fetch_class().'/core/' . (isset($mensalidade) ? $mensalidade->mensalidade_id : '')); ?>">

								<div class="form-row">
									<!-- Mensalista -->
									<div class="form-group col-md-6">
										<label for="mensalidade_mensalista_id">Mensalista</label>
										<select class="form-control" id="mensalidade_mensalista_id" name="mensalidade_mensalista_id" required>
											<option value="">Selecione um mensalista</option>
											<?php foreach ($mensalistas as $mensalista): ?>
												<option value="<?php echo $mensalista->mensalista_id; ?>"
													<?php echo (isset($mensalidade) && $mensalidade->mensalidade_mensalista_id == $mensalista->mensalista_id) ? 'selected' : ''; ?>>
													<?php echo $mensalista->mensalista_nome . ' ' . $mensalista->mensalista_sobrenome; ?>
												</option>
											<?php endforeach; ?>
										</select>
										<?php echo form_error('mensalidade_mensalista_id', '<div class="text-danger">', '</div>'); ?>
									</div>

									<!-- Precificação -->
									<div class="form-group col-md-6">
										<label for="mensalidade_precificacao_id">Plano</label>
										<select class="form-control" id="mensalidade_precificacao_id" name="mensalidade_precificacao_id" required>
											<option value="">Selecione uma precificação</option>
											<?php foreach ($precificacoes as $precificacao): ?>
												<option value="<?php echo $precificacao->precificacao_id; ?>"
													<?php echo (isset($mensalidade) && $mensalidade->mensalidade_precificacao_id == $precificacao->precificacao_id) ? 'selected' : ''; ?>>
													<?php echo $precificacao->precificacao_categoria . ' - R$ ' . $precificacao->precificacao_valor_mensalidade; ?>
												</option>
											<?php endforeach; ?>
										</select>
										<?php echo form_error('mensalidade_precificacao_id', '<div class="text-danger">', '</div>'); ?>
									</div>
								</div>

								<div class="form-row">
									<!-- Valor da Mensalidade -->
									<div class="form-group col-md-6">
										<label for="mensalidade_valor_mensalidade">Valor da Mensalidade</label>
										<input type="text" class="form-control money" id="mensalidade_valor_mensalidade" name="mensalidade_valor_mensalidade" placeholder="Ex: 150.00"
											   value="<?php echo (isset($mensalidade) ? $mensalidade->mensalidade_valor_mensalidade : set_value('mensalidade_valor_mensalidade')); ?>" required>
										<?php echo form_error('mensalidade_valor_mensalidade', '<div class="text-danger">', '</div>'); ?>
									</div>

									<!-- Dia de Vencimento -->
									<div class="form-group col-md-6">
										<label for="mensalidade_mensalista_dia_vencimento">Dia de Vencimento</label>
										<input type="number" class="form-control" id="mensalidade_mensalista_dia_vencimento" name="mensalidade_mensalista_dia_vencimento" min="1" max="31"
											   value="<?php echo (isset($mensalidade) ? $mensalidade->mensalidade_mensalista_dia_vencimento : set_value('mensalidade_mensalista_dia_vencimento')); ?>" required>
										<?php echo form_error('mensalidade_mensalista_dia_vencimento', '<div class="text-danger">', '</div>'); ?>
									</div>
								</div>

								<div class="form-row">
									<!-- Data de Vencimento -->
									<div class="form-group col-md-6">
										<label for="mensalidade_data_vencimento">Data de Vencimento</label>
										<input type="date" class="form-control" id="mensalidade_data_vencimento" name="mensalidade_data_vencimento"
											   value="<?php echo (isset($mensalidade) ? $mensalidade->mensalidade_data_vencimento : set_value('mensalidade_data_vencimento')); ?>" required>
										<?php echo form_error('mensalidade_data_vencimento', '<div class="text-danger">', '</div>'); ?>
									</div>

									<!-- Status da Mensalidade -->
									<div class="form-group col-md-6">
										<label for="mensalidade_status">Status</label>
										<select class="form-control" id="mensalidade_status" name="mensalidade_status" required>
											<?php if (isset($mensalidade)): ?>
												<option value="0" <?php echo ($mensalidade->mensalidade_status == 0 ? 'selected' : ''); ?>>Pendente</option>
												<option value="1" <?php echo ($mensalidade->mensalidade_status == 1 ? 'selected' : ''); ?>>Pago</option>
											<?php else: ?>
												<option value="0">Pendente</option>
												<option value="1">Pago</option>
											<?php endif; ?>
										</select>
										<?php echo form_error('mensalidade_status', '<div class="text-danger">', '</div>'); ?>
									</div>
								</div>

								<!-- ID da Mensalidade (Caso esteja editando) -->
								<?php if (isset($mensalidade)): ?>
									<input type="hidden" name="mensalidade_id" value="<?php echo $mensalidade->mensalidade_id; ?>">
								<?php endif; ?>

								<button type="submit" class="btn btn-primary mr-2">Salvar</button>
								<a href="<?php echo base_url('mensalidades'); ?>" class="btn btn-light">Voltar</a>
							</form>


						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
