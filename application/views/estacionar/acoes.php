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
									<a title="Home" href="<?php echo base_url('/'); ?>"><i class="ik ik-home"></i></a>
								</li>
								<li class="breadcrumb-item">
									<a title="Listar Mensalidades" href="<?php echo base_url('mensalidades'); ?>">
										Listar Mensalidades
									</a>
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
				<!-- imprestion, goal, impect start -->
				<div class="col-xl-4 col-md-12">
					<div class="card comp-card">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col">
									<h6 class="mb-25">Impressão do ticket</h6>
									<a class="btn btn-primary text-white" target="_blank" href="<?php echo base_url($this->router->fetch_class()."/pdf/".$estacionado->estacionar_id); ?>">Imprimir</a>
								</div>
								<div class="col-auto">
									<i class="fas fa-print bg-blue"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-md-6">
					<div class="card comp-card">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col">
									<h6 class="mb-25">Listar Tickets</h6>
									<a class="btn bg-green text-white" href="<?php echo base_url('estacionar'); ?>">Listar</a>
								</div>
								<div class="col-auto">
									<i class="fas fa-list bg-green"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-md-6">
					<div class="card comp-card">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col">
									<h6 class="mb-25">Novo Ticket</h6>
									<a class="btn bg-yellow text-white" href="<?php echo base_url('estacionar/core'); ?>">Novo</a>
								</div>
								<div class="col-auto">
									<i class="fas fa-newspaper bg-yellow"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
