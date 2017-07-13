<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Languages extends MY_Controller
{

	public function __construct() {

		parent::__construct();

	}

	/**
	 * Fetch and display records
	 * @return void
	 */
	public function index($key_default = 'php', $platform = '', $lang = '', $compare_with = '') {
		
		$lang_code = array(
		    
		    'js' => $this->lang->line('js_code'),
		    
		    'php' => $this->lang->line('php_code')
		    
		);

		if (!$lang) {
				
			$lang = @$this->data['lang_folder'];
			
		}

		$entries_lang = array();

		$entries_lang['module'] = htmlentities('<directory root>');

		if ($key_default == 'js') {

			$dir_uri ='themes/js_lang/';

			if (!is_dir($dir_uri.$lang)) {

				$this->create_tree_dir($dir_uri, $lang);

			}

			$entries_lang['file'] = $this->get_key_lang($lang).'.js';

			$base_file = $dir_uri.$lang.'/'.$entries_lang['file'];

			if (!is_file($base_file)) {

				@file_put_contents($base_file, '');

			}

		}
		else {

			$dir_uri = APPPATH.'language/';

			if (!is_dir($dir_uri.$lang)) {
				
				$this->create_tree_dir($dir_uri, $lang);
				
			}

			$entries_lang['module'] = htmlentities('<directory root>');

			$entries_lang['file'] = $this->get_key_lang($lang).'_lang.php';

			$base_file = $dir_uri.$lang.'/'.$entries_lang['file'];

			if (!is_file($base_file)) {

				@file_put_contents($base_file, '');

			}

		}

		$lang_root_file = $dir_uri.$lang.'/'.$entries_lang['file'];

		$entries_lang['size'] = @filesize($lang_root_file);

		$entries_lang['path'] = $lang_root_file;

		$pattern = '/[.]/i';

		$dir = $this->get_dir($dir_uri, $pattern);

		$this->data['lang_dir'] = $this->fetch_key($dir);

		$dir_uri = $dir_uri.$lang;

		$dir = $this->get_dir($dir_uri, $pattern);

		$this->load->model('t_platform');

		$this->load->model('t_language');

		if (!$platform) {

			$default_platform = $this->t_platform->get_data_by_property('*', array(
					'is_default' => 1
				)
			);

			if (count($default_platform)) {
				
				$platform = $default_platform[0]['platform_key'];

			}
			else {
				
				$platform = @$this->data['platform'];

			}

		}

		$this->data['platforms'] = $this->t_platform->get_data_by_property('*');

		$this->data['languages'] = $this->t_language->get_data_by_property('*');

		$this->data['key_default'] = $key_default;

		$this->data['key_language'] = $lang;

		$this->data['key_platform'] = $platform;

		$path = $dir_uri.'/'.$platform;

		$dir_view = $this->get_view($data = array(), $path);

		$file_list = $this->parser_dir($dir_view, $result = array(), $path);

		array_push($file_list, $entries_lang);

		$this->data['file_list'] = $file_list;

		$this->data['lang_code'] = $lang_code;

		$this->data['key_default'] = $key_default;

		$this->data['compare_with'] = $compare_with;

		$currentPlatform = $this->t_platform->get_data_by_property('*', array(
				'platform_key' => $platform
			)
		);

	}

	/**
	 * Create a record
	 * @return void
	 */
	public function create() {
		
		if ($this->input->is('post')) {
			
			$data = $this->parse_data_post();

			if (count($data)) {
				
				if (isset($data['lang_folder']) && isset($data['lang_key'])) {
						
					$this->load->model('t_language');

					$fields = $this->db->list_fields($this->t_language->table_name);

					$where = $this->array_intersect($data, $fields);

					unset($where['lang_display']);

					$existed = $this->t_language->get_data_by_property('*', $where);

					if (count($existed)) {

						$this->response->message = lang('Language_has_existed');

					}
					else {

						$langData = $this->array_intersect($data, $fields);

						$save = $this->t_language->set_data($langData);

						if ($save) {

							flash_success(lang('Saved'));

							$this->response->data = $where;

						}
						else {

							flash_error(lang('Save_error'));

							$this->response->data = $where;

						}

					}

				}
				else {

					flash_error(lang('Data_not_found'));

				}

			}
			else {

				flash_error(lang('Data_not_found'));

			}

			$this->redirect();

		}
		else {

			$this->load->model('t_country');

			$languages = $this->t_language->get_data_by_property('*');

			$where = array();

			if (count($languages)) {

				foreach ($languages as $key => $lang) {

					$this->db->where('code != ', '"'.strtoupper($lang['lang_key']).'"', FALSE);
				}

			}

			$countries = $this->t_country->get_data_by_property('*');

			$this->data['region_list'] = $countries;

			$this->load->model('t_platform');

			$this->data['platforms'] = $this->t_platform->get_data_by_property('*', array());

		}

	}

	/**
	 * Insert or update a record
	 * @param int $id Defaults to NULL
	 * @return void
	 */
	public function edit($path = null, $view_id = null) {

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

				$this->response->modal = 1;

				flash_error($error);

			}
			else {

				flash_success(lang('Saved'));

			}

			$this->response_message();

			$segments = array($this->router->class, 'edit', base64_encode($file));

	        $this->redirect($segments);

		}
		else {

			$path = base64_decode($path);

			if ($path == null || !is_file($path)) {

				flash_error(lang('File_not_found'));

	            $segments = array($this->router->class);

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

				$page_content = null;

				$file = fopen($path,"r");

				while(! feof($file)) {

					$page_content .= fgets($file);

				}

				fclose($file);

				$this->data['page_content'] = trim($page_content);

				$file_view = str_replace(APP_VIEW.VIEW_PLATFROM, '', $file_view);

				$file_view = explode('/', $file_view);

				$file_platform = $file_view[0];

				$this->data['file_platform'] = $file_platform;

				$this->load->model('t_view');

				$view_row = $this->t_view->get_data_by_id('*', $view_id);

				$this->data['view_row'] = $view_row;

				$this->load->model('t_platform');

				$this->data['platforms'] = $this->t_platform->get_data_by_property('*', array());

				$this->load->extension('ace-builds', null, $this->data);

			}

		}

	}

	/**
	 * Delete a record
	 * @param int $id
	 * @return void
	 */
	public function delete_region($id='') {

		if ($this->input->is('post')) {

			if (!$this->input->post('id')) {

				flash_error(lang('Data_not_found'));

				$this->redirect();

			}

			$id = base64_decode($this->input->post('id'));

		}
		else {

			$id = base64_decode($id);

		}

		if ($id) {

			$arr_languages = array(
				$id
			);

			$this->response->data = (object) $arr_languages;

			$this->response->data->element = (object) array();

			$this->response->data->element = base64_encode($file);

			$this->load->model('t_language');

			foreach ($arr_languages as $key => $lang) {

				$this->t_language->delete_by_id($id);

				$this->response->data->element->$key = base64_encode($lang);

			}

			flash_success(lang('Deleted'));

		}
		else {

			flash_error(lang('Data_not_found'));

		}

		$this->redirect();

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

		if (is_file($file)) {

			$arr_languages = array(
				$file
			);

			$this->response->data = (object) $arr_languages;

			$this->response->data->element = (object) array();

			$this->response->data->element = base64_encode($file);

			foreach ($arr_languages as $key => $lang) {

				$this->response->data->element->$key = base64_encode($lang);

				@unlink($lang);

			}

			flash_success(lang('Deleted'));

		}
		else {

			flash_error(lang('File_not_found'));

		}

		$this->redirect();

	}

	public function common()
	{

		if (!$this->input->is_ajax_request()) {
			
			show_error(lang('Must_ajax_request_access'));

		}

		if ($this->input->is('get')) {

			if ($this->data['lang_key']) {

				$lang_key = $this->data['lang_key'];

				$lang_dir = APP_PHP_LANG;

				$lang_file = $lang_key.PHP_SUB_LANG.EXT;

				$this->response->success = 1;

				$this->response->data = $this->lang->structure[$lang_file];

				$this->response->message = lang('Success');

				$this->response_message();

			}
			else {

				$this->response->message = lang("Unknown common language file");

			}
			
		}
		else {

			$this->response->success = 0;

			$this->response->message = lang('Not_allow_method_GET');

		}

	}

	private function get_key_lang($lang_dir = 'english')
	{

		$this->load->model('t_language');

		$lang = $this->t_language->get_data_by_property('lang_key', array('lang_folder' => $lang_dir));

		if (count($lang)) {

			return $lang[0]['lang_key'];

		}

		return 'en';

	}


	public function compare($path = null, $targetLang='')
	{

		if ($this->input->is('post')) {

			$path = base64_decode($path);

			if (isset($path)) {

				$sourceStr = '';

				$targetStr = '';

				if ($this->input->post('data')) {

					$fileData = $this->input->post('data');

					$sourceContent = $fileData['sourceFile'];

					$targetContent = $fileData['targetFile'];

					$ext = pathinfo($path, PATHINFO_EXTENSION);

					if ($ext == 'php') {

						$sourceStr = "<?php\n";

						$targetStr = "<?php\n";
						
					}

					if (count($sourceContent) && isset($sourceContent)) {

						foreach ($sourceContent as $key => $content) {

							$content = str_replace("'", "\'", $content);

							if ($ext == 'js') {

								$sourceStr .= "lang['".$key."'] = '".trim($content)."';\n";

							}
							else {

								$sourceStr .= "\$lang['".$key."'] = '".trim($content)."';\n";

							}

						}

						foreach ($targetContent as $key => $content) {

							if ($ext == 'js') {

								$targetStr .= "lang['".$key."'] = '".trim($content)."';\n";

							}
							else{

								$targetStr .= "\$lang['".$key."'] = '".trim($content)."';\n";

							}

						}

					}

					@file_put_contents($path, trim($sourceStr));

					if ($this->input->post('targetFile')) {

						$targetFile = base64_decode($this->input->post('targetFile'));

						$this->force_write_file($targetFile, trim($targetStr));

					}

					flash_success(lang('Saved'));

				}

			}
			else {

				flash_error(lang('File_not_found'));

			}

			$segments = array($this->router->class, 'compare', base64_encode($path));

	        $this->redirect($segments);

		}
		else {

			$path = base64_decode($path);

			$this->data['languages'] = $this->t_language->get_data_by_property('*', array());

			if ($path == null || !is_file($path)) {

				flash_error(lang('File_not_found'));

	            $segments = array($this->router->class);

	            $this->redirect();

			}
			else {

				$this->data['file_view'] = $path;

				$this->data['file_type'] = pathinfo($path, PATHINFO_EXTENSION);

				$sourceFile = array(
					'ext' => $this->data['file_type'],
					'filename' => basename($path, ".".$this->data['file_type'])
				);

				$dirArr = multiexplode(array('/', '\\'), $path);

				$sourceFile['lang_folder'] = $dirArr[2];

				$sourceFile['lang_parent'] = implode('/', array($dirArr[0], $dirArr[1]));

				if (isset($dirArr[4]) && isset($dirArr[3])) {

					$sourceFile['module_name'] = $dirArr[4];

					$sourceFile['platform'] = $dirArr[3];

				}

				$targetFile = $sourceFile;

				if (!$targetLang) {

					foreach ($this->data['languages'] as $key => $languages) {

						if ($languages['lang_folder'] != $sourceFile['lang_folder']) {

							$targetLang = $languages['lang_folder'];

							break;

						}

					}

				}

				$targetFile['lang_folder'] = $targetLang;

				if(!(isset($dirArr[4]) && isset($dirArr[3]))) {

					$lang = $this->t_language->get_data_by_property('*', array('lang_folder' => $targetFile['lang_folder']));

					if (count($lang) > 0) {

						if ($targetFile['ext'] == 'php') {

							$targetFile['filename'] = $lang[0]['lang_key'].'_lang';

						}
						elseif ($targetFile['ext'] == 'js') {

							$targetFile['filename'] = $lang[0]['lang_key'];

						}

					}

				}

				$this->data['sourceLang'] = $sourceFile['lang_folder'];

				$this->data['targetLang'] = $targetFile['lang_folder'];

				$fileSourceContent = array();

				$fileSource = fopen($path, "r");

				while(! feof($fileSource)) {

					$line = fgets($fileSource);

					if ($line) {

						$child = explode(' = ', $line);

						if ((strpos($line, '<?php') !== false && $this->data['file_type'] == 'php')) {

							continue;

						}

						if (count($child) >= 2) {

							if ($sourceFile['ext'] == 'js') {
								
								$child[0] = str_replace("lang['", '', $child[0]);

								$child[0] = str_replace("']", '', $child[0]);

								$child[0] = str_replace(array("'", '"'), array('', ''), $child[0]);

								$child[1] = str_replace(array("'", '"'), array('', ''), $child[1]);

								$child[1] = str_replace(";", '', $child[1]);

							}
							else {

								$child[0] = str_replace('$lang[', '', $child[0]);

								$child[0] = str_replace("]", '', $child[0]);

								$child[0] = str_replace(array("'", '"'), array('', ''), $child[0]);

								$child[1] = str_replace(array("'", '"'), array('', ''), $child[1]);

								$child[1] = str_replace(";", '', $child[1]);

							}

							array_push($fileSourceContent, $child);

						}

					}

				}

				fclose($fileSource);

				$this->data['fileSourceContent'] = $fileSourceContent;

				$fileTargetContent = array();

				$fileTarget = $targetFile;

				if (isset($targetFile['module_name']) && $targetFile['platform']) {

					$fileTargetPath = $targetFile['lang_parent']
					.'/'.$targetFile['lang_folder']
					.'/'.$targetFile['platform']
					.'/'.$targetFile['module_name']
					.'/'.$targetFile['filename']
					.'.'.$targetFile['ext'];

				}
				else {

					$fileTargetPath = $targetFile['lang_parent']
					.'/'.$targetFile['lang_folder']
					.'/'.$targetFile['filename']
					.'.'.$targetFile['ext'];

				}

				if (is_file($fileTargetPath)) {

					$fileTarget = fopen($fileTargetPath,"r");

					while(! feof($fileTarget)) {

						$line = fgets($fileTarget);

						if ($line) {

							$child = explode(' = ', $line);

							if ((strpos($line, '<?php') !== false && $this->data['file_type'] == 'php')) {
							
								continue;
								
							}

							if (count($child) >= 2) {

								if ($this->data['file_type'] == 'js') {
								
									$child[0] = str_replace("lang['", '', $child[0]);

									$child[0] = str_replace("']", '', $child[0]);

									$child[0] = str_replace(array("'", '"'), array('', ''), $child[0]);

									$child[1] = str_replace(array("'", '"'), array('', ''), $child[1]);

									$child[1] = str_replace(";", '', $child[1]);

								}
								else {

									$child[0] = str_replace('$lang[', '', $child[0]);

									$child[0] = str_replace("]", '', $child[0]);

									$child[0] = str_replace(array("'", '"'), array('', ''), $child[0]);

									$child[1] = str_replace(array("'", '"'), array('', ''), $child[1]);

									$child[1] = str_replace(";", '', $child[1]);

								}

								array_push($fileTargetContent, $child);

							}

						}

					}

					fclose($fileTarget);

				}

				$this->data['fileTargetContent'] = $fileTargetContent;

				$file_counter = count($fileSourceContent);

				if (count($fileTargetContent) >= count($fileSourceContent)) {

					$file_counter = count($fileTargetContent);

				}

				$this->data['file_counter'] = $file_counter;

				$this->data['path'] = base64_encode($path);

				$this->data['targetFile'] = base64_encode($fileTargetPath);

			}

		}

	}

	public function region()
	{

		$this->load->model(array('t_language'));

		$this->data['languages'] = $this->t_language->get_data_by_property('*', array());

	}

}