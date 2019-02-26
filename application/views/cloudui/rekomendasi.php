<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-6 grid-margin stretch-card mx-auto">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Rekomendasi Pencarian Sepeda Motor</h4>
				<ul class="bullet-line-list">
					<li>
						<h6><span class="fa fa-question-circle text-primary"></span></h6>
						<p class="mb-0">Pada menu halaman ini, pengguna diminta untuk memilih kriteria sesuai
							dengan yang diinginkan, yang nantinya sistem akan menampilkan hasil rekomendasi sepeda
							motor.</p>
						<p class="text-muted">&nbsp;</p>
					</li>
				</ul>
				<?= form_open('rekomendasi/result', ['method' => 'POST', 'id' => 'form_rekomendasi', 'novalidate' => 'novalidate']) ?>
				<fieldset>
					<div class="form-group row">
						<label class="col-md-4">Merek</label>
						<div class="col-md-8">
							<div class="btn-group btn-group-toggle btn-group-justified " data-toggle="buttons">
								<label class="btn btn-primary active">
									<input type="radio" name="merk" id="option1" autocomplete="off" checked=""
										   value="merek_yamaha"> Yamaha
								</label>
								<label class="btn btn-primary">
									<input type="radio" name="merk" id="option2" autocomplete="off" value="merek_honda">
									Honda
								</label>
							</div>
						</div>
						<br><br>
						<label class="col-md-4">Harga</label>
						<div class="col-md-8">
							<select class="form-control" name="price" required="" aria-label="Harga">
								<option disabled="disabled" selected="selected" value="">Silahkan Pilih</option>
								<option value="harga_max">Mahal ( >= Rp. 48.000.000,00 )</option>
								<option value="harga_mid">Sedang ( Rp. 24.000.000,00 - Rp. 72.000.000,00 )</option>
								<option value="harga_min">Murah ( <= Rp. 48.000.000,00 )</option>
							</select>
						</div>
						<br><br>
						<label class="col-md-4">Kapasitas BBM</label>
						<div class="col-md-8">
							<select class="form-control" name="tank" required="" aria-label="Kapasitas BBM">
								<option disabled="disabled" selected="selected" value="">Silahkan Pilih</option>
								<option value="tangki_max">Besar ( >= 9 Liter )</option>
								<option value="tangki_mid">Sedang ( 4 Liter - 14.5 Liter )</option>
								<option value="tangki_min">Kecil ( <= 9 Liter )</option>
							</select>
						</div>
						<br><br>
						<label class="col-md-4">Kecepatan Mesin</label>
						<div class="col-md-8">
							<select class="form-control" name="speed" required="" aria-label="Kecepatan Mesin">
								<option disabled="disabled" selected="selected" value="">Silahkan Pilih</option>
								<option value="kecepatan_max">Cepat ( >= 166 cc )</option>
								<option value="kecepatan_mid">Sedang ( 83 cc - 250 cc )</option>
								<option value="kecepatan_min">Lambat ( <= 166 cc )</option>
							</select>
						</div>
						<br><br>
						<label class="col-md-4">Tipe Transmisi</label>
						<div class="col-md-8">
							<div class="btn-group btn-group-toggle btn-group-justified " data-toggle="buttons">
								<label class="btn btn-primary ">
									<input type="radio" name="transmition" id="option1" autocomplete="off"
										   value="tipetransmisi_manual"> Manual
								</label>
								<label class="btn btn-primary active">
									<input type="radio" name="transmition" id="option2" autocomplete="off"
										   checked="" value="tipetransmisi_matic"> Matic
								</label>
							</div>
						</div>
						<br><br>
						<label class="col-md-4">Kapasitas Bagasi</label>
						<div class="col-md-8">
							<select class="form-control" name="luggage" required="" aria-label="Kapasitas Bagasi">
								<option disabled="disabled" selected="selected" value="">Silahkan Pilih</option>
								<option value="bagasi_max">Luas ( >= 16.6 Liter )</option>
								<option value="bagasi_mid">Sedang ( 8.3 Liter - 25 Liter )</option>
								<option value="bagasi_min">Sempit ( <= 16.6 Liter )</option>
							</select>
						</div>
						<br><br>
						<label class="col-md-4">Berat</label>
						<div class="col-md-8">
							<select class="form-control" name="weight" required="" aria-label="Berat">
								<option disabled="disabled" selected="selected" value="">Silahkan Pilih</option>
								<option value="berat_max">Berat ( >= 112 Kg )</option>
								<option value="berat_mid">Sedang ( 56 Kg - 168 Kg )</option>
								<option value="berat_min">Ringan ( <= 112 Kg )</option>
							</select>
						</div>
						<br><br>
						<label class="col-md-4">Warna</label>
						<div class="col-md-8">
							<select class="form-control" name="color" required="" aria-label="Warna">
								<option disabled="disabled" selected="selected" value="">Silahkan Pilih</option>
								<option value="warna_abu-abu">Abu-abu</option>
								<option value="warna_biru">Biru</option>
								<option value="warna_coklat">Coklat</option>
								<option value="warna_hitam">Hitam</option>
								<option value="warna_merah">Merah</option>
								<option value="warna_ungu">Ungu</option>
								<option value="warna_orange">Orange</option>
								<option value="warna_kuning">Kuning</option>
								<option value="warna_hijau">Hijau</option>
								<option value="warna_putih">Putih</option>
								<option value="warna_pink">Pink</option>
								<option value="warna_toska">Toska</option>
							</select>
						</div>
						<br><br><br>
						<div class="col-md-5 mx-auto">
							<input class="btn btn-success btn-block" type="submit" value="CARI">
						</div>
						<br><br>
					</div>
				</fieldset>
				<?= form_close() ?>
			</div>
		</div>
	</div>
</div>
