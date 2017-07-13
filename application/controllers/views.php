<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Views extends MY_Controller
{

	public function __construct() {

		parent::__construct();

    	$this->load->model('t_view');

	}

	/**
	 * Fetch and display records
	 * @return void
	 */
	public function index($key_default = '') {

		$dir_uri = APP_VIEW.VIEW_PLATFROM;

		$pattern = '/[.]/i';

		$dir = $this->get_dir($dir_uri, $pattern);

		$this->load->model('t_platform');

		$this->data['platforms'] = $this->t_platform->get_data_by_property('*', array());

		$this->data['platforms'][] = array(
	      'id' => '1',
	      'platform_key' => 'all',
	      'platform_name' => 'All platform',
	      'description' => 'Show all platform',
	      'is_default' => '0'
	    );

		if (!$key_default && $key_default != 'all') {

			$platform_default = $this->t_platform->get_data_by_property('*', array(
					'is_default' => 1
				)
			);

			$key_default = @$platform_default[0]['platform_key'];

		}

		$this->data['key_default'] = $key_default;

		if ($key_default == 'all') {

			$path = $dir_uri;

		}
		else {

			$path = $dir_uri.$key_default;

		}

		$dir_view = $this->get_view($data = array(), $path);

		$file_list = $this->parser_dir($dir_view, $result = array(), $path);

		$views_list = array();

		$this->load->model('t_view');

		foreach ($file_list as $key => $file) {
			
			if (strpos($file['file'], '_css') === false && strpos($file['file'], 'js')  === false) {

				$view_dir = str_replace(VIEW_PLATFROM, '', $file['module']);

				$view_exp = array_filter(explode('/', $view_dir));

				$view_platform = $view_exp[key($view_exp)];

				unset($view_exp[key($view_exp)]);

				$module_dir = implode('/', $view_exp);

				$plat_view = $this->t_platform->get_data_by_property('*', array(	
						'platform_key' => $view_platform
					)
				);

				$view_data = array(
					'view_name' => basename($file['path'], EXT),
					'module_name' => $module_dir,
					'platform_id' => $plat_view[0]['id']
				);

				$view_insert = $this->t_view->get_data_by_property('*', $view_data);

				if (count($view_insert)) {

					$view_insert = $view_insert[0];

				}
				else {

					$view_data['allow_delete'] = 0;

					$view_insert = $this->t_view->set_data($view_data);

				}

				$views_list[$key] = $file_list[$key];

				$views_list[$key]['id'] = $view_insert['id'];

			}

		}

		$this->data['file_list'] = $views_list;

	}

	/**
	 * Fetch and display records
	 * @return void
	 */
	public function detail($id='') {

		if (!$id) {
			
			$this->redirect(array(
					$this->router->class
				)
			);
			
		}

		$this->load->model('t_view');

		$view_file = $this->t_view->get_data_by_id('*', $id);

		$this->load->model('t_platform');

		$this->load->model('t_language');

        $langDatas = $this->t_language->get_data_by_property('*');

		$platforms = $this->t_platform->get_data_by_property('*');

		foreach ($platforms as $key => $platform) {
			
			$view_dir = APP_VIEW.VIEW_PLATFROM.$platform['platform_key'].'/'. @$view_file['module_name'];

			$php_lang_dir = APP_PHP_LANG;

			$js_lang_dir = APP_JS_LANG;

			$platforms[$key]['view_files'] = array(
				'view_file' => $view_dir.'/'.$view_file['view_name'].EXT,
				'js_file' => $view_dir.'/'.$view_file['view_name'].JS_SUB_EXT.EXT,
				'css_file' => $view_dir.'/'.$view_file['view_name'].CSS_SUB_EXT.EXT,
			);

			if (count($langDatas)) {

				$php_lang_file_arr = array();

				$js_lang_file_arr = array();

				foreach ($langDatas as $key_lang => $lang) {

					$php_lang_file = $php_lang_dir.$lang['lang_folder'].SLASH.$platform['platform_key'].SLASH.$view_file['module_name'].SLASH.$view_file['view_name'].PHP_SUB_LANG.EXT;
					
					$js_lang_file = $js_lang_dir.$lang['lang_folder'].SLASH.$platform['platform_key'].SLASH.$view_file['module_name'].SLASH.$view_file['view_name'].JS_EXT;
	
					if (is_file($php_lang_file)) {

						$php_lang_file_arr[$lang['lang_folder']] = $php_lang_file;

					}

					if (is_file($js_lang_file)) {

						$js_lang_file_arr[$lang['lang_folder']] = $js_lang_file;

					}

				}

				$platforms[$key]['php_lang_files'] = array(
					$php_lang_file_arr
				);

				$platforms[$key]['js_lang_files'] = array(
					$js_lang_file_arr
				);

			}

		}

		$this->data['platforms'] = $platforms;

		$this->load->model('t_template');

		$this->data['templates'] = $this->t_template->get_data_by_property('*', array());

		$this->data['view_origin'] = $view_file;

		$this->render(null, 'views/detail', $this->data);

	}

	/**
	 * Create a record
	 * @return void
	 */
	public function create() {
		
		$this->load->model('t_platform');

		$this->data['platforms'] = $this->t_platform->get_data_by_property('*', array());

		$this->load->model('t_template');

		$this->data['templates'] = $this->t_template->get_data_by_property('*', array());
		
		if ($this->input->is('post')) {

			$data = $this->parse_data_post();

			$generate_result = $this->generate_full_view($data);

			$generate_lang_result = $this->generate_language_file($data);

			if ($generate_result->success) {

				flash_success($generate_result->message);
				
				$this->redirect();

			}
			else {

				$segments = array(
					$this->router->class,
					'create'
				);

				$this->redirect($segments);

			}

		}
		else {

			$this->load->extension('ace-builds', null, $this->data);

		}

	}

	/**
	 * Insert or update a record
	 * @param string $path Defaults to NULL
	 * @return void
	 */
	public function edit($path = null, $view_id = null) {

		if ($this->input->is('post')) {

			$post = $this->parse_data_post();

			if (isset($post['content_body']) && isset($post['file_path'])) {

				$content_body = $this->input->post('content_body');

				$content_body = html_entity_decode($content_body);

				$file = $post['file_path'];

				$error = '';

				if (substr($file, -3) == 'php') {

					$tmp = getcwd().'/temp/php_check_syntax.php';

					@file_put_contents($tmp, trim($content_body));

					$error = $this->php_check_syntax($tmp);

					$error = str_replace($tmp, $file, $error);

				}

				if (is_null($error) && empty($error)) {

					@file_put_contents($file, trim($content_body));

					flash_success(lang('Saved'));

				}
				else {

					$this->response->modal = 1;

					flash_error($error);

				}

			}

            if (isset($post['view_id'])) {

            	$view_id = $post['view_id'];

                $this->form_validation->set_rules($this->t_view->rules_edit);

                $this->t_view->set_message_validate();

                if ($this->form_validation->run() == false) {

                    $errors = explode("\n", validation_errors());

                    flash_error($errors[0]);

                } else {

                    $data_current_view = $this->t_view->get_data_by_id('*', $view_id);

                    if (count($data_current_view) > 0) {

                        $data_update_info = array(
                            'module_name' => $this->input->post('module_name'),
                            'view_name' => $this->input->post('view_name')
                        );
                        
                        $data_rename = array(
                            'platform' => $data_current_view['platform_id'],
                            'module_name' => $data_update_info['module_name'],
                            'view_name' => $data_update_info['view_name'],
                            'old_module_name' => $data_current_view['module_name'],
                            'old_view_name' => $data_current_view['view_name']
                        );

                        $results = $this->rename_view_and_language($data_rename);

                        if ($results->success) {

                            $this->edit_info($data_update_info, $view_id);

							flash_success(lang('Saved'));

							$this->response->timeout = 0;

							$new_path = $this->response->file_path;

							$this->response->redirect = base_url('views/edit').SLASH.$new_path.SLASH.$view_id;

                        } else {

                        	if (is_null($results->message)) {
                        		
                        		flash_error(lang('Save_error'));

                        	}

                        }

                    } else {
                        
                        flash_error(lang('Data_not_found'));

                    }

                }

            } else {

                flash_error(lang('Data_not_found'));

            }

			$segments = array($this->router->class, 'edit', base64_encode($post['file_path']));

	        $this->redirect($segments);

		}
		else {

			$path = base64_decode($path);

			if ($path == null || !is_file($path)) {

				flash_error(lang('Can_t_load_file'));

	            $this->redirect();

			}
			else {

				$this->data['file_view'] = $path;

				if (substr($path, -3) == '.js') {

					$file_view = substr($path, 0, -3);

					$this->data['file_type'] = 'javascript';

				}
				elseif (substr($path, -4) == '.php') {

					$file_view = substr($path, 0, -4);
					
					$this->data['file_type'] = 'php';

				}
				else{

					$this->data['file_type'] = 'html';

				}

				$page_content = $this->read_file_content($path);

				$this->data['page_content'] = trim($page_content);

				$file_view = str_replace(APP_VIEW.VIEW_PLATFROM, '', $file_view);

				$file_view = explode('/', $file_view);

				$file_platform = $file_view[0];

				$this->data['file_platform'] = $file_platform;

				$this->load->model('t_view');

				$view_row = $this->t_view->get_data_by_id('*', $view_id);

				$this->data['view_row'] = $view_row;

				$this->load->model('t_platform');

				$this->data['file_path'] = $path;

				$this->data['platforms'] = $this->t_platform->get_data_by_property('*', array());

				$this->load->extension('ace-builds', null, $this->data);

				$this->render(null, 'views/edit', $this->data, false);

			}

		}

	}

	/**
	 * Delete a record
	 * @param int $id
	 * @return void
	 */
	public function delete($file='') {

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

		$this->load->model('t_view');

		$this->load->model('t_platform');

		if (is_file($file)) {

			$file_name = basename($file);

			$basename = basename($file, EXT);

			$view_file = str_replace(APP_VIEW.VIEW_PLATFROM, '', $file);

			$view_path = str_replace(EXT, '', $view_file);

			$arr_views = array(
				$file,
				str_replace($file_name, $basename.'_css'.EXT, $file),
				str_replace($file_name, $basename.'_js'.EXT, $file)
			);

			$plat = array_filter(explode(SLASH, $view_file));

			$platform_data = $this->t_platform->get_data_by_property('*', array(
                    'platform_key' => @$plat[0]
                )
            );

            $module_name = str_replace(SLASH.$file_name, '', $view_file);

            $module_name = str_replace(@$plat[0].SLASH, '', $module_name);

			$view_data = array(
                'view_name' => $basename,
                'module_name' => $module_name,
                'platform_id' => @$platform_data[0]['id']
            );

			$this->db->delete($this->t_view->table_name, $view_data);

			$this->response->data = (object) $arr_views;

			$this->response->data->element = (object) array();

			foreach ($arr_views as $key => $view) {

				$this->response->data->element->$key = base64_encode($view);

				@unlink($view);

			}

			$this->load->model('t_language');

			$languages = $this->t_language->get_data_by_property('*');

			if (count($languages)) {

				foreach ($languages as $key => $lang) {

					$lang_js_dir = APP_JS_LANG.$lang['lang_folder'];

					$lang_php_dir = APP_PHP_LANG.$lang['lang_folder'];

					$lang_js_path = $lang_js_dir.SLASH.$view_path.JS_EXT;

					$lang_php_path = $lang_php_dir.SLASH.$view_path.PHP_SUB_LANG.EXT;

					unlink_lang($lang_js_path, $lang_js_dir);

					unlink_lang($lang_php_path, $lang_php_dir);

				}

			}

			flash_success(lang('Deleted'));

		}
		else {

			flash_error(lang('File_not_found'));

		}

		$this->redirect();

	}

	public function preview($path = null, $platform = 'web', $template = 'web')
	{

		$path = base64_decode($path);

		if ($path == null || !is_file($path)) {

			flash_error('File_not_found');

            $segments = array($this->router->class);

            $this->redirect($segments);

		}
		else {

			$this->data['file_view'] = $path;

			if (substr($path, -3) == '.js') {

				$view_file = substr($path, 0, -3);

				$this->data['file_type'] = 'javascript';

			}
			elseif (substr($path, -4) == '.php') {

				$view_file = substr($path, 0, -4);
				
				$this->data['file_type'] = 'php';

			}
			else {

				$this->data['file_type'] = 'html';

			}

			$view_file = str_replace(APP_VIEW.VIEW_PLATFROM.$platform.'/', '', $view_file);

			$extends = $this->input->post('extend');

			$template_set = $this->input->post('template_set');

			$platform_set = $this->input->post('platform_set');

			if ($template_set) {

				$template = $template_set;

			}
			if ($platform_set) {

				$platform = $platform_set;

			}

			$this->session->set_userdata('template_set', $template);

			$this->session->set_userdata('platform_set', $platform);

			$this->data['platform'] = $platform;

			$this->data['template'] = $template;

			if ($extends) {

				sort($extends);

				$this->load->extension($extends);

			}

			$this->load->extension('jquery');

			$this->load->extension('bootstrap');

			$this->load->extension('font-awesome4.5');

			$this->load->extension('preview-tool');

			$this->load->model('t_template');

			$this->data['templates'] = $this->t_template->get_data_by_property('*', array());

			error_reporting(0);

			$this->render(null, $view_file, $this->data, null);

		}

	}

	public function get_preview_box()
    {

    	if (!$this->input->is_ajax_request()) {
			
			show_error(lang('Must_ajax_request_access'));

		}

        if ($this->input->is('post')) {

            if ($this->is_login()) {

            	$this->extensions = $this->load->controller('extensions');

            	$this->data['extends'] = $this->extensions->get_list_extension();

            	$this->load->model('t_template');

            	$this->t_template->is_object = true;

            	$this->data['templates'] = $this->t_template->get_data_by_property('*');

            	$this->load->model('t_platform');

            	$this->t_platform->is_object = true;

				$this->data['platforms'] = $this->t_platform->get_data_by_property('*', array());

            	$this->data['template_set'] = $this->session->userdata('template_set');

            	$this->data['platform_set'] = $this->session->userdata('platform_set');

            	$this->response->data = $this->load->common('preview-tool/preview-box', true, $this->data);

            	flash_success();

            }
            else {

            	flash_error(lang('Permission_denied'));

            }

        }
        else {

        	flash_error('Not_allow_method_GET');

        }

        $this->response_message();

    }

    public function edit_info($data = null, $view_id = null) {
        
        if (is_null($data) || is_null($view_id)) {
            
            return false;

        } else {
            
            $update_info = $this->t_view->update_data_by_id($data, $view_id);

            if ($update_info) {
                
                return true;

            } else {
                
                return false;

            }

        }
        
    }

}