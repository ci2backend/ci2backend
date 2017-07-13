
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Templates extends MY_Controller
{

	public function __construct() {

		parent::__construct();


	}

	/**
	 * Fetch and display records
	 * @return void
	 */
	public function index($is_backend = 0) {

		$this->load->model('t_template');

		$this->data['templates'] = $this->t_template->get_data_by_property('*', array(
				'is_backend' => $is_backend
			)
		);

		$this->data['is_backend'] = $is_backend;

	}

	/**
	 * Create a record
	 * @return void
	 */
	public function create() {

		if ($this->input->is('post')) {

			$post = $this->parse_data_post();

			$data = $this->parse_fields_table($post, $this->t_template->table_name);

			$this->form_validation->set_rules($this->t_template->rules_create);

            $this->t_template->set_message_validate();

            if ($this->form_validation->run() == false) {

                $errors = explode("\n", validation_errors());
                
                flash_error($errors[0]);

                $this->redirect();

            }
            else {

            	$new_template = $this->t_template->set_data($data, 1);

            	if (count($new_template)) {
            		
            		$template_config = $this->create_template_directory($new_template);

            		if ($template_config) {
            			
            			flash_success(lang('Created'));
            			
            		}
            		else {

            			$this->t_template->delete_by_id($new_template['id']);

            			flash_success(lang('Create_template_error'));

            		}

            	}
            	else {

            		flash_error(lang('Save_error'));

            	}

            }

            $this->redirect();

		}
		
	}

	/**
	 * Insert or update a record
	 * @param int $id Defaults to NULL
	 * @return void
	 */
	public function edit($id = NULL) {

	}

	public function detail($template_key = '')
	{

		if ($template_key) {

			$this->load->model('t_template');

			$tmpl = $this->t_template->get_data_by_property('*', array('template_key' => $template_key));

			if (count($tmpl) > 0) {

				$tmpl = $tmpl[0];

			}

			$template_path = valid_path(FCPATH.'assets/templates/'.$tmpl['template_key']);

			$template_config = valid_path($template_path.'/'.'config.json');

			$config = json_parse($template_config);

			$this->data['tmpl'] = $tmpl;

			$this->load->model('t_extension');

			$extension = $this->t_extension->get_data_by_property('*');

			$this->data['extension'] = $extension;

			$this->data['template_key'] = $template_key;

			$this->load->model('t_menu');

			$menus = $this->t_menu->get_data_by_property('*');

			$this->data['menus'] = $this->t_menu->get_data_by_property('*', array('is_show' => 1));

	        $menu_loader = $this->t_menu->get_menu_by_template('templates_menus.menu_id', array('templates_menus.template_key' => $template_key));
	        
	        if (count($menu_loader)) {

	        	foreach ($menu_loader as $key => $menu) {

		        	$menu_loader[$key] = $menu['menu_id'];

		        }
		        
	        }
	        else {

	        	$menu_loader = array();

	        }

	        $this->data['tmpl_menu_list_selected'] = $menu_loader;

	        $template_config = TEMPLATE_DIR.$template_key.SLASH.'config.json';

	        $conf = new stdClass();

	        if (is_file($template_config)) {

	        	$conf = json_parse($template_config, false);

	        }

	        $this->data['dependencies'] = array();
	        
	        if (isset($conf->dependencies) && count($conf->dependencies)) {

	        	$this->data['dependencies'] = $conf->dependencies;

	        }

	        $list_depend = array();

	        $dependencies = $this->data['dependencies'];

			if (isset($dependencies) && count($dependencies)) {

				foreach ($dependencies as $key => $ext) {

					array_push($list_depend, $ext);

				}

			}

			$this->data['list_depend'] = $list_depend;

		}
		else {

			flash_error('Template_not_found');

			$this->redirect(array(
					'templates',
					'index'
				)
			);

		}

	}

	/**
	 * Delete a record
	 * @param int $id
	 * @return void
	 */
	public function delete($id = null)
	{

		if ($this->input->is('post')) {

			if (!$this->input->post('file')) {

				$this->response->message = lang('Data_not_found');

				$this->response_message();

			}

			$id = base64_decode($this->input->post('file'));

		}
		else {

			$id = base64_decode($id);

		}

		if ($id) {

			$template = $this->t_template->get_data_by_id('*', $id);

			if (count($template)) {

				$this->db->where($template);

				$deleted = $this->db->delete($this->t_template->table_name);

				if ($deleted) {

					$template_data = array(
						FCPATH.TEMPLATE_PATH.$template['template_key'],
						FCPATH.APP_VIEW.VIEW_TEMPLATE.$template['template_key'],
						FCPATH.APP_VIEW.COMMON_VIEW_DIR.$template['template_key']
					);
					
					$this->response->data = (object) $template_data;

					$this->response->data->element = (object) array();

					foreach ($template_data as $key => $tmpl_path) {

						_Rmdir(valid_path($tmpl_path));

						$this->response->data->element->$key = $template['template_key'];

					}

					flash_success(lang('Deleted'));

				}
				else {

					flash_success(lang('Delete_error'));

				}

			}
			else {

				flash_error(lang('Template_not_found'));

			}

		}

		$this->redirect();

	}

	public function check_existed_template_key($key='')
	{

		if ($key) {

			$this->load->model('t_template');

			$template = $this->t_template->get_data_by_property('*', array('template_key' => $key));

			if (count($template) > 0) {

				return $template;

			}

			return false;

		}

		return true;

	}

	public function create_template_directory($tempate_data)
	{
		
		if ($this->check_existed_template_key($tempate_data['template_key'])) {
			
			$template_root_path = TEMPLATE_DIR;

			$template_path = $template_root_path . $tempate_data['template_key'];

			@mkdir(valid_path($template_path));

			@mkdir(valid_path($template_path . '/css/'));

			@mkdir(valid_path($template_path . '/js/'));

			$data_json = array(
				'name' => $tempate_data['template_name'],
				'key' => $tempate_data['template_key'],
				'description' => $tempate_data['description'],
				'css' => array(),
				'js' => array(),
				'dependencies' => array()
			);

			@file_put_contents(valid_path($template_path. '/config.json'), stripslashes(json_encode($data_json, JSON_PRETTY_PRINT)));
			
			@file_put_contents(valid_path($template_path. '/README.md'), '');

			$template_view_dir = APP_VIEW.VIEW_TEMPLATE.$tempate_data['template_key'];

			@mkdir($template_view_dir);

			$template_common_dir = APP_VIEW.COMMON_VIEW_DIR.VIEW_TEMPLATE.$tempate_data['template_key'];

			@mkdir($template_common_dir);

			$template_head_config = array(
				'header' => array('content' => ''),
				'main' => array(
					'content' => '<?php

if (file_exists(APPPATH."views/template/$template/header".\'.php\')) {

	$this->load->view("template/$template/header");

}

?>

<?php echo $content?>

<?php

if (file_exists(APPPATH."views/template/$template/footer".\'.php\')) {

	$this->load->view("template/$template/footer");
	
}

?>'
				),
				'footer' => array('content' => '')
			);

			foreach ($template_head_config as $key => $head) {

				$fp = fopen($template_view_dir.SLASH.$key.EXT, 'w');

				fwrite($fp, @$head['content']);

				fclose($fp);

			}

			if (is_dir($template_view_dir) && is_file(valid_path($template_path. '/config.json'))) {
				
				return $data_json;

			}

			return false;

		}

		return false;

	}

	public function template_loader()
	{

		if ($this->input->is('post')) {

			$data = $this->input->post();

			if (!isset($data['template_key'])) {

				flash_error('Template_directory_not_found');

			}
			else {

				$template_key = $data['template_key'];

				if (isset($data['save_template_setting'])) {
					
					if (isset($data['enable_customize_view'])) {

						$template_setting = array(
							'enable_customize_view' => $data['enable_customize_view'],
							'customize_view_folder' => $data['customize_view_folder']
						);
						
						$saved = $this->t_template->update_data_by_property($template_setting, array(
								'template_key' => $data['template_key']
							)
						);

						if ($saved) {

							flash_success(lang('Saved'));

						}
						else {

							flash_success(lang('Nothing_change'));

						}

					}
					else {

						flash_success(lang('Data_not_found'));

					}
					
				}

				if (isset($data['save_menu_list'])) {

					if (isset($data['template_menu_loaded_list'])) {
						
						$menu_lists = $data['template_menu_loaded_list'];

						if (count($menu_lists)) {

							$this->load->model('t_menu_loader');

							$where = array(
								'template_key' => $template_key
							);

							$del = $this->t_menu_loader->delete_data_by_property($where);

							if (!$del) {

								$data = array(
									'is_load' => 0
								);

								$where = array(
									'template_key' => $template_key
								);

								$this->t_menu_loader->update_data_by_property($data, $where);

							}
							else {

								foreach ($menu_lists as $key => $menu) {

									$data = array(
										'template_key' => $template_key,
										'menu_id' => $menu,
										'priority' => $key,
										'is_load' => 1
									);
									
									$this->t_menu_loader->set_data($data, 1);

								}

							}

							flash_success(lang('Saved'));

						}
						else {

							$this->load->model('t_menu_loader');

							$where = array(
								'template_key' => $template_key
							);

							$del = $this->t_menu_loader->delete_data_by_property($where);

						}

					}
					else {

						$this->load->model('t_menu_loader');

						$where = array(
							'template_key' => $template_key
						);

						$del = $this->t_menu_loader->delete_data_by_property($where);

					}

				}

				if (isset($data['save_dependencies_list'])) {

					$dependencies_lists = @$data['template_extension_dependencies_list'] ? $data['template_extension_dependencies_list'] : array();

					$template_assets_dir = TEMPLATE_DIR.$template_key;

					if (is_dir($template_assets_dir)) {

						$template_config = $template_assets_dir.SLASH.'config.json';

				        $conf = new stdClass();

				        if (is_file($template_config)) {

				        	$conf = json_parse($template_config, false);

				        	$conf->dependencies = $dependencies_lists;

				        	$new_config = json_decode(json_encode($conf), true);

				        	file_put_contents(valid_path($template_config), stripslashes(json_encode($new_config, JSON_PRETTY_PRINT)));

				        	flash_success(lang('Saved'));

				        }
				        else {

				        	flash_error(lang('Save_error'));

				        }

					}
					else {

						flash_error(lang('Template_directory_not_found'));

					}
					
				}

			}

		}
		else {

			show_error(lang('Not_allow_method_GET'));

		}

		$this->redirect(array(
				$this->router->class,
				'detail',
				@$template_key
			)
		);

	}

	public function get_default_template()
	{

		$this->load->model('t_template');

        $this->t_template->is_object = true;

        $template = $this->t_template->get_data_by_property('*', array('is_default' => 1));

        if (count($template) > 0) {

            return $template[0]->template_key;

        }

        return null;

	}

}