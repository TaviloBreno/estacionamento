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
									<a title="Home" data-toggle="tooltip" data-placement="top" href="<?php echo base_url('precificacoes'); ?>">
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
						<div class="card-header"><?php echo (isset($categoria) ? "<i class='ik ik-calendar'></i> Última alteração: " . formata_data_banco_com_hora($categoria->precificacao_data_alteracao) : ''); ?></div>
						<div class="card-body">

							<form class="forms-sample" name="form_core" method="post" action="<?php echo base_url('precificacoes/core/' . (isset($categoria) ? $categoria->precificacao_id : '')); ?>">
								<div class="form-row">
									<!-- Categoria -->
									<div class="form-group col-md-6">
										<label for="precificacao_categoria">Categoria</label>
										<input type="text" class="form-control" id="precificacao_categoria" name="precificacao_categoria" placeholder="Categoria"
											   value="<?php echo (isset($categoria) ? $categoria->precificacao_categoria : set_value('precificacao_categoria')); ?>">
										<?php echo form_error('precificacao_categoria', '<div class="text-danger">', '</div>'); ?>
									</div>

									<!-- Valor da Hora -->
									<div class="form-group col-md-6">
										<label for="precificacao_valor_hora">Valor por Hora</label>
										<input type="text" class="form-control" id="precificacao_valor_hora" name="precificacao_valor_hora" placeholder="Ex: 5.00"
											   value="<?php echo (isset($categoria) ? $categoria->precificacao_valor_hora : set_value('precificacao_valor_hora')); ?>">
										<?php echo form_error('precificacao_valor_hora', '<div class="text-danger">', '</div>'); ?>
									</div>
								</div>

								<div class="form-row">
									<!-- Valor da Mensalidade -->
									<div class="form-group col-md-6">
										<label for="precificacao_valor_mensalidade">Valor da Mensalidade</label>
										<input type="text" class="form-control" id="precificacao_valor_mensalidade" name="precificacao_valor_mensalidade" placeholder="Ex: 150.00"
											   value="<?php echo (isset($categoria) ? $categoria->precificacao_valor_mensalidade : set_value('precificacao_valor_mensalidade')); ?>">
										<?php echo form_error('precificacao_valor_mensalidade', '<div class="text-danger">', '</div>'); ?>
									</div>

									<!-- Número de Vagas -->
									<div class="form-group col-md-6">
										<label for="precificacao_numero_vagas">Número de Vagas</label>
										<input type="number" class="form-control" id="precificacao_numero_vagas" name="precificacao_numero_vagas" placeholder="Número de vagas"
											   value="<?php echo (isset($categoria) ? $categoria->precificacao_numero_vagas : set_value('precificacao_numero_vagas')); ?>">
										<?php echo form_error('precificacao_numero_vagas', '<div class="text-danger">', '</div>'); ?>
									</div>
								</div>

								<div class="form-row">
									<!-- Status Ativo -->
									<div class="form-group col-md-6">
										<label for="precificacao_ativa">Ativo</label>
										<select class="form-control" id="precificacao_ativa" name="precificacao_ativa">
											<?php if(isset($precificacao)): ?>
											<option value="0" <?php echo ($precificacao->precificacao_ativa == 0 ? 'selected' : ''); ?>>Não</option>
											<option value="1" <?php echo ($precificacao->precificacao_ativa == 1 ? 'selected' : ''); ?>>Sim</option>
											<?php else: ?>
												<option value="0">Não</option>
												<option value="1">Sim</option>
											<?php endif; ?>
										</select>
									</div>
								</div>

								<?php if (isset($categoria)): ?>
									<input type="hidden" name="precificacao_id" value="<?php echo $categoria->precificacao_id; ?>">
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
