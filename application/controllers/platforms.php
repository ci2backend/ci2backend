<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Platforms extends MY_Controller
{

	public function __construct() {

		parent::__construct();

	}

	/**
	 * Fetch and display records
	 * @return void
	 */
	public function index() {

		$this->load->model('t_platform');

		$this->data['platforms'] = $this->t_platform->get_data_by_property('*', array());

		$this->render(null, 'platforms/index', $this->data);

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
		var_dump($this->input->post()); exit();
	}

	public function set_default()
	{

		if (!$this->input->is_ajax_request()) {

			flash_error(lang('Only_allow_access_with_ajax'));

			$this->response_message();

		}

		if ($this->input->is('post')) {

			if (!$this->input->post('platform_key')) {

				flash_error(lang('Data_not_found'));

				$this->response_message();

			}

			$platform_key = $this->input->post('platform_key');

			$this->load->model('t_platform');

			$this->t_platform->update_data_by_property(array(
					'is_default' => 0
				)
			);

			$this->t_platform->update_data_by_property(array(
					'is_default' => 1
				), array(
					'platform_key' => $platform_key
				)
			);

			flash_success(lang('Saved'));

		}
		else {
			
			flash_error(lang('Not_allow_method_GET'));

		}

		$this->response_message();

	}

	/**
	 * Delete a record
	 * @param int $id
	 * @return void
	 */
	public function delete($id) {

	}

	public function get_default_platform()
	{

		$this->load->model('t_platform');

        $this->t_platform->is_object = true;

        $platform = $this->t_platform->get_data_by_property('*', array('is_default' => 1));

        if (count($platform) > 0) {

            return $platform[0]->platform_key;

        }

	}

}