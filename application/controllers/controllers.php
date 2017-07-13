<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controllers extends MY_Controller
{

	public function __construct() {

		parent::__construct();


	}

	/**
	 * Fetch and display records
	 * @return void
	 */
	public function index() {

		$controllers_list = $this->get_controller_file();

		$this->data['file_list'] = $controllers_list;

	}

	protected function get_controller_file($file_list = array())
	{

		$controllers_list = array();

		$ctrl_uri = APPPATH.'controllers';

		$pattern = '/(@null)/i';

		$dir = $this->get_dir($ctrl_uri, $pattern);

		$dir_view = $this->get_view($data = array(), $ctrl_uri);

		$file_list = $this->parser_dir($dir_view, $result = array(), $ctrl_uri);

		if (count($file_list)) {
			
			foreach ($file_list as $key => $file) {

				$control_data = array(
					'controller_name' => ucfirst(basename($file['path'])),
					'controller_key' => basename($file['path'], EXT),
					'directory' => $file['module']
				);

				$control_insert = $this->t_controller->get_data_by_property('*', $control_data);

				if (count($control_insert)) {

					$control_insert = $control_insert[0];

				}

				$controllers_list[$key] = $file_list[$key];

				$controllers_list[$key]['id'] = $control_insert['id'];
			
			}

		}

		return $controllers_list;

	}

	/**
	 * Create a record
	 * @return void
	 */
	public function create() {

		if ($this->input->post()) {

			$data = $this->parse_data_post();

			$data['controller_key'] = strtolower($data['controller_name']);

			$contrl = $this->parse_fields_table($data, $this->t_controller->table_name);

			$insert = $this->t_controller->set_data($contrl, 1);

			if ($insert) {

				$this->generate = $this->load->controller('generate');

				if (method_exists('generate', 'controller')) {

					$this->response = $this->generate->controller($data);

				}
				else {

					flash_error(lang('Function_not_found'));

				}

			}
			else {

				flash_error(lang('Save_error'));

			}

			$this->redirect();

		}
		else {

			$this->load->model('t_template');

			$this->data['templates'] = $this->t_template->get_data_by_property('*', array());

			$this->load->model('t_platform');

			$this->data['platforms'] = $this->t_platform->get_data_by_property('*', array());

		}

	}

	/**
	 * Insert or update a record
	 * @param string $path Defaults to NULL
	 * @return void
	 */
	public function edit($path = NULL) {

		if ($this->input->is('post')) {

			$data = $this->input->post('content_body');

			$file = $this->input->post('file_path');

			$data = html_entity_decode($data);

			$error = '';

			if (substr($file, -3) == 'php') {

				$tmp = getcwd().'/temp/php_check_syntax.php';

				@file_put_contents($tmp, trim($data));

				$error = $this->php_check_syntax($tmp);

				$error = str_replace($tmp, $file, $error);

			}

			if (is_null($error) || empty($error)) {

				@file_put_contents($file, trim($data));

			}

			if (!is_null($error) && !empty($error)) {

				flash_error($error);

				$result->modal = 1;

			}
			else {

				flash_success(lang('Saved'));

			}

			$segments = array($this->router->class, 'edit', base64_encode($file));

	        $this->redirect($segments);

		}
		else {

			$path = base64_decode($path);

			if ($path == null || !is_file($path)) {

				flash_error(lang('File_not_found'));

	            $segments = array($this->router->class, 'index');

	            $this->redirect($segments);

			}
			else {

				$this->data['file_view'] = $path;

				$this->data['file_type'] = 'php';

				$page_content = null;

				$file = fopen($path,"r");

				while(! feof($file)) {

					$page_content .= fgets($file);

				}

				fclose($file);

				$this->load->extension('ace-builds');

				$this->data['page_content'] = trim($page_content);

				$this->render(null, 'system/edit_view', $this->data, false);

			}

		}

	}

	public function detail($file='', $id)
	{

		if ($this->input->is('post')) {

			if (!$this->input->post('id')) {

				$this->response->message = lang('Data_not_found');

				$this->response_message();

			}

			$id = $this->input->post('id');

			$template_key = $this->input->post('template_key');

			if ($template_key) {

				$this->load->model('t_controller');

				$control_data = $this->t_controller->get_data_by_id('*', $id);

				if (!count($control_data)) {
			
					flash_error(lang('Controller_data_not_found'));

				}
				else {

					$control_data['template_key'] = $template_key;

					if ($this->t_controller->update_data_by_id($control_data, $id)) {
						
						flash_success(lang('Updated'));

					}
					else {

						flash_error(lang('Update_error'));

					}

				}

			}
			else {

				flash_error('Missing_data');

			}

			$this->redirect(['controllers', 'detail']);

		}

		if (!$id) {
			
			flash_error(lang('Missing_id_parametter'));

			$this->redirect();

		}

		$this->load->model('t_controller');

		$control_data = $this->t_controller->get_data_by_id('*', $id);

		if (!count($control_data)) {
			
			flash_error(lang('Controller_data_not_found'));

			$this->redirect();

		}

		$this->data['control_data'] = $control_data;

		$this->data['file_path'] = $file;

		$this->load->model('t_template');

		$this->data['templates'] = $this->t_template->get_data_by_property('*');

	}

	/**
	 * Delete a record
	 * @param string $filename
	 * @return void
	 */
	public function delete($file = null)
	{

		if ($this->input->is('post')) {

			if (!$this->input->post('file')) {

				flash_error(lang('Data_not_found'));

				$this->redirect();

			}

			$file = base64_decode($this->input->post('file'));

		}
		else {

			$file = base64_decode($file);

		}

		if (is_file($file)) {

			$arr_controls = array(
				$file
			);

			$this->response->data = (object) $arr_controls;

			$this->response->data->element = (object) array();

			foreach ($arr_controls as $key => $control) {

				$this->response->data->element->$key = base64_encode($control);

				@unlink($control);

			}

			flash_success(lang('Deleted'));

		}
		else {

			flash_error(lang('File_not_found'));

		}

		$this->redirect();

	}

}