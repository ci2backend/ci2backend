<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_constants extends MY_Controller
{

	public function __construct() {

		parent::__construct();

	}

    public function checkConstantExist() {

        if ($this->input->post('constant')) {
            
            $constant = $this->input->post('constant');

            $this->load->model('t_constants');

            $checkExist = $this->t_constants->get_data_by_property('*', ['constant' => $constant]);
        
            if (count($checkExist) > 0) {
                
                echo 'false';

            } else {
                
                echo 'true';

            }            

        } else {

            echo 'false';

        }

        exit();

    }

	public function create() {

		if ($this->input->post()) {

			$post = $this->input->post();

			$this->load->model('t_constants');

			$data = $this->parse_fields_table($post, $this->t_constants->table_name);

            if (isset($data['is_system'])) {
                            
                unset($data['is_system']);

            }

			if (count($data) > 0) {

                foreach ($data as $key => $value) {
                    
                    $data[$key] = trim($value);

                }

                $this->form_validation->set_rules($this->t_constants->rules_create);

                $this->t_constants->set_message_validate();

                if ($this->form_validation->run() == false) {

                    $errors = explode("\n", validation_errors());
                    
                    $this->response->message = $errors[0];
                    
                    $this->response_message();

                }

				$insert = $this->t_constants->set_data($data, 1);

				if ($insert) {

                    $this->response->success = 1;

					$this->response->message = lang('Saved');

                    $template = $this->data['template'];

                    $insert['template'] = $template;

					$this->response->data = $this->load->common("setting/item_constant", true, $insert);

                    $this->response->callback_function = 'constant_create';

				} else {

					$this->response->message = lang('Save_error');

				}

			} else {

                $this->response->message = lang('Data_not_found');

            }

			$this->response_message();

		} else {

            die(lang('Permission_denied'));

        }

	}

	/**
	 * Insert or update a record
	 * @param int $id Defaults to NULL
	 * @return void
	 */
	public function edit() {

		if ($this->input->post('constant_id')) {

            $post = $this->input->post();

            $this->load->model('t_constants');

			$data = $this->parse_fields_table($post, $this->t_constants->table_name);

			if (count($data) > 0) {

                foreach ($data as $key => $value) {
                    
                    $data[$key] = trim($value);
                    
                }

				$id = $this->input->post('constant_id');

                $dataCheck = $this->t_constants->get_data_by_id('*', $id);

                if (count($dataCheck) > 0) {

                    if ($dataCheck['is_system'] == 1) {
                        
                        $this->response->message = lang('Permission_denied');

                        $this->response_message();

                    }

                    if (isset($data['constant']) && $data['constant'] != $dataCheck['constant']) {
                        
                        $this->form_validation->set_rules($this->t_constants->rules_create);

                    } else {

                        $this->form_validation->set_rules($this->t_constants->rules_edit);

                    }

                    $this->t_constants->set_message_validate();

                    if ($this->form_validation->run() == false) {

                        $errors = explode("\n", validation_errors());
                        
                        $this->response->message = $errors[0];
                        
                        $this->response_message();

                    }

    				$updated = $this->t_constants->update_data_by_id($data, $id);

    				if ($updated) {

                        $dataUpdated = $this->t_constants->get_data_by_id('*', $id);

                        $this->response->success = 1;

                        $this->response->message = lang('Saved');

                        $template = $this->data['template'];

                        $dataUpdated['template'] = $template;

                        $this->response->data = $this->load->common("setting/item_constant", true, $dataUpdated);

                        $this->response->callback_function = 'constant_update';

    				} else {

    					$this->response->message = lang('Save_error');

    				}

                } else {
                    
                    $this->response->message = lang('Data_not_found');

                }

			} else {

                $this->response->message = lang('Data_not_found');

            }

			$this->response_message();

		} else {

            die(lang('Permission_denied'));

        }

	}
	
	/**
	 * Delete a record
	 * @param  int $id
	 * @return bool
	 */
	public function delete($id = null) {

        $this->response->message = lang('Data_not_found');

        if ($this->input->is('post')) {

            if (!$this->input->post('file')) {

                $this->response->message = lang('Data_not_found');

                $this->response_message();

            }

            $id = base64_decode($this->input->post('file'));

        }
        else {

            $id = base64_decode($id);

        }

        if (is_null($id)) {
            
            $this->response_message();

        }

        $this->load->model('t_constants');

        $dataCheck = $this->t_constants->get_data_by_id('*', $id);

        if (count($dataCheck) > 0) {
            
            if (isset($dataCheck['is_system']) && $dataCheck['is_system'] == 0) {

                if ($this->t_constants->delete_data_by_id($id)) {

                    $this->response->success = 1;

                    flash_success(lang('Deleted'));

                    $this->response->data = $id;

                    $this->response->callback_function = 'constant_delete';

                } else {

                    flash_error(lang('Delete_error'));

                }

            } else {
                
                flash_error(lang('Permission_denied'));

            }
            
        }

        $this->redirect();

	}

}