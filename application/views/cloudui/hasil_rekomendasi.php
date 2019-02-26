<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="row">
		<div class="col-md-12">
			<div class="card-body">
				<h4 class="card-title">Hasil Rekomendasi</h4>
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
								<th class="d-none">Fire Strength</th>
							</tr>
							</thead>
							<tbody>
							<?php
//							krsort($tahani);
							$n = 1;
							foreach ($mixed as $d): /*if ($n > 5) break;*/ ?>
								<tr>
									<td><?= $n++ ?></td>
									<td><?= $d->merek ?></td>
									<td><?= $d->tipe ?></td>
									<td><?= $d->harga ?></td>
									<td><?= $d->tangki ?></td>
									<td><?= $d->kecepatan ?></td>
									<td><?= $d->transmisi ?></td>
									<td><?= $d->bagasi ?></td>
									<td><?= $d->berat ?></td>
									<td><?= $d->warna ?></td>
									<td class="d-none"><?= $d->nilai ?></td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
