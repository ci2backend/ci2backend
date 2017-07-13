<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Generic model for entity class, CI AR.
 * @author PhuTv
 *
 */
class MY_Model extends CI_Model {
	
	var $table_name;

	var $is_object = false;

	function __construct() {

		parent::__construct();

	}

	public function result_data($query)
	{

		if ($this->is_object) {

			return $query->result_object();

		}
		else {

			return $query->result_array();

		}

	}

	/**
	 * Get max value by field name (eg: integer field).
	 * @param unknown $field
	 */
	function get_max_id($field) {

		$r = $this->db->select('max('.$field.') as '.$field)->from($this->table_name)->get()->row();
		
		return $r->$field;

	}

	function where($where)
	{

		array_push($this->db->ar_where, $where);

	}

	function like($post_slug, $like)
	{
		
		$this->db->like($post_slug, $like);
		
	}

	function group_by($group='')
	{

		if ($group) {
			
			$this->db->group_by($group);

		}

		return $this;

	}

	function join($table, $on_condition, $left = null)
	{

		$tables = $this->list_tables(false);

		if (in_array($table, $tables)) {

			if (isset($left)) {
				
				$this->db->join($table, $on_condition, $left);

			}
			else {

				$this->db->join($table, $on_condition);

			}

			return $this;

		}

	}

	public function list_tables($prefix = false)
    {

    	$tables = $this->db->list_tables();

    	if (!$prefix) {

    		foreach ($tables as $key => $table) {
    			
    			$tables[$key] = str_replace($this->db->dbprefix, '', $table);
    			
    		}

    	}

    	return $tables;

    }

    public function get_model_by_table_name($table_name = null)
    {

    	$ini_file = APPPATH.'models/'."config_model.ini";

    	if (is_file($ini_file)) {

    		$ini_array = parse_ini_file(APPPATH.'models/'."config_model.ini");
    		
			if (count(@$ini_array) > 0) {

				foreach ($ini_array as $key => $table) {

					if ($table == $table_name) {

						return $key;

					}

				}

			}
			else{

				$ini_array = array(

					$name => $table

				);

			}

    	}

    	return $table_name;
    	
    }

    public function set_message_validate() {

		$this->form_validation->set_message('required', lang('The_name_field_is_required'));

		$this->form_validation->set_message('max_length', lang('The_name_field_can_not_exceed_number_characters_in_length'));
		
		$this->form_validation->set_message('is_unique', lang('This_name_is_exist'));

	}

	public function delete_by_id($id)
	{
		
		if ($this->table_name && $id) {
			
			$this->db->where('id', $id);

  			$this->db->delete($this->table_name);

		}

	}
	
}