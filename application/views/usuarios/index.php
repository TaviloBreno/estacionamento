
	<?php $this->load->view('layout/navbar'); ?>

	<div class="page-wrap">

		<?php $this->load->view('layout/sidebar'); ?>

		<div class="main-content">
			<div class="container-fluid">
				<div class="page-header">
					<div class="row align-items-end">
						<div class="col-lg-8">
							<div class="page-header-title">
								<i class="ik ik-users bg-blue"></i>
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
										<a title="Home" data-toggle="" href="<?php echo base_url('/'); ?>"><i class="ik ik-home"></i></a>
									</li>
									<li class="breadcrumb-item active" aria-current="page"><?php echo $titulo; ?></li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<?php if($message = $this->session->flashdata('sucesso')): ?>
					<div class="row">
						<div class="col-md-12">
							<div class="alert bg-success alert-dismissible fade show text-white" role="alert">
								<strong><?php echo $message; ?></strong>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<?php if($message = $this->session->flashdata('error')): ?>
					<div class="row">
						<div class="col-md-12">
							<div class="alert bg-danger alert-dismissible fade show text-white" role="alert">
								<strong><?php echo $message; ?></strong>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header"><a title="Cadastro de <?php echo  str_replace('a', 'á', ucfirst($this->router->fetch_class())); ?>" data-toggle="tooltip" data-placement="top" class="btn btn-success" href="<?php echo base_url($this->router->fetch_class().'/'.'core'); ?>">+ Novo</a></div>
							<div class="card-body">
								<table class="table data-table">
									<thead>
									<tr>
										<th>#</th>
										<th>Usuário</th>
										<th>Email</th>
										<th>Nome</th>
										<th>Perfil de acesso</th>
										<th>Ativo</th>
										<th class="text-center">Ações</th>
									</tr>
									</thead>
									<tbody>
									<?php foreach ($usuarios as $usuario): ?>
									<tr>
										<td><?php echo $usuario->id; ?></td>
										<td><?php echo $usuario->username; ?></td>
										<td><?php echo $usuario->email; ?></td>
										<td><?php echo $usuario->first_name.' '.$usuario->last_name; ?></td>
										<td><?php echo ($this->ion_auth->is_admin($usuario->id) ? 'Administrador' : 'Funcionário'); ?></td>
										<td><?php echo ($usuario->active == 1 ? '<span class="badge badge-success"><i class="fas fa-lock-open"></i> Sim</span>' : '<span class="badge badge-danger"><i class="fas fa-lock"></i> Não</span>'); ?></td>
										<td>
											<div class="table-actions text-center">
												<a type="button"
												   		href="<?php echo base_url('usuarios/core/'.$usuario->id); ?>"
														class="btn btn-icon btn-primary"
												   		style="color: white;"
														data-toggle="tooltip"
														data-placement="top"
														title="Editar <?php echo ucfirst(str_replace('a', 'á', $this->router->fetch_class())); ?>">
													<i class="ik ik-edit"></i>
												</a>

												<button type="button" class="btn btn-icon btn-danger" data-toggle="modal" data-target="#user-<?php echo $usuario->id; ?>" title="Excluir <?php echo ucfirst(str_replace('a', 'á', $this->router->fetch_class())); ?>">
													<i class="ik ik-trash"></i>
												</button>

											</div>
										</td>
									</tr>

										<div class="modal fade" id="user-<?php echo $usuario->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalCenterLabel"><i class="fas fa-exclamation-triangle alert-warning"></i> Você tem certeza que deseja excluir o usuário <?php echo $usuario->username;  ?>?</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
														<a type="button" href="<?php echo base_url($this->router->fetch_class().'/del/'.$usuario->id); ?>" class="btn btn-primary" style="color: white;font-style: none;">Sim, excluir</a>
													</div>
												</div>
											</div>
										</div>

									<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



