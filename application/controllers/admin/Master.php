<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Master
 * @property Ion_auth|Ion_auth_model $ion_auth
 * @property CI_Form_validation $form_validation The form validation library
 */
class Master extends Authenticated_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_motor');
		$this->load->model('m_variabel');
		$this->load->helper('textextraction');
	}

	public function index()
	{
		redirect('admin/master/motor', 'refresh');
	}

	//MOTOR
	public function motor()
	{
		$this->_load_ext_datatable();
		if ($this->input->method() == 'post') {
			if (isset($_POST['edit']))
				$this->_store_motor($this->input->post('edit'));
			elseif (isset($_POST['remove_id']))
				$this->_remove_motor($this->input->post('remove_id'));
			else
				$this->_store_motor();
		} else {
			$this->add_inline_script($this->load->view('admin/motor_js', ['judul_laporan' => 'Laporan Daftar Motor'], true));
			$this->title('Master Motor')->menu_active('motor')->layout('cloudui')->view('admin/motor')->render();
		}
	}

	public function publish_motor()
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

	private function _store_motor($edit = '')
	{
		$this->form_validation->set_rules('merek', 'Merek', 'trim|required');
		$this->form_validation->set_rules('tipe', 'Tipe', 'trim|required');
		$this->form_validation->set_rules('harga', 'Harga', 'trim|required|greater_than[0]|integer');
		$this->form_validation->set_rules('tangki', 'Kapasitas Tangki BBM', 'trim|required|greater_than[0]|numeric');
		$this->form_validation->set_rules('kecepatan', 'Kecepatan', 'trim|required|greater_than[0]|numeric');
		$this->form_validation->set_rules('transmisi', 'Tipe Transmisi', 'trim|required');
		$this->form_validation->set_rules('bagasi', 'Kapasitas Bagasi', 'trim|required|greater_than[0]|numeric');
		$this->form_validation->set_rules('berat', 'Berat', 'trim|required|greater_than[0]|integer');
		$this->form_validation->set_rules('warna', 'Warna', 'trim|required');
		$data = [];
		if ($this->form_validation->run() === TRUE) {
			$data['merek'] = $this->input->post('merek');
			$data['tipe'] = $this->input->post('tipe');
			$data['harga'] = $this->input->post('harga');
			$data['tangki'] = $this->input->post('tangki');
			$data['kecepatan'] = $this->input->post('kecepatan');
			$data['transmisi'] = $this->input->post('transmisi');
			$data['tipetransmisi'] = 'Manual';
			if (strpos('.' . $data['transmisi'], 'Otomatis'))
				$data['tipetransmisi'] = 'Matic';
			$data['bagasi'] = $this->input->post('bagasi');
			$data['berat'] = $this->input->post('berat');
			$data['warna'] = $this->input->post('warna');
			$new_motor_id = empty($edit) ? $this->m_motor->insert(array_merge($data, ['created_by' => $this->ion_auth->get_user_id()])) : $this->m_motor->update(array_merge($data, ['updated_by' => $this->ion_auth->get_user_id()]), $edit);
			if ($new_motor_id) {
				$this->render_json(['success' => true, 'message' => 'Berhasil menyimpan data motor']);
			} else {
				$this->render_json(['success' => false, 'message' => 'Gagal menyimpan data motor']);
			}
		} else {
			$this->render_json(['success' => false, 'message' => extract_text(validation_errors())]);
		}
	}

	private function _remove_motor($id)
	{
		$motor = $this->m_motor->get($id);
		if ($motor) {
			$remove = $this->m_motor->delete($id);
			if ($remove) {
				$this->render_json(['success' => true, 'message' => 'Motor berhasil dihapus']);
			} else {
				$this->render_json(['success' => false, 'message' => 'Motor berhasil dihapus']);
			}
		} else {
			$this->render_json(['success' => false, 'message' => 'Motor tidak ditemukan']);
		}
	}

	//VARIABEL
	public function variabel()
	{
		$this->_load_ext_datatable();
		if ($this->input->method() == 'post') {
			if (isset($_POST['edit']))
				$this->_store_variabel($this->input->post('edit'));
			elseif (isset($_POST['remove_id']))
				$this->_remove_variabel($this->input->post('remove_id'));
			else
				$this->_store_variabel();
		} else {
			$this->add_inline_script($this->load->view('admin/variabel_js', ['judul_laporan' => 'Laporan Daftar Variabel'], true));
			$this->title('Master Variabel')->menu_active('variabel')->layout('cloudui')->view('admin/variabel')->render();
		}
	}

	private function _store_variabel($edit = '')
	{
		$this->form_validation->set_rules('variabel', 'Variabel', 'trim|required');
		$this->form_validation->set_rules('min', 'Range Nilai Minimum', 'trim|required');
		$this->form_validation->set_rules('max', 'Range Nilai Maksimum', 'trim|required');
		$this->form_validation->set_rules('tabel', 'Tabel', 'trim|required');
		$this->form_validation->set_rules('field', 'Field', 'trim|required');
		$data = [];
		if ($this->form_validation->run() === TRUE) {
			$data['variabel'] = $this->input->post('variabel');
			$data['min'] = $this->input->post('min');
			$data['max'] = $this->input->post('max');
			$data['tabel'] = $this->input->post('tabel');
			$data['field'] = $this->input->post('field');
			$new_variabel_id = empty($edit) ? $this->m_variabel->insert(array_merge($data, ['created_by' => $this->ion_auth->get_user_id()])) : $this->m_variabel->update(array_merge($data, ['updated_by' => $this->ion_auth->get_user_id()]), $edit);
			if ($new_variabel_id) {
				$this->render_json(['success' => true, 'message' => 'Berhasil menyimpan data variabel']);
			} else {
				$this->render_json(['success' => false, 'message' => 'Gagal menyimpan data variabel']);
			}
		} else {
			$this->render_json(['success' => false, 'message' => extract_text(validation_errors())]);
		}
	}

	private function _remove_variabel($id)
	{
		$variabel = $this->m_variabel->get($id);
		if ($variabel) {
			$remove = $this->m_variabel->delete($id);
			if ($remove) {
				$this->render_json(['success' => true, 'message' => 'Variabel berhasil dihapus']);
			} else {
				$this->render_json(['success' => false, 'message' => 'Variabel berhasil dihapus']);
			}
		} else {
			$this->render_json(['success' => false, 'message' => 'Variabel tidak ditemukan']);
		}
	}

	public function publish_variabel()
	{
		$params = $_GET;
		$id = isset($params['id']) ? $params['id'] : null;
		$dt = isset($params['dt']) ? boolval($params['dt']) : false;
		if ($id == null)
			$data = $this->m_variabel->as_array()->fields('id_variabel,variabel,min,max,tabel,field')->order_by('created_at', 'DESC')->get_all();
		else
			$data = $this->m_variabel->as_array()->fields('id_variabel,variabel,min,max,tabel,field')->order_by('created_at', 'DESC')->get($id);
		if ($dt) {
			$start = @$_GET['start'];
			$length = @$_GET['length'];
			$draw = @$_GET['draw'];
			$search = @$_GET['search']['value'];
			$data = $this->m_variabel->limit($length, $start)->fields('id_variabel,variabel,min,max,tabel,field');
			if ($search) {
				$data = $data->where('variabel', 'like', $search, true)
					->where('field', 'like', $search, true)
					->where('tabel', 'like', $search, true);
			}
			$data = $data->order_by('created_at', 'DESC')->as_array()->get_all();
			$rowTotal = $this->m_variabel->count_rows();
			if ($search) {
				$rowTotal = $this->m_motor->where('variabel', 'like', $search, true)
					->where('field', 'like', $search, true)
					->where('tabel', 'like', $search, true)->count_rows();
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
