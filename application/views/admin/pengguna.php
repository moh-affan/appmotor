<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="row h-100">
		<div class="col-md-3 border-right">
			<div class="card-body">
				<h4 class="card-title"><span class="text-success fa fa-user-plus"></span> Pengguna Baru</h4>
				<?= form_open('', ['method' => 'POST', 'novalidate' => 'novalidate', 'id' => 'form-create']) ?>
				<fieldset>
					<div class="form-group">
						<label for="firstname">Nama</label>
						<input id="firstname" maxlength="25" class="form-control" name="first_name" type="text">
					</div>
					<div class="form-group">
						<label for="username">Username</label>
						<input id="username" maxlength="20" class="form-control" name="identity" type="text">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input id="password" maxlength="20" class="form-control" name="password" type="password">
					</div>
					<div class="form-group">
						<label for="confirm_password">Confirm password</label>
						<input id="confirm_password" class="form-control" name="confirm_password" type="password">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input id="email" maxlength="40" class="form-control" name="email" type="email">
					</div>
					<div class="form-group">
						<label for="phone">No. Handphone</label>
						<input id="phone" maxlength="15" class="form-control" name="phone" type="tel">
					</div>
					<div class="form-group">
						<label>Grup Pengguna</label>
						<?php foreach ($groups as $group): ?>
							<div class="form-check">
								<label class="form-check-label">
									<?php
									$gID = $group['id'];
									$checked = null;
									$item = null;
									?>
									<input type="checkbox" class="form-check-input" name="groups[]"
										   value="<?php echo $group['id']; ?>">
									<?php echo htmlspecialchars($group['description'], ENT_QUOTES, 'UTF-8') . " [" . htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8') . "]"; ?>
									<i class="input-helper"></i></label>
							</div>
						<?php endforeach ?>
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
				<h4 class="card-title">Data Pengguna</h4>
				<div class="row">
					<div class="col-12 table-responsive">
						<table id="order-listing" class="datatable table">
							<thead>
							<tr>
								<th>#</th>
								<th>Nama</th>
								<th>Email</th>
								<th>No. Handphone</th>
								<th>Username</th>
								<th>Status</th>
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
				<h5 class="modal-title">Edit Pengguna</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?= form_open('', ['method' => 'POST', 'novalidate' => 'novalidate', 'id' => 'form-edit']) ?>
			<div class="modal-body">
				<div class="progress progress-md mb-5 edit-progress">
					<div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar"
						 style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<fieldset>
					<input type="hidden" name="edit" id="edit" value="0">
					<div class="form-group">
						<label for="e_firstname">Nama</label>
						<input id="e_firstname" maxlength="25" class="form-control" name="first_name" type="text">
					</div>
					<div class="form-group">
						<label for="e_username">Username</label>
						<input id="e_username" maxlength="20" class="form-control" name="identity" type="text"
							   readonly="readonly">
						<span
							class="input-helper text-secondary text-small"><sup>*</sup>Username tidak dapat diubah</span>
					</div>
					<div class="form-group">
						<label for="e_email">Email</label>
						<input id="e_email" maxlength="40" class="form-control" name="email" type="email"
							   readonly="readonly">
						<span
							class="input-helper text-secondary text-small"><sup>*</sup>Email tidak dapat diubah</span>
					</div>
					<div class="form-group">
						<label for="e_phone">No. Handphone</label>
						<input id="e_phone" maxlength="15" class="form-control" name="phone" type="tel">
					</div>
					<div class="form-group">
						<label>Grup Pengguna</label>
						<?php foreach ($groups as $group): ?>
							<div class="form-check">
								<label class="form-check-label">
									<?php
									$gID = $group['id'];
									$checked = null;
									$item = null;
									?>
									<input type="checkbox" class="form-check-input" name="groups[]"
										   value="<?php echo $group['id']; ?>" id="<?php echo $group['name']; ?>">
									<?php echo htmlspecialchars($group['description'], ENT_QUOTES, 'UTF-8') . " [" . htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8') . "]"; ?>
									<i class="input-helper"></i></label>
							</div>
						<?php endforeach ?>
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
<?= form_open('', ['method' => 'POST', 'id' => 'form-remove']) ?>
<input type="hidden" name="remove_id" id="remove_id">
<?= form_close() ?>

<?= form_open('', ['method' => 'POST', 'id' => 'form-act']) ?>
<input type="hidden" id="act_id">
<?= form_close() ?>

<?= form_open('', ['method' => 'POST', 'id' => 'form-reset']) ?>
<input type="hidden" name="reset_id" id="reset_id">
<?= form_close() ?>
