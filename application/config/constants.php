<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


define('DOMAIN', '');

define('DEFAULT_PAGE_TITLE', 'Your page title default');

define('USER_SESSION_KEY', 'uid');

define('POST_DATA', 'post_data');

define('SUCCESS_CLASS',		'success');

define('INFO_CLASS',		'info');

define('ERROR_CLASS',		'error');

define('WARNING_CLASS',		'warning');

define('ADMIN_MAIL','');

define('USERNAME','');

define('PASSWORD','');

define('FROM_NAME', '');


define('ADMIN_MAIL_CONTACT','');

define('USERNAME_CONTACT','');

define('PASSWORD_CONTACT','');

define('FROM_NAME_CONTACT', '');

define('SUBJECT', '');

define('HOST_MAIL','');

define('PORT', 25);

define('ALT_BODY_FORGOT_ID', 'This email is feedback requirements reminiscent username');

define('ALT_BODY_FORGOT_PASSWORD', 'This email is feedback requirements reminiscent password');

define('ALT_BODY_ACTIVE_ACCOUNT', 'This email contains information to activate your account');

define('SMTPSECURE','tls'); // or 'ssl'



define('SUB_PAGE', 'Admin backend');

define('PREFIX_SUB_PAGE', ' | ');

define('RECIEVED_KENNEL', 'my_notifications');

define('NODE_URL', 'http://localhost:8125');

define('TIMEOUT_SECURITY_CODE', 'error:000');

define('WRONG_METHOD_SECURITY_CODE', 'error:001');

define('DENY_SECURITY_CODE', 'error:002');

define('REJECT_CODE', 'error:003');

define('JS_EXT', '.js');

define('JS_SUB_EXT', '_js');

define('CSS_EXT', '.css');

define('CSS_SUB_EXT', '_css');

define('ASSETS', 'assets/');

define('EXTENSIONS', 'extensions/');

define('THEMES', 'themes/');

define('ASSETS_PATH', FCPATH.'assets/');

define('TEMPLATE_PATH', ASSETS.'templates/');

define('TEMPLATE_DIR', ASSETS_PATH.'templates/');

define('APP_EXT_DIR', ASSETS_PATH.'extensions/');

define('APP_MODEL', APPPATH.'models/');

define('APP_VIEW', APPPATH.'views/');

define('APP_CONTROLLER', APPPATH.'controllers/');

define('APP_PHP_LANG', APPPATH.'language/');

define('PHP_SUB_LANG', '_lang');

define('PHP_LANG_DIR', 'language/');

define('COMMON_VIEW_DIR', 'common/');

define('APP_JS_LANG', FCPATH.'themes/js_lang/');

define('JS_LANG_DIR', 'themes/js_lang/');

define('SLASH', '/');

define('VIEW_PLATFROM', 'platform/');

define('VIEW_TEMPLATE', 'template/');

define('THEME_PATH', FCPATH.'themes/');


/* End of file constants.php */
/* Location: ./application/config/constants.php */