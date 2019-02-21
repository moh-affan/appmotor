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
		$this->_load_ext_datatable();
		$data = $this->m_motor->get_all();
		$this->benchmark->mark('tahani_start');
		$this->fuzzy->tahani(array_values($this->input->post()), $data);
		$this->benchmark->mark('tahani_end');
		$this->set_var('tahani_time', $this->benchmark->elapsed_time('tahani_start', 'tahani_end'));
		$this->set_var('tahani', $this->fuzzy->get_fire_strength());
		$this->benchmark->mark('tsukamoto_start');
		$this->fuzzy->tsukamoto(array_values($this->input->post()), $data, 'id_motor');
		$this->benchmark->mark('tsukamoto_end');
		var_dump($this->benchmark->elapsed_time('tsukamoto_start', 'tsukamoto_end'));
		var_dump($this->fuzzy->get_rules());
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
