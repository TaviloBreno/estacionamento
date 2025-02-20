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
									<a title="Home" data-toggle="tooltip" data-placement="top" href="<?php echo base_url($this->router->fetch_class()); ?>">
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
						<div class="card-header"><?php echo (isset($categoria) ? "<i class='ik ik-calendar'></i> Última alteração: " . formata_data_banco_com_hora($mensalista->mensalista_data_alteracao) : ''); ?></div>
						<div class="card-body">

							<form class="forms-sample" name="form_core" method="POST" action="<?php echo base_url($this->router->fetch_class().'/core/' . (isset($mensalista) ? $mensalista->mensalista_id : '')); ?>">
								<div class="form-row">
									<!-- Nome -->
									<div class="form-group col-md-6">
										<label for="mensalista_nome">Nome</label>
										<input type="text" class="form-control" id="mensalista_nome" name="mensalista_nome" placeholder="Nome"
											   value="<?php echo (isset($mensalista) ? $mensalista->mensalista_nome : set_value('mensalista_nome')); ?>">
										<?php echo form_error('mensalista_nome', '<div class="text-danger">', '</div>'); ?>
									</div>

									<!-- Sobrenome -->
									<div class="form-group col-md-6">
										<label for="mensalista_sobrenome">Sobrenome</label>
										<input type="text" class="form-control" id="mensalista_sobrenome" name="mensalista_sobrenome" placeholder="Sobrenome"
											   value="<?php echo (isset($mensalista) ? $mensalista->mensalista_sobrenome : set_value('mensalista_sobrenome')); ?>">
										<?php echo form_error('mensalista_sobrenome', '<div class="text-danger">', '</div>'); ?>
									</div>
								</div>

								<div class="form-row">
									<!-- Data de Nascimento -->
									<div class="form-group col-md-6">
										<label for="mensalista_data_nascimento">Data de Nascimento</label>
										<input type="date" class="form-control" id="mensalista_data_nascimento" name="mensalista_data_nascimento"
											   value="<?php echo (isset($mensalista) ? $mensalista->mensalista_data_nascimento : set_value('mensalista_data_nascimento')); ?>">
										<?php echo form_error('mensalista_data_nascimento', '<div class="text-danger">', '</div>'); ?>
									</div>

									<!-- CPF -->
									<div class="form-group col-md-6">
										<label for="mensalista_cpf">CPF</label>
										<input type="text" class="form-control cpf" id="mensalista_cpf" name="mensalista_cpf" placeholder="CPF"
											   value="<?php echo (isset($mensalista) ? $mensalista->mensalista_cpf : set_value('mensalista_cpf')); ?>">
										<?php echo form_error('mensalista_cpf', '<div class="text-danger">', '</div>'); ?>
									</div>
								</div>

								<div class="form-row">
									<!-- RG -->
									<div class="form-group col-md-6">
										<label for="mensalista_rg">RG</label>
										<input type="text" class="form-control rg" id="mensalista_rg" name="mensalista_rg" placeholder="RG"
											   value="<?php echo (isset($mensalista) ? $mensalista->mensalista_rg : set_value('mensalista_rg')); ?>">
										<?php echo form_error('mensalista_rg', '<div class="text-danger">', '</div>'); ?>
									</div>

									<!-- Email -->
									<div class="form-group col-md-6">
										<label for="mensalista_email">Email</label>
										<input type="email" class="form-control" id="mensalista_email" name="mensalista_email" placeholder="Email"
											   value="<?php echo (isset($mensalista) ? $mensalista->mensalista_email : set_value('mensalista_email')); ?>">
										<?php echo form_error('mensalista_email', '<div class="text-danger">', '</div>'); ?>
									</div>
								</div>

								<div class="form-row">
									<!-- Telefone Fixo -->
									<div class="form-group col-md-6">
										<label for="mensalista_telefone_fixo">Telefone Fixo</label>
										<input type="text" class="form-control phone_with_ddd" id="mensalista_telefone_fixo" name="mensalista_telefone_fixo" placeholder="Telefone Fixo"
											   value="<?php echo (isset($mensalista) ? $mensalista->mensalista_telefone_fixo : set_value('mensalista_telefone_fixo')); ?>">
										<?php echo form_error('mensalista_telefone_fixo', '<div class="text-danger">', '</div>'); ?>
									</div>

									<!-- Telefone Móvel -->
									<div class="form-group col-md-6">
										<label for="mensalista_telefone_movel">Telefone Móvel</label>
										<input type="text" class="form-control phone_with_ddd" id="mensalista_telefone_movel" name="mensalista_telefone_movel" placeholder="Telefone Móvel"
											   value="<?php echo (isset($mensalista) ? $mensalista->mensalista_telefone_movel : set_value('mensalista_telefone_movel')); ?>">
										<?php echo form_error('mensalista_telefone_movel', '<div class="text-danger">', '</div>'); ?>
									</div>
								</div>

								<div class="form-row">
									<!-- CEP -->
									<div class="form-group col-md-6">
										<label for="mensalista_cep">CEP</label>
										<input type="text" class="form-control cep" id="mensalista_cep" name="mensalista_cep" placeholder="CEP"
											   value="<?php echo (isset($mensalista) ? $mensalista->mensalista_cep : set_value('mensalista_cep')); ?>">
										<?php echo form_error('mensalista_cep', '<div class="text-danger">', '</div>'); ?>
									</div>

									<!-- Endereço -->
									<div class="form-group col-md-6">
										<label for="mensalista_endereco">Endereço</label>
										<input type="text" class="form-control" id="mensalista_endereco" name="mensalista_endereco" placeholder="Endereço"
											   value="<?php echo (isset($mensalista) ? $mensalista->mensalista_endereco : set_value('mensalista_endereco')); ?>">
										<?php echo form_error('mensalista_endereco', '<div class="text-danger">', '</div>'); ?>
									</div>
								</div>

								<div class="form-row">
									<!-- Número do Endereço -->
									<div class="form-group col-md-6">
										<label for="mensalista_numero_endereco">Número</label>
										<input type="text" class="form-control" id="mensalista_numero_endereco" name="mensalista_numero_endereco" placeholder="Número"
											   value="<?php echo (isset($mensalista) ? $mensalista->mensalista_numero_endereco : set_value('mensalista_numero_endereco')); ?>">
										<?php echo form_error('mensalista_numero_endereco', '<div class="text-danger">', '</div>'); ?>
									</div>

									<!-- Bairro -->
									<div class="form-group col-md-6">
										<label for="mensalista_bairro">Bairro</label>
										<input type="text" class="form-control" id="mensalista_bairro" name="mensalista_bairro" placeholder="Bairro"
											   value="<?php echo (isset($mensalista) ? $mensalista->mensalista_bairro : set_value('mensalista_bairro')); ?>">
										<?php echo form_error('mensalista_bairro', '<div class="text-danger">', '</div>'); ?>
									</div>
								</div>

								<div class="form-row">
									<!-- Cidade -->
									<div class="form-group col-md-6">
										<label for="mensalista_cidade">Cidade</label>
										<input type="text" class="form-control" id="mensalista_cidade" name="mensalista_cidade" placeholder="Cidade"
											   value="<?php echo (isset($mensalista) ? $mensalista->mensalista_cidade : set_value('mensalista_cidade')); ?>">
										<?php echo form_error('mensalista_cidade', '<div class="text-danger">', '</div>'); ?>
									</div>

									<!-- Estado -->
									<div class="form-group col-md-6">
										<label for="mensalista_estado">Estado</label>
										<input type="text" class="form-control" id="mensalista_estado" name="mensalista_estado" placeholder="Estado"
											   value="<?php echo (isset($mensalista) ? $mensalista->mensalista_estado : set_value('mensalista_estado')); ?>">
										<?php echo form_error('mensalista_estado', '<div class="text-danger">', '</div>'); ?>
									</div>
								</div>

								<div class="form-row">
									<!-- Complemento -->
									<div class="form-group col-md-6">
										<label for="mensalista_complemento">Complemento</label>
										<input type="text" class="form-control" id="mensalista_complemento" name="mensalista_complemento" placeholder="Complemento"
											   value="<?php echo (isset($mensalista) ? $mensalista->mensalista_complemento : set_value('mensalista_complemento')); ?>">
										<?php echo form_error('mensalista_complemento', '<div class="text-danger">', '</div>'); ?>
									</div>

									<!-- Dia de Vencimento -->
									<div class="form-group col-md-6">
										<label for="mensalista_dia_vencimento">Dia de Vencimento</label>
										<input type="number" class="form-control" id="mensalista_dia_vencimento" name="mensalista_dia_vencimento" placeholder="Dia de Vencimento"
											   value="<?php echo (isset($mensalista) ? $mensalista->mensalista_dia_vencimento : set_value('mensalista_dia_vencimento')); ?>">
										<?php echo form_error('mensalista_dia_vencimento', '<div class="text-danger">', '</div>'); ?>
									</div>
								</div>

								<div class="form-row">
									<!-- Status Ativo -->
									<div class="form-group col-md-6">
										<label for="mensalista_ativo">Ativo</label>
										<select class="form-control" id="mensalista_ativo" name="mensalista_ativo">
											<?php if(isset($mensalista)): ?>
												<option value="0" <?php echo ($mensalista->mensalista_ativo == 0 ? 'selected' : ''); ?>>Não</option>
												<option value="1" <?php echo ($mensalista->mensalista_ativo == 1 ? 'selected' : ''); ?>>Sim</option>
											<?php else: ?>
												<option value="0">Não</option>
												<option value="1">Sim</option>
											<?php endif; ?>
										</select>
									</div>

									<!-- Observações -->
									<div class="form-group col-md-12">
										<label for="mensalista_obs">Observações</label>
										<textarea class="form-control" id="mensalista_obs" name="mensalista_obs" placeholder="Observações"><?php echo (isset($mensalista) ? $mensalista->mensalista_obs : set_value('mensalista_obs')); ?></textarea>
										<?php echo form_error('mensalista_obs', '<div class="text-danger">', '</div>'); ?>
									</div>
								</div>

								<?php if (isset($mensalista)): ?>
									<input type="hidden" name="mensalista_id" value="<?php echo $mensalista->mensalista_id; ?>">
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
