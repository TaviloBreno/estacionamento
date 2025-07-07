<?php $this->load->view('layout/navbar'); ?>

<div class="page-wrap">
	<?php $this->load->view('layout/sidebar'); ?>

	<div class="main-content">
		<div class="container-fluid">
			<div class="page-header">
				<div class="row align-items-end">
					<div class="col-lg-8">
						<div class="page-header-title">
							<i class="fas fa-file-invoice-dollar bg-blue"></i>
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
							<a title="Cadastrar nova mensalidade" class="btn btn-success float-right"
							   href="<?php echo base_url('estacionar/core'); ?>">+ Novo</a>
						</div>
						<div class="card-body">
							<table class="table data-table">
								<thead>
								<tr>
									<th>#</th>
									<th class="text-center">Categoria</th>
									<th class="text-center">Valor da Hora</th>
									<th class="text-center">Placa do Veículo</th>
									<th class="text-center">Forma de Pagamento</th>
									<th class="text-center">Status</th>
									<th class="text-center">Ações</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach ($estacionados as $estacionado): ?>
									<tr>
										<td><?php echo $estacionado->estacionar_id; ?></td>
										<td class="text-center"><?php echo $estacionado->precificacao_categoria; ?></td>
										<td class="text-center"><?php echo number_format($estacionado->precificacao_valor_hora, 2, ',', '.'); ?></td>
										<td class="text-center"><?php echo $estacionado->estacionar_placa_veiculo; ?></td>
										<td class="text-center"><?php echo $estacionado->forma_pagamento_nome; ?></td>
										<td class="text-center">
											<?php echo($estacionado->estacionar_status == 0 ? '<span class="badge badge-warning">Em aberto</span>' : '<span class="badge badge-success">Fechado</span>'); ?>
										</td>
										<td>
											<div class="table-actions text-center">
												<a href="<?php echo base_url($this->router->fetch_class() . '/core/' . $estacionado->estacionar_id); ?>"
												   class="btn btn-icon btn-primary" style="color: white;"
												   data-toggle="tooltip" data-placement="top" title="Editar ticket">
													<i class="ik ik-edit"></i>
												</a>
												<button type="button" class="btn btn-icon btn-danger"
														data-toggle="modal"
														data-target="#estacionado-<?php echo $estacionado->estacionar_id; ?>"
														title="Excluir ticket">
													<i class="ik ik-trash"></i>
												</button>
												<a href="<?php echo base_url($this->router->fetch_class() . '/acoes/' . $estacionado->estacionar_id); ?>"
												   class="btn btn-icon btn-success" style="color: white;"
												   data-toggle="tooltip" data-placement="top" title="Ações no ticket">
													<i class="ik ik-check-circle"></i>
												</a>
											</div>
										</td>
									</tr>

									<div class="modal fade" id="estacionado-<?php echo $estacionado->estacionar_id; ?>"
										 tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel"
										 aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalCenterLabel">
														<i class="fas fa-exclamation-triangle alert-warning"></i>
														Você tem certeza que deseja excluir esta mensalidade?
													</h5>
													<button type="button" class="close" data-dismiss="modal"
															aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary"
															data-dismiss="modal">Não
													</button>
													<a href="<?php echo base_url($this->router->fetch_class() . '/del/' . $estacionado->estacionar_id); ?>"
													   class="btn btn-primary" style="color: white;">Sim, excluir</a>
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

		<div class="row">
			<div class="col-md-12">
				<div class="card-header d-block text-center text-uppercase">Situação Vagas</div>
				<div class="card-body">
					<div class="row g-4">

						<!-- VEÍCULO PEQUENO -->
						<?php
						$ocupadas_pequeno = array_column($vagas_ocupadas_pequeno, 'estacionar_numero_vaga');
						$placas_pequeno = [];
						foreach ($vagas_ocupadas_pequeno as $vaga) {
							$placas_pequeno[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo;
						}
						?>
						<div class="col-md-4">
							<p class="text-center text-uppercase fw-bold">Veículo Pequeno</p>
							<div class="widget social-widget text-center">
								<i class="fas fa-car fa-3x text-primary mb-2"></i>
								<ul class="list-inline mt-3">
									<?php if (isset($numero_vagas_pequeno) && is_object($numero_vagas_pequeno)): ?>
										<?php for ($i = 1; $i <= $numero_vagas_pequeno->vagas; $i++): ?>
											<li class="list-inline-item">
												<?php
												$ocupada = in_array($i, $ocupadas_pequeno);
												$classe = $ocupada ? 'bg-danger text-white' : 'bg-success';
												$title = $ocupada ? $placas_pequeno[$i] : 'Livre';
												?>
												<div class="widget social-widget vaga <?php echo $classe; ?>"
													 title="<?php echo $title; ?>">
													<div class="widget-body text-center">
														<div class="content">
															<div
																class="number"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></div>
														</div>
													</div>
												</div>
											</li>
										<?php endfor; ?>
									<?php else: ?>
										<p class="text-danger text-center">Nenhuma vaga cadastrada para veículos
											pequenos.</p>
									<?php endif; ?>
								</ul>
							</div>
						</div>

						<!-- VEÍCULO MÉDIO -->
						<?php
						$ocupadas_medio = array_column($vagas_ocupadas_medio, 'estacionar_numero_vaga');
						$placas_medio = [];
						foreach ($vagas_ocupadas_medio as $vaga) {
							$placas_medio[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo;
						}
						?>
						<div class="col-md-4">
							<p class="text-center text-uppercase fw-bold">Veículo Médio</p>
							<div class="widget social-widget text-center">
								<i class="fas fa-truck-pickup fa-3x text-info mb-2"></i>
								<ul class="list-inline mt-3">
									<?php if (isset($numero_vagas_medio) && is_object($numero_vagas_medio)): ?>
										<?php for ($i = 1; $i <= $numero_vagas_medio->vagas; $i++): ?>
											<li class="list-inline-item">
												<?php
												$ocupada = in_array($i, $ocupadas_medio);
												$classe = $ocupada ? 'bg-danger text-white' : 'bg-success';
												$title = $ocupada ? $placas_medio[$i] : 'Livre';
												?>
												<div class="widget social-widget vaga <?php echo $classe; ?>"
													 title="<?php echo $title; ?>">
													<div class="widget-body text-center">
														<div class="content">
															<div
																class="number"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></div>
														</div>
													</div>
												</div>
											</li>
										<?php endfor; ?>
									<?php else: ?>
										<p class="text-danger text-center">Nenhuma vaga cadastrada para veículos
											médios.</p>
									<?php endif; ?>
								</ul>
							</div>
						</div>

						<!-- VEÍCULO GRANDE -->
						<?php
						$ocupadas_grande = array_column($vagas_ocupadas_grande, 'estacionar_numero_vaga');
						$placas_grande = [];
						foreach ($vagas_ocupadas_grande as $vaga) {
							$placas_grande[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo;
						}
						?>
						<div class="col-md-4">
							<p class="text-center text-uppercase fw-bold">Veículo Grande</p>
							<div class="widget social-widget text-center">
								<i class="fas fa-truck-moving fa-3x text-danger mb-2"></i>
								<ul class="list-inline mt-3">
									<?php if (isset($numero_vagas_grande) && is_object($numero_vagas_grande)): ?>
										<?php for ($i = 1; $i <= $numero_vagas_grande->vagas; $i++): ?>
											<li class="list-inline-item">
												<?php
												$ocupada = in_array($i, $ocupadas_grande);
												$classe = $ocupada ? 'bg-danger text-white' : 'bg-success';
												$title = $ocupada ? $placas_grande[$i] : 'Livre';
												?>
												<div class="widget social-widget vaga <?php echo $classe; ?>"
													 title="<?php echo $title; ?>">
													<div class="widget-body text-center">
														<div class="content">
															<div
																class="number"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></div>
														</div>
													</div>
												</div>
											</li>
										<?php endfor; ?>
									<?php else: ?>
										<p class="text-danger text-center">Nenhuma vaga cadastrada para veículos
											grandes.</p>
									<?php endif; ?>
								</ul>
							</div>
						</div>

						<!-- MOTO -->
						<?php
						$ocupadas_moto = array_column($vagas_ocupadas_moto, 'estacionar_numero_vaga');
						$placas_moto = [];
						foreach ($vagas_ocupadas_moto as $vaga) {
							$placas_moto[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo;
						}
						?>
						<div class="col-md-4">
							<p class="text-center text-uppercase fw-bold">Moto</p>
							<div class="widget social-widget text-center">
								<i class="fas fa-motorcycle fa-3x text-dark mb-2"></i>
								<ul class="list-inline mt-3">
									<?php if (isset($numero_vagas_moto) && is_object($numero_vagas_moto)): ?>
										<?php for ($i = 1; $i <= $numero_vagas_moto->vagas; $i++): ?>
											<li class="list-inline-item">
												<?php
												$ocupada = in_array($i, $ocupadas_moto);
												$classe = $ocupada ? 'bg-danger text-white' : 'bg-success';
												$title = $ocupada ? $placas_moto[$i] : 'Livre';
												?>
												<div class="widget social-widget vaga <?php echo $classe; ?>"
													 title="<?php echo $title; ?>">
													<div class="widget-body text-center">
														<div class="content">
															<div
																class="number"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></div>
														</div>
													</div>
												</div>
											</li>
										<?php endfor; ?>
									<?php else: ?>
										<p class="text-danger text-center">Nenhuma vaga cadastrada para motos.</p>
									<?php endif; ?>
								</ul>
							</div>
						</div>

						<!-- BICICLETA -->
						<?php
						$ocupadas_bicicleta = array_column($vagas_ocupadas_bicicleta, 'estacionar_numero_vaga');
						$placas_bicicleta = [];
						foreach ($vagas_ocupadas_bicicleta as $vaga) {
							$placas_bicicleta[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo;
						}
						?>
						<div class="col-md-4">
							<p class="text-center text-uppercase fw-bold">Bicicleta</p>
							<div class="widget social-widget text-center">
								<i class="fas fa-bicycle fa-3x text-dark mb-2"></i>
								<ul class="list-inline mt-3">
									<?php if (isset($numero_vagas_bicicleta) && is_object($numero_vagas_bicicleta)): ?>
										<?php for ($i = 1; $i <= $numero_vagas_bicicleta->vagas; $i++): ?>
											<li class="list-inline-item">
												<?php
												$ocupada = in_array($i, $ocupadas_bicicleta);
												$classe = $ocupada ? 'bg-danger text-white' : 'bg-success';
												$title = $ocupada ? $placas_bicicleta[$i] : 'Livre';
												?>
												<div class="widget social-widget vaga <?php echo $classe; ?>"
													 title="<?php echo $title; ?>">
													<div class="widget-body text-center">
														<div class="content">
															<div
																class="number"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></div>
														</div>
													</div>
												</div>
											</li>
										<?php endfor; ?>
									<?php else: ?>
										<p class="text-danger text-center">Nenhuma vaga cadastrada para bicicletas.</p>
									<?php endif; ?>
								</ul>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

	</div>
</div>
