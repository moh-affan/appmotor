<?php defined('BASEPATH') OR exit('No direct script access allowed');
$ci =& get_instance();
$pengguna = $ci->session->userdata('name');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description"
		  content="APLIKASI SISTEM PEMILIHAN SEPEDA MOTOR <?= isset($title) ? " - " . $title : '' ?>">
	<title><?= isset($title) ? $title : 'Beranda' ?></title>
	<link rel="stylesheet"
		  href="<?= site_url('assets/') ?>vendors/iconfonts/simple-line-icon/css/simple-line-icons.css">
	<link rel="stylesheet"
		  href="<?= site_url('assets/') ?>vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
	<link rel="stylesheet"
		  href="<?= site_url('assets/') ?>vendors/iconfonts/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= site_url('assets/') ?>vendors/css/vendor.bundle.base.css">
	<link rel="stylesheet" href="<?= site_url('assets/') ?>vendors/css/vendor.bundle.addons.css">
	<link rel="stylesheet" href="<?= site_url('assets/themes/cloudui/') ?>css/style.css">
	<?php if (isset($stylesheets) && count($stylesheets) > 0): ?>
		<?php foreach ($stylesheets as $style): ?>
			<link rel="stylesheet" href="<?= $style ?>">
		<?php endforeach; ?>
	<?php endif; ?>
	<?= @$inline_style ?>
	<link rel="shortcut icon" href="<?= site_url('assets/themes/cloudui/') ?>images/sepeda.png"/>
</head>

<body>
<div class="container-scroller">
	<nav class="navbar horizontal-layout col-lg-12 col-12 p-0">
		<div class="nav-top flex-grow-1">
			<div class="container d-flex flex-row h-100 align-items-center">
				<div class="text-center navbar-brand-wrapper d-flex align-items-center">
					<a class="navbar-brand brand-logo" href="<?= site_url() ?>"><img
							src="<?= site_url('assets/themes/cloudui/images/sepeda.png') ?>" alt="logo"/></a>
					<a class="navbar-brand brand-logo-mini" href="<?= site_url() ?>"><img
							src="<?= site_url('assets/themes/cloudui/images/sepeda.png') ?>" alt="logo"/></a>
				</div>
				<div class="navbar-menu-wrapper d-flex align-items-center justify-content-between flex-grow-1">
					<strong>Aplikasi</strong>&nbsp;<span class="text-success">SISTEM PEMILIHAN SEPEDA MOTOR</span>&nbsp;<i
						class="fa fa-motorcycle"></i>
					<ul class="navbar-nav navbar-nav-right mr-0 ml-auto">
						<li class="nav-item nav-profile dropdown">
							<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
								<img src="<?= site_url('assets/themes/cloudui/images/admin.jpg') ?>" alt="profile"/>
								<span class="nav-profile-name"><?= $pengguna ?></span>
							</a>
							<div class="dropdown-menu dropdown-menu-right navbar-dropdown"
								 aria-labelledby="profileDropdown">
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#ganti-password"
								   data-whatever="@getbootstrap">
									<i class="icon-key text-primary mr-2"></i>
									Ganti Password
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="<?= site_url('auth/logout') ?>">
									<i class="icon-logout text-primary mr-2"></i>
									Logout
								</a>
							</div>
						</li>
					</ul>
					<button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
						<span class="icon-menu text-dark"></span>
					</button>
				</div>
			</div>
		</div>
		<?php $this->load->view('theme/cloudui_nav') ?>
	</nav>

	<!-- partial -->
	<div class="container-fluid page-body-wrapper">
		<div class="main-panel">
			<div class="content-wrapper">
				<?= @$view_content ?>
			</div>
			<div class="modal fade" id="ganti-password" tabindex="-1" role="dialog"
				 aria-labelledby="exampleModalLabel-4" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Ubah Password</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<?= form_open(site_url('auth/change_password'), ['method' => 'POST', 'id' => 'change-password']) ?>
							<div class="form-group">
								<label for="old" class="col-form-label">Password lama:</label>
								<input type="password" name="old" class="form-control" id="old">
							</div>
							<div class="form-group">
								<label for="new" class="col-form-label">Password baru:</label>
								<input type="password" name="new" class="form-control" id="new">
							</div>
							<div class="form-group">
								<label for="confirm" class="col-form-label">Ulangi password:</label>
								<input type="password" name="confirm" class="form-control" id="confirm">
							</div>
							<?= form_close() ?>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-success" onclick="function submit() {
							  $('#change-password').submit()
							}">Simpan
							</button>
							<button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
						</div>
					</div>
				</div>
			</div>
			<footer class="footer">
				<div class="w-100 clearfix">
					<span class="text-muted d-block text-center text-sm-left d-sm-inline-block">@ <?= date('Y') ?> <a
							href="#">desy</a></span>
					<span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Dibuat dengan <i
							class="icon-heart text-danger"></i> untuk Anda</span>
				</div>
			</footer>
		</div>
	</div>
</div>
<script src="<?= site_url('assets/') ?>vendors/js/vendor.bundle.base.js"></script>
<script src="<?= site_url('assets/') ?>vendors/js/vendor.bundle.addons.js"></script>
<script src="<?= site_url('assets/themes/cloudui/') ?>js/template.js"></script>
<script type="application/javascript">
	$(document).ready(function () {
		$('.nav').find('.active').removeClass('active');
		$('.nav').find(".<?=$menu_active?>").parents('.nav-item').last().addClass('active');
		$('.nav').find(".<?=$menu_active?>").addClass("active");
	});
</script>
<?php if (isset($external_scripts) && count($external_scripts) > 0): ?>
	<?php foreach ($external_scripts as $script): ?>
		<script src="<?= $script ?>"></script>
	<?php endforeach; ?>
<?php endif; ?>
<?= $inline_script ?>
</body>
</html>
