<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Generate User Key
| -------------------------------------------------------------------------
*/

class Auto_load_lang_file {

	public function load_view_lang() {

		$CI =& get_instance();

        $module = $CI->router->class;

        $action = $CI->router->method;

        $CI->lang->load("$module/$action");

	}
	
}

/* End of file generate_user_key.php */
/* Location: ./application/hooks/generate_user_key.php */