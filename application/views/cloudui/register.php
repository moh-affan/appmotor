<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="APLIKASI SISTEM PEMILIHAN SEPEDA MOTOR">
	<title><?= isset($title) ? $title : 'Login' ?></title>
	<!-- plugins:css -->
	<link rel="stylesheet"
		  href="<?= site_url('assets/') ?>vendors/iconfonts/simple-line-icon/css/simple-line-icons.css">
	<link rel="stylesheet"
		  href="<?= site_url('assets/') ?>vendors/iconfonts/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet"
		  href="<?= site_url('assets/') ?>vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
	<link rel="stylesheet" href="<?= site_url('assets/') ?>vendors/css/vendor.bundle.base.css">
	<link rel="stylesheet" href="<?= site_url('assets/') ?>vendors/css/vendor.bundle.addons.css">
	<!-- endinject -->
	<!-- plugin css for this page -->
	<!-- End plugin css for this page -->
	<!-- inject:css -->
	<link rel="stylesheet" href="<?= site_url('assets/themes/cloudui/') ?>css/style.css">
	<!-- endinject -->
	<link rel="shortcut icon" href="<?= site_url('assets/themes/cloudui/images/sepeda.png') ?>"/>
</head>

<body>
<div class="container-scroller">
	<div class="container-fluid page-body-wrapper full-page-wrapper">
		<div class="content-wrapper auth p-0 theme-two">
			<div class="row d-flex align-items-stretch">
				<div class="col-md-4 banner-section d-none d-md-flex align-items-stretch justify-content-center">
					<div class="slide-content bg-1"
						 style="background: url('<?= site_url('assets/themes/cloudui/images/login_image.jpg') ?>');background-position: center">
					</div>
				</div>
				<div class="col-12 col-md-8 h-100 bg-white">
					<div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">
						<div class="nav-get-started">
							<p>Sudah punya akun?</p>
							<a class="btn get-started-btn" href="<?= site_url('auth/login') ?>">L O G I N</a>
						</div>
						<form autocomplete="off" novalidate="novalidate"></form>
						<?= form_open("auth/register", ['method' => 'POST', 'id' => 'form-create', 'autocomplete' => 'off', 'novalidate' => 'novalidate']); ?>
						<?php
						$redirect = @$_GET['redirect_to'];
						if (!empty($redirect))
							echo form_hidden('redirect_to', $redirect);
						?>
						<h3 class="mr-auto">Register</h3>
						<h4 class="mt-5 mr-auto text-primary">Silahkan isikan data Anda</h4>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-user"></i></span>
								</div>
								<input name="first_name" id="first_name" type="text" class="form-control"
									   placeholder="Nama">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-at"></i></span>
								</div>
								<input name="email" id="email" type="email" class="form-control"
									   placeholder="Email">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-phone"></i></span>
								</div>
								<input name="phone" id="phone" type="text" class="form-control"
									   placeholder="Phone">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-user"></i></span>
								</div>
								<input name="identity" id="identity" type="text" class="form-control"
									   placeholder="Username">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-lock"></i></span>
								</div>
								<input name="password" id="password" type="password" class="form-control"
									   placeholder="Password">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-lock"></i></span>
								</div>
								<input name="password_confirm" id="password_confirm" type="password"
									   class="form-control"
									   placeholder="Ulangi Password">
							</div>
						</div>
						<input type="hidden" name="last_name" value="">
						<input type="hidden" name="company" value="">

						<?php if (!empty($message)): ?>
							<div class="alert alert-warning alert-dismissible fade show" role="alert">
								<?= $message ?>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
						<?php endif; ?>
						<div class="form-group">
							<button type="submit" class="btn btn-primary submit-btn mt-2">D A F T A R</button>
						</div>
						<div class="wrapper mt-5 text-gray">
							<p class="footer-text">@<?= date('Y') ?> desy</p>
							<ul class="auth-footer text-gray d-none">
								<li><a href="#">Terms & Conditions</a></li>
								<li><a href="#">Cookie Policy</a></li>
							</ul>
						</div>
						<?= form_close() ?>
					</div>
				</div>
			</div>
		</div>
		<!-- content-wrapper ends -->
	</div>
	<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="<?= site_url('assets/') ?>vendors/js/vendor.bundle.base.js"></script>
<script src="<?= site_url('assets/') ?>vendors/js/vendor.bundle.addons.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="<?= site_url('assets/themes/cloudui/') ?>js/template.js"></script>
<script type="application/javascript">
	(function ($) {
		'use strict';
		$(function () {
			let formCreate = $('#form-create');
			$(document).ready(function () {
				let rules = {
					first_name: "required",
					identity: {
						required: true,
						minlength: 6
					},
					password: {
						required: true,
						minlength: 8
					},
					password_confirm: {
						required: true,
						minlength: 8,
						equalTo: "#password"
					},
					email: {
						required: true,
						email: true
					},
					phone: {
						required: true,
						minlength: 10,
						maxlength: 15,
						digits: true
					}
				};
				let errorMessage = {
					first_name: "Masukkan nama Anda",
					identity: {
						required: "Masukkan username",
						minlength: "Username minimal 6 karakter"
					},
					password: {
						required: "Masukkan password",
						minlength: "Password minimal 8 karakter"
					},
					password_confirm: {
						required: "Ulangi password",
						minlength: "Password minimal 8 karakter",
						equalTo: "Password tidak sama"
					},
					email: "Masukkan alamat email yang valid",
					phone: "Masukkan nomor hp yang valid",
				};

				let errPlacement = function (label, element) {
					label.addClass('mt-2 text-danger');
					label.insertAfter(element);
				};

				let valitaionHighlight = function (element, errorClass) {
					$(element).parent().addClass('has-danger');
					$(element).addClass('form-control-danger');
				};

				let validationUnhighlight = function (element, errorClass) {
					$(element).parent().removeClass('has-danger');
					$(element).removeClass('form-control-danger');
				};
				formCreate.validate({
					rules: rules,
					messages: errorMessage,
					errorPlacement: errPlacement,
					highlight: valitaionHighlight,
					unhighlight: validationUnhighlight
				});
			});
		})
	})(jQuery)
</script>
<!-- endinject -->
<!-- Custom js for this page-->
<!-- End custom js for this page-->
</body>

</html>
