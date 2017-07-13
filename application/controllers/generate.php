<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generate extends MY_Controller {

	private $msg = array();
 
	public function __construct ()
	{
		parent::__construct();
		
		// This class should only be run in development!
		if (ENVIRONMENT != 'development') {

			show_404();

		}
		
		$this->load->helper('file');

		$this->load->helper('html');

	}

	public function index()
	{

		// $this->model('t_user', 'jr_users');
		if (!$this->input->is_ajax_request()) {

			exit();

		}

	}
 
	/**
	 * Create a controller file in APPATH/controllers. Do not include '.php' in the name.
	 * 
	 * Typical usage:
	 * generate/controller/controller_name[/class_to_extend][/include_crud_methods]
	 * 
	 * @param string $name Separate subfolders with backslash folder1\folder2\class_name
	 * @param string $extends Defaults to NULL
	 * @param boolean $crud Defaults to FALSE
	 * @return void
	 * @author Joost van Veen
	 */
	public function controller ($post = array())
	{

		$name = $post['controller_name'];

		if (is_file(APPPATH.'controllers/'.$name.'.php')) {

			$message = sprintf(lang('Controller_s_is_existed'), APPPATH.'controllers/'.$name.'.php');

			$this->msg[] = $message;

			return $this->result(false, $this->msg[0]);

		}

		$extends = null;

		if (isset($post['crud'])) {

			$crud = true;
			
		}
		else{

			$crud = false;

		}

		$file = $this->_create_folders_from_name($name, 'controllers');

		$data = '';

		$data .= $this->_class_open($file['file'], __METHOD__, $extends);

		$crud === FALSE || $data .= $this->_crud_methods_contraller($post);

		$data .= $this->_class_close();

		$path = APPPATH . 'controllers/' . $file['path'] . strtolower($file['file']) . '.php';

		write_file($path, $data);

		$this->msg[] = sprintf(lang('Created_controller_s'), $path);

		//echo $this->_messages();
		return $this->result(true, $this->msg[0]);

	}
 
	/**
	 * Create a model file in APPATH/controllers. The model extends MY_Model as 
	 * used in the course. Do not include '.php' in the name.
	 * 
	 * Typical usage:
	 * generate/model/model_name[/table_name]
	 * 
	 * @param string $name Separate subfolders with backslash folder1\folder2\class_name
	 * @param string $table Defaults to emtpy string
	 * @return void
	 * @author Joost van Veen
	 */
	public function model ($data = array())
	{

		$name = $data['model_name'];

		if (is_file(APPPATH.'models/'.$name.'.php')) {

			$message = sprintf(lang('Model_s_is_existed'), APPPATH.'models/'.$name.'.php');

			$this->msg[] = $message;

			return $this->result(false, $this->msg[0]);

		}

		if (isset($data['table_name'])) {

			$table = $data['table_name'];

		}
		else{

			$table = null;

		}

		if (isset($data['base_query'])) {

			$base_query = true;

		}
		else{
			
			$base_query = false;

		}

		$file = $this->_create_folders_from_name($name, 'models');
		
		$data = '';

		$data .= $this->_class_open($file['file'], 'MY_Model', 'MY_Model');

		$data .= $this->_crud_methods_model($table, $base_query);

		$data .= $this->_class_close();

		$path = APPPATH . 'models/' . $file['path'] . strtolower($file['file']) . '.php';

		write_file($path, $data);

		if (is_file(APPPATH.'models/'."config_model.ini")) {

			$ini_array = parse_ini_file(APPPATH.'models/'."config_model.ini");

			if (count(@$ini_array) > 0) {

				$ini_array[$name] = $table;

			}
			else{

				$ini_array = array(

					$name => $table

				);

			}
			
			$this->write_php_ini($ini_array, APPPATH.'models/'."config_model.ini");

		}
		else {

			$data = array(

				$name => $table

			);

			$this->write_php_ini($data, APPPATH.'models/'."config_model.ini");

		}

		$this->msg[] = 'Created model ' . $path;

		// //echo $this->_messages();
		return $this->result(true, $this->msg[0]);

	}

	function write_php_ini($array, $file)
	{

	    $res = '; This is a sample configuration file '."\n".'[model_table]'."\n";

	    foreach($array as $key => $val) {

	        $res .= $key.' = '.$val."\n";

	    }

	    @file_put_contents($file, $res);

	}
 
	/**
	 * Create a view file (and folders, if they do not exist yet).  Do not 
	 * include '.php' in the name.
	 * 
	 * Typical usage:
	 * generate/view/folder1\folder2\folder3\filename
	 * 
	 * @param string $name Separate subfolders with backslash folder1\folder2\file_name
	 * @return void
	 * @author Joost van Veen
	 */
	public function view ($name)
	{

		$name = $data['view_name'];

		$file = $this->_create_folders_from_name($name, 'views');
		
		$data = $this->_php_open();

		$path = APPPATH . 'views/' . $file['path'] . strtolower($file['file']) . '.php';

		write_file($path, $data);

		$this->msg[] = 'Created view file ' . $path;

		//echo $this->_messages();
		return $this->result(true, $this->msg[0]);

	}
 
	/**
	 * Create an empty library class. Do not include '.php' in the name.
	 * 
	 * Typical usage:
	 * generate/library/some_library[/class_to_extend]
	 * 
	 * @param string $name Separate subfolders with backslash folder1\folder2\class_name
	 * @param string $extends Defaults to NULL
	 * @return void
	 * @author Joost van Veen
	 */
	public function library ($name, $extends = NULL)
	{

		$file = $this->_create_folders_from_name($name, 'libraries');
		
		$data = '';

		$data .= $this->_class_open($file['file'], NULL, $extends);

		$data .= "\n\tpublic function __construct() {\n";

		$data .= "\t}\n";

		$data .= $this->_class_close();

		$path = APPPATH . 'libraries/' . $file['path'] . strtolower($file['file']) . '.php';

		write_file($path, $data);

		$this->msg[] = 'Created library ' . $path;

		//echo $this->_messages();
		return $this->result(true, $this->msg[0]);

	}
 
	/**
	 * Create an empty helper file. The extension _helper.php will automatically 
	 * be added. Do not include '.php' in the name.
	 * 
	 * Typical usage:
	 * generate/helper/some_helper
	 * 
	 * @param string $name Separate subfolders with backslash folder1\folder2\file_name
	 * @return void
	 * @author Joost van Veen
	 */
	public function helper ($name)
	{
		$file = $this->_create_folders_from_name($name, 'helpers');
		
		$data = $this->_php_open();
		strpos($file['file'], '_helper') || $file['file'] .= '_helper';
		$path = APPPATH . 'helpers/' . $file['path'] . strtolower($file['file']) . '.php';
		write_file($path, $data);
		$this->msg[] = 'Created helper file at ' . $path;
		//echo $this->_messages();
		return $this->result(true, $this->msg[0]);
	}
 
	/**
	 * Take the name of a file and traverse the folder path in that filename. 
	 * If the folders in the filename do not exist, create them.
	 * 
	 * Folders are separated by backslashes.
	 * 
	 * Typical usage:
	 * file - does nothing and just returns filname 'file'
	 * folder\file - creates folder 'folder' if it does not exist, and returns filename 'folder/file'
	 * folder\subfolder/file - creates folders 'folder' and 'folder/subfolder' if they do not exist, and returns filename 'folder/subfolder/file'
	 * 
	 * @param string $name [folder\][subfolder\]filename
	 * @param string $base_folder The base folder, relative to '/applications', e.g. 'views' or 'controllers'
	 * @return string The filepath
	 * @author Joost van Veen
	 */
	private function _create_folders_from_name ($name, $base_folder)
	{
		$this->load->helper('directory');
		$name = str_replace('%5C', '/', $name);
		
		// Check if folders exist. If not, create them.
		$folders = explode('/', $name);
		
		// Remove the last index, because that is the file
		$file = array_pop($folders);
		
		// Check if folders exist and create them if they don't
		$path = '';
		if (count($folders)) {
			$current_folder = directory_map(APPPATH . $base_folder);
			$current_path = APPPATH . $base_folder;
			foreach ($folders as $folder) {
				
				if (! isset($current_folder[$folder])) {
					$this->msg[] = 'Created new folder: ' . $folder;
					mkdir($current_path . '/' . $folder);
				}
				
				$current_folder = @$current_folder[$folder];
				$current_path .= '/' . $folder;
				$path .= $folder . '/';
			}

		}
		
		return array('path' => $path, 'file' => $file);

	}
 
	/**
	 * Return generic class opener
	 * @param string $name
	 * @param string $extends
	 * @return string
	 * @author Joost van Veen
	 */
	private function _class_open ($name, $type = NULL, $extends = NULL)
	{

		$string = $this->_php_open()."\n";

		$string .= "class " . ucfirst($name) . " ";

		if ($extends === NULL && $type !== NULL) {

			$string .= "extends MY_" . ucfirst(str_replace('Generate::', '', $type));

		}
		elseif ($extends !== NULL) {

			$string .= "extends $extends ";

		}

		$string .= "\n{"."\n";

		return $string;

	}
 
	/**
	 * Return generic CRUD methods for model
	 * @return string
	 * @author Joost van Veen
	 */
	private function _crud_methods_model ($table, $base_query = false)
	{

		$string = '';
		
		$string .= "\n\tprotected \$_table_name = '$table'; // table name\n"."\n";

		$string .= "\tprotected \$_primary_key = 'id'; // Delete this if value is 'id'\n"."\n";

		$string .= "\tprotected \$_primary_filter = 'intval'; // Delete this if value is 'intval'\n"."\n";

		$string .= "\tprotected \$_order_by = '';\n"."\n";

		$string .= "\tprotected \$_timestamps = FALSE; // Delete this if value is FALSE\n"."\n";

		$string .= "\tpublic \$rules = array(\n"."\n";

		$string .= "\t\t'some_field' => array(\n"."\n";

		$string .= "\t\t\t'field' => '',\n"."\n";

		$string .= "\t\t\t'label' => '',\n"."\n";

		$string .= "\t\t\t'rules' => 'trim',\n"."\n";

		$string .= "\t\t),\n"."\n";

		$string .= "\t);\n";
		
		$string .= "\n\tpublic function __construct() {\n"."\n";

		$string .= "\t\tparent::__construct();\n"."\n";

		$string .= "\t\t\$this->table_name = \$this->db->dbprefix.\$this->_table_name;\n"."\n";

		$string .= "\t}\n";

		if ($base_query) {

			$string .= "\t".'/**
	 * [get_data_by_id Using to get record data base on id record]
	 * @param  string $select [The field want to select]
	 * @param  [type] $id     [The id for record data]
	 * @return [type]         [null || record data]
	 */
	function get_data_by_id($select = "*", $id = null){

		//validate data
		if(!is_null($id) && is_numeric($id)){

			$this->db->where("ID = $id LIMIT 1");

		}
		else{

			return null;

		}

		//select data
		if(strcmp($select, "*") != 0){

			$this->db->select($select);

		} else {

			$this->db->select();

		}

		//query db
		$query = $this->db->get($this->table_name);

		$query = $this->result_data($query);

		//return result
		if (count($query) > 0) {

			return $query[0];

		}
		else {

			return null;

		}
		
	}

	/**
	 * [get_data_by_property Using get property of record base on any conditions]
	 * @param  [type] $select [The field want to select]
	 * @param  array  $where  [Array conditions]
	 * @param  optional  $limit  [Array or number limit record]
	 * @return [type]         [null || multi record data]
	 */
	function get_data_by_property($select, $where = array(), $limit = null){

		//validate data
		if(!is_null($where) && is_array($where)){

			$this->db->where($where);

		}
		else {

			return null;

		}

		//select data
		if(strcmp($select, "*") != 0) {

			$this->db->select($select);

		}
		else {

			$this->db->select();

		}

		if (isset($limit)) {

			if (is_array($limit)) {

				$this->db->limit(@$limit[0], @$limit[1]);

			}
			else {

				$this->db->limit($limit);

			}

		}
		
		//query
		$query = $this->db->get($this->table_name);
		
		//return result
		$query = $this->result_data($query);

		//return result
		if (count($query) > 0) {

			return $query;

		}
		else {

			return null;

		}

	}


	/**
	 * [set_data Using to insert data in table]
	 * @param array   $data   [Array data]
	 * @param integer $result [id || records]
	 */
	function set_data($data = array(), $result = 0){

		if(is_null($data) || !is_array($data)) {

			return null;

		}
		
		//insert data
		$this->db->insert($this->table_name, $data);

		//get last id
		$id = $this->db->insert_id();

		//return result
		if($result == 0){

			return $id;

		}
		else {

			$user = $this->get_data_by_id("*", $id);

			return $user;

		}

	}
	
	/**
	 * [update_data_by_id Using update data for a record]
	 * @param  array  $data [data update]
	 * @param  [type] $id   [id of record]
	 * @return [type]       [true || false]
	 */
	function update_data_by_id($data = array(), $id){

		//validate data
		if(is_null($data) || !is_array($data)){

			return null;

		}

		//get data by id
		$this->db->where("id", $id );

		//update
		$this->db->update($this->table_name, $data);
		
		//return result
		if($this->db->affected_rows() > 0){

			return true;

		}
		else {

			return false;

		}

	}
	

	/**
	 * [insert_all description]
	 * @param  array  $data [description]
	 * @return [type]       [description]
	 */
	public function insert_all($data = array())
	{

		if(count($data) > 0) {

			return $this->db->insert_batch($this->table_name, $data);

		}
		else {

			return null;

		}

	}

	/**
	 * [update_data_by_property description]
	 * @param  array  $data  [description]
	 * @param  array  $where [description]
	 * @return [type]        [description]
	 */
	function update_data_by_property ($data = array(), $where = array()){
		
		//validate data
		if(is_null($data) || !is_array($data)){

			return null;

		}

		if(is_null($where) || !is_array($where)){

			return null;

		}

		//get data by condition where
		$this->db->where($where);

		//update data
		$this->db->update($this->table_name, $data);

		//return result
		if($this->db->affected_rows() > 0){

			return true;

		}
		else {

			return false;

		}

	}

	/**
	 * [delete_data_by_property description]
	 * @param  array  $where [description]
	 * @return [type]        [description]
	 */
	public function delete_data_by_property($where = array())
	{

		if (is_array($where)) {

			$this->db->where($where);

			return $this->db->delete($this->table_name);

		}

	}'."\n";
		}

		return $string;

	}
 
	/**
	 * Return generic CRUD methods for controller
	 * @return string
	 * @author Joost van Veen
	 */
	private function _crud_methods_contraller ($data = array())
	{
		$string = '';
		$string .= "\n\tpublic function __construct() {\n"."\n";
		$string .= "\t\tparent::__construct();\n\n";

		$string .= "\n\t}\n";
		
		$string .= "\n\t/**\n";
		$string .= "\t * Fetch and display records\n";
		$string .= "\t * @return void\n";
		$string .= "\t */\n";
		$string .= "\tpublic function index() {\n";
		$string .= "\n\t}\n";

		$string .= "\n\t/**\n";
		$string .= "\t * Create a record\n";
		$string .= "\t * @return void\n";
		$string .= "\t */\n";
		$string .= "\tpublic function create() {\n";
		$string .= "\n\t}\n";

		$string .= "\n\t/**\n";
		$string .= "\t * Insert or update a record\n";
		$string .= "\t * @param int \$id Defaults to NULL\n";
		$string .= "\t * @return void\n";
		$string .= "\t */\n";
		$string .= "\tpublic function edit(\$id = NULL) {\n";
		$string .= "\n\t}\n";
		
		$string .= "\n\t/**\n";
		$string .= "\t * Delete a record\n";
		$string .= "\t * @param int \$id\n";
		$string .= "\t * @return void\n";
		$string .= "\t */\n";
		$string .= "\tpublic function delete(\$id) {\n";
		$string .= "\n\t}\n";
		return $string;
	}
 
	/**
	 * Return a generic class closing
	 * @return string
	 * @author Joost van Veen
	 */
	private function _class_close ()
	{
		return "\n}";
	}
 
	private function _php_open ()
	{
		return '<?php if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');' . "\n";
	}
 
	/**
	 * Wrap $this->msg in HTML and return it to be displayed
	 * @return string
	 * @author Joost van Veen
	 */
	private function _messages ()
	{
		$string = '<!DOCTYPE html>
		<html>
		<head>
		    <meta charset="utf-8">
		    <title>Generator script Phutv</title>
		    <script type="text/javascript">

				setInterval(function () {
					window.location.reload();
				}, 1000);

				</script>
		</head>
		<body style="background: #FCF7E3;">
			<div style="width: 600px; margin: 40px auto; font-family: arial, sans-serif; background: #fff; border: 1px dotted #000; padding: 30px; ">
			<h1>Generator script run Phutv</h1>
				' . ul($this->msg) . '
			</div>
		</body>
		</html>';
		return $string;
		
	}

	public function _add_contruct() {

		return "public function __construct() {\n
		
					parent::__construct(); \n
	
				}\n";

	}

	public function result($success = true, $message)
	{

		$this->response->success = $success;

		$this->response->message = $message;

		return $this->response;

	}

}

/* End of file generate.php */
/* Location: ./application/controllers/generate.php */