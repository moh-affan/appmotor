<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$ci =& get_instance();
$pengguna = $ci->session->userdata('identity');
$user_id = $ci->ion_auth->get_user_id();
if ($ci->ion_auth->is_admin()):
	?>

	<div class="nav-bottom">
		<div class="container">
			<ul class="nav page-navigation">
				<li class="nav-item dashboard">
					<a href="<?= site_url('admin/dashboard') ?>" class="nav-link" style="padding-left: 18px">
						<i class="link-icon icon-home"></i></a>
				</li>
				<li class="nav-item master">
					<a href="#" class="nav-link"><i
							class="link-icon icon-drawer"></i><span
							class="menu-title">Master</span><i
							class="menu-arrow"></i></a>
					<div class="submenu">
						<ul class="submenu-item">
							<li class="nav-item motor"><a class="nav-link" href="<?= site_url('admin/master/motor') ?>">Sepeda
									Motor</a></li>
							<li class="nav-item variabel"><a class="nav-link" href="<?= site_url('admin/master/variabel') ?>">Variabel</a>
							</li>
						</ul>
					</div>
				</li>
				<li class="nav-item pengunjung">
					<a href="<?= site_url('admin/pengunjung') ?>" class="nav-link"><i
							class="link-icon fa fa-line-chart"></i><span
							class="menu-title">Pengunjung</span></a>
				</li>
				<li class="nav-item mgmt-user">
					<a href="#" class="nav-link"><i class="link-icon icon-user"></i>
						<span class="menu-title">Manajemen Pengguna</span>
						<i class="menu-arrow"></i></a>
					<div class="submenu">
						<ul class="submenu-item">
							<li class="nav-item group"><a class="nav-link"
														  href="<?= site_url('admin/pengguna/grup') ?>">Grup</a></li>
							<li class="nav-item users"><a class="nav-link" href="<?= site_url('admin/pengguna') ?>">Pengguna</a>
							</li>
						</ul>
					</div>
				</li>
				<li class="nav-item"><?php for ($i = 0; $i < 50; $i++) echo '&nbsp;' ?></li>
				<li class="nav-item"><?php for ($i = 0; $i < 100; $i++) echo '&nbsp;' ?></li>
			</ul>
		</div>
	</div>
<?php else: ?>
	<div class="nav-bottom">
		<div class="container">
			<ul class="nav page-navigation">
				<li class="nav-item dashboard">
					<a href="<?= site_url() ?>" class="nav-link" style="padding-left: 18px">
						<i class="link-icon icon-home"></i></a>
				</li>
				<li class="nav-item sepeda_motor">
					<a href="<?= site_url('sepeda_motor') ?>" class="nav-link"><i
							class="link-icon fa fa-motorcycle"></i>
						<span class="menu-title">Sepeda Motor</span></a>
				</li>
				<li class="nav-item rekomendasi">
					<a href="<?= site_url('rekomendasi') ?>" class="nav-link"><i
							class="link-icon fa fa-thumbs-o-up"></i>
						<span class="menu-title">Rekomendasi</span></a>
				</li>
				<li class="nav-item"><?php for ($i = 0; $i < 50; $i++) echo '&nbsp;' ?></li>
				<li class="nav-item"><?php for ($i = 0; $i < 100; $i++) echo '&nbsp;' ?></li>
			</ul>
		</div>
	</div>
<?php endif; ?>
