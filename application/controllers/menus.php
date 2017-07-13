<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menus extends MY_Controller
{

	public function __construct() {

		parent::__construct();

	}

	/**
	 * Fetch and display records
	 * @return void
	 */
	public function index() {

		$this->load->model('t_menu');

		$this->data['menus'] = $this->t_menu->get_data_by_property('*');

	}

	public function sub_menu()
	{

        $this->load->model('t_menu');

		$this->data['menus'] = $this->t_menu->get_data_by_property('*');

		if ($this->input->post()) {

			$post = $this->input->post();

			$data = $this->parse_fields_table($post, $this->t_menu->table_name);

			if (count($data) && isset($post['parent_menu'])) {

				$data['menu_id'] = $post['parent_menu'];

				$this->load->model('t_sub_menu');

                $rows = $this->t_sub_menu->get_data_by_property('*', $data);

                if (count($rows)) {

                    $this->response->message = 'Sub menu has been existed';

                    $this->response_message();

                }

				$insert = $this->t_sub_menu->set_data($data, 1);

				if ($insert) {

                    $this->response->success = 1;

					$this->response->message = lang('Saved');

					$this->response->data = $insert;

				}
				else {

					$this->response->message = lang('Save_error');

				}

			}

			$this->response_message();

		}

		$this->data['title_key'] = array(
            'name' => 'title_key',
            'id' => 'title_key',
            'type' => 'text',
            'class' => 'input-long extra uniform modalGetValue',
            'data-modal' => '#modal-title_key',
            'value' => $this->form_validation->set_value('title_key')
        );
        
        $this->data['action_router'] = array(
            'name' => 'action_router',
            'id' => 'action_router',
            'type' => 'text',
            'class' => 'input-long extra uniform modalGetValue',
            'data-modal' => '#modal-action_router',
            'value' => $this->form_validation->set_value('action_router')
        );
        
        $this->data['icon'] = array(
            'name' => 'icon',
            'id' => 'icon',
            'type' => 'text',
            'class' => 'input-long extra uniform',
            'value' => $this->form_validation->set_value('icon')
        );

        $this->data['parent_menu'] = array(
            'name' => 'parent_menu',
            'id' => 'parent_menu',
            'type' => 'text',
            'class' => 'input-long extra uniform modalGetValue',
            'data-modal' => '#modal-parent_menu',
            'value' => $this->form_validation->set_value('parent_menu')
        );
        
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'class' => 'input-long extra uniform',
            'value' => $this->form_validation->set_value('description')
        );

        $lang_key = $this->data['lang_key'];

        $controller = $this->get_controller_list();

        $this->data['controller_lists'] = $controller;

        $this->data['lang_data'] = $this->lang->structure[$lang_key.'_lang'.EXT];

        $first_controller = @array_values($controller)[0];

        $this->data['first_controller'] = $first_controller;

        $this->data['first_action_lists'] = $this->get_all_method_of_class($first_controller);

	}

	public function create()
	{

		if ($this->input->post()) {

			$post = $this->input->post();

			$this->load->model('t_menu');

			$data = $this->parse_fields_table($post, $this->t_menu->table_name);

			if (count($data)) {

                $rows = $this->t_menu->get_data_by_property('*', $data);

                if (count($rows)) {

                    $this->response->message = 'Menu has been existed';

                    $this->response_message();

                }

				$insert = $this->t_menu->set_data($data, 1);

				if ($insert) {

                    $this->response->success = 1;

					$this->response->message = lang('Saved');

					$this->response->data = $insert;

				}
				else {

					$this->response->message = lang('Save_error');

				}

			}

			$this->response_message();

		}

		$this->data['title_key'] = array(
            'name' => 'title_key',
            'id' => 'title_key',
            'type' => 'text',
            'class' => 'input-long extra uniform modalGetValue',
            'data-modal' => '#modal-title_key',
            'value' => $this->form_validation->set_value('title_key')
        );
        
        $this->data['action_router'] = array(
            'name' => 'action_router',
            'id' => 'action_router',
            'type' => 'text',
            'class' => 'input-long extra uniform modalGetValue',
            'data-modal' => '#modal-action_router',
            'value' => $this->form_validation->set_value('action_router')
        );
        
        $this->data['icon'] = array(
            'name' => 'icon',
            'id' => 'icon',
            'type' => 'text',
            'class' => 'input-long extra uniform',
            'value' => $this->form_validation->set_value('icon')
        );
        
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'class' => 'input-long extra uniform',
            'value' => $this->form_validation->set_value('description')
        );

        $lang_key = $this->data['lang_key'];

        $controller = $this->get_controller_list();

        $this->data['controller_lists'] = $controller;

        $this->data['lang_data'] = $this->lang->structure[$lang_key.'_lang'.EXT];

        $first_controller = @array_values($controller)[0];

        $this->data['first_controller'] = $first_controller;

        $this->data['first_action_lists'] = $this->get_all_method_of_class($first_controller);

		$this->render(null, 'system/create_menu_view', $this->data, false);

	}

	/**
	 * Insert or update a record
	 * @param int $id Defaults to NULL
	 * @return void
	 */
	public function edit($id = NULL) {

        $this->load->model('t_menu');

		if ($this->input->post()) {

			$post = $this->input->post();

			$data = $this->parse_fields_table($post, $this->t_menu->table_name);

			if (count($data)) {

				$id = $post['menu_id'];

				$updated = $this->t_menu->update_data_by_id($data, $id);

				if ($updated) {

                    $this->response->success = 1;

					$this->response->message = lang('Saved');

					$this->response->data = $updated;

				}
				else {

					$this->response->message = lang('Save_error');

				}

			}

			$this->response_message();

		}

		if (!$id || empty($id)) {
            
            $this->redirect(array(
            	'menu',
            	'index'
            ), 'refresh');
            
        }

		$menus = $this->t_menu->get_data_by_id('*', $id);

		$this->data['title_key'] = array(
            'name' => 'title_key',
            'id' => 'title_key',
            'type' => 'text',
            'class' => 'input-long extra uniform modalGetValue',
            'data-modal' => '#modal-title_key',
            'value' => $this->form_validation->set_value('title_key', $menus['title_key'])
        );
        
        $this->data['action_router'] = array(
            'name' => 'action_router',
            'id' => 'action_router',
            'type' => 'text',
            'class' => 'input-long extra uniform modalGetValue',
            'data-modal' => '#modal-action_router',
            'value' => $this->form_validation->set_value('action_router', $menus['action_router'])
        );
        
        $this->data['icon'] = array(
            'name' => 'icon',
            'id' => 'icon',
            'type' => 'text',
            'class' => 'input-long extra uniform',
            'value' => $this->form_validation->set_value('icon', $menus['icon'])
        );
        
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'class' => 'input-long extra uniform',
            'value' => $this->form_validation->set_value('description', $menus['description'])
        );

        $lang_key = $this->data['lang_key'];

        $controller = $this->get_controller_list();

        $this->data['menu_id'] = $id;

        $this->data['controller_lists'] = $controller;

        $this->data['lang_data'] = $this->lang->structure[$lang_key.'_lang'.EXT];

        $first_controller = @array_values($controller)[0];

        $this->data['first_controller'] = $first_controller;

        $this->data['first_action_lists'] = $this->get_all_method_of_class($first_controller);

		$this->render(null, 'system/edit_menu_view', $this->data, false);

	}

	/**
	 * Delete a record
	 * @param int $id
	 * @return void
	 */
	public function delete($id) {

	}

}