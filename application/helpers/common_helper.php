<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Get the list file in a directory
 * @param directory $directory
 * @return array
 */
if ( ! function_exists('list_file')) {

	function list_file($directory) {

		if (!is_dir($directory)) {
			
			return null;

		}

	    $files = array();

	    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
	    	
	    	if ($file->isFile()) {
	    		
	    		array_push($files, $file);

	    	}

	    }

	    return $files;

	}

}
/**
 * Get the directory size
 * @param directory $directory
 * @return integer
 */
if ( ! function_exists('dir_size')) {

	function dir_size($directory) {

		if (!is_dir($directory)) {
			
			return null;

		}

	    $size = 0;

	    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){

	        $size+=$file->getSize();

	    }

	    return $size;

	}

}

if ( ! function_exists('clear_messi')) {

	function clear_messi() { 
	    
		$CI =& get_instance();

		$CI->session->unset_userdata('error_mess_code');

        $CI->session->unset_userdata('error_flag_code');

        $CI->session->unset_userdata('title_mess_code');

        $CI->session->unset_userdata('type_mess_code');

        $CI->session->unset_userdata('error_timeout');

        $CI->session->unset_userdata('is_modal_mess');

	}

}

if ( ! function_exists('clear_flashdata')) {

	function clear_flashdata() { 
	    
		$CI =& get_instance();

		$CI->session->unset_userdata('flash:old:message');

        $CI->session->unset_userdata('flash:new:message');

	}

}

if ( ! function_exists('flash_success')) {

	function flash_success($message='') { 
	    
		$CI =& get_instance();

		$CI->session->set_userdata('title_mess_code', lang('Success'));

		$CI->session->set_userdata('type_mess_code', SUCCESS_CLASS);

		$CI->session->set_userdata('error_flag_code', $message?1:0);

		$CI->session->set_userdata('error_mess_code', $message);

		$CI->response->success = 1;

		$CI->response->message = $message;

	}

}

if ( ! function_exists('flash_error')) {

	function flash_error($message='') { 
	    
		$CI =& get_instance();

		$CI->session->set_userdata('title_mess_code', lang('Error'));

		$CI->session->set_userdata('type_mess_code', ERROR_CLASS);

		$CI->session->set_userdata('error_flag_code', $message?1:0);

		$CI->session->set_userdata('error_mess_code', $message);

		$CI->response->message = $message;

	}

}

if ( ! function_exists('flash_warning')) {

	function flash_warning($message='') { 
	    
		$CI =& get_instance();

		$CI->session->set_userdata('title_mess_code', lang('Warning'));

		$CI->session->set_userdata('type_mess_code', WARNING_CLASS);

		$CI->session->set_userdata('error_flag_code', $message?1:0);

		$CI->session->set_userdata('error_mess_code', $message);

		$CI->response->message = $message;

	}

}

if ( ! function_exists('unique_multidim_array')) {

	function unique_multidim_array($array, $key) { 
	    
	    $temp_array = array();
	    
	    $i = 0;

	    $key_array = array();
	    
	    foreach($array as $val) {

	        if (!in_array($val[$key], $key_array)) {

	            $key_array[$i] = $val[$key];

	            $temp_array[$i] = $val;

	        }

	        $i++;

	    }

	    return $temp_array;

	}

}

/**
 * Form Declaration
 *
 * Creates the opening portion of the form.
 *
 * @access	public
 * @param	string	the URI segments of the form destination
 * @param	array	a key/value pair of attributes
 * @param	array	a key/value pair hidden data
 * @return	string
 */
if ( ! function_exists('form_ajax')) {

	function form_ajax($action = '', $attributes = '', $hidden = array()) {

		$CI =& get_instance();

		if ($attributes == '') {

			$attributes = 'method="post", class="ajax validate"';

		}
		else {

			if (is_array($attributes)) {

				if (isset($attributes['class'])) {

					$class = $attributes['class'];

					$attributes['class'] =  "ajax validate " .$class;

				}
				else {

					$attributes['class'] = "ajax validate";

				}

			}
			else {

				$attributes .= ' method-submit="ajax"';

			}

		}

		$ajax_action = $CI->config->site_url('ajax.html');

		$ajax_input = $action;

		// If an action is not a full URL then turn it into one
		if ($action && strpos($action, '://') === FALSE) {

			$action = $CI->config->site_url($action);

		}

		// If no action is provided then set to the current url
		$action OR $action = $CI->config->site_url($CI->uri->uri_string());

		if (!isset($CI->data['ext_loaded']['jquery']) ||
		 !isset($CI->data['ext_loaded']['jquery-validation']) || 
		  !isset($CI->data['ext_loaded']['overlay']) || 
		   !isset($CI->data['ext_loaded']['messi'])) {

			$ajax_action = $action;

		}

		$ajax_input = str_replace(array('/', '\\'), ' ', $ajax_input);

		$ajax_input = trim($ajax_input);

		$ajax_input = explode(' ', $ajax_input);

		if (count($ajax_input) >= 2) {

			$hidden_controls['controls'] = $ajax_input[0];

			$hidden_action['operation_action'] = $ajax_input[1];

			unset($ajax_input[0]);

			unset($ajax_input[1]);

			if (count($ajax_input)) {

				$pattern = array_values($ajax_input);

				array_unshift($pattern, $ajax_action);

				$ajax_action = implode('/', $pattern);

			}

		}

		$form = '<form action="'.$ajax_action.'"';

		$form .= _attributes_to_string($attributes, TRUE);

		$form .= '>';

		if (isset($hidden_controls['controls'])) {

			$form .= form_hidden($hidden_controls);

		}

		if (isset($hidden_action['operation_action'])) {

			$form .= form_hidden($hidden_action);

		}

		// Add CSRF field if enabled, but leave it out for GET requests and requests to external websites	
		if ($CI->config->item('csrf_protection') === TRUE AND ! (strpos($action, $CI->config->base_url()) === FALSE OR strpos($form, 'method="get"'))) {
			
			$hidden[$CI->security->get_csrf_token_name()] = $CI->security->get_csrf_hash();

		}

		if (is_array($hidden) AND count($hidden) > 0) {

			$form .= sprintf("<div style=\"display:none\">%s</div>", form_hidden($hidden));

		}

		return $form;

	}

}

/**
 * Form Declaration - Multipart type
 *
 * Creates the opening portion of the form, but with "multipart/form-data".
 *
 * @access	public
 * @param	string	the URI segments of the form destination
 * @param	array	a key/value pair of attributes
 * @param	array	a key/value pair hidden data
 * @return	string
 */
if ( ! function_exists('form_ajax_multipart')) {

	function form_ajax_multipart($action = '', $attributes = array(), $hidden = array()) {

		if (is_string($attributes)) {

			$attributes .= ' enctype="multipart/form-data"';

		}
		else {

			$attributes['enctype'] = 'multipart/form-data';

		}

		return form_ajax($action, $attributes, $hidden);

	}

}

if (!function_exists('fetch_common_stylesheet')) {

	function fetch_common_stylesheet()
	{

		$css_common = 'common/css/common.css';

		if (is_file(THEME_PATH.$css_common)) {

			echo '<link rel="stylesheet" href="'.base_url(THEMES.$css_common).'">'."\n";

		}
		else {

			echo null;

		}

	}

}

if (!function_exists('fetch_common_script')) {

	function fetch_common_script()
	{

		$js_common = 'common/js/common.js';

		if (is_file(THEME_PATH.$js_common)) {
			
			echo '<script src="'.base_url(THEMES.$js_common).'" type="text/javascript"></script>'."\n";

		}
		else {

			echo null;

		}

	}

}

if (!function_exists('get_menu_templates')) {

	function get_menu_templates()
	{

		$CI =& get_instance();

		return $CI->data['tmpl_menu_loader'];

	}

}

if (!function_exists('get_sub_menu_templates')) {

	function get_sub_menu_templates($id="")
	{

		$CI =& get_instance();

		if (!$id) {

			$id = @$CI->data['active_menu_id'] ? $CI->data['active_menu_id'] : 1;

		}

		$sub_menus = array();

		if (isset($CI->data['tmpl_menu_loader']) && count($CI->data['tmpl_menu_loader']) && !empty($id)) {

			foreach ($CI->data['tmpl_menu_loader'] as $key => $menu) {

				if ($menu['id'] == $id) {

					$sub_menus = $CI->data['tmpl_menu_loader'][$key]['tmpl_sub_menu_loader'];

					break;

				}

			}

		}

		if (!count($sub_menus)) {

			$CI->load->model('t_menu');

			$actRouter = $CI->router->class.'/'.$CI->router->method;

	        $new_menu['tmpl_menu_loader'] = $CI->t_menu->get_sub_menu_by_template('menus.*', array('menus.action_router' => $actRouter, 'menus.is_show' => 1));

	        $sub_menus = @$new_menu['tmpl_menu_loader'][0]['tmpl_sub_menu_loader'];

		}

		return $sub_menus;

	}

}

if (!function_exists('fetch_menu_templates')) {

	function fetch_menu_templates()
	{

		$CI =& get_instance();

		$menu_lists = get_menu_templates();

		if (count($menu_lists)) {

			$menu_html = '<ul id="nav">';

			$CI->load->model('t_module');

			$action_modules = $CI->t_module->get_data_by_property('action');

			if (count($action_modules)) {

				foreach ($action_modules as $key => $action) {

					$action_modules[$key] = $action['action'];

				}

			}

			$current_action = $CI->router->class.'/'.$CI->router->method;

			if (in_array($current_action, array_values($action_modules))) {

				$CI->breadcrumbs->unshift(lang('Dashboard'), site_url('dev/index'));

			}

			foreach ($menu_lists as $key => $menu) {

				$actRouter = str_replace('/', '_', $menu['action_router']);

				if (@$CI->data[$actRouter]) {

					$CI->data['active_menu_id'] = $menu['id'];

					if ($menu['action_router'] != 'dev/index') {

						$CI->breadcrumbs->push(lang($menu['title_key']), site_url($menu['action_router']));

					}

				}

				$menu_html .= '<li '.@$CI->data[$actRouter].'>

	                <a href="'.site_url(@$menu['action_router']).'" title="'.@$menu['description'].'">'.lang(@$menu['title_key']).'</a>

	            </li>';		

			}

			$menu_html .= '</ul>';
        
        	echo $menu_html;

		}
		else {

			echo null;

		}

	}

}

if (!function_exists('fetch_sub_menu_templates')) {

	function fetch_sub_menu_templates()
	{

		$CI =& get_instance();

		$sub_menu_lists = get_sub_menu_templates();

		if (count($sub_menu_lists)) {

			$sub_menu_html = '<div id="subnav">
    
                        <div class="container_12 full-dimensions">
    
                            <div class="grid_12">
    
                                <ul>';

			foreach ($sub_menu_lists as $key => $sub) {

				$actRouter = str_replace('/', '_', $sub['action_router']);

				if (isset($CI->data[$actRouter])) {

					if ($sub['action_router'] != 'dev/index') {
						
						$CI->breadcrumbs->push(lang($sub['title_key']), site_url($sub['action_router']));

					}

				}

				if (!$sub['is_show']) {
					
					continue;

				}

				$sub_menu_html .= '<li '.@$CI->data[$actRouter].'>

	                <a href="'.site_url(@$sub['action_router']).'" title="'.@$sub['description'].'">'.lang(@$sub['title_key']).'</a>

	            </li>';		

			}

			$sub_menu_html .= '</ul></div></div></div>';

			if (!isset($CI->data['active_menu_id'])) {

				$action_router = $CI->router->class. '/' .$CI->router->method;

				$active_sub = $CI->load->t_sub_menu->get_data_by_property('*', array(
						'action_router' => $action_router
					)
				);

				if (count($active_sub)) {
					
					$CI->breadcrumbs->push(lang($active_sub[0]['title_key']), site_url($active_sub[0]['action_router']));

				}

			}
        
        	echo $sub_menu_html;

		}
		else {

			echo null;

		}

	}

}

if (!function_exists('fetch_title')) {

	function fetch_title()
	{

		$CI =& get_instance();

		if(isset($CI->data['page_title']) && !empty($CI->data['page_title'])){

            echo $CI->data['page_title'];

        }
        else {

            echo DEFAULT_PAGE_TITLE;
            
        }

	}

}

if (!function_exists('fetch_js')) {

	function fetch_js()
	{

		$CI =& get_instance();

		if (isset($CI->data['ext_js'])) {

			$jsList = '';

			if (isset($CI->data['ext_js']['jquery-jquery'])) {
				
				$jquery = $CI->data['ext_js']['jquery-jquery'];

				unset($CI->data['ext_js']['jquery-jquery']);

				array_unshift($CI->data['ext_js'], $jquery);

			}

			if (isset($CI->data['js_lang'])) {

				foreach ($CI->data['js_lang'] as $key => $lang) {

					array_unshift($CI->data['ext_js'], $lang);

				}
				
			}

			$CI->data['ext_js'] = array_filter($CI->data['ext_js']);
            
            foreach (array_values($CI->data['ext_js']) as $key => $js) {

            	if ($key == 0) {

            		$jsList .= '<script src="'.$js.'" type="text/javascript"></script>'."\n";

            	}
            	else {

            		$jsList .= "\t\t".'<script src="'.$js.'" type="text/javascript"></script>'."\n";

            	}

            }

        }

        echo $jsList;

        echo @$CI->data['content_js'];

	}

}

if (!function_exists('fetch_css')) {

	function fetch_css()
	{

		$CI =& get_instance();

		if (isset($CI->data['ext_css'])) {

			$cssList = '';

			$CI->data['ext_css'] = array_filter($CI->data['ext_css']);
            
            foreach (array_values($CI->data['ext_css']) as $key => $css) {

            	if ($key == 0) {

            		$cssList .= '<link rel="stylesheet" href="'.$css.'">'."\n";

            	}
            	else {

            		$cssList .= "\t\t".'<link rel="stylesheet" href="'.$css.'">'."\n";

            	}

            }

        }

        echo $cssList;

        echo @$CI->data['content_css'];

	}

}

if (!function_exists('is_rewrite_mode')) {

	function is_rewrite_mode()
	{

		if (function_exists('apache_get_modules')) {
			
		  $modules = apache_get_modules();
		  
		  $mod_rewrite = in_array('mod_rewrite', $modules);
		  
		} else {
			
		  $mod_rewrite =  getenv('HTTP_MOD_REWRITE')=='On' ? true : false ;
		  
		}

		return $mod_rewrite;

	}

}

if (!function_exists('placeholder')) {

	function placeholder($string = null)
	{

		$text = lang($string);

		$first = mb_strtolower(mb_substr($text, 0, 1), 'UTF-8');

		$last = mb_substr($text, 1);

		return lang('Enter').' '.$first.$last;

	}

}

if (!function_exists('_echo')) {

	function _echo($string = null)
	{

		if (isset($string) && is_string($string)) {

			echo $string;

		}
		else{

			echo null;

		}

	}

}

if (!function_exists('valid_path')) {

	function valid_path($path = null)
	{

		if (is_file($path)) {

			$path = realpath($path);

		}

		return str_replace('\\', '/', $path);

	}

}


if (!function_exists('json_parse')) {

	function json_parse($file = null, $array = true)
	{

		if (is_file(valid_path($file))) {

			$string = file_get_contents($file);

			return json_decode($string, $array);

		}
		else {

			echo null;

		}

	}

}

if (!function_exists('multiexplode')) {

	function multiexplode($delimiters,$string)
	{

		$ready = str_replace($delimiters, $delimiters[0], $string);

	    $launch = explode($delimiters[0], $ready);

	    return  $launch;

	}

}

if (!function_exists('array_strip')) {

	function array_strip($arr = array())
	{

		if (is_array($arr)) {

			$new = array();

			foreach ($arr as $key => $val) {

				if (!is_null($val) && strlen($val)) {

					$new[$key] = $val;

				}

			}

			return $new;

		}
		else {

			return $arr;

		}

	}

}

if (!function_exists('unlink_php_lang')) {

	function unlink_lang($path = null, $dir = null)
	{

		if (is_file($path)) {

			unlink($path);

			if (is_dir_empty($dir, true)) {

				if (is_dir($dir)) {

					rmdir($dir);

				}

			}

		}
		else {
			
			return 'No file '.$path;

		}

	}

}

if (!function_exists('is_dir_empty')) {

	function is_dir_empty($dir, $bypass_index = false) {

		if (!is_readable($dir)) return NULL;

  		$handle = opendir($dir);

  		while (false !== ($entry = readdir($handle))) {

    		if ($bypass_index) {

    			if ($entry != "." && $entry != ".." && $entry != "index.html") {

	      			return FALSE;

	    		}

    		}
    		else {

    			if ($entry != "." && $entry != "..") {

	      			return FALSE;

	    		}

    		}

	  	}

		return TRUE;

	}

}

if (!function_exists('_Rmdir')) {

	function _Rmdir($dir) {

		if (!is_dir($dir)) {
			
			return false;

		}

	    $it = new RecursiveDirectoryIterator($dir);

	    $it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);

	    foreach($it as $file) {

	        if ('.' === $file->getBasename() || '..' ===  $file->getBasename()) continue;

	        if ($file->isDir()) rmdir($file->getPathname());

	        else unlink($file->getPathname());

	    }
	    
	    rmdir($dir);
	    
	}

}