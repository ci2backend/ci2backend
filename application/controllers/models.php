<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Models extends MY_Controller
{

	public function __construct() {

		parent::__construct();


	}

	/**
	 * Fetch and display records
	 * @return void
	 */
	public function index() {

		$model_uri = APPPATH.'models';

		$pattern = '/[.]/i';

		$dir = $this->get_dir($model_uri, $pattern);

		$view_platform = $this->fetch_key($dir);

		$this->data['view_platform'] = $view_platform;

		$path = $model_uri;

		$dir_view = $this->get_view($data = array(), $path);

		$file_list = $this->parser_dir($dir_view, $result = array(), $path);

		$conf = $model_uri.'/config_model.ini';

		$ini_arr = array();

		if (is_file($conf)) {

			$ini_arr = parse_ini_file($conf);

		}

		if (count($ini_arr) > 0) {
			
			foreach ($file_list as $key => $file) {

				$k = str_replace('.php', null, $file['file']);

				if (isset($ini_arr[$k])) {

					$file_list[$key]['table'] = $ini_arr[$k];

				}
				else{

					$file_list[$key]['table'] = htmlentities('<none install>');

				}

			}	
			
		}

		$this->data['file_list'] = $file_list;
		
	}

	/**
	 * Create a record
	 * @return void
	 */
	public function create() {

		if ($this->input->is('post')) {
			
			$data = $this->parse_data_post();

			$this->generate = $this->load->controller('generate');

			if (method_exists('generate', 'model')) {

				$this->response = $this->generate->model($data);

			}
			else {

				flash_error(lang('Function_not_found'));

			}

			$segments = array($this->router->class, 'create');

        	$this->redirect($segments);

		}
		else {

			$this->load->model('t_user');

			$tables = $this->t_user->list_tables();

			$this->data['tables'] = $tables;

		}

	}

	/**
	 * Insert or update a record
	 * @param int $id Defaults to NULL
	 * @return void
	 */
	public function edit($path = null) {
		
		if ($this->input->post()) {

			$content_body = $this->input->post('content_body');

			$file = $this->input->post('file_path');

			$content_body = html_entity_decode($content_body);

			@file_put_contents($this->input->post('file_path'), trim($content_body));

			flash_success(lang('Saved'));

			$segments = array($this->router->class, 'edit');

	        $this->redirect($segments);

		}
		else {

			$path = base64_decode($path);

			if ($path == null || !is_file($path)) {

				flash_error(lang('File_not_found'));

	            $segments = array($this->router->class);

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

				$this->data['page_content'] = trim($page_content);

				$this->load->extension('ace-builds');

				$this->render(null, 'system/edit_view', $this->data, false);

			}

		}

	}

	/**
	 * Delete a record
	 * @param int $id
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

		if (is_file($file) > 0) {

			$root = APP_MODEL;

			if (is_file($file)) {

				$arr_models = array(
					$file
				);

				$this->response->data = (object) $arr_models;

				$this->response->data->element = (object) array();

				foreach ($arr_models as $key => $view) {

					$this->response->data->element->$key = base64_encode($view);

					@unlink($view);

				}

				flash_success(lang('Deleted'));

			}
			else {

				flash_error(lang('File_not_found'));

			}

		}

		$this->redirect();

	}

}