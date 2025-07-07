
	<?php $this->load->view('layout/navbar'); ?>

	<div class="page-wrap">

		<?php $this->load->view('layout/sidebar'); ?>

		<div class="main-content">
			<div class="container-fluid">

				<?php if($message = $this->session->flashdata('sucesso')): ?>
					<div class="alert bg-success alert-dismissible fade show text-white" role="alert">
						<strong><?php echo $message; ?></strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
				<?php endif; ?>

				<h2 class="mb-3">Bem-vindo ao Sistema</h2>
				<div class="row text-center mb-4">
					<div class="col-md-3 mb-3">
						<div class="card shadow-sm">
							<div class="card-body">
								<i class="fa fa-car fa-lg mb-1 text-primary"></i>
								<div>Vagas</div>
								<strong><?php echo isset($vagas_disponiveis) ? $vagas_disponiveis : '-'; ?></strong>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card shadow-sm">
							<div class="card-body">
								<i class="fa fa-users fa-lg mb-1 text-success"></i>
								<div>Clientes</div>
								<strong><?php echo isset($clientes_ativos) ? $clientes_ativos : '-'; ?></strong>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card shadow-sm">
							<div class="card-body">
								<i class="fa fa-money-bill fa-lg mb-1 text-warning"></i>
								<div>Faturamento</div>
								<strong>R$ <?php echo isset($faturamento_hoje) ? number_format($faturamento_hoje, 2, ',', '.') : '0,00'; ?></strong>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card shadow-sm">
							<div class="card-body">
								<i class="fa fa-clock fa-lg mb-1 text-info"></i>
								<div>Movimentações</div>
								<strong><?php echo isset($movimentacoes_hoje) ? $movimentacoes_hoje : '-'; ?></strong>
							</div>
						</div>
					</div>
				</div>

				<div class="row justify-content-center mb-4">
					<div class="btn-group" role="group" aria-label="Ações rápidas">
						<a href="<?php echo base_url('movimentacoes'); ?>" class="btn btn-primary btn-lg mx-1 mb-2 shadow-sm d-flex align-items-center">
							<i class="fa fa-plus mr-2"></i> Nova Movimentação
						</a>
						<a href="<?php echo base_url('relatorios'); ?>" class="btn btn-outline-secondary btn-lg mx-1 mb-2 shadow-sm d-flex align-items-center">
							<i class="fa fa-chart-bar mr-2"></i> Relatórios
						</a>
						<a href="<?php echo base_url('mensalistas'); ?>" class="btn btn-outline-info btn-lg mx-1 mb-2 shadow-sm d-flex align-items-center">
							<i class="fa fa-user mr-2"></i> Clientes
						</a>
						<a href="<?php echo base_url('estacionar'); ?>" class="btn btn-outline-dark btn-lg mx-1 mb-2 shadow-sm d-flex align-items-center">
							<i class="fa fa-car mr-2"></i> Veículos
						</a>
					</div>
				</div>
			</div>
		</div>

		<footer class="footer">
			<div class="w-100 clearfix">
				<span class="text-center text-sm-left d-md-inline-block">Copyright © <?php echo date('Y'); ?>. Todos os direitos reservados.</span>
				<span class="float-none float-sm-right mt-1 mt-sm-0 text-center">Customizado <i class="fa fa-code text-danger"></i> por <a href="#" class="text-dark" target="_blank">Breno</a></span>
			</div>
		</footer>

	</div>

