<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class T_platform extends MY_Model 
{

	protected $_table_name = 'platforms'; // table name

	protected $_primary_key = 'id'; // Delete this if value is 'id'

	protected $_primary_filter = 'intval'; // Delete this if value is 'intval'

	protected $_order_by = '';

	protected $_timestamps = FALSE; // Delete this if value is FALSE

	public $rules = array(

		'some_field' => array(

			'field' => '',

			'label' => '',

			'rules' => 'trim',

		),

	);

	public function __construct() {

		parent::__construct();

		$this->table_name = $this->db->dbprefix.$this->_table_name;

	}
	/**
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

		}else{

			$this->db->select();

		}

		//query db
		$query= $this->db->get($this->table_name);

		$query = $this->result_data($query);

		//return result
		if (count($query) > 0) {

			return $query[0];

		}
		else{

			return null;

		}
		
	}

	/**
	 * [get_data_by_property Using get property of record base on any conditions]
	 * @param  [type] $select [The field want to select]
	 * @param  array  $where  [Array conditions]
	 * @return [type]         [null || multi record data]
	 */
	function get_data_by_property($select, $where = array()){

		//validate data
		if(!is_null($where) && is_array($where)){

			$this->db->where($where);

		}
		else{

			return null;

		}

		//select data
		if(strcmp($select, "*") != 0){

			$this->db->select($select);

		}
		else{

			$this->db->select();

		}
		
		//query
		$query = $this->db->get($this->table_name);
		
		//return result
		$query = $this->result_data($query);

		//return result
		if (count($query) > 0) {

			return $query;

		}
		else{

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
		else{

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
		else{

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

		if (count($data) > 0) {

			return $this->db->insert_batch($this->table_name, $data);

		}
		else{

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
		else{

			return false;

		}

	}

}