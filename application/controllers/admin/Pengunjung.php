<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengunjung extends Authenticated_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_vw_log_pengunjung');
	}

	public function index()
	{
		$this->_load_ext_datatable();
		$this->add_inline_script($this->load->view('admin/pengunjung_js', ['judul_laporan' => 'Laporan Daftar Pengunjung Aplikasi'], true));
		$this->title('Pengunjung')->menu_active('pengunjung')->layout('cloudui')->view('admin/pengunjung')->render();
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

	public function publish()
	{
		$params = $_GET;
		$id = isset($params['id']) ? $params['id'] : null;
		$dt = isset($params['dt']) ? boolval($params['dt']) : false;
		if ($id == null)
			$data = $this->m_vw_log_pengunjung->as_array()->fields('id_log,metode,nilai,urutan,merek,tipe,pengguna')->order_by('id_log', 'DESC')->get_all();
		else
			$data = $this->m_vw_log_pengunjung->as_array()->fields('id_log,metode,nilai,urutan,merek,tipe,pengguna')->order_by('id_log', 'DESC')->get($id);
		if ($dt) {
			$start = @$_GET['start'];
			$length = @$_GET['length'];
			$draw = @$_GET['draw'];
			$search = @$_GET['search']['value'];
			$data = $this->m_vw_log_pengunjung->limit($length, $start)->fields('id_log,metode,nilai,urutan,merek,tipe,pengguna');
			if ($search) {
				$data = $data->where('metode', 'like', $search, true)
					->where('nilai', 'like', $search, true)
					->where('merek', 'like', $search, true)
					->where('tipe', 'like', $search, true)
					->where('pengguna', 'like', $search, true)
					->where('urutan', 'like', $search, true);
			}
			$data = $data->order_by('id_log', 'DESC')->as_array()->get_all();
			$rowTotal = $this->m_vw_log_pengunjung->count_rows();
			if ($search) {
				$rowTotal = $this->m_vw_log_pengunjung->where('metode', 'like', $search, true)
					->where('nilai', 'like', $search, true)
					->where('merek', 'like', $search, true)
					->where('tipe', 'like', $search, true)
					->where('pengguna', 'like', $search, true)
					->where('urutan', 'like', $search, true);
			}
			$response = ['draw' => $draw,
				'recordsTotal' => $rowTotal,
				'recordsFiltered' => $rowTotal,
				'data' => $data
			];
			$this->render_json($response);
		}
		if ($data) {
			$this->render_json($data);
		} else
			$this->render_json(['success' => false, 'message' => 'Data yang Anda minta tidak ada']);
	}

}
