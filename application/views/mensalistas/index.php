<?php $this->load->view('layout/navbar'); ?>

<div class="page-wrap">
	<?php $this->load->view('layout/sidebar'); ?>

	<div class="main-content">
		<div class="container-fluid">
			<div class="page-header">
				<div class="row align-items-end">
					<div class="col-lg-8">
						<div class="page-header-title">
							<i class="fas fa-user-tie bg-blue"></i>
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

			<?php if ($message = $this->session->flashdata('sucesso')): ?>
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

			<?php if ($message = $this->session->flashdata('error')): ?>
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
							<a title="Cadastrar novo mensalista" class="btn btn-success float-right" href="<?php echo base_url('mensalistas/core'); ?>">+ Novo</a>
						</div>
						<div class="card-body">
							<table class="table data-table">
								<thead>
								<tr>
									<th>#</th>
									<th class="text-center">Nome Completo</th>
									<th class="text-center">CPF</th>
									<th class="text-center">Telefone</th>
									<th class="text-center">Status</th>
									<th class="text-center">Última Alteração</th>
									<th class="text-center">Ações</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach ($mensalistas as $mensalista): ?>
									<tr>
										<td><?php echo $mensalista->mensalista_id; ?></td>
										<td class="text-center"><?php echo $mensalista->mensalista_nome . ' ' . $mensalista->mensalista_sobrenome; ?></td>
										<td class="text-center"><?php echo $mensalista->mensalista_cpf; ?></td>
										<td class="text-center"><?php echo $mensalista->mensalista_telefone_movel; ?></td>
										<td class="text-center">
											<?php echo ($mensalista->mensalista_ativo == 1 ? '<span class="badge badge-success">Ativo</span>' : '<span class="badge badge-danger">Inativo</span>'); ?>
										</td>
										<td class="text-center"><?php echo formata_data_banco_com_hora($mensalista->mensalista_data_alteracao); ?></td>
										<td>
											<div class="table-actions text-center">
												<a href="<?php echo base_url('mensalistas/core/'.$mensalista->mensalista_id); ?>" class="btn btn-icon btn-primary" style="color: white;" data-toggle="tooltip" data-placement="top" title="Editar mensalista">
													<i class="ik ik-edit"></i>
												</a>
												<button type="button" class="btn btn-icon btn-danger" data-toggle="modal" data-target="#mensalista-<?php echo $mensalista->mensalista_id; ?>" title="Excluir mensalista">
													<i class="ik ik-trash"></i>
												</button>
											</div>
										</td>
									</tr>

									<div class="modal fade" id="mensalista-<?php echo $mensalista->mensalista_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalCenterLabel">
														<i class="fas fa-exclamation-triangle alert-warning"></i>
														Você tem certeza que deseja excluir o mensalista <?php echo $mensalista->mensalista_nome . ' ' . $mensalista->mensalista_sobrenome; ?>?
													</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
													<a href="<?php echo base_url($this->router->fetch_class().'/del/'.$mensalista->mensalista_id); ?>" class="btn btn-primary" style="color: white;">Sim, excluir</a>
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
