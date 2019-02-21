<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekomendasi extends Member_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->title('Rekomendasi')->menu_active('rekomendasi')->layout('cloudui')->view('cloudui/rekomendasi')->render();
	}

	public function result()
	{
		$this->load->library('fuzzy');
		$this->load->model('m_motor');
		$this->load->model('m_log_rek');
		$this->_load_ext_datatable();
		$kriteria = array_values($this->input->post());
		$post_kriteria = array();
		$data = $this->m_motor;
		$exclude = array();
		foreach ($kriteria as $kr) {
			$x_kr = explode('_', $kr);
			$f = $x_kr[0];
			$h = $x_kr[1];
			$non_fuzzy = $h != 'min' && $h != 'mid' && $h != 'max';
			if ($non_fuzzy) {
				$data = $data->where($f, 'like', $h);
				$exclude[] = $x_kr;
			} else
				$post_kriteria[] = $kr;
		}
		$data = $data->get_all();
		$this->benchmark->mark('tahani_start');
		$this->fuzzy->tahani($kriteria, $data);
		$this->benchmark->mark('tahani_end');
		$this->set_var('tahani_time', $this->benchmark->elapsed_time('tahani_start', 'tahani_end'));
		$firestrength = $this->fuzzy->get_fire_strength();
		$this->set_var('tahani', $firestrength);
		$this->benchmark->mark('tsukamoto_start');
		$this->fuzzy->tsukamoto2($post_kriteria, $this->m_motor->get_all(), 'id_motor', $exclude);
		$this->benchmark->mark('tsukamoto_end');
		$this->set_var('tsukamoto_time', $this->benchmark->elapsed_time('tsukamoto_start', 'tsukamoto_end'));
		$defuzzed = $this->fuzzy->get_defuzzed();
		$this->set_var('tsukamoto', $defuzzed);
		$counter = 0;
		foreach ($firestrength as $k => $fs) {
			if ($counter == 5) break;
			$this->m_log_rek->insert(['motor_id' => $fs->id_motor, 'metode' => 'tahani', 'nilai' => $fs->fire_strength, 'urutan' => $k, 'created_by' => $this->ion_auth->get_user_id()]);
			$counter++;
		}
		$counter = 0;
		foreach ($defuzzed as $k => $fs) {
			if ($counter == 5) break;
			$this->m_log_rek->insert(['motor_id' => $fs->id_motor, 'metode' => 'tsukamoto', 'nilai' => $fs->defuzzed, 'urutan' => $k, 'created_by' => $this->ion_auth->get_user_id()]);
			$counter++;
		}
		$this->add_inline_script($this->load->view('cloudui/hasil_js', ['judul_laporan' => 'Hasil Rekomendasi'], true));
		$this->title('Hasil Rekomendasi')->menu_active('rekomendasi')->layout('cloudui')->view('cloudui/hasil_rekomendasi')->render();
	}

	public function rules_check()
	{
		$this->load->library('fuzzy');
		$this->load->model('m_motor');
		$data = $this->m_motor->get_all();
		$this->fuzzy->tsukamoto2(['harga_min', 'tangki_min', 'kecepatan_min', 'bagasi_min', 'berat_max'], $data, 'id_motor');
		$defuzzed = $this->fuzzy->get_defuzzed();
		var_dump($defuzzed);
	}

	private function _load_ext_datatable()
	{
		$this->add_style(site_url('assets/vendors/datatable/buttons.bootstrap.min.css'));
		$this->add_script(site_url('assets/vendors/datatable/dataTables.buttons.min.js'));
		$this->add_script(site_url('assets/vendors/datatable/buttons.bootstrap.min.js'));
		$this->add_script(site_url('assets/vendors/datatable/buttons.flash.min.js'));
		$this->add_script(site_url('assets/vendors/datatable/buttons.html5.min.js'));
		$this->add_script(site_url('assets/vendors/datatable/buttons.print.min.js'));
		$this->add_script(site_url('assets/vendors/datatable/pdfmake.min.js'));
		$this->add_script(site_url('assets/vendors/datatable/vfs_fonts.js'));
		$this->add_script(site_url('assets/vendors/jszip/jszip.min.js'));
	}
}
