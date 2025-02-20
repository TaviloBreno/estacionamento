<?php $this->load->view('layout/navbar'); ?>

<div class="page-wrap">
	<?php $this->load->view('layout/sidebar'); ?>

	<div class="main-content">
		<div class="container-fluid">
			<div class="page-header">
				<div class="row align-items-end">
					<div class="col-lg-8">
						<div class="page-header-title">
							<i class="ik ik-credit-card bg-blue"></i>
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
						<div class="card-header d-block">
							<a title="Cadastro de forma de pagamento" class="btn btn-success float-right" href="<?php echo base_url('formas/core'); ?>">+ Novo</a>
						</div>
						<div class="card-body">
							<table class="table data-table">
								<thead>
								<tr>
									<th>#</th>
									<th class="text-center">Nome</th>
									<th class="text-center">Ativo</th>
									<th class="text-center">Última Alteração</th>
									<th class="text-center">Ações</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach ($formas as $forma): ?>
									<tr>
										<td><?php echo $forma->forma_pagamento_id; ?></td>
										<td class="text-center"><?php echo $forma->forma_pagamento_nome; ?></td>
										<td class="text-center">
											<?php echo ($forma->forma_pagamento_ativa == 1 ? '<span class="badge badge-success">Sim</span>' : '<span class="badge badge-danger">Não</span>'); ?>
										</td>
										<td class="text-center"><?php echo date('d/m/Y H:i:s', strtotime($forma->forma_pagamento_data_alteracao)); ?></td>
										<td>
											<div class="table-actions text-center">
												<a href="<?php echo base_url('formas/core/'.$forma->forma_pagamento_id); ?>" class="btn btn-icon btn-primary" style="color: white;" data-toggle="tooltip" data-placement="top" title="Editar forma de pagamento">
													<i class="ik ik-edit"></i>
												</a>
												<button type="button" class="btn btn-icon btn-danger" data-toggle="modal" data-target="#forma-<?php echo $forma->forma_pagamento_id; ?>" title="Excluir forma de pagamento">
													<i class="ik ik-trash"></i>
												</button>
											</div>
										</td>
									</tr>

									<div class="modal fade" id="forma-<?php echo $forma->forma_pagamento_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalCenterLabel">
														<i class="fas fa-exclamation-triangle alert-warning"></i>
														Você tem certeza que deseja excluir a forma de pagamento <?php echo $forma->forma_pagamento_nome; ?>?
													</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
													<a href="<?php echo base_url($this->router->fetch_class().'/del/'.$forma->forma_pagamento_id); ?>" class="btn btn-primary" style="color: white;">Sim, excluir</a>
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
</div>
