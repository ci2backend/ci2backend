<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Generate User Key
| -------------------------------------------------------------------------
*/

class Generate_User_Key {

	public function generate() {

		$CI =& get_instance();

		if (!isset($CI->session)) {

	        $CI->load->library('session');

	    }
		
		$user_key = $CI->session->userdata('USER_KEY');

		if (!$user_key) {

			$CI->session->set_userdata('USER_KEY', $CI->guid());

		}

	}
	
}

/* End of file generate_user_key.php */
/* Location: ./application/hooks/generate_user_key.php */