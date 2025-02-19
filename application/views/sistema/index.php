
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
										<a title="Home" data-toggle="tooltip" data-placement="top" href="<?php echo base_url('usuarios'); ?>">
											<i class="ik ik-home"></i>
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
							<div class="card-header"><?php echo (isset($sistema) ? "<i class='ik ik-calendar'></i> Data da última atualização: ".formata_data_banco_com_hora($sistema->sistema_data_alteracao) : '');?></div>
							<div class="card-body">

								<form class="forms-sample" name="form_core" method="post" action="<?php echo base_url('usuarios/core/' . (isset($sistema) ? $sistema->sistema_id : '')); ?>">
									<div class="form-row">
										<div class="col-md-6 mb-20">
											<label for="sistema_razao_social">Razão Social</label>
											<input type="text" class="form-control" id="sistema_razao_social" name="sistema_razao_social" placeholder="Razão Social"
												   value="<?php echo (isset($sistema) ? $sistema->sistema_razao_social : set_value('sistema_razao_social')); ?>">
											<?php echo form_error('sistema_razao_social', '<div class="text-danger">', '</div>'); ?>
										</div>

										<div class="col-md-6 mb-20">
											<label for="sistema_nome_fantasia">Nome Fantasia</label>
											<input type="text" class="form-control" id="sistema_nome_fantasia" name="sistema_nome_fantasia" placeholder="Nome Fantasia"
												   value="<?php echo (isset($sistema) ? $sistema->sistema_nome_fantasia : set_value('sistema_nome_fantasia')); ?>">
											<?php echo form_error('sistema_nome_fantasia', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<div class="form-row">
										<div class="col-md-6 mb-20">
											<label for="sistema_cnpj">CNPJ</label>
											<input type="text" class="form-control cnpj" id="sistema_cnpj" name="sistema_cnpj" placeholder="CNPJ"
												   value="<?php echo (isset($sistema) ? $sistema->sistema_cnpj : set_value('sistema_cnpj')); ?>">
											<?php echo form_error('sistema_cnpj', '<div class="text-danger">', '</div>'); ?>
										</div>

										<div class="col-md-6 mb-20">
											<label for="sistema_ie">Inscrição Estadual</label>
											<input type="text" class="form-control" id="sistema_ie" name="sistema_ie" placeholder="Inscrição Estadual"
												   value="<?php echo (isset($sistema) ? $sistema->sistema_ie : set_value('sistema_ie')); ?>">
											<?php echo form_error('sistema_ie', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<div class="form-row">
										<div class="col-md-6 mb-20">
											<label for="sistema_telefone_fixo">Telefone Fixo</label>
											<input type="text" class="form-control sp_celphones" id="sistema_telefone_fixo" name="sistema_telefone_fixo" placeholder="Telefone Fixo"
												   value="<?php echo (isset($sistema) ? $sistema->sistema_telefone_fixo : set_value('sistema_telefone_fixo')); ?>">
											<?php echo form_error('sistema_telefone_fixo', '<div class="text-danger">', '</div>'); ?>
										</div>

										<div class="col-md-6 mb-20">
											<label for="sistema_telefone_movel">Telefone Móvel</label>
											<input type="text" class="form-control sp_celphones" id="sistema_telefone_movel" name="sistema_telefone_movel" placeholder="Telefone Móvel"
												   value="<?php echo (isset($sistema) ? $sistema->sistema_telefone_movel : set_value('sistema_telefone_movel')); ?>">
											<?php echo form_error('sistema_telefone_movel', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<div class="form-row">
										<div class="col-md-6 mb-20">
											<label for="sistema_email">E-mail</label>
											<input type="email" class="form-control" id="sistema_email" name="sistema_email" placeholder="E-mail"
												   value="<?php echo (isset($sistema) ? $sistema->sistema_email : set_value('sistema_email')); ?>">
											<?php echo form_error('sistema_email', '<div class="text-danger">', '</div>'); ?>
										</div>

										<div class="col-md-6 mb-20">
											<label for="sistema_site_url">Site</label>
											<input type="text" class="form-control" id="sistema_site_url" name="sistema_site_url" placeholder="Site"
												   value="<?php echo (isset($sistema) ? $sistema->sistema_site_url : set_value('sistema_site_url')); ?>">
											<?php echo form_error('sistema_site_url', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<div class="form-row">
										<div class="col-md-6 mb-20">
											<label for="sistema_cep">CEP</label>
											<input type="text" class="form-control cep" id="sistema_cep" name="sistema_cep" placeholder="CEP"
												   value="<?php echo (isset($sistema) ? $sistema->sistema_cep : set_value('sistema_cep')); ?>">
											<?php echo form_error('sistema_cep', '<div class="text-danger">', '</div>'); ?>
										</div>

										<div class="col-md-6 mb-20">
											<label for="sistema_endereco">Endereço</label>
											<input type="text" class="form-control" id="sistema_endereco" name="sistema_endereco" placeholder="Endereço"
												   value="<?php echo (isset($sistema) ? $sistema->sistema_endereco : set_value('sistema_endereco')); ?>">
											<?php echo form_error('sistema_endereco', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<div class="form-row">
										<div class="col-md-6 mb-20">
											<label for="sistema_numero">Número</label>
											<input type="text" class="form-control" id="sistema_numero" name="sistema_numero" placeholder="Número"
												   value="<?php echo (isset($sistema) ? $sistema->sistema_numero : set_value('sistema_numero')); ?>">
											<?php echo form_error('sistema_numero', '<div class="text-danger">', '</div>'); ?>
										</div>

										<div class="col-md-6 mb-20">
											<label for="sistema_cidade">Cidade</label>
											<input type="text" class="form-control" id="sistema_cidade" name="sistema_cidade" placeholder="Cidade"
												   value="<?php echo (isset($sistema) ? $sistema->sistema_cidade : set_value('sistema_cidade')); ?>">
											<?php echo form_error('sistema_cidade', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<div class="form-row">
										<div class="col-md-6 mb-20">
											<label for="sistema_estado">Estado</label>
											<input type="text" class="form-control" id="sistema_estado" name="sistema_estado" placeholder="Estado"
												   value="<?php echo (isset($sistema) ? $sistema->sistema_estado : set_value('sistema_estado')); ?>">
											<?php echo form_error('sistema_estado', '<div class="text-danger">', '</div>'); ?>
										</div>

										<div class="col-md-6 mb-20">
											<label for="sistema_txt_ordem_servico">Texto do ticket de estacionamento</label>
											<textarea class="form-control" id="sistema_texto_ticket" name="sistema_texto_ticket" placeholder="Texto do ticket de estacionamento"><?php echo (isset($sistema) ? $sistema->sistema_texto_ticket : set_value('sistema_texto_ticket')); ?></textarea>
											<?php echo form_error('sistema_texto_ticket', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>


									<button type="submit" class="btn btn-primary mr-2">Salvar</button>
									<a href="<?php echo base_url('/'); ?>" class="btn btn-light">Voltar</a>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



