<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tree extends MY_Controller {

	public function __construct() {

		parent::__construct();

	}

	public function index()
	{

		$root = FCPATH;

		if( !$root ) exit("ERROR: Root filesystem directory not set");

		$data = $this->input->post();

		if (count($data)) {

			$postDir = rawurldecode($root.(isset($data['dir']) ? $data['dir'] : null ));

			// set checkbox if multiSelect set to true
			$checkbox = ( isset($data['multiSelect']) && $data['multiSelect'] == 'true' ) ? "<input type='checkbox' />" : null;
			
			$onlyFolders = ( isset($data['onlyFolders']) && $data['onlyFolders'] == 'true' ) ? true : false;
			
			$onlyFiles = ( isset($data['onlyFiles']) && $data['onlyFiles'] == 'true' ) ? true : false;

			if( file_exists($postDir) ) {

				$files		= scandir($postDir);

				$returnDir	= substr($postDir, strlen($root));

				natcasesort($files);

				if( count($files) > 2 ) { // The 2 accounts for . and ..

					echo "<ul class='jqueryFileTree'>";

					foreach( $files as $file ) {

						$htmlRel	= htmlentities($returnDir . $file);
						
						$htmlName	= htmlentities($file);
						
						$ext		= preg_replace('/^.*\./', '', $file);

						if( file_exists($postDir . $file) && $file != '.' && $file != '..' ) {

							if( is_dir($postDir . $file) && (!$onlyFiles || $onlyFolders) )
								echo "<li class='directory collapsed'>{$checkbox}<a rel='" .$htmlRel. "/'>" . $htmlName . "</a></li>";
							else if (!$onlyFolders || $onlyFiles)
								echo "<li class='file ext_{$ext}'>{$checkbox}<a rel='" . $htmlRel . "'>" . $htmlName . "</a></li>";
						}

					}

					echo "</ul>";

				}

			}

		}
		else {

			echo "No found data";

		}

	}

	public function loadExtensionFolder()
	{

		if ($_GET['extension']) {

			$extension = $_GET['extension'];

			$this->load->library('FolderFinder');

			$this->folderfinder->setDirectory(valid_path(APP_EXT_DIR.$extension));

			$this->folderfinder->setPath(valid_path(ASSETS.EXTENSIONS.$extension));

			$this->folderfinder->init();

			echo $this->folderfinder->run();

		}
		else {

			echo json_encode(array());

		}
		
	}

	public function loadTemplateFolder()
	{

		if ($_GET['template']) {

			$template = $_GET['template'];

			$this->load->library('FolderFinder');

			$this->folderfinder->setDirectory(valid_path(APP_VIEW.VIEW_TEMPLATE.$template));

			$this->folderfinder->setPath(valid_path(APP_VIEW.VIEW_TEMPLATE.$template));

			$this->folderfinder->init();

			$foller_tree = $this->folderfinder->run();

			echo $this->folderfinder->run();

		}
		else {

			echo json_encode(array());

		}
		
	}

	public function loadTemplateCommonFolder()
	{

		if ($_GET['template']) {

			$template = $_GET['template'];

			$this->load->library('FolderFinder');

			$this->folderfinder->setDirectory(valid_path(APP_VIEW.COMMON_VIEW_DIR.VIEW_TEMPLATE.$template));

			$this->folderfinder->setPath(valid_path(APP_VIEW.COMMON_VIEW_DIR.VIEW_TEMPLATE.$template));

			$this->folderfinder->init();

			$foller_tree = $this->folderfinder->run();

			echo $this->folderfinder->run();

		}
		else {

			echo json_encode(array());

		}
		
	}

}

/* End of file dev.php */
/* Location: ./application/controllers/dev.php */