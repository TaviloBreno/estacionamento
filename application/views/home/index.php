
	<?php $this->load->view('layout/navbar'); ?>

	<div class="page-wrap">

		<?php $this->load->view('layout/sidebar'); ?>

		<div class="main-content">
			<div class="container-fluid">

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



			</div>
		</div>

		<footer class="footer">
			<div class="w-100 clearfix">
				<span class="text-center text-sm-left d-md-inline-block">Copyright © <?php echo date('Y'); ?>. Todos os direitos reservados.</span>
				<span class="float-none float-sm-right mt-1 mt-sm-0 text-center">Customizado <i class="fa fa-code text-danger"></i> por <a href="#" class="text-dark" target="_blank">Breno</a></span>
			</div>
		</footer>

	</div>

