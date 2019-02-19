<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="row h-100">
		<div class="col-md-3 border-right">
			<div class="card-body">
				<h4 class="card-title"><span class="text-success fa fa-bookmark-o"></span> Variabel Baru</h4>
				<?= form_open('admin/master/variabel', ['method' => 'POST', 'novalidate' => 'novalidate', 'id' => 'form-create']) ?>
				<fieldset>
					<div class="form-group">
						<label for="variabel">Variabel</label>
						<input class="form-control" name="variabel" id="variabel" type="text" maxlength="20">
					</div>
					<div class="form-group">
						<label>Rang Nilai Minimum</label>
						<div class="input-group">
							<input type="number" class="form-control" id="min_min" aria-label="min min">
							<div class="input-group-prepend">
								<span class="input-group-text">:</span>
							</div>
							<input type="number" class="form-control" id="min_max" aria-label="min max">
						</div>
					</div>
					<div class="form-group">
						<label>Rang Nilai Maximum</label>
						<div class="input-group">
							<input type="number" class="form-control" id="max_min" aria-label="max min">
							<div class="input-group-prepend">
								<span class="input-group-text">:</span>
							</div>
							<input type="number" class="form-control" id="max_max" aria-label="max max">
						</div>
					</div>
					<div class="form-group">
						<label for="tabel">Tabel</label>
						<input id="tabel" maxlength="100" class="form-control" name="tabel" type="text">
						<span class="input-helper text-muted text-small"><sup>*)</sup>Tabel yang akan digunakan</span>
					</div>
					<div class="form-group">
						<label for="field">Field</label>
						<input id="field" maxlength="100" class="form-control" name="field" type="text">
						<span class="input-helper text-muted text-small"><sup>*)</sup>Field dalam tabel yang berhubungan dengan variabel ini</span>
					</div>
					<input type="hidden" name="min" id="min">
					<input type="hidden" name="max" id="max">
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
				<h4 class="card-title">Data Variabel</h4>
				<div class="row">
					<div class="col-12 table-responsive">
						<table id="order-listing" class="datatable table">
							<thead>
							<tr>
								<th>#</th>
								<th>Variabel</th>
								<th>Range Nilai Min</th>
								<th>Range Nilai Max</th>
								<th>Tabel</th>
								<th>Field</th>
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
				<h5 class="modal-title">Edit Variabel</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?= form_open('admin/master/variabel', ['method' => 'POST', 'novalidate' => 'novalidate', 'id' => 'form-edit']) ?>
			<div class="modal-body">
				<div class="progress progress-md mb-5 edit-progress">
					<div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
						 role="progressbar"
						 style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<fieldset>
					<input type="hidden" name="edit" id="edit" value="0">
					<div class="form-group">
						<label for="e_variabel">Variabel</label>
						<input class="form-control" name="variabel" id="e_variabel" type="text" maxlength="20">
					</div>
					<div class="form-group">
						<label>Rang Nilai Minimum</label>
						<div class="input-group">
							<input type="number" class="form-control" id="e_min_min" aria-label="min min">
							<div class="input-group-prepend">
								<span class="input-group-text">:</span>
							</div>
							<input type="number" class="form-control" id="e_min_max" aria-label="min max">
						</div>
					</div>
					<div class="form-group">
						<label>Rang Nilai Maximum</label>
						<div class="input-group">
							<input type="number" class="form-control" id="e_max_min" aria-label="max min">
							<div class="input-group-prepend">
								<span class="input-group-text">:</span>
							</div>
							<input type="number" class="form-control" id="e_max_max" aria-label="max max">
						</div>
					</div>
					<div class="form-group">
						<label for="e_tabel">Tabel</label>
						<input id="e_tabel" maxlength="100" class="form-control" name="tabel" type="text">
						<span class="input-helper text-muted text-small"><sup>*)</sup>Tabel yang akan digunakan</span>
					</div>
					<div class="form-group">
						<label for="e_field">Field</label>
						<input id="e_field" maxlength="100" class="form-control" name="field" type="text">
						<span class="input-helper text-muted text-small"><sup>*)</sup>Field dalam tabel yang berhubungan dengan variabel ini</span>
					</div>
					<input type="hidden" name="min" id="e_min">
					<input type="hidden" name="max" id="e_max">
					<div class="progress progress-md mb-1 create-progress d-none animated">
						<div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
							 role="progressbar"
							 style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
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
<?= form_open('admin/master/variabel', ['method' => 'POST', 'id' => 'form-remove']) ?>
<input type="hidden" name="remove_id" id="remove_id">
<?= form_close() ?>
