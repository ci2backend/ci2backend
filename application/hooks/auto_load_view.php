<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Generate User Key
| -------------------------------------------------------------------------
*/

class Auto_load_view {

	public function auto_render() {

		$CI =& get_instance();

		if ($CI->input->is_ajax_request()) {

			$CI->auto_render = false;

		}

	    if (isset($CI->data['settings']['AUTO_LOAD_VIEW']) && $CI->data['settings']['AUTO_LOAD_VIEW']) {

	    	if ($CI->auto_render) {
	    		
	    		$CI->render();
	    		
	    	}

	    }

	}
	
}

/* End of file generate_user_key.php */
/* Location: ./application/hooks/generate_user_key.php */