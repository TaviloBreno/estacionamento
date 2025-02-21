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

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<?php echo (isset($mensalidade) ? "<i class='ik ik-calendar'></i> Última alteração: " . formata_data_banco_com_hora($mensalidade->mensalidade_data_alteracao) : ''); ?>
						</div>
						<div class="card-body">

							<form class="forms-sample" name="form_core" method="POST" action="<?php echo base_url('mensalidades/core/' . (isset($mensalidade) ? $mensalidade->mensalidade_id : '')); ?>">



								<?php if (isset($mensalidade)): ?>
									<input type="hidden" name="mensalidade_id" value="<?php echo $mensalidade->mensalidade_id; ?>">
								<?php endif; ?>

								<button type="submit" class="btn btn-primary mr-2">Salvar</button>
								<a href="<?php echo base_url('mensalidades'); ?>" class="btn btn-light">Voltar</a>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
