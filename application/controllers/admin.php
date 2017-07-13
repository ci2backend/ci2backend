<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller
{

	public function __construct() {

		parent::__construct();

	}

	/**
	 * Fetch and display records
	 * @return void
	 */
	public function index() {

		$this->render(null, 'admin/index', $this->data);

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