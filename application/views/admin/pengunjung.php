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
</div>
