<?php if (!isset($is_login_page) || !$is_login_page): ?>
	<footer class="footer">
		<div class="w-100 clearfix">
			<span class="text-center text-sm-left d-md-inline-block">Copyright © <?php echo date('Y'); ?>. Todos os direitos reservados.</span>
			<span class="float-none float-sm-right mt-1 mt-sm-0 text-center">Customizado <i class="fa fa-code text-danger"></i> por <a href="#" class="text-dark" target="_blank">Breno</a></span>
		</div>
	</footer>
<?php endif; ?>

</div>

</div>

<div class="modal fade apps-modal" id="appsModal" tabindex="-1" role="dialog" aria-labelledby="appsModalLabel" aria-hidden="true" data-backdrop="false">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ik ik-x-circle"></i></button>
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="quick-search">
				<div class="container">
					<div class="row">
						<div class="col-md-4 ml-auto mr-auto">
							<div class="input-wrap">
								<input type="text" id="quick-search" class="form-control" placeholder="Search..." />
								<i class="ik ik-search"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-body d-flex align-items-center">
				<div class="container">
					<div class="apps-wrap">
						<div class="app-item">
							<a href="#"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
						</div>
						<div class="app-item dropdown">
							<a href="#" class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-command"></i><span>Ui</span></a>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else here</a>
							</div>
						</div>
						<div class="app-item">
							<a href="#"><i class="ik ik-mail"></i><span>Message</span></a>
						</div>
						<div class="app-item">
							<a href="#"><i class="ik ik-users"></i><span>Accounts</span></a>
						</div>
						<div class="app-item">
							<a href="#"><i class="ik ik-shopping-cart"></i><span>Sales</span></a>
						</div>
						<div class="app-item">
							<a href="#"><i class="ik ik-briefcase"></i><span>Purchase</span></a>
						</div>
						<div class="app-item">
							<a href="#"><i class="ik ik-server"></i><span>Menus</span></a>
						</div>
						<div class="app-item">
							<a href="#"><i class="ik ik-clipboard"></i><span>Pages</span></a>
						</div>
						<div class="app-item">
							<a href="#"><i class="ik ik-message-square"></i><span>Chats</span></a>
						</div>
						<div class="app-item">
							<a href="#"><i class="ik ik-map-pin"></i><span>Contacts</span></a>
						</div>
						<div class="app-item">
							<a href="#"><i class="ik ik-box"></i><span>Blocks</span></a>
						</div>
						<div class="app-item">
							<a href="#"><i class="ik ik-calendar"></i><span>Events</span></a>
						</div>
						<div class="app-item">
							<a href="#"><i class="ik ik-bell"></i><span>Notifications</span></a>
						</div>
						<div class="app-item">
							<a href="#"><i class="ik ik-pie-chart"></i><span>Reports</span></a>
						</div>
						<div class="app-item">
							<a href="#"><i class="ik ik-layers"></i><span>Tasks</span></a>
						</div>
						<div class="app-item">
							<a href="#"><i class="ik ik-edit"></i><span>Blogs</span></a>
						</div>
						<div class="app-item">
							<a href="#"><i class="ik ik-settings"></i><span>Settings</span></a>
						</div>
						<div class="app-item">
							<a href="#"><i class="ik ik-more-horizontal"></i><span>More</span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url('public/'); ?>src/js/vendor/modernizr-2.8.3.min.js"></script>
<script src="<?php echo base_url('public/'); ?>src/js/vendor/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url('public/'); ?>plugins/popper.js/dist/umd/popper.min.js"></script>
<script src="<?php echo base_url('public/'); ?>plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('public/'); ?>plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
<script src="<?php echo base_url('public/'); ?>plugins/screenfull/dist/screenfull.js"></script>

<!--<script src="<?php echo base_url('public/'); ?>plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('public/'); ?>plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url('public/'); ?>plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url('public/'); ?>plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url('public/'); ?>plugins/jvectormap/jquery-jvectormap.min.js"></script>
<script src="<?php echo base_url('public/'); ?>plugins/jvectormap/tests/assets/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo base_url('public/'); ?>plugins/moment/moment.js"></script>
<script src="<?php echo base_url('public/'); ?>plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?php echo base_url('public/'); ?>plugins/d3/dist/d3.min.js"></script>
<script src="<?php echo base_url('public/'); ?>plugins/c3/c3.min.js"></script>
<script src="<?php echo base_url('public/'); ?>js/tables.js"></script>
<script src="<?php echo base_url('public/'); ?>js/widgets.js"></script>
<script src="<?php echo base_url('public/'); ?>js/charts.js"></script>-->

<script src="<?php echo base_url('public/'); ?>dist/js/theme.min.js"></script>
<?php if (isset($scripts)): ?>
	<?php foreach ($scripts as $script): ?>
		<script src="<?php echo base_url('public/'); ?>plugins/<?php echo $script; ?>"></script>
	<?php endforeach; ?>
<?php endif; ?>
</body>
</html>
