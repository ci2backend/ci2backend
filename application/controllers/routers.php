<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Routers extends MY_Controller
{

	public function __construct() {

		parent::__construct();


	}

	/**
	 * Fetch and display records
	 * @return void
	 */
	public function index($control='') {

		$this->t_router->is_object = true;

		if (!$control) {

			$control = 'dev';

		}
		else {

			if ($control != 'all') {

				$control = base64_decode($control);

			}

		}

		if ($control != 'all') {

			$condition = explode('/', $control);

			$this->t_router->like('router_source', end($condition).'/');

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

				$arr_methods[$router_key] = $router_key;

			}

		}

		$this->db->order_by('id', 'DESC');

		$routers = $this->t_router->get_data_by_property('*');

		$this->data['routers'] = $routers;

		$this->data['methods'] = $arr_methods;

		$this->data['control_default'] = $control;

		$last_insert = 'SELECT LAST_INSERT_ID();';

		$last_insert_id = $this->db->query($last_insert)->result_array()[0]['LAST_INSERT_ID()'];

		$this->data['last_insert_id'] = $last_insert_id;

	}

	/**
	 * Create a record
	 * @return void
	 */
	public function create() {

		if ($this->input->post()) {

			$this->load->model('t_router');

			$router = $this->input->post('router');

			if (count($router) > 0) {

				$list = array();

				foreach ($router as $key => $route) {

					$row_id = $route['row_id'];

					unset($route['row_id']);

					$data = $this->parse_fields_table($route, $this->t_router->table_name);

					$router_row = $this->t_router->get_data_by_id('*', $row_id);

					if (count($router_row) > 0) {

						$where = array('id' => $row_id);

						unset($data['id']);

						$update = $this->t_router->update_data_by_property($data, $where);

						if (!$update) {
							
							continue;

						}
						else {

							$data['id'] = $where['id'];

						}

					}
					else {

						unset($data['id']);

						$insert = $this->t_router->set_data($data, 1);

						if ($insert) {

							$data['row_id'] = $insert['id'];

						}

					}

					array_push($list, $data);

					$this->response->data = (object) $list;

				}

				flash_success(lang('Saved'));

			}

		}

		$this->redirect();

	}

	/**
	 * Insert or update a record
	 * @param int $id Defaults to NULL
	 * @return void
	 */
	public function edit($id = NULL) {

	}

	/**
	 * Delete a record
	 * @param int $id
	 * @return void
	 */
	public function delete($id='') {

		if ($this->input->is('post')) {

			if (!$this->input->post('file')) {

				flash_error(lang('Data_not_found'));

				$this->redirect();

			}

			$id_routes = base64_decode($this->input->post('file'));

		}
		else {

			$id_routes = $id;

		}

		var_dump($id_routes); exit();

		$this->load->model('T_router');

		$routes = $this->T_router->get_data_by_id('*', $id_routes);

		if (count($routes)) {

			$this->db->where('id', $id_routes);

			$this->db->delete($this->T_router->table_name);

			$this->response->data = (object) $routes;

			$this->response->callback_function = 'delete_routes';

			flash_success(lang('Saved'));

		}
		else {

			flash_error(lang('Data_not_found'));

		}

		$this->redirect();

	}

}