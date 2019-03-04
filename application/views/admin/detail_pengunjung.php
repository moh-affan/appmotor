<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<h2 class="text-center"><?php echo $mamdani[0]['pengguna']?></h2>
<br>
<div class="card mb-5">
	<div class="row">
		<div class="col-md-12">
			<div class="card-body">
				<h4 class="card-title">Hasil Rekomendasi Mamdani</h4>
				<div class="row">
					<div class="col-12 table-responsive">
						<table id="order-listing" class="datatable table">
							<thead>
							<tr>
								<th>#</th>
								<th>Merek</th>
								<th>Tipe</th>
								<th>Defuzzifikasi</th>
								<th>Execution Time</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$n = 1;
							foreach ($mamdani as $d): /*if ($n > 5) break;*/
								$d = json_decode(json_encode($d)); ?>
								<tr>
									<td><?= $n++ ?></td>
									<td><?= $d->merek ?></td>
									<td><?= $d->tipe ?></td>
									<td><?= $d->nilai ?></td>
									<td><?= $d->exec_time ?> second</td>
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

<div class="card mb-5">
	<div class="row">
		<div class="col-md-12">
			<div class="card-body">
				<h4 class="card-title">Hasil Rekomendasi Tsukamoto</h4>
				<div class="row">
					<div class="col-12 table-responsive">
						<table id="order-listing" class="datatable table">
							<thead>
							<tr>
								<th>#</th>
								<th>Merek</th>
								<th>Tipe</th>
								<th>Defuzzifikasi</th>
								<th>Execution Time</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$n = 1;
							foreach ($tsukamoto as $d): /*if ($n > 5) break;*/
								$d = json_decode(json_encode($d)); ?>
								<tr>
									<td><?= $n++ ?></td>
									<td><?= $d->merek ?></td>
									<td><?= $d->tipe ?></td>
									<td><?= $d->nilai ?></td>
									<td><?= $d->exec_time ?> second</td>
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

<div class="card">
	<div class="row">
		<div class="col-md-12">
			<div class="card-body">
				<h4 class="card-title">Grafik Perbandingan Firestrength/Defuzzifikasi</h4>
				<div class="row">
					<div class="col-12">
						<canvas id="grafik"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
