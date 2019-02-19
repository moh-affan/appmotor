<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="row h-100">
		<div class="col-md-3 border-right">
			<div class="card-body">
				<h4 class="card-title"><span class="text-success fa fa-motorcycle"></span> Motor Baru</h4>
				<?= form_open('admin/master/motor', ['method' => 'POST', 'novalidate' => 'novalidate', 'id' => 'form-create']) ?>
				<fieldset>
					<div class="form-group">
						<label for="merek">Merek</label>
						<select class="form-control" name="merek" id="merek">
							<option value=""></option>
							<option value="Honda">Honda</option>
							<option value="Yamaha">Yamaha</option>
						</select>
					</div>
					<div class="form-group">
						<label for="tipe">Tipe</label>
						<input id="tipe" maxlength="100" class="form-control" name="tipe" type="text">
					</div>
					<div class="form-group">
						<label for="harga">Harga</label>
						<input id="harga" max="10000000000" class="form-control" name="harga" type="number">
						<span class="input-helper text-muted text-small"><sup>*)</sup>Dalam Rupiah</span>
					</div>
					<div class="form-group">
						<label for="tangki">Kapasitas Tangki BBM</label>
						<input id="tangki" max="10" class="form-control" name="tangki" type="number" step="0.1">
						<span class="input-helper text-muted text-small"><sup>*)</sup>Dalam Liter</span>
					</div>
					<div class="form-group">
						<label for="kecepatan">Kecepatan</label>
						<input id="kecepatan" max="240" class="form-control" name="kecepatan" type="number" step="0.1">
						<span class="input-helper text-muted text-small"><sup>*)</sup>Dalam Km/Jam</span>
					</div>
					<div class="form-group">
						<label for="transmisi">Tipe Transmisi</label>
						<select class="form-control" id="transmisi" name="transmisi">
							<option value=""></option>
							<option value="Manual, 4-kecepatan">Manual, 4-kecepatan</option>
							<option value="Manual, 5-kecepatan">Manual, 5-kecepatan</option>
							<option value="Manual, 6-kecepatan">Manual, 6-kecepatan</option>
							<option value="Otomatis, V-matic">Otomatis, V-matic</option>
						</select>
					</div>
					<div class="form-group">
						<label for="bagasi">Kapasitas Bagasi</label>
						<input id="bagasi" max="50" class="form-control" name="bagasi" type="number" step="0.1">
						<span class="input-helper text-muted text-small"><sup>*)</sup>Dalam Liter</span>
					</div>
					<div class="form-group">
						<label for="berat">Berat</label>
						<input id="berat" max="300" class="form-control" name="berat" type="number">
						<span class="input-helper text-muted text-small"><sup>*)</sup>Dalam Kilogram</span>
					</div>
					<div class="form-group">
						<label for="warna">Warna</label>
						<input id="warna" maxlength="100" class="form-control" name="warna" type="text">
						<span class="input-helper text-muted text-small"><sup>*)</sup>Warna sepeda motor, jika lebih dari satu, dipisah koma (cth: Merah, Putih)</span>
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
				<h4 class="card-title">Data Motor</h4>
				<div class="row">
					<div class="col-12 table-responsive">
						<table id="order-listing" class="datatable table">
							<thead>
							<tr>
								<th>#</th>
								<th>Merek</th>
								<th>Tipe</th>
								<th>Harga</th>
								<th>Tangki</th>
								<th>Kecepatan</th>
								<th>Tipe Transmisi</th>
								<th>Bagasi</th>
								<th>Berat</th>
								<th>Warna</th>
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
				<h5 class="modal-title">Edit Motor</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?= form_open('admin/master/motor', ['method' => 'POST', 'novalidate' => 'novalidate', 'id' => 'form-edit']) ?>
			<div class="modal-body">
				<div class="progress progress-md mb-5 edit-progress">
					<div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
						 role="progressbar"
						 style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<fieldset>
					<input type="hidden" name="edit" id="edit" value="0">
					<div class="form-group">
						<label for="e_merek">Merek</label>
						<select class="form-control" name="merek" id="e_merek">
							<option value=""></option>
							<option value="Honda">Honda</option>
							<option value="Yamaha">Yamaha</option>
						</select>
					</div>
					<div class="form-group">
						<label for="e_tipe">Tipe</label>
						<input id="e_tipe" maxlength="100" class="form-control" name="tipe" type="text">
					</div>
					<div class="form-group">
						<label for="e_harga">Harga</label>
						<input id="e_harga" max="10000000000" class="form-control" name="harga" type="number">
						<span class="input-helper text-muted text-small"><sup>*)</sup>Dalam Rupiah</span>
					</div>
					<div class="form-group">
						<label for="e_tangki">Kapasitas Tangki BBM</label>
						<input id="e_tangki" max="10" class="form-control" name="tangki" type="number" step="0.1">
						<span class="input-helper text-muted text-small"><sup>*)</sup>Dalam Liter</span>
					</div>
					<div class="form-group">
						<label for="e_kecepatan">Kecepatan</label>
						<input id="e_kecepatan" max="240" class="form-control" name="kecepatan" type="number"
							   step="0.1">
						<span class="input-helper text-muted text-small"><sup>*)</sup>Dalam Km/Jam</span>
					</div>
					<div class="form-group">
						<label for="e_transmisi">Tipe Transmisi</label>
						<select class="form-control" id="e_transmisi" name="transmisi">
							<option value=""></option>
							<option value="Manual, 4-kecepatan">Manual, 4-kecepatan</option>
							<option value="Manual, 5-kecepatan">Manual, 5-kecepatan</option>
							<option value="Manual, 6-kecepatan">Manual, 6-kecepatan</option>
							<option value="Otomatis, V-matic">Otomatis, V-matic</option>
						</select>
					</div>
					<div class="form-group">
						<label for="e_bagasi">Kapasitas Bagasi</label>
						<input id="e_bagasi" max="50" class="form-control" name="bagasi" type="number" step="0.1">
						<span class="input-helper text-muted text-small"><sup>*)</sup>Dalam Liter</span>
					</div>
					<div class="form-group">
						<label for="e_berat">Berat</label>
						<input id="e_berat" max="300" class="form-control" name="berat" type="number">
						<span class="input-helper text-muted text-small"><sup>*)</sup>Dalam Kilogram</span>
					</div>
					<div class="form-group">
						<label for="e_warna">Warna</label>
						<input id="e_warna" maxlength="100" class="form-control" name="warna" type="text">
						<span class="input-helper text-muted text-small"><sup>*)</sup>Warna sepeda motor, jika lebih dari satu, dipisah koma (cth: Merah, Putih)</span>
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
<?= form_open('admin/master/motor', ['method' => 'POST', 'id' => 'form-remove']) ?>
<input type="hidden" name="remove_id" id="remove_id">
<?= form_close() ?>
