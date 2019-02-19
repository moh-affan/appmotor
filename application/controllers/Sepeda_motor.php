<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sepeda_motor extends Member_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_motor');
	}

	public function index()
	{
		$this->_load_ext_datatable();
		$this->add_inline_script($this->load->view('cloudui/motor_js', ['judul_laporan' => 'Laporan Daftar Motor'], true));
		$this->title('Sepeda Motor')->menu_active('sepeda_motor')->layout('cloudui')->view('cloudui/motor')->render();
	}

	public function publish()
	{
		$params = $_GET;
		$id = isset($params['id']) ? $params['id'] : null;
		$dt = isset($params['dt']) ? boolval($params['dt']) : false;
		if ($id == null)
			$data = $this->m_motor->as_array()->fields('id_motor,merek,tipe,harga,tangki,kecepatan,tipetransmisi,transmisi,bagasi,berat,warna')->order_by('created_at', 'DESC')->get_all();
		else
			$data = $this->m_motor->as_array()->fields('id_motor,merek,tipe,harga,tangki,kecepatan,tipetransmisi,transmisi,bagasi,berat,warna')->order_by('created_at', 'DESC')->get($id);
		if ($dt) {
			$start = @$_GET['start'];
			$length = @$_GET['length'];
			$draw = @$_GET['draw'];
			$search = @$_GET['search']['value'];
			$data = $this->m_motor->limit($length, $start)->fields('id_motor,merek,tipe,harga,tangki,kecepatan,tipetransmisi,transmisi,bagasi,berat,warna');
			if ($search) {
				$data = $data->where('merek', 'like', $search, true)
					->where('tipe', 'like', $search, true)
					->where('warna', 'like', $search, true)
					->where('transmisi', 'like', $search, true)
					->where('tipetransmisi', 'like', $search, true);
			}
			$data = $data->order_by('created_at', 'DESC')->as_array()->get_all();
			$rowTotal = $this->m_motor->count_rows();
			if ($search) {
				$rowTotal = $this->m_motor->where('merek', 'like', $search, true)
					->where('tipe', 'like', $search, true)
					->where('warna', 'like', $search, true)
					->where('transmisi', 'like', $search, true)
					->where('tipetransmisi', 'like', $search, true)->count_rows();
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
