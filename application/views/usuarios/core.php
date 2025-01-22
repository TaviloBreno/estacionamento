
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
									<li class="breadcrumb-item">
										<a title="Listar <?php echo ucfirst(str_replace('a', 'á', $this->router->fetch_class())); ?>" data-toggle="tooltip" data-placement="top" href="<?php echo base_url($this->router->fetch_class()); ?>">
											Listar <?php echo ucfirst(str_replace('a', 'á', $this->router->fetch_class())); ?>
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
							<div class="card-header"><?php echo (isset($usuario) ? "<i class='ik ik-calendar'></i> Data da última atualização: ".formata_data_banco_com_hora($usuario->data_ultima_alteracao) : '');?></div>
							<div class="card-body">

								<form class="forms-sample" name="form_core" method="post" action="<?php echo base_url('usuarios/core'); ?>">
									<div class="form-row">
										<!-- Nome -->
										<div class="form-group col-md-6">
											<label for="first_name">Nome</label>
											<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Nome"
												   value="<?php echo (isset($usuario) ? $usuario->first_name : set_value('first_name')); ?>">
											<?php echo form_error('first_name', '<div class="text-danger">', '</div>'); ?>
										</div>

										<!-- Sobrenome -->
										<div class="form-group col-md-6">
											<label for="last_name">Sobrenome</label>
											<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Sobrenome"
												   value="<?php echo (isset($usuario) ? $usuario->last_name : set_value('last_name')); ?>">
											<?php echo form_error('last_name', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<div class="form-row">
										<!-- Email -->
										<div class="form-group col-md-6">
											<label for="email">Email</label>
											<input type="email" class="form-control" id="email" name="email" placeholder="Email"
												   value="<?php echo (isset($usuario) ? $usuario->email : set_value('email')); ?>">
											<?php echo form_error('email', '<div class="text-danger">', '</div>'); ?>
										</div>

										<!-- Usuário -->
										<div class="form-group col-md-6">
											<label for="username">Usuário</label>
											<input type="text" class="form-control" id="username" name="username" placeholder="Usuário"
												   value="<?php echo (isset($usuario) ? $usuario->username : set_value('username')); ?>">
											<?php echo form_error('username', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<div class="form-row">
										<!-- Senha -->
										<div class="form-group col-md-6">
											<label for="password">Senha</label>
											<input type="password" class="form-control" id="password" name="password" placeholder="Senha">
											<?php echo form_error('password', '<div class="text-danger">', '</div>'); ?>
										</div>

										<!-- Confirmação de Senha -->
										<div class="form-group col-md-6">
											<label for="confirm_password">Confirmação de Senha</label>
											<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmação de Senha">
											<?php echo form_error('confirm_password', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<div class="form-row">
										<!-- Perfil de Acesso -->
										<div class="form-group col-md-6">
											<label for="perfil_usuario">Perfil de Acesso</label>
											<select class="form-control" id="perfil_usuario" name="perfil_usuario">
												<?php if(isset($usuario)): ?>
												<option value="2" <?php echo ($perfil->id == 2 ? 'selected' : ''); ?>>Funcionário</option>
												<option value="1" <?php echo ($perfil->id == 1 ? 'selected' : ''); ?>>Administrador</option>
												<?php else: ?>
												<option></option>
												<option value="2">Funcionário</option>
												<option value="1">Administrador</option>
												<?php endif; ?>
											</select>
										</div>

										<!-- Ativo -->
										<div class="form-group col-md-6">
											<label for="active">Ativo</label>
											<select class="form-control" id="active" name="active">
												<?php if(isset($usuario)): ?>
												<option value="0" <?php echo ($usuario->active == 0 ? 'selected' : ''); ?>>Não</option>
												<option value="1" <?php echo ($usuario->active == 1 ? 'selected' : ''); ?>>Sim</option>
												<?php else: ?>
												<option></option>
												<option value="0">Não</option>
												<option value="1">Sim</option>
												<?php endif; ?>
											</select>
										</div>
									</div>

									<?php if (isset($usuario)): ?>
										<input type="hidden" name="usuario_id" value="<?php echo $usuario->id; ?>">
									<?php endif; ?>

									<button type="submit" class="btn btn-primary mr-2">Salvar</button>
									<a href="<?php echo base_url('usuarios'); ?>" class="btn btn-light">Voltar</a>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



