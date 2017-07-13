<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dev extends MY_Controller {

	function __construct() {

		parent::__construct();

	}

	public function index()
	{

		$folder = BASEPATH;

		if (substr((int)sprintf('%o', fileperms($folder)), -4) <= 0775) {
			
			$this->data['permission_folder'] = true;

		}

		$this->load->model('t_module');

		$this->data['modules'] = $this->t_module->get_data_by_property('*', array(
				'is_show' => 1
			)
		);

	}

	protected function default_controller()
	{

		if ($this->input->post()) {

			if ($this->ion_auth->is_admin()) {

				$this->response->message = lang('Data_not_found');

				$this->response->data = $this->input->post();

				$folder = getcwd()."/application/config/";

				$file = "routes.php"; /* original file */

				if ($this->rewrite_file($folder, $file)) {

					$this->response->success = 1;

					$this->response->message = lang('Saved');

					$this->response->data = $this->input->post();
					
				}
				else {

					$this->response->message = lang('Save_error');

					$this->response->data = $this->input->post();

				}

			}
			else {

				$this->response->message = "Must admin role";

			}

		}
		else {

			$this->response->message = "Please input data";

		}

		$this->response_message();

	}

	
	public function profile($tabActive = 'user_profile')
	{

		$funcs = array(
			'user_profile',
			'user_settings'
		);

		foreach ($funcs as $key => $func) {

			if (in_array($func, $this->funcs)) {
			
				$this->$func($this->data['user']['id']);

			}

		}

		$this->data[$tabActive] = 'active';

	}

	protected function save_profile($id = null)
	{

		if (is_null($id)) {
			
			$id = $this->data['user']['id'];

		}

		if ($this->input->post()) {

			// do we have a valid request?
	        if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
	            
	            show_error($this->lang->line('error_csrf'));
	            
	        }
	        
	        //update the password if it was posted
	        if ($this->input->post('password')) {
	            
	            $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
	            
	            $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
	            
	        }

	        //validate form input
	        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
	        
	        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
	        
	        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
	        
	        $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');
	        
	        if ($this->form_validation->run() === TRUE) {

	        	$post =  $this->parse_data_post();

	        	$this->load->model('t_user');

	        	$fields = $this->db->list_fields($this->t_user->table_name);
	            
	            $data = $this->array_intersect($post, $fields);

	            unset($data['id']);

	            unset($data['password']);
	            
	            //update the password if it was posted
	            if ($this->input->post('password')) {
	                
	                $data['password'] = $this->input->post('password');
	                
	            }
	            
	            // Only allow updating groups if user is admin
	            if ($this->ion_auth->is_admin()) {
	                
	                //Update the groups user belongs to
	                $groupData = $this->input->post('groups');
	                
	                if (isset($groupData) && !empty($groupData)) {
	                    
	                    $this->ion_auth->remove_from_group('', $id);
	                    
	                    foreach ($groupData as $grp) {

	                        $this->ion_auth->add_to_group($grp, $id);

	                    }
	                    
	                }
	                
	            }
	            
	            //check to see if we are updating the user
	            if ($this->ion_auth->update($id, $data)) {
	                
	                //redirect them back to the admin page if admin, or to the base url if non admin
	                $this->session->set_flashdata('message', $this->ion_auth->messages());

	                $this->response->success = true;
	                
	                $this->response->message = $this->ion_auth->messages();
	                
	            } else {
	                
	                //redirect them back to the admin page if admin, or to the base url if non admin
	                $this->session->set_flashdata('message', $this->ion_auth->errors());

	                $this->response->message = $this->ion_auth->messages();
	                
	            }
	            
	        }
	        else {

	        	$this->response->success = false;

	        	$this->response->message = validation_errors();

	        }

		}

		return $this->response;

	}

	public function user_profile($id)
	{

		$this->data['title'] = "Edit User";
        
        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
            
            redirect('auth', 'refresh');
            
        }
        
        $user = $this->ion_auth->user($id)->row();
        
        $groups = $this->ion_auth->groups()->result_array();
        
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        //display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();
        
        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        $this->data['user'] = $this->ion_auth->user($id)->result_array()[0];
        
        $this->data['groups'] = $groups;
        
        $this->data['currentGroups'] = $currentGroups;
        
        $this->data['operation_action'] = array(
            'name' => 'operation_action',
            'id' => 'operation_action',
            'type' => 'hidden',
            'value' => 'save_profile',
            'class' => 'form-control input-medium'
        );

        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
            'class' => 'form-control input-medium'
        );
        
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
            'class' => 'form-control input-medium'
        );
        
        $this->data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'value' => $this->form_validation->set_value('company', $user->company),
            'class' => 'form-control input-medium'
        );
        
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone),
            'class' => 'form-control input-medium'
        );

        $this->load->model('t_language');

        $lang_arr = $this->t_language->get_data_by_property('*');

        $option = array();

        if (count($lang_arr) > 0) {

        	foreach ($lang_arr as $key => $lang) {

				$option[$lang['lang_folder']] = $lang['lang_display'];

        	}

        }

        $this->data['lang_arr'] = $option;

        $this->data['lang_default'] = $user->lang_folder;
        
        $this->data['password']         = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password',
            'class' => 'form-control input-medium'
        );

        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password',
            'class' => 'form-control input-medium'
        );

	}

	public function user_settings($id='')
	{
		
		$this->data['languages'] = $this->t_language->get_data_by_property('*');

	}

	private function save_settings()
	{

		if ($this->input->post('settings')) {

			$settings = $this->input->post('settings');

			if (is_array($settings) && count($settings)) {

				$this->load->model('t_setting');

				foreach ($settings as $key => $set) {

					$update = array(
						'value_setting' => $set
					);

					$where = array(
						'key_setting' => $key
					);

					$this->t_setting->update_data_by_property($update, $where);

				}

				$this->response->message = 'System settings saved';

				$this->response->success = 1;

			}
			else {

				$this->response->message = 'Nothing changed setting';

				$this->response->success = 1;

			}

		}
		else {

			$this->response->message = lang('Data_not_found');

			$this->response->success = 1;
			

		}
		
		$this->response_message();

	}

	private function system_configure()
	{

		if ($this->input->post()) {

			if (!$this->input->post('config')) {

				$this->response->message = lang('Data_not_found');

			}
			else {

				$folder = getcwd()."/application/config/";

				$file = "config.php"; /* original file */

				$oldTableName = $this->db->dbprefix.$this->config->item('sess_table_name');

				if ($this->rewrite_file($folder, $file)) {

					$config = $this->input->post('config');

					$this->response->success = 1;

					$this->response->message = lang('Saved');

					$change = $this->db->dbprefix.$config['sess_table_name'] != $oldTableName;

					if ($change) {

						$newTableName = $this->db->dbprefix.$config['sess_table_name'];

						$tableCmd = 'RENAME table `'.$oldTableName.'` TO `'.$newTableName.'`;';

						$rename = $this->db->query($tableCmd);

					}

				}
				else {

					$this->response->message = lang('Save_error');

				}

			}

		}
		else {
			
			$this->response->message = lang('Not_allow_method_GET');

		}

		$this->response_message();

	}

	public function db_resetdb()
	{

		if ($this->input->post()) {

			if (!$this->input->post('db')) {

				$this->response->success = true;

				$this->response->message = 'Missing data';

			}
			else {

				error_reporting(0);

				$db = $this->input->post('db');

				if ($db['default']['database']!= $this->db->database) {

					$this->response->message = 'Database not found';

					$this->response_message();

				}

				$dbs = $this->db->list_tables();

				$this->load->dbutil();

				$this->response->success = true;

				$this->response->message = 'This function is temporary progress';

				$message = array();

				$folder_name = 'database/';

				$path = getcwd(); // Codeigniter application /assets

				$restore_file = $path . '/' .$folder_name . '/' . 'base-database.sql';

				if (!file_exists($restore_file)) {

					$this->response->message = lang('File_not_found');

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

				$this->response->message = lang('Database_has_been_reset_Please_login_again');

			}
			
		}
		else {

			$this->response->message = lang('Not_allow_method_GET');

		}

		$this->response_message();

	}

	protected function db_repair_database()
	{

		if ($this->input->post()) {

			if (!$this->input->post('db')) {

				$this->response->message = lang('Data_not_found');

			}
			else {

				$db = $this->input->post('db');

				$dbs = $this->db->list_tables();

				$this->load->dbutil();

				$this->response->success = 1;

				$this->response->message = 'This function is temporary progress';

				$message = array();

				// foreach ($dbs as $tb) {

				//     $this->db->query("SET FOREIGN_KEY_CHECKS = 0");

				//     $query = "DROP TABLES `$tb`";

				// 	$drop = $this->db->query($query);

				// 	$this->db->query("SET FOREIGN_KEY_CHECKS = 1");

				// }

				// $result['message'] = 'Successful drop table';

			}
			
		}
		else {

			$this->response->message = lang('Not_allow_method_GET');

		}

		$this->response_message();

	}

	/**
	 * public function for ajax access checking database name
	 * @return string Json string status
	 */
	public function db_check_database()
	{

		if ($this->input->post('db')) {

			$db = $this->input->post('db');

			$db_obj = $this->load->database('default',TRUE);

  			$connect = $db_obj->initialize();

			$dbname = $db['default']['database'];

			var_dump($dbname); exit();

			if ($dbname == $this->db->database) {

				$this->load->dbutil();

				if ($this->dbutil->database_exists($dbname)) {

					$this->response->success = 1;

					$this->response->message = 'Temporary function';

				}
				else {

					$this->response->message = "Could not open the db '$dbname'";

				}

			}
			else {

				$this->response->message = "Database name is wrong. Please check your database configure";

			}

		}
		else {

			$this->response->message = lang('Not_allow_method_GET');

		}

		$this->response_message();

	}

	public function db_check_connection()
	{

		if ($this->input->post('db')) {

			$db = $this->input->post('db');

			$connect = @mysqli_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password']);

			if ($connect) {

				$dbname = $db['default']['database'];
			
				if (@mysqli_select_db($connect, $dbname)) {

					$test_query = "SHOW TABLES FROM $dbname";

					$result = mysqli_query($connect, $test_query);

					$tblCnt = 0;

					while($tbl = mysqli_fetch_array($result)) {

					  	$tblCnt++;

					}

					if (!$tblCnt) {

						$this->response->success = 1;

						$this->response->message = $this->lang->line('There_are_no_tables');


					} else {

						$this->response->success = 1;

						$this->response->message = sprintf($this->lang->line('There_are_n_tables'), $tblCnt);

					}

				}
				else {

					$this->response->message = sprintf($this->lang->line('Could_not_open_the_db_n'), $dbname);

				}

			}
			else {

				$this->response->message = "Unable to Connect to ".$db['default']['hostname'];

			}

		}
		else {

			$this->response->message = $this->lang->line('Data_not_found');

		}

		$this->response_message();

	}

	public function change_db_setting()
	{

		$folder = getcwd()."/application/config/";

		$file = "database.php"; /* original file */

		return $this->rewrite_file($folder, $file);

	}

	public function form_ajax()
	{

		if (!$this->input->is_ajax_request()) {
			
			show_error(lang('Must_ajax_request_access'));

		}

		if ($this->input->is('post')) {

			if (!$this->input->post()) {

				$this->response->message = lang('Data_not_found');

				$this->response_message();

			}

			$controls = $this->input->post('controls');

			if ($this->input->post('operation_action')) {

				$action = $this->input->post('operation_action');

				$arguments = $this->uri->rsegments;

				unset($arguments[1]);

				unset($arguments[2]);

				if (in_array($action, $this->funcs)) {

					if ( ! is_callable(array($this, $action))) {

			            throw new InvalidArgumentException(lang('Callback_needs_to_be_a_function'));

			        }
			        else {

			        	$this->response = call_user_func_array(array($this, $action), $arguments);

			        }

				}
				else if (!$controls && !in_array($action, $this->funcs)) {

					$this->response->message = lang('Can_not_access_this_function_or_does_not_exist');

					$this->response_message();

				}
				else {

					if (isset($controls) && $controls) {

						$this->{$controls} = $this->load->controller($controls);

						$this->funcs = $this->get_all_method_of_class($controls);

						if (in_array($action, $this->funcs)) {

							if ( ! is_callable(array($this->{$controls}, $action))) {

					            throw new InvalidArgumentException(lang('Callback_needs_to_be_a_function'));

					        }
					        else {

					        	$this->response = call_user_func_array(array($this->{$controls}, $action), $arguments);

					        }

						}
						else {

							$this->response->message = lang('Can_not_access_this_function_or_does_not_exist');

						}

					}
					else {

						$this->response->message = lang('Missing_controller');

					}

				}

			}
			else {

				$this->response->message = "Missing_operation_action";

			}

		}
		else {

			$this->response->message = lang('Not_allow_method_GET');

		}

		$this->response_message();

	}

	private function change_db_connection()
	{

		if ($this->input->post()) {

			$data = $this->parse_data_post();

			$this->response->message = lang('Data_not_found');

			if (isset($data['db']) && isset($data['db']['default'])) {

				if (isset($data['operation_action'])) {

					if (count($data['db']['default'])) {

						$rename = $this->db->dbprefix != $data['db']['default']['dbprefix'];

						if ($rename) {
							
							$tables = $this->db->query('select table_name from information_schema.tables where table_schema="'.$this->db->database.'"');
							
							$listTable = $tables->result_array();

							if (count($listTable) && $rename) {

								foreach ($listTable as $key => $table) {
									
									$tableCmd = 'RENAME table `'.$table['table_name'].'` TO `'.$data['db']['default']['dbprefix'].str_replace($this->db->dbprefix, '', $table['table_name']).'`;';

									$rename = $this->db->query($tableCmd);

								}

							}

						}

						$folder = getcwd()."/application/config/";

						$file = "database.php"; /* original file */

						if (!$this->rewrite_file($folder, $file)) {

							$this->response->message = 'Can\'t write setting database file';

						}

						$this->response->success = 1;

						$this->response->message = 'Change setting database success.';

						if ($rename) {

							$this->response->message .= ' Change prefix to '. $data['db']['default']['dbprefix'];

						}

					}

				}
				else {

					$this->response->message = 'Missing action name';

				}

			}
			else {

				$this->response->message = lang('Data_not_found');

			}

		}
		else {

			$this->response->message = lang('Not_allow_method_GET');

		}

		if ($this->input->is_ajax_request()) {

			$this->response_message();

		}
		else {

			$this->redirect(array('dev', 'setting'));

		}

	}

	public function setting($tabActive = 'site_settings')
	{

		$this->data['db']['default'] = (array) $this->db;

		$this->data['route'] = (array) $this->router;

		$this->data['config'] = $this->config->config;

		$controllers = array();

	    $this->load->helper('file');

	    $this->load->model('t_language');

	    $this->data['languages'] = $this->t_language->get_data_by_property('*', array());

	    $this->load->model('t_platform');

	    $this->data['platforms'] = $this->t_platform->get_data_by_property('*', array());

	     $this->load->model('t_template');

	    $this->data['templates'] = $this->t_template->get_data_by_property('*', array());

	    $this->data['dbdriver'] = array(
	    	'mysql' => 'mysql',
	    	'mysqli' => 'mysqli'
	    );

	    $this->data['controllers'] = $this->get_controller_list();

	    $this->set_active_tab();

	    $this->load->model('t_constants');

	    $this->data['list_constant'] = $this->t_constants->get_data_by_property('*', ['is_system' => 0]);

	}

	public function formbuilder()
	{

		$this->load->extension('formbuilder');

		$this->render(null, 'system/formbuilder', $this->data);

	}

	public function delete()
	{

		if ($this->input->is_ajax_request()) {

			if ($this->input->post()) {

				$control_class = $this->input->post('control');

				$file = $this->input->post('file');

				if ($file && $control_class) {

					$this->{$control_class} = $this->load->controller($control_class);

					if (method_exists($this->{$control_class}, 'delete')) {

						$this->{$control_class}->delete();

					}
					else {

						$this->response->message = lang('Method_not_found');

					}

				}
				else {

					$this->response->message = lang('Data_not_found');

					$this->response_message();

				}

			}
			else {

				echo WRONG_METHOD_SECURITY_CODE; exit();

			}

		}
		else {

			$this->session->set_userdata('title_mess_code', 'Warning message');

        	$this->session->set_userdata('type_mess_code', WARNING_CLASS);

            $this->session->set_userdata('error_flag_code', 1);

            $this->session->set_userdata('error_mess_code', "Can't access this function by current method !");

            $segments = array($this->router->class, 'index');

            $this->redirect($segments);

		}

	}

	private function del_models($filename = null)
	{

		if (count($filename) > 0) {

			$root = APPPATH.'models/';

			$file = $root.$filename;

			if (is_file($file)) {

				$conf = $root.'config_model.ini';

				$is_write = false;

				if (is_file($conf)) {

					$ini_array = parse_ini_file($conf);

					foreach ($ini_array as $key => $ini) {

						if ($key == str_replace('.php', null, $filename)) {

							@unlink($ini_array[$key]);

							$is_write = true;

						}

					}

				}

				if (unlink($file)) {

					if ($is_write) {

						$this->write_php_ini($ini_array, APPPATH.'models/'."config_model.ini");

					}

					$this->response->success = 1;

					$this->response->message = 'Deleted file '.$filename.' successfully';

					return $this->response;

				}
				else {

					$this->response->message = 'Can\'t delete file';

					return $this->response;

				}

			}
			else {

				$this->response->message = 'Can\'t found file '.$filename;

				return $this->response;

			}

		}

	}

	private function del_views()
	{

		if (!$this->input->post('file')) {

			$this->response->message = 'Missing data file !';

			$this->response_message();

		}

		$this->views = $this->load->controller('views');

		return $this->views->delete();

	}

	private function del_platforms()
	{

		if (!$this->input->post('file')) {

			$this->response->message = 'Missing data file !';

			$this->response_message();

		}

		$this->response->success = 1;

		$this->response->message = 'Temporary function !';

		$this->response_message();

	}

	private function del_my_constants($id = null) {

		$this->response->message = lang('Data_not_found');

		if (is_null($id) || $id == '') {

			$this->response_message();

		}

		$this->my_constants = $this->load->controller('my_constants');

		$this->my_constants->delete($id);

	}

	private function rewrite_file($folder, $file)
	{

		$originalFile = $folder.$file; /* original file */

		$sourceFile = $folder.$file; /* original file */

		$haystack = file($originalFile); /* put contents into an array */

		if ($this->input->post()) {

			$dbrw = array();

			if ($this->input->post('db')) {

				$dbrw = $this->input->post('db');

				$parent = '$db';

			}
			elseif ($this->input->post('config')) {

				$dbrw = $this->input->post('config');

				$parent = '$config';

			}
			elseif ($this->input->post('route')) {

				$dbrw = $this->input->post('route');

				$dbrw['default_controller'] = base64_decode($dbrw['default_controller']);

				$parent = '$route';

			}

			$arrReplace = array();

			$this->parse_arr_2_str($arrReplace, $parent, $dbrw);

			$arrReplace = array_filter($arrReplace);

			if (count($arrReplace)) {

				foreach ($arrReplace as $key => $replace) {

					$line = explode(' = ', $replace);

					$var = str_replace($parent, '', $line[0]);

					$var_key = str_replace('$', '', $parent);

					if ($this->input->post('route')) {

						$parent_arr = (array)$this->router->routes;

					}
					else {

						$parent_arr = (array)$this->$var_key;

					}

					$var = array_filter(preg_split("/[\[\'|\'\],]+/", $var, null, PREG_SPLIT_DELIM_CAPTURE));

					$value = $this->loop_var_value($parent_arr, $parent, $var);

					if ($value !== null) {

						if (is_bool($value)) {

							if ($value) {

								$value = 'TRUE';

							}
							else {

								$value = 'FALSE';

							}

						}


						for( $i = 0; $i < count($haystack); $i++) {

							if (strpos($haystack[$i], $parent) === 0) {
								
								$haystack[$i] = str_replace("\t", "", $haystack[$i]);

								$haystack[$i] = str_replace("']= ", "'] = ", $haystack[$i]);
								
							}

							if ($value == '') {

								$replaceBy_2 = $line[0] . ' = \''.'\'';

							}
							else {

								$replaceBy_2 = $line[0] . ' = \''.$value.'\'';

							}

							$replaceBy_3 = $line[0] . ' = "'.$value.'"';

							$non_string = ($value === "TRUE") || 
							($value === "FALSE") || 
							($value === true) || 
							($value === false) || 
							is_numeric($value);

							if ($non_string) {

								$replaceBy_1 = $line[0] . ' = '.$value;

								$haystack[$i] = str_ireplace($replaceBy_1, $replace, $haystack[$i]); /* case insensitive replacement */

							}
							
							$haystack[$i] = str_ireplace($replaceBy_2, $replace, $haystack[$i]); /* case insensitive replacement */
							
							$haystack[$i] = str_ireplace($replaceBy_3, $replace, $haystack[$i]); /* case insensitive replacement */
						
						}

					}

				}

				$content = implode("", $haystack); /* put array into one variable with newline as delimiter */

				$dir_writable = substr((int)sprintf('%o', fileperms($folder)), -4) >= 774 ? "true" : "false";
				
				if ($dir_writable) {
					
					@file_put_contents($sourceFile, $content); /* over write original with changes made */

					if ($this->input->post('db')) {

						$db = $this->input->post('db');

						if (isset($db['default']['database'])) {

							$this->db->database = $db['default']['database'];

							$this->db->query('USE '.$db['default']['database'].';');
							
						}

					}

					return true;

				}
				else {

					return false;

				}

			}

		}
		else {

			return null;

		}

	}

	/**
	 * Parse array to array contain string
	 * @param  array  &$arrStr array contain sting result
	 * @param  string $parent  string variable key
	 * @param  array  $arr     array to parse
	 * @return array          array contain string variable key
	 */
	protected function parse_arr_2_str(&$arrStr = array(), $parent, $arr = array())
	{

		if (is_array($arr)) {

			foreach ($arr as $key => $val) {

				$str = "$parent"."['".$key."']"." = ";

				$str_1 = '';

				$str_2 = '';

				if (is_array($val)) {

					$parent = "$parent"."['".$key."']";

					$this->parse_arr_2_str($arrStr, $parent, $val);

				}
				else {

					$non_string = ($val === "TRUE") || 
					($val === "FALSE") || 
					($val === true) || 
					($val === false) || 
					is_numeric($val);

					if ($non_string) {

						$str_1 = $str . $val;

					}
					else {

						if (empty($val)) {

							$str_1 = $str . '\'\'';

							$str_2 = $str . '\'\'';

						}
						else {

							$str_1 = $str . '\''.$val.'\'';

							$str_2 = $str . '"'.$val.'"';

						}

						array_push($arrStr, $str_2);

					}

				}

				array_push($arrStr, $str_1);

			}

			return $arrStr;

		}

	}

	/**
	 * Loop variable
	 * @param  object $var    object variable
	 * @param  string $parent string to create string variable
	 * @param  array  $arr    array loop
	 * @return string         string variable before loop
	 */
	public function loop_var_value($var, $parent, $arr = array())
	{

		foreach ($arr as $key => $a) {

			if ($parent == '$db' && isset($arr[1]) && $arr[1] == 'default') {

				if ($key == 1) {

					continue;

				}

			}

			if ($parent == '$config') {

				$var = $var['config'];

			}

			$var = $var[$a];

		}

		if (!is_object($var) && !is_array($var)) {

			return $var;

		}

		return '';

	}

	private function import_dump($path = null) {

		$folder_name = 'dumps';

		$path = 'assets/backup_db/'; // Codeigniter application /assets

		$file_restore = $this->load->file($path, true);

		$file_array = explode(';', $file_restore);

		foreach ($file_array as $query) {

			$this->db->query("SET FOREIGN_KEY_CHECKS = 0");

			$this->db->query($query);

			$this->db->query("SET FOREIGN_KEY_CHECKS = 1");

		}

	}

	public function confirm_delete($uri_string='')
	{

		$delete_uri_string = base64_decode($uri_string);

		if ($delete_uri_string) {

			$delete_data = explode('/', $delete_uri_string);

			$this->data['file'] = base64_decode($delete_data[2]);

			$this->data['uri_referrer'] = site_url($delete_data[0]);

			if ($this->agent->is_referral()) {

				$this->data['uri_referrer'] = $this->agent->referrer();

			}

			if (empty($this->data['file'])) {
				
				flash_error(lang('Delete_data_not_found'));

				$this->redirect(array(
						$delete_data[0]
					)
				);

			}

			$this->data['delete_confirm_code'] = $uri_string;

			$this->session->set_userdata('delete_confirm_code', $uri_string);

			$this->data['delete_uri_string'] = $delete_uri_string;

			$this->data['delete_confirm_target'] = $delete_uri_string;

			$this->session->set_userdata('delete_confirm_target', $delete_uri_string);

			if ($this->input->is('post')) {

				$post = $this->input->post();

				if (isset($post['delete_confirm_code']) && $post['delete_confirm_code'] == $uri_string) {

					if (isset($post['delete_confirm_target']) && $post['delete_confirm_target']) {

						$this->redirect($delete_data);

					}
					else {

						flash_error(lang('Action_not_found'));

					}

				}
				else {

					flash_error(lang('Confirm_code_not_match'));

				}

			}

		}
		else {

			show_error(lang('Data_not_found'));

		}

	}

}

/* End of file dev.php */
/* Location: ./application/controllers/dev.php */