<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modules extends MY_Controller
{

	public function __construct() {

		parent::__construct();


	}

	/**
	 * Fetch and display records
	 * @return void
	 */
	public function index() {

		$this->load->model('t_module');

		$this->data['menus'] = $this->t_module->get_data_by_property('*');
		
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

}