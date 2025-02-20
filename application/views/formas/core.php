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
									<a title="Home" data-toggle="tooltip" data-placement="top" href="<?php echo base_url('/'); ?>">
										<i class="ik ik-home"></i>
									</a>
								</li>
								<li class="breadcrumb-item">
									<a title="Listar <?php echo ucfirst($this->router->fetch_class()); ?>" data-toggle="tooltip" data-placement="top" href="<?php echo base_url($this->router->fetch_class()); ?>">
										Listar <?php echo ucfirst($this->router->fetch_class()); ?>
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
							<?php echo (isset($forma_pagamento) ? "<i class='ik ik-calendar'></i> Última alteração: " . formata_data_banco_com_hora($forma_pagamento->forma_pagamento_data_alteracao) : ''); ?>
						</div>
						<div class="card-body">
							<form class="forms-sample" name="form_core" method="post" action="<?php echo base_url('formas/core/' . (isset($forma_pagamento) ? $forma_pagamento->forma_pagamento_id : '')); ?>">

								<div class="form-row">
									<!-- Nome da Forma de Pagamento -->
									<div class="form-group col-md-6">
										<label for="forma_pagamento_nome">Nome da Forma de Pagamento</label>
										<input type="text" class="form-control" id="forma_pagamento_nome" name="forma_pagamento_nome" placeholder="Ex: Cartão de Crédito"
											   value="<?php echo (isset($forma_pagamento) ? $forma_pagamento->forma_pagamento_nome : set_value('forma_pagamento_nome')); ?>">
										<?php echo form_error('forma_pagamento_nome', '<div class="text-danger">', '</div>'); ?>
									</div>

									<!-- Status Ativo -->
									<div class="form-group col-md-6">
										<label for="forma_pagamento_ativa">Ativo</label>
										<select class="form-control" id="forma_pagamento_ativa" name="forma_pagamento_ativa">
											<option value="1" <?php echo (isset($forma_pagamento) && $forma_pagamento->forma_pagamento_ativa == 1 ? 'selected' : ''); ?>>Sim</option>
											<option value="0" <?php echo (isset($forma_pagamento) && $forma_pagamento->forma_pagamento_ativa == 0 ? 'selected' : ''); ?>>Não</option>
										</select>
										<?php echo form_error('forma_pagamento_ativa', '<div class="text-danger">', '</div>'); ?>
									</div>
								</div>

								<?php if (isset($forma_pagamento)): ?>
									<input type="hidden" name="forma_pagamento_id" value="<?php echo $forma_pagamento->forma_pagamento_id; ?>">
								<?php endif; ?>

								<button type="submit" class="btn btn-primary mr-2">Salvar</button>
								<a href="<?php echo base_url($this->router->fetch_class()); ?>" class="btn btn-light">Voltar</a>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
