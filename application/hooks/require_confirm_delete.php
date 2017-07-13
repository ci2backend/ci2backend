<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Generate User Key
| -------------------------------------------------------------------------
*/

class Require_confirm_delete {

	public function confirm_delete() {

		$CI =& get_instance();

        $require_list = array('delete', 'delete_region');

	    if (in_array($CI->router->method, $require_list) && $CI->router->class != 'dev') {
            
            if ($CI->input->is('get') && !$CI->session->userdata('delete_confirm_code')) {

            	MY_Controller::call_static_func('redirect', array(
                        'dev',
                        'confirm_delete',
                        base64_encode($CI->uri->uri_string())
                    )
            	);

            }
            else {

                $CI->session->unset_userdata('delete_confirm_code');

                $CI->session->unset_userdata('delete_confirm_target');

            }

        }
        elseif ($CI->router->method == 'confirm_delete' && $CI->router->class == 'dev') {

            $uri_string = $CI->uri->uri_string();

            $delete_data = explode('/', $uri_string);

            $delete_confirm_code = $CI->session->userdata('delete_confirm_code');

            if ($delete_confirm_code == @$delete_data[2] && $CI->input->is('post')) {

                $delete_confirm_target = $CI->session->userdata('delete_confirm_target');

                if ($delete_confirm_target && $delete_confirm_target == base64_decode($delete_data[2])) {

                    MY_Controller::call_static_func('redirect',
                    	explode('/', $delete_confirm_target)
	            	);
                    
                }

            }

        }
        else {

            $CI->session->unset_userdata('delete_confirm_code');

            $CI->session->unset_userdata('delete_confirm_target');

        }

	}
	
}

/* End of file generate_user_key.php */
/* Location: ./application/hooks/generate_user_key.php */