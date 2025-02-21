
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
							<div class="card-header d-block"><a title="Cadastro de <?php echo  str_replace('a', 'á', ucfirst($this->router->fetch_class())); ?>" data-toggle="tooltip" data-placement="top" class="btn btn-success float-right" href="<?php echo base_url($this->router->fetch_class().'/'.'core'); ?>">+ Novo</a></div>
							<div class="card-body">
								<table class="table data-table">
									<thead>
									<tr>
										<th>#</th>
										<th class="text-center">Categoria</th>
										<th class="text-center">Valor da hora</th>
										<th class="text-center">Valor da mensalidade</th>
										<th class="text-center">Número de vagas</th>
										<th>Ativo</th>
										<th class="text-center">Ações</th>
									</tr>
									</thead>
									<tbody>
									<?php foreach ($precificacoes as $categoria): ?>
										<tr>
											<td><?php echo $categoria->precificacao_id; ?></td>
											<td class="text-center"><?php echo $categoria->precificacao_categoria; ?></td>
											<td class="text-center"><?php echo 'R$ '.$categoria->precificacao_valor_hora; ?></td>
											<td class="text-center"><?php echo 'R$ '.$categoria->precificacao_valor_mensalidade; ?></td>
											<td class="text-center"><?php echo $categoria->precificacao_numero_vagas; ?></td>
											<td><?php echo ($categoria->precificacao_ativa == 1 ? '<span class="badge badge-success">Sim</span>' : '<span class="badge badge-danger">Não</span>'); ?></td>
											<td>
												<div class="table-actions text-center">
													<a type="button" href="<?php echo base_url($this->router->fetch_class().'/core/'.$categoria->precificacao_id); ?>" class="btn btn-icon btn-primary" style="color: white;" data-toggle="tooltip" data-placement="top" title="Editar <?php echo ucfirst(str_replace('a', 'á', $this->router->fetch_class())); ?>">
														<i class="ik ik-edit"></i>
													</a>

													<button type="button" class="btn btn-icon btn-danger" data-toggle="modal" data-target="#categoria-<?php echo $categoria->precificacao_id; ?>" title="Excluir <?php echo ucfirst(str_replace('a', 'á', $this->router->fetch_class())); ?>">
														<i class="ik ik-trash"></i>
													</button>
												</div>
											</td>
										</tr>

										<div class="modal fade" id="categoria-<?php echo $categoria->precificacao_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalCenterLabel">
															<i class="fas fa-exclamation-triangle alert-warning"></i>
															Você tem certeza que deseja excluir a categoria <?php echo $categoria->precificacao_categoria; ?>?
														</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
														<a type="button" href="<?php echo base_url($this->router->fetch_class().'/del/'.$categoria->precificacao_id); ?>" class="btn btn-primary" style="color: white;">Sim, excluir</a>
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



