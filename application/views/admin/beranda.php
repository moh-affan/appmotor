<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="alert alert-fill-success" role="alert">
					<i class="icon-exclamation"></i>
					SELAMAT DATANG <?= get_instance()->session->userdata('name'); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h2 class="text-center text-primary">Aplikasi Sistem Pemilihan Sepeda Motor</h2>
				<h4 class="text-center">HENI DESY PURNAMI</h4>
				<h3 class="text-center text-success">14.04.1.1.1.00042</h3>
				<img class="mx-auto d-block" src="<?= site_url('assets/themes/cloudui/images/sepeda.png') ?>"
					 alt="logo"/>
			</div>
		</div>
	</div>
</div>
