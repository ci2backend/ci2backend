<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Databases extends MY_Controller
{

	public function __construct() {

		parent::__construct();

	}

	/**
	 * Fetch and display records
	 * @return void
	 */
	public function index() {

		$db['default']['database'] = $this->db->database;

		$this->data['db'] = $db;

	}

	public function reset()
	{

		if ($this->input->is('post')) {
			
			if ($this->input->post()) {
				
				if (!$this->input->post('db')) {

					$this->response->success = true;

					$this->response->message = lang('Data_not_found');

				}
				else {

					error_reporting(0);

					$db = $this->input->post('db');

					if ($db['default']['database'] != $this->db->database) {

						$this->response->message = lang('Database_not_found');

						$this->response_message();

					}

					$dbs = $this->db->list_tables();

					$this->load->dbutil();

					$message = array();

					$folder_name = 'database/';

					$path = getcwd(); // Codeigniter application /assets

					$restore_file = $path . '/' .$folder_name . '/' . 'base-database.sql';

					if (!file_exists($restore_file)) {

						$this->response->message = lang('File_not_found');

						$this->session->set_flashdata('message', lang('File_not_found'));

						$this->response_message();

					}

					$file_restore = $this->load->file($restore_file, true);

					$file_array = explode(';', $file_restore);

					foreach ($file_array as $query) {

						$query = trim($query);

						if (!empty($query) && strlen($query)) {

							$this->db->query("SET FOREIGN_KEY_CHECKS = 0");

						 	$this->db->query($query);

						 	$this->db->query("SET FOREIGN_KEY_CHECKS = 1");

						}

					}

					$this->response->data = (object) array(
						'code' => TIMEOUT_SECURITY_CODE
					);

					flash_success(lang('Database_has_been_reset_Please_login_again'));

				}

			}
			else {

				flash_error(lang('Data_not_found'));

			}

		}
		else {

			flash_error(lang('Not_allow_method_GET'));

		}

		$this->redirect();

	}

	/**
	 * Create a record
	 * @return void
	 */
	public function create() {

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
	public function delete($id) {

	}

	public function rename()
	{

		if ($this->input->post()) {
			
			$data = $this->parse_data_post();

			if (empty($data['db_new_name'])) {

				$this->response->data = $_POST;

				flash_success(lang('Please_input_new_database_name'));

			}
			else if ($data['db_new_name'] != $data['db_old_name']) {
				
				$resultQuery = $this->db->query('CREATE DATABASE IF NOT EXISTS '.$data['db_new_name'].';');

				if ($resultQuery) {

					$query = 'SELECT concat(\'RENAME TABLE '.$data['db_old_name'].'.\',table_name, \' TO '.$data['db_new_name'].'.\',table_name, \';\') AS \'RENAME_QUERY\' FROM information_schema.TABLES WHERE table_schema=\''.$data['db_old_name'].'\';';

					$arrQuery = $this->db->query($query);

					if (count($arrQuery->result_array()) > 0) {

						foreach ($arrQuery->result_array() as $key => $value) {

							$conver = $this->db->query($value['RENAME_QUERY']);

						}

					}

					$db['default'] = array(
						'database' => $data['db_new_name']
					);

					$_POST['db'] = $db;

					$this->dev = $this->load->controller('dev');

					$changed = $this->dev->change_db_setting();

					if (!$changed) {

						$this->db->query('USE '.$data['db_new_name'].';');

						$this->response->data = $_POST;

						flash_error(lang('Cant_change_setting_database'));

					}
					else {

						$this->db->query('DROP DATABASE IF EXISTS '.$data['db_old_name'].';');

						$this->response->data = $_POST;

						flash_success(lang('Change_database_success'));

					}

				}
				else {

					$this->response->data = $_POST;

					flash_error(lang('Transfer_data_error'));

				}

			}
			else {

				$this->response->data = $_POST;

				flash_error(lang('Database_name_has_existed'));

			}

			$this->redirect();

		}

	}

}