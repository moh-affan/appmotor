<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Pengguna
 * @property Ion_auth|Ion_auth_model $ion_auth
 * @property CI_Form_validation $form_validation The form validation library
 */
class Pengguna extends Authenticated_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('language');
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
		$this->load->model('m_users');
		$this->load->model('m_groups');
		$this->load->helper('textextraction');
		$this->add_script(site_url('assets/themes/cloudui/js/form-validation.js'));
	}

	public function index()
	{
		$this->_load_ext_datatable();
		if ($this->input->method() == 'post') {
			if (isset($_POST['edit']))
				$this->_edit_user($this->input->post('edit'));
			elseif (isset($_POST['remove_id']))
				$this->_remove_user($this->input->post('remove_id'));
			elseif (isset($_POST['activate_id']))
				$this->_activate($this->input->post('activate_id'));
			elseif (isset($_POST['deactivate_id']))
				$this->_deactivate($this->input->post('deactivate_id'));
			elseif (isset($_POST['reset_id']))
				$this->_reset_password($this->input->post('reset_id'));
			else
				$this->_create_user();
		} else {
			$this->add_inline_script($this->load->view('admin/pengguna_js', ['judul_laporan' => 'Laporan Pengguna'], true));
			$groups = $this->ion_auth->groups()->result_array();
			$this->set_var('groups', $groups);
			$this->title('Pengguna')->menu_active('users')->layout('cloudui')->view('admin/pengguna')->render();
		}
	}

	public function grup()
	{
		$this->_load_ext_datatable();
		if ($this->input->method() == 'post') {
			if (isset($_POST['edit']))
				$this->_edit_group($this->input->post('edit'));
			elseif (isset($_POST['remove_id']))
				$this->_remove_group($this->input->post('remove_id'));
			else
				$this->_create_group();
		} else {
			$this->add_inline_script($this->load->view('admin/group_js', ['judul_laporan' => 'Laporan Grup Pengguna'], true));
			$this->title('Grup')->menu_active('group')->layout('cloudui')->view('admin/group')->render();
		}
	}

	public function publish()
	{
		$params = $_GET;
		$id = isset($params['id']) ? $params['id'] : null;
		$dt = isset($params['dt']) ? boolval($params['dt']) : false;
		if ($id == null)
			$data = $this->m_users->as_array()->fields('id,username,email,active,first_name,phone')->with_groups()->order_by('id', 'DESC')->get_all();
		else
			$data = $this->m_users->as_array()->fields('id,username,email,active,first_name,phone')->with_groups()->order_by('id', 'DESC')->get($id);
		if ($dt) {
			$start = @$_GET['start'];
			$length = @$_GET['length'];
			$draw = @$_GET['draw'];
			$search = @$_GET['search']['value'];
			$data = $this->m_users->limit($length, $start)->fields('id,username,email,active,first_name,phone');
			if (!empty($search)) {
				$data = $data->where('username', 'like', $search, true)
					->where('first_name', 'like', $search, true)
					->where('phone', 'like', $search, true)
					->where('email', 'like', $search, true);
			}
			$data = $data->with_groups()->order_by('id', 'DESC')->as_array()->get_all();
			$rowTotal = $this->m_users->count_rows();
			if (!empty($search)) {
				$rowTotal = $this->m_users->where('username', 'like', $search, true)
					->where('first_name', 'like', $search, true)
					->where('phone', 'like', $search, true)
					->where('email', 'like', $search, true)->with_groups()->count_rows();
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

	public function publish_group()
	{
		$params = $_GET;
		$id = isset($params['id']) ? $params['id'] : null;
		$dt = isset($params['dt']) ? boolval($params['dt']) : false;
		if ($id == null)
			$data = $this->m_groups->as_array()->fields('id,name,description')->order_by('id', 'DESC')->get_all();
		else
			$data = $this->m_groups->as_array()->fields('id,name,description')->order_by('id', 'DESC')->get($id);
		if ($dt) {
			$start = @$_GET['start'];
			$length = @$_GET['length'];
			$draw = @$_GET['draw'];
			$search = @$_GET['search']['value'];
			$data = $this->m_groups->limit($length, $start)->fields('id,name,description');
			if (!empty($search)) {
				$data = $data->where('name', 'like', $search, true)
					->where('description', 'like', $search, true);
			}
			$data = $data->order_by('id', 'DESC')->as_array()->get_all();
			$rowTotal = $this->m_groups->count_rows();
			if (!empty($search)) {
				$rowTotal = $this->m_groups->where('name', 'like', $search, true)
					->where('description', 'like', $search, true)->count_rows();
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

	private function _remove_user($id)
	{
		if (!$this->load->is_loaded('m_users_groups'))
			$this->load->model('m_users_groups');
		if (!$this->load->is_loaded('m_users'))
			$this->load->model('m_users');
		$this->ion_auth->remove_from_group('', $id);
		if ($this->m_users->delete($id)) {
			$this->render_json(['success' => true, 'message' => 'Berhasil menghapus']);
		} else {
			$this->render_json(['success' => false, 'message' => 'Gagal menghapus']);
		}
	}

	private function _create_user()
	{
		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
		if ($identity_column !== 'email') {
			$this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
		} else {
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
		}
		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

		if ($this->form_validation->run() === TRUE) {
			$email = strtolower($this->input->post('email'));
			$identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
			$password = $this->input->post('password');

			$additional_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => '',
				'company' => '',
				'phone' => $this->input->post('phone'),
			);
		}
		if ($this->form_validation->run() === TRUE && $id = $this->ion_auth->register($identity, $password, $email, $additional_data)) {
			if ($this->ion_auth->is_admin()) {
				$groupData = $this->input->post('groups');
				if (isset($groupData) && !empty($groupData)) {
					$this->ion_auth->remove_from_group('', $id);
					foreach ($groupData as $grp) {
						$this->ion_auth->add_to_group($grp, $id);
					}
				}
				$this->render_json(['success' => true, 'message' => $this->ion_auth->messages()]);
			} else {
				$this->output->set_status_header(403);
				$this->render_json(['success' => false, 'message' => 'Not Authorized']);
			}
		} else {
			$this->render_json(['success' => false, 'message' => extract_text(validation_errors())]);
		}
		exit(0);
	}

	private function _edit_user($id)
	{
		$user = $this->ion_auth->user($id)->row();
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim|required');
		if (isset($_POST) && !empty($_POST)) {
			if ($this->input->post('password')) {
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}
			if ($this->form_validation->run() === TRUE) {
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => '',
					'company' => '',
					'phone' => $this->input->post('phone'),
				);
				if ($this->input->post('password')) {
					$data['password'] = $this->input->post('password');
				}
				if ($this->ion_auth->is_admin()) {
					$groupData = $this->input->post('groups');
					if (isset($groupData) && !empty($groupData)) {
						$this->ion_auth->remove_from_group('', $id);
						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}
					}
				} else {
					$this->output->set_status_header(403);
					$this->render_json(['success' => false, 'message' => 'Not Authorized']);
				}
				if ($this->ion_auth->update($user->id, $data)) {
					$this->render_json(['success' => true, 'message' => extract_text($this->ion_auth->messages())]);
				} else {
					$this->render_json(['success' => false, 'message' => extract_text($this->ion_auth->errors())]);
				}
			}
		}
		$this->render_json(['message' => (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')))]);
		exit(0);
	}

	private function _activate($id)
	{
		$id = intval($id);
		if ($this->ion_auth->activate($id)) {
			$this->render_json(['success' => true, 'message' => extract_text($this->ion_auth->messages())]);
		} else {
			$this->render_json(['success' => false, 'message' => extract_text($this->ion_auth->errors())]);
		}
	}

	private function _deactivate($id)
	{
		$id = intval($id);
		if ($this->ion_auth->deactivate($id)) {
			$this->render_json(['success' => true, 'message' => extract_text($this->ion_auth->messages())]);
		} else {
			$this->render_json(['success' => false, 'message' => extract_text($this->ion_auth->errors())]);
		}
	}

	private function _reset_password($id)
	{
		$data['password'] = 'p@55w0Rd';
		$user = $this->ion_auth->user($id)->row();
		if ($this->ion_auth->update($user->id, $data)) {
			$this->render_json(['success' => true, 'message' => 'Password berhasil direset\nPassword baru : ' . $data['password']]);
		} else {
			$this->render_json(['success' => false, 'message' => 'Gagal mereset password']);
		}
	}

	private function _create_group()
	{
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'trim|required|alpha_dash');
		if ($this->form_validation->run() === TRUE) {
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if ($new_group_id) {
				$this->render_json(['success' => true, 'message' => extract_text($this->ion_auth->messages())]);
			} else {
				$this->render_json(['success' => false, 'message' => extract_text($this->ion_auth->errors())]);
			}
		} else {
			$this->render_json(['success' => false, 'message' => extract_text(validation_errors())]);
		}
	}

	private function _edit_group($id)
	{
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'trim|required|alpha_dash');
		if ($this->form_validation->run() === TRUE) {
			$update = $this->m_groups->update(['name' => $this->input->post('group_name'), 'description' => $this->input->post('description')], $id);
			if ($update) {
				$this->render_json(['success' => true, 'message' => 'Grup berhasil diupdate']);
			} else {
				$this->render_json(['success' => false, 'message' => 'Grup gagal diupdate']);
			}
		} else {
			$this->render_json(['success' => false, 'message' => extract_text(validation_errors())]);
		}
	}

	private function _remove_group($id)
	{
		$grup = $this->m_groups->get($id);
		if ($grup) {
			$remove = $this->m_groups->delete($id);
			if ($remove) {
				$this->render_json(['success' => true, 'message' => 'Grup berhasil dihapus']);
			} else {
				$this->render_json(['success' => false, 'message' => 'Grup berhasil dihapus']);
			}
		} else {
			$this->render_json(['success' => false, 'message' => 'Grup tidak ditemukan']);
		}
	}

}
