<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Extensions extends MY_Controller {

	public function __construct() {

		parent::__construct();

	}

		/**
	 * Fetch and display records
	 * @return void
	 */
	public function index($tabActive = 'local_extension') {

		$this->load->model('t_extension');

		$this->set_active_tab();

		$this->load->extension('dropzone');

		$this->data['extensions'] = $this->t_extension->get_data_by_property('*');

		$this->load->extension('ajax_download');

	}

	public function edit($id='')
	{
		# code...
	}

	public function download($extension = null)
	{

		if ($extension) {

			$store_dir = FCPATH.'temp/';

			if (!is_dir($store_dir)) {

				$this->create_tree_dir($store_dir);

			}

			$zip_file = $store_dir.$extension.'.zip';

			if (!is_file($zip_file)) {

				$this->zipCreateWithFolder($zip_file, FCPATH."assets/extensions/$extension");

			}

			$mine = 'application/zip';

			//then send the headers to foce download the zip file
            header("Content-type: $mine");
            
            header("Content-Disposition: attachment; filename=$extension.zip");
            
            header("Pragma: no-cache");
            
            header("Expires: 0");
            
            readfile($zip_file);
            
            exit(0);

		}
		else {

			$this->response->message = 'Missing extenstion name';

		}
		
		$this->response_message();
		
	}

	public function detail($item = null)
	{

		if ($item) {

			$this->load->model('t_extension');

			$extension = $this->t_extension->get_data_by_property('*', array('extension_key' => $item));
			
			if (count($extension)) {

				$extension = $extension[0];

				$ext_dir = valid_path(FCPATH.'assets/extensions/'.$extension['extension_key']);

				$this->data['extension'] = $extension;

				if (is_dir($ext_dir)) {

					$this->load->library('Parsedown');

					$read_me = $ext_dir . '/' . 'README.md';

					if (is_file($read_me)) {

						$read_me_content = file_get_contents($read_me);

						$this->data['extension']['read_me'] = $this->parsedown->text($read_me_content);

					}

					$changelog = $ext_dir . '/' . 'CHANGELOG.md';

					if (is_file($changelog)) {

						$changelog_content = file_get_contents($changelog);

						$this->data['extension']['changelog'] = $this->parsedown->text($changelog_content);

					}

					$license = $ext_dir . '/' . 'LICENSE';

					if (is_file($license)) {

						$license_content = file_get_contents($license);

						$this->data['extension']['license'] = $this->parsedown->text($license_content);

					}

					$contribution = $ext_dir . '/' . 'CONTRIBUTING.md';

					if (is_file($contribution)) {

						$contribution_content = file_get_contents($contribution);

						$this->data['extension']['contribution'] = $this->parsedown->text($contribution_content);

					}

					$this->data['extension']['files'] = new DirectoryIterator($ext_dir);

					$file_counter = new FilesystemIterator(__DIR__, FilesystemIterator::SKIP_DOTS);

					$this->data['extension']['total_files'] = iterator_count($file_counter);

				}

			}

		}
		else {

			$this->redirect(array(
					$this->router->class,
					'index'
				)
			);

		}

	}

	public function create()
	{

		if ($this->input->is_ajax_request()) {

			if ($this->input->post()) {

				$post = $this->input->post();

				$this->load->model('t_extension');

				$ext = $this->parse_fields_table($post, $this->t_extension->table_name);

				if ($this->check_existed_extension_key(@$ext['extension_key'])) {

					$this->response->success = 0;

					$this->response->message = "Extension has existed";

					$this->response_message();

				}
				
				if (count($ext)) {

					$insert = $this->t_extension->set_data($ext, 1);
					
					if (count($ext)) {

						$ex = $this->create_extension_directory($insert);

						if ($ex) {

							$this->response->success = 1;

							$this->response->message = "Insert data successfully. Extension had created !";

							$this->response->data = $ex;

						}
						else {

							$this->response->success = 0;

							$this->response->message = "Insert data success. But can't create extension folder !";

							$this->response->data = array();

						}

					}
					else {

						$this->response->success = 0;

						$this->response->message = "Insert data error";

					}

				}
				else {

					$this->response->success = 0;

					$this->response->message = "Data not matching";

				}
				
			}
			else {

				$this->response->success = 0;

				$this->response->message = "Not allowed method";

			}

			$this->response_message();

		}

		$this->set_page_title();

		$this->render(null, 'system/new_extension', $this->data);

	}

	public function delete()
	{

		if (!$this->input->post('file')) {

			$this->response->message = lang('Data_not_found');

			$this->response_message();

		}

		$extension_key = $this->input->post('file');

		$root = APP_EXT_DIR.$extension_key;

		$this->load->model('t_extension');

		$this->db->where('extension_key', $extension_key);
		
		$this->db->where('allow_delete', 1);

 		$this->db->delete($this->t_extension->table_name);

		if (is_dir($root)) {

			_Rmdir($root);

			$this->response->success = 1;

			$this->response->message .= lang('Deleted');

		}
		else {

			$this->response->message .= lang('File_not_found');

		}

		$this->response_message();

	}

	public function import()
	{

		if (!empty($_FILES)) {

		    $tempFile = $_FILES['file']['tmp_name'];
		    var_dump($_FILES);exit();
		    $targetPath = FCPATH . 'temp/';

		    $targetFile = $targetPath . $_FILES['file']['name'];
		    error_reporting(-1);
		    move_uploaded_file($tempFile, $targetFile);
		    var_dump(mime_content_type($targetFile));exit();
		    if  (in_array(mime_content_type($targetFile), array(
									    	'application/x-compressed',
									    	'application/x-zip-compressed',
									    	'application/zip',
									    	'multipart/x-zip'))) {

		    	$this->response->message = 'Not allowed file tye';

		    	$this->response_message();

		    }
		    else{

		    	$this->response->message = 'Ok';
		    	
		    	$this->response_message();

		    }

		}
		else{

			$this->response->message = 'File not found';

			$this->response_message();

		}

	}

	public function check_existed_extension_key($key='')
	{

		if ($key) {

			$this->load->model('t_extension');

			$extension = $this->t_extension->get_data_by_property('*', array('extension_key' => $key));

			if (count($extension) > 0) {

				return $extension;

			}

			return false;

		}

		return true;

	}

	private function create_extension_directory($ext_data)
	{
		
		if ($this->check_existed_extension_key($ext_data['extension_key'])) {
			
			$exten_root_path = FCPATH. 'assets/extensions/';

			$exten_path = $exten_root_path . $ext_data['extension_key'];

			@mkdir(valid_path($exten_path));

			@mkdir(valid_path($exten_path . '/css/'));

			@mkdir(valid_path($exten_path . '/js/'));

			$data_json = array(
				'name' => $ext_data['extension_name'],
				'key' => $ext_data['extension_key'],
				'description' => $ext_data['description'],
				'css' => array(),
				'js' => array(),
			);

			@file_put_contents(valid_path($exten_path. '/config.json'), stripslashes(json_encode($data_json, JSON_PRETTY_PRINT)));

			@file_put_contents(valid_path($exten_path. '/README.md'), ' ');

			return $data_json;

		}

		return false;

	}

	protected function zipCreateWithFolder($filePath, $rootPath)
    {
    	
    	$rootFolder = basename($rootPath);

        //create the object
        $zip = new ZipArchive();

        if ($zip->open($filePath, ZIPARCHIVE::CREATE) !== TRUE) {

            return false;

        }

        // Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new RecursiveIteratorIterator(
		    new RecursiveDirectoryIterator($rootPath),
		    RecursiveIteratorIterator::LEAVES_ONLY
		);
		
		foreach ($files as $name => $file) {

		    // Skip directories (they would be added automatically)
		    if (!$file->isDir()) {

		        // Get real and relative path for current file
		        $pathFile = $file->getRealPath();

		        $relativePath = substr($pathFile, strlen($rootPath) + 1);

		        // Add current file to archive
		        $zip->addFile($pathFile, $rootFolder.'/'.$relativePath);

		    }

		}

        $zip->close();

        return true;

    }

	protected function zipCreateWithFiles($filePath, $files)
    {
        //create the object
        $zip = new ZipArchive();

        if ($zip->open($filePath, ZIPARCHIVE::CREATE) !== TRUE) {

            return false;

        }

        if (count($files)) {
            //add each files of $file_name array to archive
            foreach($files as $key => $file) {

                $zip->addFile($file['LOCATION'].$file['ENCRYPT_NAME'], $file['REAL_NAME']);

            }

        }
        else {

            return false;

        }

        $zip->close();

        return true;

    }

    public function get_list_extension()
    {

        if ($this->is_login()) {

        	$ext_dir = APP_EXT_DIR;

        	$dir_ext = $this->get_dir($ext_dir);

        	$arr_ext = array();

        	if (count($dir_ext)) {

        		foreach ($dir_ext as $key => $dir) {

        			if (is_file($ext_dir.$dir.'/config.json')) {

        				array_push($arr_ext, $dir);

        			}

        		}

        		return $arr_ext;

        	}

        }
        else {

        	return null;

        }

    }

}

/* End of file dev.php */
/* Location: ./application/controllers/dev.php */