<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengunjung extends Authenticated_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_vw_pengunjung');
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
			$data = $this->m_vw_pengunjung->as_array()->fields('id_log,metode,nilai,urutan,pengguna,sesi,created_at')->order_by('id_log', 'DESC')->get_all();
		else
			$data = $this->m_vw_pengunjung->as_array()->fields('id_log,metode,nilai,urutan,pengguna,sesi,created_at')->order_by('id_log', 'DESC')->get($id);
		if ($dt) {
			$start = @$_GET['start'];
			$length = @$_GET['length'];
			$draw = @$_GET['draw'];
			$search = @$_GET['search']['value'];
			$data = $this->m_vw_pengunjung->limit($length, $start)->fields('id_log,metode,nilai,urutan,pengguna,sesi,created_at');
			if ($search) {
				$data = $data->where('metode', 'like', $search, true)
					->where('nilai', 'like', $search, true)
					->where('created_at', 'like', $search, true)
					->where('pengguna', 'like', $search, true)
					->where('urutan', 'like', $search, true);
			}
			$data = $data->order_by('id_log', 'DESC')->as_array()->get_all();
			$rowTotal = $this->m_vw_pengunjung->count_rows();
			if ($search) {
				$rowTotal = $this->m_vw_pengunjung->where('metode', 'like', $search, true)
					->where('nilai', 'like', $search, true)
					->where('pengguna', 'like', $search, true)
					->where('created_at', 'like', $search, true)
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

	public function detail($sesi)
	{
		$graph = array();
		/*$tahani = $this->m_vw_log_pengunjung->as_array()->where(['metode' => 'tahani', 'sesi' => $sesi])->get_all();*/
		$tsukamoto = $this->m_vw_log_pengunjung->as_array()->where(['metode' => 'tsukamoto', 'sesi' => $sesi])->get_all();
		$mamdani = $this->m_vw_log_pengunjung->as_array()->where(['metode' => 'mamdani', 'sesi' => $sesi])->get_all();
		/* tahani
		foreach ($tahani as $t) {
			$mtr = $t['merek'] . ' ' . $t['tipe'];
			$graph['label'][] = $mtr;
			$graph['data']['tahani'][$mtr] = floatval($t['nilai']);
			$graph['data']['tsukamoto'][$mtr] = 0;
		}
		*/
		foreach ($mamdani as $t) {
			$mtr = $t['merek'] . ' ' . $t['tipe'];
			$graph['label'][] = $mtr;
			$graph['data']['mamdani'][$mtr] = floatval($t['nilai']);
			$graph['data']['tsukamoto'][$mtr] = 0;
		}
		foreach ($tsukamoto as $t) {
			$mtr = $t['merek'] . ' ' . $t['tipe'];
			$graph['data']['tsukamoto'][$mtr] = floatval($t['nilai']);
			if (!isset($graph['data']['mamdani'][$mtr])) {
				$graph['data']['mamdani'][$mtr] = 0;
				$graph['label'][] = $mtr;
			}
		}
		$label = '"' . implode('","', $graph['label']) . '"';
		$data_tsukamoto = implode(',', array_values($graph['data']['tsukamoto']));
		$data_mamdani = implode(',', array_values($graph['data']['mamdani']));
		/*$this->set_var('tahani', $tahani);*/
		$this->set_var('mamdani', $mamdani);
		$this->set_var('tsukamoto', $tsukamoto);
		$data['label'] = $label;
		$data['data_tsukamoto'] = $data_tsukamoto;
		$data['data_mamdani'] = $data_mamdani;
		$this->_load_ext_datatable();
		$this->add_inline_script($this->load->view('admin/detail_pengunjung_js', array_merge(['judul_laporan' => 'Laporan Detail Pengunjung'], $data), true));
		$this->title('Detail Pengunjung')->menu_active('pengunjung')->layout('cloudui')->view('admin/detail_pengunjung')->render();
	}

}
