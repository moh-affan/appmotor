<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="row h-100">
		<div class="col-md-3 border-right">
			<div class="card-body">
				<h4 class="card-title"><span class="text-success fa fa-users"></span> Grup Baru</h4>
				<?= form_open('admin/pengguna/grup', ['method' => 'POST', 'novalidate' => 'novalidate', 'id' => 'form-create']) ?>
				<fieldset>
					<div class="form-group">
						<label for="group_name">Nama</label>
						<input id="group_name" maxlength="25" class="form-control" name="group_name" type="text">
					</div>
					<div class="form-group">
						<label for="description">Deskripsi</label>
						<input id="description" maxlength="100" class="form-control" name="description" type="text">
					</div>
					<div class="progress progress-md mb-1 create-progress d-none animated">
						<div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
							 role="progressbar"
							 style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					<button class="btn btn-primary" type="submit" value="1"><span class="fa fa-save"></span>&nbsp;
						Simpan
					</button>
				</fieldset>
				<?= form_close() ?>
			</div>
		</div>
		<div class="col-md-9">
			<div class="card-body">
				<h4 class="card-title">Data Grup Pengguna</h4>
				<div class="row">
					<div class="col-12 table-responsive">
						<table id="order-listing" class="datatable table">
							<thead>
							<tr>
								<th>#</th>
								<th>Nama</th>
								<th>Deskripsi</th>
								<th class="hidden-print">Actions</th>
							</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog"
	 aria-labelledby="exampleModalLabel-4" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Grup</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?= form_open('admin/pengguna/grup', ['method' => 'POST', 'novalidate' => 'novalidate', 'id' => 'form-edit']) ?>
			<div class="modal-body">
				<div class="progress progress-md mb-5 edit-progress">
					<div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
						 role="progressbar"
						 style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<fieldset>
					<input type="hidden" name="edit" id="edit" value="0">
					<div class="form-group">
						<label for="e_group_name">Nama</label>
						<input id="e_group_name" maxlength="25" class="form-control" name="group_name" type="text">
					</div>
					<div class="form-group">
						<label for="e_description">Deskripsi</label>
						<input id="e_description" maxlength="100" class="form-control" name="description"
							   type="text">
					</div>
				</fieldset>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" type="submit" value="1"><span class="fa fa-save"></span>&nbsp;
					Simpan
				</button>
				<button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>
<?= form_open('admin/pengguna/grup', ['method' => 'POST', 'id' => 'form-remove']) ?>
<input type="hidden" name="remove_id" id="remove_id">
<?= form_close() ?>
