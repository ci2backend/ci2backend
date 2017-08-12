<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{
    
    function __construct()
    {
        
        parent::__construct();
        
        $this->load->library(array(
            'ion_auth',
            'form_validation'
        ));
        
        $this->load->helper(array(
            'url',
            'language'
        ));
        
    }
    
    //redirect if needed, otherwise display the user list
    function index()
    {

        $this->redirect(array(
            'users',
            'index'
        ));
        
    }
    
    //log the user in
    function login()
    {
        
        if ($this->ion_auth->logged_in()) {
            
            $this->redirect(array(
                'admin.html'
            ));
            
        }
        
        //validate form input
        $this->form_validation->set_rules('identity', $this->lang->line('login_identity_label'), 'required');
        
        $this->form_validation->set_rules('password', $this->lang->line('login_password_label'), 'required');
        
        if ($this->form_validation->run() == true) {
            
            //check to see if the user is logging in
            //check for "remember me"
            $remember = (bool) $this->input->post('remember');
            // var_dump($this->input->post());exit();
            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                
                //if the login is successful
                //redirect them back to the home page
                flash_success($this->ion_auth->messages());

                $data_user = $this->ion_auth->user()->row_array();

                if ($data_user['first_login'] == 1) {

                    $this->ion_auth->update($data_user['id'], array('first_login' => 0));

                } else {

                    if ($this->get_current_url() != null) {

                        $this->redirect_current();

                    }

                }

                if ($this->ion_auth->is_admin()) {

                    $this->redirect(array(
                        'admin.html'
                    ));

                }
                
                $this->redirect(array(
                    $this->router->default_controller
                ));
                
            } else {
                
                //if the login was un-successful
                //redirect them back to the login page
                flash_error($this->ion_auth->errors());

                $this->response->message = $this->ion_auth->errors();
                
                $this->redirect(array(
                    'login.html'
                ));
                
            }
            
        } else {
            
            //the user is not logging in so display the login page
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->response->message = $this->data['message'];

            $this->response->modal = 1;
            
            $this->data['identity'] = array(
                'name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
                'class' => 'form-control'
            );
            
            $this->data['password'] = array(
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'class' => 'form-control'
            );
            
            $this->set_page_title($this->lang->line('admin_login'));
            
            $this->data['key_page'] = $this->guid();
            
            if ($this->session->userdata('http_post_data')) {
                
                foreach ($this->session->userdata('http_post_data') as $key => $post) {
                    
                    $this->data[$key] = strtoupper($post);
                    
                }
                
                $this->session->unset_userdata('http_post_data');
                
            }
            
            $this->load->extension('jquery-validate');
            
            if ($this->data['message']) {
                
                flash_warning($this->data['message']);
                
            }
            
            $this->render(null, 'admin/login/admin_login', $this->data);
            
        }
        
    }
    	
    public function delete_user($id)
    {

    	if (isset($id) && $this->ion_auth->is_admin()) {

    		$groups = $this->ion_auth->get_groups_users($id)->result_array();

    		$group_names = array();

    		if (count($groups) > 0) {

    			foreach ($groups as $key => $group) {

    				array_push($group_names, $group['name']);

    			}

    		}

    		$admin = $this->ion_auth->group(1)->result_array()[0]['name'];

    		if (in_array($admin, $group_names)) {

    			flash_warning(lang('You_not_have_privilege_to_delete_this_user'));

    			$this->redirect($_SERVER['HTTP_REFERER'], 'refresh');

    		}
    		else {

    			if ($this->ion_auth->delete_user($id)) {

	    			if ($this->ion_auth->messages()) {

                        flash_success($this->ion_auth->messages());
		                
		            }
                    else {

                        flash_error(lang('Delete_error'));

                    }

	    		}

    			$this->redirect($_SERVER['HTTP_REFERER'], 'refresh');

    		}

    	}
    	else {

    		$this->redirect($_SERVER['HTTP_REFERER'], 'refresh');

    	}

    }

    //log the user out
    function logout()
    {
        
        //log the user out
        $logout = $this->ion_auth->logout();
        
        //redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        
        $this->redirect(array(
                'login.html'
            )
        );
        
    }
    
    //change password
    public function change_password()
    {
        
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');
        
        if (!$this->ion_auth->logged_in()) {
            
            $this->redirect(array(
                    'login.html'
                )
            );
            
        }
        
        $user = $this->ion_auth->user()->row();
        
        if ($this->form_validation->run() == false) {
            
            //display the form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            
            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            
            $this->data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
                'class' => 'extra input-long'
            );
            
            $this->data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                'class' => 'extra input-long'
            );
            
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                'class' => 'extra input-long'
            );
            
            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
                'class' => 'extra input-long'
            );
            
            //render
            $this->render(null, 'auth/change_password', $this->data, null);
            
        } else {
            
            $identity = $this->session->userdata('identity');
            
            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));
            
            if ($change) {
                
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                
                $this->logout();
                
            } else {
                
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                
                redirect('auth/change_password', 'refresh');
                
            }
            
        }
        
    }
    
    //forgot password
    public function forgot_password()
    {
        
        //setting validation rules by checking wheather identity is username or email
        if ($this->config->item('identity', 'ion_auth') == 'username') {
            
            $this->form_validation->set_rules('email', $this->lang->line('forgot_password_username_identity_label'), 'required');
            
        } else {
            
            $this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
            
        }

        $this->data['type'] = $this->config->item('identity', 'ion_auth');

        $this->data['identity'] = array(
            'name' => $this->config->item('identity', 'ion_auth'),
            'id' => $this->config->item('identity', 'ion_auth'),
            'class' => 'input-long',
            'placeholder' => 'Please input value'
        );
        
        if ($this->config->item('identity', 'ion_auth') == 'username') {
            
            $this->data['identity_label'] = $this->lang->line('forgot_password_username_identity_label');
            
        } else {
            
            $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            
        }
        
        if ($this->input->is('post')) {

            if ($this->form_validation->run() == false) {
            
                //set any errors and display the form
                
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                flash_error($this->data['message']);
                
            } else {
                
                // get identity from username or email
                if ($this->config->item('identity', 'ion_auth') == 'username') {
                    
                    $identity = $this->ion_auth->where('username', strtolower($this->input->post('email')))->users()->row();
                    
                } else {
                    
                    $identity = $this->ion_auth->where('email', strtolower($this->input->post('email')))->users()->row();
                    
                }
                
                if (empty($identity)) {
                    
                    if ($this->config->item('identity', 'ion_auth') == 'username') {
                        
                        $this->ion_auth->set_message('forgot_password_username_not_found');
                        
                    } else {
                        
                        $this->ion_auth->set_message('forgot_password_email_not_found');
                        
                    }
                    
                    flash_error($this->ion_auth->messages());

                    $segments = array(
                        'auth',
                        'forgot_password'
                    );

                    $this->redirect($segments);
                    
                }
                else {

                    //run the forgotten password method to email an activation code to the user
                    $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});
                    
                    if ($forgotten) {
                        
                        //if there were no errors
                        flash_success($this->ion_auth->messages());
                        
                        $this->redirect(['login.html']); //we should display a confirmation page here instead of the login page
                        
                    } else {
                        
                        flash_error($this->ion_auth->messages());
                        
                        $segments = array(
                            'auth',
                            'forgot_password'
                        );

                        $this->redirect($segments);
                        
                    }

                }
                
            }
            
        }
        
    }
    
    //reset password - final step for forgotten password
    public function reset_password($code = NULL)
    {
        if (!$code) {
            
            show_404();
            
        }
        
        $user = $this->ion_auth->forgotten_password_check($code);
        
        if ($user) {
            
            //if the code is valid then display the password reset form
            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');
            
            if ($this->form_validation->run() == false) {
                
                //display the form
                //set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                
                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                
                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                    'class' => 'form-control'
                );
                
                $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                    'class' => 'form-control'
                );
                
                $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                    'class' => 'form-control'
                );
                
                $this->data['csrf'] = $this->_get_csrf_nonce();
                
                $this->data['code'] = $code;
                
                //render
                $this->_render_page('auth/reset_password', $this->data);
                
            } else {
                
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {
                    
                    //something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);
                    
                    show_error($this->lang->line('error_csrf'));
                    
                } else {
                    
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};
                    
                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));
                    
                    if ($change) {
                        
                        //if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        
                        redirect("auth/login", 'refresh');
                        
                    } else {
                        
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        
                        redirect('auth/reset_password/' . $code, 'refresh');
                        
                    }
                    
                }
                
            }
            
        } else {
            
            //if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            
            redirect("auth/forgot_password", 'refresh');
            
        }
        
    }
    
    
    //activate the user
    function activate($id, $code = false)
    {
        
        if ($code !== false) {
            
            $activation = $this->ion_auth->activate($id, $code);
            
        } else if ($this->ion_auth->is_admin()) {
            
            $activation = $this->ion_auth->activate($id);
            
        }
        
        if ($activation) {
            
            //redirect them to the auth page
            flash_success($this->ion_auth->messages());
            
            $this->referrer();
            
        } else {
            
            //redirect them to the forgot password page
            flash_error($this->ion_auth->errors());

            $segments = array(
                'auth',
                'forgot_password'
            );
            
            $this->redirect($segments);
            
        }
        
    }
    
    //deactivate the user
    function deactivate($id = NULL)
    {
        
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            
            //redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
            
        }
        
        $id = (int) $id;
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');
        
        if ($this->form_validation->run() == FALSE) {
            
            // insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            
            $this->data['user'] = $this->ion_auth->user($id)->row();
            
            $this->render(null, 'auth/deactivate_user', $this->data);
            
        } else {
            
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes') {
                
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                    
                    show_error($this->lang->line('error_csrf'));
                    
                }
                
                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    
                    $this->ion_auth->deactivate($id);
                    
                }
                
            }
            
            //redirect them back to the auth page
            $this->redirect(['users']);
            
        }
        
    }
    
    //create a new user
    function create_user()
    {

        $this->data['title'] = lang('Create_user');
        
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {

            $this->redirect(['users']);

        }
        
        $tables                        = $this->config->item('tables', 'ion_auth');

        $identity_column               = $this->config->item('identity', 'ion_auth');

        $this->data['identity_column'] = $identity_column;
        
        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        
        if ($identity_column !== 'email') {

            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
            
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');

        }
        else {
            
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');

        }

        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
        
        if ($this->form_validation->run() == true) {

            $email    = strtolower($this->input->post('email'));

            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');

            $password = $this->input->post('password');

            $username = explode('@', $this->input->post('email'));

            if (count($username) > 0) {
            	
            	$username = $username[0];

            }
            else {

            	$username = null;

            }
            
            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'username' => $username,
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
                'lang_folder' => $this->input->post('lang_folder')
            );

        }

        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data)) {
            // check to see if we are creating the user
            
            // redirect them back to the admin page
            flash_success($this->ion_auth->messages());
            
            $this->redirect();
            
        } else {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            
            $this->data['first_name'] = array(
                'name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'class' => 'input-long extra uniform',
                'value' => $this->form_validation->set_value('first_name'),
                'placeholder' => placeholder('create_user_validation_fname_label')
            );
            
            $this->data['last_name'] = array(
                'name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'class' => 'input-long extra uniform',
                'value' => $this->form_validation->set_value('last_name'),
                'placeholder' => placeholder('create_user_validation_lname_label')
            );
            
            $this->data['identity'] = array(
                'name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'class' => 'input-long extra uniform',
                'value' => $this->form_validation->set_value('identity'),
                'placeholder' => placeholder('create_user_validation_identity_label')
            );
            
            $this->data['email'] = array(
                'name' => 'email',
                'id' => 'email',
                'type' => 'text',
                'class' => 'input-long extra uniform',
                'value' => $this->form_validation->set_value('email'),
                'placeholder' => placeholder('create_user_validation_email_label')
            );

            $this->data['lang_default'] = array(
                'name' => 'lang_folder',
                'id' => 'lang_folder',
                'class' => 'input-long extra uniform'
            );

            $options = array();

            $this->load->model('t_language');

            $languages = $this->t_language->get_data_by_property('*');

            if (count($languages)) {

                foreach ($languages as $key => $language) {

                    $options[$language['lang_folder']] = $language['lang_display'];

                }

            }

            $this->data['options'] =$options;
            
            $this->data['company'] = array(
                'name' => 'company',
                'id' => 'company',
                'type' => 'text',
                'class' => 'input-long extra uniform',
                'value' => $this->form_validation->set_value('company'),
                'placeholder' => placeholder('create_user_validation_company_label')
            );
            
            $this->data['phone'] = array(
                'name' => 'phone',
                'id' => 'phone',
                'type' => 'text',
                'class' => 'input-long extra uniform',
                'value' => $this->form_validation->set_value('phone'),
                'placeholder' => placeholder('edit_user_validation_phone_label')
            );
            
            $this->data['password'] = array(
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'class' => 'input-long extra uniform',
                'value' => $this->form_validation->set_value('password'),
                'placeholder' => placeholder('create_user_validation_password_label')
            );
            
            $this->data['password_confirm'] = array(
                'name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'password',
                'class' => 'input-long extra uniform',
                'value' => $this->form_validation->set_value('password_confirm'),
                'placeholder' => placeholder('create_user_validation_password_confirm_label')
            );
            
        }
        
    }
    
    
    //edit a user
    function edit_user($id)
    {
        
        $this->data['title'] = lang("Edit_user");
        
        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
            
            redirect('auth', 'refresh');
            
        }
        
        $user = $this->ion_auth->user($id)->row();
        
        $groups = $this->ion_auth->groups()->result_array();
        
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();
        
        //validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
        
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
        
        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
        
        $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');
        
        if (isset($_POST) && !empty($_POST)) {
            
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                
                show_error($this->lang->line('error_csrf'));
                
            }
            
            //update the password if it was posted
            if ($this->input->post('password')) {
                
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
                
            }
            
            if ($this->form_validation->run() === TRUE) {
                
                $post = $this->parse_data_post();

                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                    'phone' => $this->input->post('lang_folder')
                );
                
                //update the password if it was posted
                if ($this->input->post('password')) {
                    
                    $data['password'] = $this->input->post('password');
                    
                }
                
                // Only allow updating groups if user is admin
                if ($this->ion_auth->is_admin()) {
                    
                    //Update the groups user belongs to
                    $groupData = $this->input->post('groups');
                    
                    if (isset($groupData) && !empty($groupData)) {
                        
                        $this->ion_auth->remove_from_group('', $id);
                        
                        foreach ($groupData as $grp) {
                            $this->ion_auth->add_to_group($grp, $id);
                        }
                        
                    }
                    
                }
                
                //check to see if we are updating the user
                if ($this->ion_auth->update($user->id, $data)) {
                    
                    //redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    
                    if ($this->ion_auth->is_admin()) {
                        
                        redirect('auth', 'refresh');
                        
                    } else {
                        
                        redirect('/', 'refresh');
                        
                    }
                    
                } else {
                    
                    //redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    
                    if ($this->ion_auth->is_admin()) {
                        
                        redirect('auth', 'refresh');
                        
                    } else {
                        
                        redirect('/', 'refresh');
                        
                    }
                    
                }
                
            }
            
        }
        
        //display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();
        
        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        
        //pass the user to the view
        $this->data['user'] = $user;
        
        $this->data['groups'] = $groups;
        
        $this->data['currentGroups'] = $currentGroups;
        
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
            'class' => 'extra input-long uniform'
        );
        
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
            'class' => 'extra input-long uniform'
        );
        
        $this->data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'value' => $this->form_validation->set_value('company', $user->company),
            'class' => 'extra input-long uniform'
        );
        
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone),
            'class' => 'extra input-long uniform'
        );
        
        $this->data['password']         = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password',
            'class' => 'extra input-long uniform'
        );
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password',
            'class' => 'extra input-long uniform'
        );
        
        $this->render(null, 'auth/edit_user', $this->data, null);
        
    }
    
    // create a new group
    function create_group()
    {

        $this->lang->load('auth/create_group');
        
        $this->data['title'] = $this->lang->line('create_group_title');
        
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            
            $this->redirect();
            
        }
        
        //validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');
        
        if ($this->form_validation->run() == TRUE) {
            
            $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
            
            if ($new_group_id) {
                
                // check to see if we are creating the group
                // redirect them back to the admin page
                flash_success($this->ion_auth->messages());
                
            }
            else {
                
                flash_error($this->ion_auth->errors());

            }

            $this->redirect();
            
        } else {
            
            //display the create group form
            //set the flash data error message if there is one
            $message = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            flash_error($message);

            $this->data['group_name'] = array(
                'name' => 'group_name',
                'placeholder' => placeholder('Group_name'),
                'id' => 'group_name',
                'type' => 'text',
                'class' => 'input-long uniform',
                'value' => $this->form_validation->set_value('group_name')
            );
            
            $this->data['description'] = array(
                'name' => 'description',
                'placeholder' => placeholder('Group_description'),
                'id' => 'description',
                'type' => 'text',
                'class' => 'input-long uniform',
                'value' => $this->form_validation->set_value('description')
            );

            $groups = $this->ion_auth->groups()->result_array();

            $this->data['groups'] = $groups;
            
            $this->render(null, 'auth/create_group', $this->data, null);
            
        }
        
    }
    
    //edit a group
    function edit_group($id = null)
    {
        
        // bail if no group id given
        if (!$id || empty($id)) {
            
            redirect('auth', 'refresh');
            
        }
        
        $this->data['title'] = $this->lang->line('edit_group_title');
        
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            
            redirect('auth', 'refresh');
            
        }
        
        $group = $this->ion_auth->group($id)->row();
        
        //validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');
        
        if (isset($_POST) && !empty($_POST)) {
            
            if ($this->form_validation->run() === TRUE) {

                $message = '';
                
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);
                
                if ($group_update) {

                    $message = $this->lang->line('edit_group_saved');
                    
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                    
                } else {

                    $message = $this->ion_auth->errors();
                    
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    
                }

                if ($this->input->is_ajax_request()) {

                    $this->response->success = $group_update;

                    $this->response->message = $message;

                    $this->response_message();

                }
                
                redirect("auth", 'refresh');
                
            }
            
        }
        
        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        
        //pass the user to the view
        $this->data['group'] = $group;
        
        $readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';
        
        $this->data['group_name'] = array(
            'name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'class' => 'input-long uniform',
            'value' => $this->form_validation->set_value('group_name', $group->name),
            $readonly => $readonly
        );
        
        $this->data['group_description'] = array(
            'name' => 'group_description',
            'id' => 'group_description',
            'type' => 'text',
            'class' => 'input-long uniform',
            'value' => $this->form_validation->set_value('group_description', $group->description)
        );
        
        $this->render(null, 'auth/edit_group', $this->data, null);
        
    }
    
    
    function _get_csrf_nonce()
    {
        
        $this->load->helper('string');
        
        $key = random_string('alnum', 8);
        
        $value = random_string('alnum', 20);
        
        $this->session->set_flashdata('csrfkey', $key);
        
        $this->session->set_flashdata('csrfvalue', $value);
        
        return array(
            $key => $value
        );
        
    }
    
    function _valid_csrf_nonce()
    {
        
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE && $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
            
            return TRUE;
            
        } else {
            
            return FALSE;
            
        }
        
    }
    
    function _render_page($view, $data = null, $render = false)
    {
        
        $this->viewdata = (empty($data)) ? $this->data : $data;
        
        $view_html = $this->load->view($view, $this->viewdata, $render);
        
        if (!$render)
            return $view_html;
        
    }
    
}