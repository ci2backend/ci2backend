<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller_constructor'][] = array( 
	'class' => 'Generate_User_Key', 
	'function' => 'generate', 
	'filename' => 'generate_user_key.php', 
	'filepath' => 'hooks', 
	'params' => array() 
);

$hook['post_controller_constructor'] = array(
	array( 
		'class' => 'Require_confirm_delete', 
		'function' => 'confirm_delete', 
		'filename' => 'require_confirm_delete.php', 
		'filepath' => 'hooks', 
		'params' => array() 
	),
	array( 
		'class' => 'Auto_load_lang_file', 
		'function' => 'load_view_lang', 
		'filename' => 'auto_load_lang_file.php', 
		'filepath' => 'hooks', 
		'params' => array() 
	)
);


$hook['post_controller'][] = array( 
	'class' => 'Auto_load_view', 
	'function' => 'auto_render', 
	'filename' => 'auto_load_view.php', 
	'filepath' => 'hooks', 
	'params' => array() 
);

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */