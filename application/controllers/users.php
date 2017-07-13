<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller
{

	public function __construct() {

		parent::__construct();

	}

	/**
	 * Fetch and display records
	 * @return void
	 */
	public function index($key_default = 'system') {

		$this->load->model('t_user');

		$where = array();

		$user_sys = $this->ion_auth->users()->result_array();

		foreach ($user_sys as $k => $user) {

            $user_sys[$k]['groups'] = $this->ion_auth->get_users_groups($user['id'])->result_array();

        }

		$this->data['user_sys'] = $user_sys;

	}

	public function login()
	{

		if ($this->is_login()) {
		
			redirect($this->router->default_controller);

		}

		if ($this->input->is('post')) {
			
			$this->load->controller('auth');

			$this->auth->login();

		}

		$this->set_page_title($this->lang->line('admin_login'));

		$this->data['key_page'] = $this->guid();

		if ($this->session->userdata('http_post_data')) {

			foreach ($this->session->userdata('http_post_data') as $key => $post) {

				$this->data[$key] = strtoupper($post);

			}

			$this->session->unset_userdata('http_post_data');

		}

		if ($this->ion_auth->errors()) {

			flash_error($this->ion_auth->errors());
			
		}

	}

	/**
	 * Insert or update a record
	 * @param int $id Defaults to NULL
	 * @return void
	 */
	public function edit($id = NULL) {

		$this->render(null, 'system/menu_view', $this->data);

	}

	public function access_right($control='', $auto_init = false, $trumcate = 0)
	{
		
		if (!$control) {

			$control = 'dev';

		}
		else {

			if ($control != 'all') {

				$control = base64_decode($control);

			}

		}

		$this->data['controllers'] = $this->get_controller_list();

		if ($control == 'all') {

			$list = array();

			foreach ($this->data['controllers'] as $key => $control_name) {

				$sub_list = $this->get_public_functions($control_name);

				if (count($sub_list) > 0) {

					foreach ($sub_list as $key => $sub) {

						$list[] = $sub;

					}

				}

			}

			$methods = (object) ($list);

		}
		else {

			$methods = $this->get_public_functions($control);

		}

		$arr_methods = array();

		if (count($methods)) {
			
			foreach ($methods as $key => $method) {

				$router_key = strtolower($method->class).'/'.$method->name;

				if (strpos($method->name, '__') !== false) {
					
					continue;

				}

				$arr_methods[] = array(
					'control' => $method->class,
					'action' => $method->name
				);

			}

		}

		$this->load->model('t_access_right');

		$this->load->model('t_access_right_group');

		$admin_group = $this->config->item('admin_group', 'ion_auth');

		if ($auto_init && !$trumcate) {
			
			$groups = $this->ion_auth->groups()->result_array();

			$this->load->model('t_controller');

			foreach ($arr_methods as $key => $method) {

				if (in_array($method['action'], array('login', 'logout'))) {
                    
                    continue;

                }

				$access_row = $this->t_access_right->get_data_by_property('*', $method);

				if (!count($access_row)) {

					$method['require_login'] = 1;

					$access_row = $this->t_access_right->set_data($method, 1);

				}
				else {

					$access_row = $access_row[0];

				}

				if (count($groups)) {

					$this->load->model('t_access_right_group');

					$controller = $this->t_controller->get_data_by_property('*', array(
							'controller_key' => $method['control']
						)
					);
					
					foreach ($groups as $key => $group) {

						$group_access = array(
							'group_id' => $group['id'],
							'access_right_id' => $access_row['id']
						);
						
						$group_access_right = $this->t_access_right_group->get_data_by_property('*', $group_access);

						if (!count($group_access_right)) {

							if (isset($controller[0]['is_backend']) && $controller[0]['is_backend']) {

								if ($group['name'] !== $admin_group) {
									
									$group_access = array(
										'group_id' => $group['id'],
										'access_right_id' => $access_row['id'],
										'enable' => 0
									);

								}

							}

							$this->t_access_right_group->set_data($group_access);

						}

					}

				}

			}

		}

		if ($control != 'all') {

			$access_right_where = array(
				'control' => $control
			);

		}
		else {

			$access_right_where = array();

		}

		if ($trumcate && !$auto_init) {

			$this->db->query("TRUNCATE " . $this->t_access_right->table_name);

    		$this->db->query("ALTER TABLE ".$this->t_access_right->table_name." AUTO_INCREMENT = 1");

    		$this->db->query("TRUNCATE " . $this->t_access_right_group->table_name);

    		$this->db->query("ALTER TABLE ".$this->t_access_right_group->table_name." AUTO_INCREMENT = 1");

		}

		$this->data['access_right'] = $this->t_access_right->get_access_right_by_router($access_right_where);

		$this->data['control_default'] = $control;

		$this->data['admin_group'] = $admin_group;

	}

	public function enable_access_right()
	{
		
		if (!$this->input->is_ajax_request()) {

			flash_error(lang('Only_allow_access_with_ajax'));

			$this->response_message();

		}

		if ($this->input->is('post')) {

			if (!$this->input->post('access_right_id')) {

				flash_error(lang('Data_not_found'));

				$this->response_message();

			}

			$access_right_id = $this->input->post('access_right_id');

			$this->load->model('t_access_right_group');

			$this->t_access_right_group->update_data_by_property(array(
					'enable' => 0
				), array(
					'access_right_id' => $access_right_id
				)
			);

			$groups = $this->input->post('groups');

			if (is_array($groups) && count($groups)) {
				
				foreach ($groups as $key => $group) {

					$this->t_access_right_group->update_data_by_property(array(
						'enable' => 1
					), array(
							'access_right_id' => $access_right_id,
							'group_id' => $group
						)
					);
				}

			}

			flash_success(lang('Saved'));

		}
		else {
			
			flash_error(lang('Not_allow_method_GET'));

		}

		$this->response_message();

	}

	public function set_require_login()
	{

		if (!$this->input->is_ajax_request()) {

			flash_error(lang('Only_allow_access_with_ajax'));

			$this->response_message();

		}

		if ($this->input->is('post')) {

			if (!$this->input->post('access_right_id')) {

				flash_error(lang('Data_not_found'));

				$this->response_message();

			}

			$id = $this->input->post('access_right_id');

			$require_login = $this->input->post('require_login');

			$this->load->model('t_access_right');

			$this->t_access_right->update_data_by_property(array(
					'require_login' => $require_login
				), array(
					'id' => $id
				)
			);

			flash_success(lang('Saved'));

		}
		else {
			
			flash_error(lang('Not_allow_method_GET'));

		}

		$this->response_message();

	}

	/**
	 * Delete a record
	 * @param int $id
	 * @return void
	 */
	public function delete($id = '') {

		if ($this->input->is('post')) {

			if (!$this->input->post('file')) {

				flash_error(lang('Data_not_found'));

				$this->redirect();

			}

			$id = base64_decode($this->input->post('file'));

		}
		else {

			$id = base64_decode($id);

		}

		if ($id) {

			$user = $this->ion_auth->user($id)->result_array();

			if (count($user)) {

				$this->auth = $this->load->controller('auth');

				$result = $this->auth->delete_user($user[0]['id']);

			}
			else {

				flash_error(lang('User_does_not_exist'));

			}

		}
		else {

			flash_error(lang('User_does_not_exist'));

		}

		$this->redirect();

	}

	public function update_last_login($id = null)
	{
		
		if(!empty($id)) {

			$this->load->model('t_user');

			$time = date("Y-m-d H:i:s");

			$this->t_user->update_data_by_property(array("LAST_LOGIN_ATTEMPT" => $time) ,array("ID" => $id));

		}
		else {

			return false;

		}

	}
	
	public function check_expired_session()
	{

		if ($this->is_login()) {

			$segment = array($this->router->class, 'index');

			$this->redirect($segment);

		}

	}

	public function change_language($id='')
	{

		if ($this->input->is('post')) {
			# code...
		}
		else{

			flash_error('Not_allow_method_GET');

		}

		$this->redirect();

	}

	public function logout()
	{
		
		$this->load->controller('auth');

		$this->auth->logout();

	}

}