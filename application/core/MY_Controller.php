<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Generic and override CI controller class. Please add common functions here.
 * @author PhuTv
 *
*/
class MY_Controller extends CI_Controller {

    /**
     * Check if is ajax request and store
     * @var boolean
     */
	var $is_ajax_request;

    /**
     * Container of all data in the request
     * @var Array
     */
    var $data;

    /**
     * Response data for ajax request
     * @var stdClass
     */
    var $response;

    /**
     * constainer of all function in a class
     * @var array
     */
    var $funcs;

    /**
     * Keep status logged in
     * @var boolean
     */
    public $is_login = false;

    /**
     * Keep status auto render a view
     * @var boolean
     */
    public $auto_render = true;

    /**
     * Construct function of class
     */
	public function __construct() {

		parent::__construct();

        // Load defaul model and library.
        $this->loader();

        // Set no cache
        $this->output->nocache();

        // Load setting of the system
        $this->setting_system();

        // Check system role
        $this->access_role_require();

        // Import language
        $this->import_language();
        
	}
    
    /**
     * Check ACL to access child of class MY_Controller
     * @return boolean Deny OR Redirect
     */
    private function access_role_require()
    {

        $control = $this->router->class;

        $method = $this->router->method;

        if (!$this->is_ajax_request) {

            $this->set_referrer();

        }

        $access = array(

            'control' => $control,

            'action' => $method

        );

        $this->load->model('t_access_right');

        $access_rights = $this->t_access_right->get_access_right_by_router($access);

        if (count($access_rights)) {
            
            foreach ($access_rights as $key => $item) {

                if (in_array($item['action'], array('login', 'logout'))) {
                    
                    continue;

                }

                if ($item['require_login']) {

                    if (!$this->ion_auth->logged_in()) {

                        $this->require_login();

                    }

                }

                if ($this->ion_auth->logged_in()) {

                    if (isset($item['groups'])) {

                        $access_groups = array();

                        if (count($item['groups'])) {

                            foreach ($item['groups'] as $key => $group) {

                                if ($group['enable']) {

                                    array_push($access_groups, $group['name']);

                                }

                            }

                        }

                        if (!$this->ion_auth->in_group($access_groups)) {

                            $this->lang->load('en');

                            if ($this->is_ajax_request) {
                                
                                flash_error(lang('Access_is_denied'));
                                
                                $this->response_message();

                            }

                            show_error(lang('Access_is_denied'));

                        }
                        
                    }

                }

            }

        }

    }

    /**
     * Allow call a function in this class
     * @param  string $func  Function name
     * @param  array  $param Parametters
     * @return array        container data of the fucntion
     */
    public static function call_static_func($func='', $param = array())
    {

        if (is_callable(array('MY_Controller', $func))) {

            $CI = get_instance();

            return $CI->$func($param);

        }
        else{

            return null;

        }
        
    }

    /**
     * Load default library and model
     * @return [type] [description]
     */
    private function loader()
    {

        $this->load->library(array(
                'detect',
                'breadcrumbs',
                'user_agent'
            )
        );

        // Load back model
        $this->load->model(array(
                't_setting',
                't_platform',
                't_template',
                't_language',
                't_controller',
                't_view',
                't_router',
                't_extension'
            )
        );

    }

    /**
     * Common setting in this system
     * @return void No response data
     */
    private function setting_system()
    {

        ini_set('error_log', FCPATH.$this->config->item('log_path'));

        $this->is_ajax_request = $this->input->is_ajax_request();

        // Check logged in
        $this->is_login = $this->is_login();

        // Set active menu
        $this->data[$this->router->class. '_' .$this->router->method] = ' id="current" class="active"';
            
        // Get database setting
        $settings = $this->t_setting->get_data_by_property('*');

        if (count($settings)) {

            foreach ($settings as $key => $sett) {

                $settings[$sett['key_setting']] = $sett['value_setting'];

                unset($settings[$key]);

            }

        }
        
        $this->data['settings'] = $settings;

        $this->generate_response_message();

        $this->funcs = $this->get_all_method_of_class($this->router->class, 1);

        // Set auto detect platform
        if ($settings['MULTI_PLATFORM']) {

            $this->data['platform'] = $this->detect->get_platform();

            if (isset($settings['ENABLE_PRODUCTION']) && !$settings['ENABLE_PRODUCTION']) {

                // Set admin platform
                if (isset($this->data['settings']['DEVELOPER_PLATFORM']) && $this->data['settings']['DEVELOPER_PLATFORM']) {

                    $current_control = $this->t_controller->get_data_by_property('*', array(
                            'controller_key' => $this->router->class
                        )
                    );

                    if (count($current_control) && isset($current_control[0]['is_backend']) && $current_control[0]['is_backend']) {

                        $this->data['platform'] = $this->data['settings']['DEVELOPER_PLATFORM'];

                    }

                }

                if (isset($this->data['settings']['DEVELOPER_TEMPLATE']) && $this->data['settings']['DEVELOPER_TEMPLATE']) {

                    $current_control = $this->t_controller->get_data_by_property('*', array(
                            'controller_key' => $this->router->class,
                            'is_backend' => 1
                        )
                    );

                    if (count($current_control)) {

                        $this->data['template'] = $this->data['settings']['DEVELOPER_TEMPLATE'];

                    }

                }

            }

        }
        else {

            // Set default platform
            if (!isset($this->data['platform'])) {
                
                $platform = $this->t_platform->get_data_by_property('*', array('is_default' => 1));

                if (count($platform)) {

                    $this->data['platform'] = $platform[0]['platform_key'];

                }

            }

            // Override platform by development mode
            if (isset($settings['ENABLE_PRODUCTION']) && !$settings['ENABLE_PRODUCTION']) {

                if (isset($this->data['settings']['DEVELOPER_PLATFORM']) && $this->data['settings']['DEVELOPER_PLATFORM']) {

                    $current_control = $this->t_controller->get_data_by_property('*', array(
                            'controller_key' => $this->router->class,
                            'is_backend' => 1
                        )
                    );

                    if (count($current_control) && isset($current_control[0]['is_backend']) && $current_control[0]['is_backend']) {

                        $this->data['platform'] = $this->data['settings']['DEVELOPER_PLATFORM'];

                    }

                }

            }

        }

        // Set default template
        if (!isset($this->data['template'])) {

            $template = $this->t_template->get_data_by_property('*', array('is_default' => 1));

            if (count($template) > 0) {

                $this->data['template'] = $template[0]['template_key'];

            }

        }

        // Override template by development mode
        if (isset($settings['ENABLE_PRODUCTION']) && !$settings['ENABLE_PRODUCTION']) {

            if (isset($this->data['settings']['DEVELOPER_TEMPLATE']) && $this->data['settings']['DEVELOPER_TEMPLATE']) {

                $current_control = $this->t_controller->get_data_by_property('*', array(
                        'controller_key' => $this->router->class,
                        'is_backend' => 1
                    )
                );

                if (count($current_control)) {

                    $this->data['template'] = $this->data['settings']['DEVELOPER_TEMPLATE'];

                }

            }

        }

        $this->data['user'] = $this->get_current_user_login();

        $this->output->nocache();

        if (isset($settings['ENABLE_PRODUCTION']) && !$settings['ENABLE_PRODUCTION']) {

            ini_set('display_errors', 'On');

            error_reporting(E_ALL);

        }
        else {

            ini_set('display_errors', 'Off');

            error_reporting(0);

        }

        $this->load->helper('common');

    }

    public function render($template = null, $dir_view = null, &$layout_data = array(), $load = false, $auto_load = false)
    {
        
        if($this->input->is_ajax_request()) {

            header('Content-Type: application/json');

            $this->response_message();

        }
        else {

            if (!$dir_view) {
                
                $dir_view = $this->router->class.SLASH.$this->router->method;
                
            }
            
            $this->view($template, $dir_view, $layout_data, $load, $auto_load);

        }

    }

    private function import_language()
    {

        // Load common language
        $lang = array(
            'lang_folder',
            'lang_key'
        );

        $lang_folder = $this->config->item('language');

        if (isset($this->data['user']['lang_folder'])) {
            
            $lang_folder = $this->data['user']['lang_folder'];

        }

        $this->load->model('t_language');

        $langData = $this->t_language->get_data_by_property('*', array('lang_folder' => $lang_folder));
        
        if (count($langData)) {

            $langData = $this->array_intersect($langData[0], $lang);

        }
        else {

            $langData = array(
                'lang_folder' => 'english',
                'lang_key' => 'en'
            );

        }

        if (!is_dir(APP_PHP_LANG.$langData['lang_folder'])) {

            @mkdir(APP_PHP_LANG.$langData['lang_folder'], 0700);
            
        }

        if (is_file(APP_PHP_LANG.$langData['lang_folder'].SLASH.$langData['lang_key'].'_lang.php')) {

            $this->lang->load($langData['lang_key'], $langData['lang_folder']);

        }
        else {

            @file_put_contents(APP_PHP_LANG.$langData['lang_folder'].SLASH.$langData['lang_key'].'_lang.php', '<?php'."\n\n".'$lang["'.time().'"] = "";'."\n\n".'?>');

            $this->lang->load($langData['lang_key'], $langData['lang_folder']);
            
        }

        $this->lang->load('ion_auth', $langData['lang_folder']);

        $this->lang->load('auth', $langData['lang_folder']);

        $this->data = array_merge($this->data, $langData);

    }

    /**
     * [get_current_user_login is data data info user login]
     * @return [array] [session array]
     */
    public function get_current_user_login($all = false)
    {

        if ($this->session->userdata('user_id')) {

            $userInfo = $this->ion_auth->user()->result_array();

            if (count($userInfo) > 0) {

                $user = $userInfo[0];

                if (!$all) {

                    unset($user['password']);

                    unset($user['salt']);

                }
                
                return $user;

            }

            return null;

        }
        else{

            return null;

        }

    }

	/**
	 * [__configure description]
	 * @return [type] [description]
	 */
	protected function __configure()
	{

		// Write total config here
           
	}


	/**
	 * [__unset unset session or other things]
	 */
	protected function _unset()
	{
		// Put code unset here
	}

	public function set_page_title($title='')
	{

		if(!empty($title)) {

			$this->data['page_title'] = $title.PREFIX_SUB_PAGE.SUB_PAGE;

		}
		else {

			$title = lang('HOME_PAGE');

			$this->data['page_title'] = $title.PREFIX_SUB_PAGE.SUB_PAGE;

		}

	}

    public function set_template($template='')
    {

        if(!empty($template)) {

            $this->data['template'] = $template;

        }

    }

    public function set_platform($platform='')
    {

        if(!empty($platform)) {

            $this->data['platform'] = $platform;

        }

    }


	
	/**
	 * [view description]
	 * @param  string $template    [dir of template]
	 * @param  [type] $dir         [dir of view]
	 * @param  [type] $layout_data [data parse]
	 * @return [interface]              [interface]
	 */
    protected function view($template = null, $dir_view, &$layout_data = array(), $load=false, $auto_load=false)
    {
        
        if (count($layout_data)) {

            $this->data = array_merge($this->data, $layout_data);

        }

        if (!$template) {
            
            $template = $this->data['template'];

        }

        if (strlen($dir_view) > 0) {

            $dir_explode = explode(SLASH, $dir_view);

            if (isset($this->data['platform'])) {

                $main_view = VIEW_PLATFROM.$this->data['platform'].SLASH.$dir_view;

            }
            else {

                $main_view = $dir_view;

            }

            $current_template = $this->t_template->get_data_by_property('', array(
                    'template_key' => $template
                )
            );

            if (count($current_template) && isset($current_template[0]['enable_customize_view']) && $current_template[0]['enable_customize_view']) {
                
                $main_view = VIEW_TEMPLATE.$template.SLASH.$current_template[0]['customize_view_folder'].SLASH.$this->data['platform'].SLASH.$dir_view;
                
            }

            $platform = @$this->data['platform'];

            $modules = null;

            for ($i = 0; $i < count($dir_explode); $i++) {
                    
                if ($i == (count($dir_explode) - 2)) {

                    $modules .= $dir_explode[$i];
                    
                    break;

                }
                else{

                    $modules .= $dir_explode[$i].SLASH;

                }

            }
            
            $view_file = APP_VIEW.$main_view.EXT;

            if (!is_file($view_file)) {

                if (!$this->auto_render) {

                    return false;

                }

                // Show missing view file
                $this->load->view($main_view.EXT);

            }

            $this->data['js_lang']  = $this->load_js_lang($dir_view);

            $view_file_css = APP_VIEW.$main_view.CSS_SUB_EXT.EXT;

            $view_file_js = APP_VIEW.$main_view.JS_SUB_EXT.EXT;

            $content_css = '';

            $content_js = '';

            if (!file_exists($view_file_css) && @$this->data['settings']['AUTO_GENERATE_ASSEST_FILE']) {

                @file_put_contents($view_file_css, null);

            }

            if (file_exists($view_file_css)) {

                $view_css = $main_view.CSS_SUB_EXT.EXT;

                $content_css = $this->load->view($view_css, $this->data, true);

            }
            else {

                $content_css = '';
                
            }

            if (!file_exists($view_file_js) && @$this->data['settings']['AUTO_GENERATE_ASSEST_FILE']) {

                @file_put_contents($view_file_js, null);

            }

            if (file_exists($view_file_js)) {

                $view_js = $main_view.JS_SUB_EXT.EXT;

                $content_js = $this->load->view($view_js, $this->data, true);

            }
            else {

                $content_js = '';
                
            }

            // Load language for page
            $current_dir = APP_PHP_LANG;

            $str_path = $this->data['lang_folder'].SLASH.$platform.SLASH.$modules;

            $this->create_tree_dir($current_dir, $str_path);

            if (!is_dir(APP_PHP_LANG.$str_path) && @$this->data['settings']['AUTO_GENERATE_LANGUAGE_FILE']) {

                @mkdir(APP_PHP_LANG.$this->data['lang_folder'].SLASH.$platform, 0700);

                @mkdir(APP_PHP_LANG.$this->data['lang_folder'].SLASH.$platform.SLASH.$modules, 0700);

            }

            if (is_file(APP_PHP_LANG.$this->data['lang_folder'].SLASH.$platform.SLASH.$modules.SLASH.$dir_explode[count($dir_explode) - 1].'_lang.php')) {

                $this->lang->load($dir_explode[count($dir_explode) - 1], $this->data['lang_folder'].SLASH.$platform.SLASH.$modules);

            }
            else {

                if (@$this->data['settings']['AUTO_GENERATE_LANGUAGE_FILE']) {
                    
                    @file_put_contents(APP_PHP_LANG.$this->data['lang_folder'].SLASH.$platform.SLASH.$modules.SLASH.$dir_explode[count($dir_explode) - 1].'_lang.php', '<?php'."\n\n".'$lang["'.time().'"] = "";'."\n\n".'?>');

                    $this->lang->load($dir_explode[count($dir_explode) - 1], $this->data['lang_folder'].SLASH.$platform.SLASH.$modules);

                }

            }

            // Load extension of template
            if (isset($template)) {

                // Load template
                $this->load->template();

            }

            $content = $this->load->view($main_view, $this->data, true);

            $this->data['content'] = $content;

            $this->data['content_css'] = $content_css;

            $this->data['content_js'] = $content_js;

            $this->data = array_merge($this->data, $this->data);

            $this->load->model('t_sub_menu');

            $action_router = $this->router->class. '/' .$this->router->method;

            $parent_menu = $this->t_sub_menu->get_parent_by_action_router('*', $action_router);

            if (count($parent_menu)) {

                $this->load->model('t_module');

                $action_modules = $this->t_module->get_data_by_property('action');

                if (count($action_modules)) {

                    foreach ($action_modules as $key => $action) {

                        $action_modules[$key] = $action['action'];

                    }

                }

                $current_action = $this->router->class. '_' .$this->router->method;

                if (isset($this->data[$current_action])) {

                    foreach ($parent_menu as $key => $menu) {

                        if (in_array($menu['action_router'], array_values($action_modules))) {

                            $this->breadcrumbs->unshift(lang('Dashboard'), site_url('dev/index'));

                        }

                        $parent_active = str_replace('/', '_', $menu['action_router']);

                        // Active parent menu
                        $this->data[$parent_active] = $this->data[$current_action];

                    }

                }

            }

            $this->auto_render = $auto_load;

            $this->load->ion_auth = $this->ion_auth;

            return $this->load->view("template/$template/main", $this->data, $load);

        }

    }

    public function load_js_lang($str_path = null)
    {

        $lang_path = APP_JS_LANG;

        if (!is_dir($lang_path)) {

            @mkdir($lang_path);

        }

        $lang_dir = $this->data['lang_folder'];

        $language = $this->data['lang_key'];

        $platform = $this->data['platform'];

        $template = $this->data['template'];

        if (!is_dir($lang_path.$lang_dir)) {

            @mkdir($lang_path.$lang_dir);

        }

        // Create lang default
        if (!is_file($lang_path.$lang_dir.SLASH.$language.JS_EXT) && @$this->data['settings']['AUTO_GENERATE_LANGUAGE_FILE']) {

            @file_put_contents($lang_path.$lang_dir.SLASH.$language.JS_EXT, null);

        }

        $arr_view_file = array_filter(explode('/', $str_path));

        unset($arr_view_file[count($arr_view_file) - 1]);

        $view_dir = implode('/', $arr_view_file);

        $this->create_tree_dir($lang_path.$lang_dir.SLASH.$platform.SLASH, $view_dir);

        if (!is_file($lang_path.$lang_dir.SLASH.$platform.SLASH.$str_path.JS_EXT) && @$this->data['settings']['AUTO_GENERATE_LANGUAGE_FILE']) {

            @file_put_contents($lang_path.$lang_dir.SLASH.$platform.SLASH.$str_path.JS_EXT, null);

        }

        $js_lang = array(

            base_url().JS_LANG_DIR.$lang_dir.SLASH.$language.JS_EXT,

            base_url().JS_LANG_DIR.$lang_dir.SLASH.$platform.SLASH.$str_path.JS_EXT

        );

        return $js_lang;

    }

	/**
	 * [redirect description]
	 * @param  [array] $segments [config controller name, method, param]
	 * @return [interface]           [interface follow url parse from $segments]
	 */
	protected function redirect($segments = null)
	{

        $url = site_url();

        if (is_rewrite_mode()) {

            $url = base_url();

        }

		if (!(!empty($segments) && (count($segments) > 0))) {

            $segments = array(
                $this->router->class
            );

        }

        if ($this->input->is_ajax_request()) {

            if (empty($this->response->message)) {

                flash_error(lang('Data_is_empty_Please_input_data'));

            }
            
            $this->response_message();

        }
        else {

            if ($this->response->success == 1) {

                flash_success($this->response->message);

            }
            elseif ($this->response->success == 0) {

                flash_error($this->response->message);

            }
            else {

                flash_warning($this->response->message);

            }

        }

        if ($segments && !filter_var($segments, FILTER_VALIDATE_URL) === false) {
            
            redirect($segments);

        }

        foreach ($segments as $key => $value) {

            if ($key == 0 && is_rewrite_mode()) {

                $url .= $value;

            }
            else {

                $url .= SLASH.$value;

            }

        }

		redirect($url);

	}
	
	/**
	 * [is_login description]
	 * @return boolean [check user login]
	 */
	public function is_login()
	{

		if (class_exists('ion_auth')) {

			if (!$this->ion_auth->logged_in()) {

                return false;

			}
			else {

				return true;

			}

		}
		else{

	        return false;

		}

	}

	/**
	 * [require_login description]
	 * @return [type] [Required user login before access a method]
	 */
	public function require_login()
	{

        $control = $this->router->class;

        $method = $this->router->method;

        if (in_array($method, array('login', 'logout'))) {
            
            return true;
            
        }

        if ($this->is_ajax_request) {

            error_log("Login failed!". $this->ion_auth->logged_in(), 0);

            echo TIMEOUT_SECURITY_CODE; exit();

        }
        else {
            
            flash_warning(lang('please_login'));

            $segments = array('login.html');

            $this->redirect($segments);

        }

	}


	/**
	 * [guid generate key]
	 * @return [string] [key random]
	 */
	public function guid($charid = 8){

        mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.

        $charid = strtoupper(md5(uniqid(rand(), true)));

        // $hyphen = chr(45); // "-"

       $uuid = substr($charid, 0, 8)

                . substr($charid, 8, 4)

                . substr($charid, 12, 4)

                . substr($charid, 16, 4)

                . substr($charid, 20, 12);

      	return $uuid;

    }

    public function generate_token(){

        mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.

        $charid = strtoupper(md5(uniqid(rand(), true)));

        $hyphen = chr(45); // "-"

       $uuid = substr($charid, 0, 8)

                . substr($charid, 8, 4).$hyphen

                . substr($charid, 12, 4).$hyphen

                . substr($charid, 16, 4).$hyphen

                . substr($charid, 20, 12);

      	return $uuid;

    }


    public function get_agent()
    {

        $this->load->library('user_agent');

        $platforms = array(
            'windows nt 6.3'    => 'Windows 8.1',
            'windows nt 6.2'    => 'Windows 8',
            'windows nt 6.1'    => 'Windows 7',
            'windows nt 6.0'    => 'Windows Vista',
            'windows nt 5.2'    => 'Windows 2003',
            'windows nt 5.1'    => 'Windows XP',
            'windows nt 5.0'    => 'Windows 2000',
            'windows nt 4.0'    => 'Windows NT 4.0',
            'winnt4.0'          => 'Windows NT 4.0',
            'winnt 4.0'         => 'Windows NT',
            'winnt'             => 'Windows NT',
            'windows 98'        => 'Windows 98',
            'win98'             => 'Windows 98',
            'windows 95'        => 'Windows 95',
            'win95'             => 'Windows 95',
            'windows phone'         => 'Windows Phone',
            'windows'           => 'Unknown Windows OS',
            'android'           => 'Android',
            'blackberry'        => 'BlackBerry',
            'iphone'            => 'iOS',
            'ipad'              => 'iOS',
            'ipod'              => 'iOS',
            'os x'              => 'Mac OS X',
            'ppc mac'           => 'Power PC Mac',
            'freebsd'           => 'FreeBSD',
            'ppc'               => 'Macintosh',
            'linux'             => 'Linux',
            'debian'            => 'Debian',
            'sunos'             => 'Sun Solaris',
            'beos'              => 'BeOS',
            'apachebench'       => 'ApacheBench',
            'aix'               => 'AIX',
            'irix'              => 'Irix',
            'osf'               => 'DEC OSF',
            'hp-ux'             => 'HP-UX',
            'netbsd'            => 'NetBSD',
            'bsdi'              => 'BSDi',
            'openbsd'           => 'OpenBSD',
            'gnu'               => 'GNU/Linux',
            'unix'              => 'Unknown Unix OS',
            'symbian'           => 'Symbian OS'
        );

        $browsers = array(
            'OPR'           => 'Opera',
            'Flock'         => 'Flock',
            'Chrome'        => 'Chrome',
            // Opera 10+ always reports Opera/9.80 and appends Version/<real version> to the user agent string
            'Opera.*?Version'   => 'Opera',
            'Opera'         => 'Opera',
            'IE'          => 'Internet Explorer',
            'Trident.* rv'  => 'Internet Explorer',
            'Shiira'        => 'Shiira',
            'Firefox'       => 'Firefox',
            'Chimera'       => 'Chimera',
            'Phoenix'       => 'Phoenix',
            'Firebird'      => 'Firebird',
            'Camino'        => 'Camino',
            'Netscape'      => 'Netscape',
            'OmniWeb'       => 'OmniWeb',
            'Safari'        => 'Safari',
            'Mozilla'       => 'Mozilla',
            'Konqueror'     => 'Konqueror',
            'icab'          => 'iCab',
            'Lynx'          => 'Lynx',
            'Links'         => 'Links',
            'hotjava'       => 'HotJava',
            'amaya'         => 'Amaya',
            'IBrowse'       => 'IBrowse',
            'Maxthon'       => 'Maxthon',
            'Ubuntu'        => 'Ubuntu Web Browser'
        );

        $mobiles = array(
            // legacy array, old values commented out
            'mobileexplorer'    => 'Mobile Explorer',
                //  'openwave'          => 'Open Wave',
                //  'opera mini'        => 'Opera Mini',
                // 'operamini'         => 'Opera Mini',
                // 'elaine'            => 'Palm',
            'palmsource'        => 'Palm',
                // 'digital paths'     => 'Palm',
                // 'avantgo'           => 'Avantgo',
                // 'xiino'             => 'Xiino',
            'palmscape'         => 'Palmscape',
                // 'nokia'             => 'Nokia',
                // 'ericsson'          => 'Ericsson',
                // 'blackberry'        => 'BlackBerry',
                // 'motorola'          => 'Motorola'

                // Phones and Manufacturers
            'motorola'      => 'Motorola',
            'nokia'         => 'Nokia',
            'palm'          => 'Palm',
            'iphone'        => 'Apple iPhone',
            'ipad'          => 'iPad',
            'ipod'          => 'Apple iPod Touch',
            'sony'          => 'Sony Ericsson',
            'ericsson'      => 'Sony Ericsson',
            'blackberry'    => 'BlackBerry',
            'cocoon'        => 'O2 Cocoon',
            'blazer'        => 'Treo',
            'lg'            => 'LG',
            'amoi'          => 'Amoi',
            'xda'           => 'XDA',
            'mda'           => 'MDA',
            'vario'         => 'Vario',
            'htc'           => 'HTC',
            'samsung'       => 'Samsung',
            'sharp'         => 'Sharp',
            'sie-'          => 'Siemens',
            'alcatel'       => 'Alcatel',
            'benq'          => 'BenQ',
            'ipaq'          => 'HP iPaq',
            'mot-'          => 'Motorola',
            'playstation portable'  => 'PlayStation Portable',
            'playstation 3'     => 'PlayStation 3',
            'playstation vita'      => 'PlayStation Vita',
            'hiptop'        => 'Danger Hiptop',
            'nec-'          => 'NEC',
            'panasonic'     => 'Panasonic',
            'philips'       => 'Philips',
            'sagem'         => 'Sagem',
            'sanyo'         => 'Sanyo',
            'spv'           => 'SPV',
            'zte'           => 'ZTE',
            'sendo'         => 'Sendo',
            'nintendo dsi'  => 'Nintendo DSi',
            'nintendo ds'   => 'Nintendo DS',
            'nintendo 3ds'  => 'Nintendo 3DS',
            'wii'           => 'Nintendo Wii',
            'open web'      => 'Open Web',
            'openweb'       => 'OpenWeb',

            // Operating Systems
            'android'       => 'Android',
            'symbian'       => 'Symbian',
            'SymbianOS'     => 'SymbianOS',
            'elaine'        => 'Palm',
            'series60'      => 'Symbian S60',
            'windows ce'    => 'Windows CE',

            // Browsers
            'obigo'         => 'Obigo',
            'netfront'      => 'Netfront Browser',
            'openwave'      => 'Openwave Browser',
            'mobilexplorer' => 'Mobile Explorer',
            'operamini'     => 'Opera Mini',
            'opera mini'    => 'Opera Mini',
            'opera mobi'    => 'Opera Mobile',
            'fennec'        => 'Firefox Mobile',

            // Other
            'digital paths' => 'Digital Paths',
            'avantgo'       => 'AvantGo',
            'xiino'         => 'Xiino',
            'novarra'       => 'Novarra Transcoder',
            'vodafone'      => 'Vodafone',
            'docomo'        => 'NTT DoCoMo',
            'o2'            => 'O2',

            // Fallback
            'mobile'        => 'Generic Mobile',
            'wireless'      => 'Generic Mobile',
            'j2me'          => 'Generic Mobile',
            'midp'          => 'Generic Mobile',
            'cldc'          => 'Generic Mobile',
            'up.link'       => 'Generic Mobile',
            'up.browser'    => 'Generic Mobile',
            'smartphone'    => 'Generic Mobile',
            'cellphone'     => 'Generic Mobile'
        );

        $robots = array(
            'googlebot'     => 'Googlebot',
            'msnbot'        => 'MSNBot',
            'baiduspider'   => 'Baiduspider',
            'bingbot'       => 'Bing',
            'slurp'         => 'Inktomi Slurp',
            'yahoo'         => 'Yahoo',
            'askjeeves'     => 'AskJeeves',
            'fastcrawler'   => 'FastCrawler',
            'infoseek'      => 'InfoSeek Robot 1.0',
            'lycos'         => 'Lycos',
            'yandex'        => 'YandexBot'
        );

        if($this->agent->platform()) {

            $get['platform'] = ($this->agent->platform());

            $check_find = 0;

            foreach ($platforms as $key => $value) {
               
                if($get['platform'] == ($value)) {

                    $get['platform'] = ($key);

                    $check_find++;

                }

            }

            if($check_find == 0) {

                $get['platform'] = 'OTHER';

            }

        }
        else {

            $get['platform'] = 'OTHER';

        }

        if($this->agent->browser()) {

            $get['BROWSER'] = ($this->agent->browser());

            $check_find = 0;

            foreach ($browsers as $key => $value) {
               
                if($get['BROWSER'] == ($value)) {

                    $get['BROWSER'] = ($key);

                    $check_find++;

                }

            }

            if($check_find == 0) {

                $get['BROWSER'] = 'OTHER';

            }

            if(strpos($this->agent->agent_string(), 'rv:') && $get['BROWSER'] == 'Mozilla') {

                $get['BROWSER'] = 'IE';

            }

            if(strpos($this->agent->agent_string(), 'OPR/')) {

                $get['BROWSER'] = 'OPERA';

            }

        }
        else {

            $get['BROWSER'] = 'OTHER';

        }

        if($this->agent->is_mobile()) {

            $get['MOBILE'] = ($this->agent->mobile());

            $check_find = 0;

            foreach ($mobile as $key => $value) {
               
                if($get['MOBILE'] == ($value))
                {
                    $get['MOBILE'] = ($key);

                    $check_find++;
                }

            }

            if($check_find == 0) {

                $get['MOBILE'] = 'OTHER';

            }

        }
        else {

            $get['MOBILE'] = '';
        }

        foreach ($get as $key => $value) {

            $get[$key] = strtoupper($value);

        }
        
        return $get;

    }

    public function get_location($ip = '127.0.0.1')
    {
        if($ip == "127.0.0.1" || $ip == "::1") {

            return "LOCALHOST";

        }
        elseif($ip == "UNKNOWN") {

            return "UNKNOWN";

        }
        else {

            require_once("application/controllers/geoiploc.php");

            return getCountryFromIP($ip,"name");

        }
        
    }

    public function get_client_ip() {
        
        $ipaddress = '';

        if (getenv('HTTP_CLIENT_IP')) {

            $ipaddress = getenv('HTTP_CLIENT_IP');

        }   
        else if(getenv('HTTP_X_FORWARDED_FOR')) {

            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');

        }
        else if(getenv('HTTP_X_FORWARDED')) {

            $ipaddress = getenv('HTTP_X_FORWARDED');

        }
        else if(getenv('HTTP_FORWARDED_FOR')) {

            $ipaddress = getenv('HTTP_FORWARDED_FOR');

        }
        else if(getenv('HTTP_FORWARDED')) {

           $ipaddress = getenv('HTTP_FORWARDED');

        }
        else if(getenv('REMOTE_ADDR')) {

            $ipaddress = getenv('REMOTE_ADDR');

        }
        else {

            $ipaddress = 'UNKNOWN';

        }

        return $ipaddress;

    }

    function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));

        if (array_key_exists($ext, $mime_types)) {

            return $mime_types[$ext];

        }
        elseif (function_exists('finfo_open')) {

            $finfo = finfo_open(FILEINFO_MIME);

            $mimetype = finfo_file($finfo, $filename);

            finfo_close($finfo);

            return $mimetype;

        }
        else {

            return 'application/octet-stream';

        }

    }


    public function generate_full_view($data = null)
    {

        $dir = APP_VIEW.VIEW_PLATFROM;

        if ($data != null && isset($data['platform']) && count($data['platform'])) {

            if (!isset($data['view_name'])) {

                flash_error(lang('View_name_is_empty_Please_input_data'));

            }

            if (is_array($data['platform'])) {

                $this->load->model('t_view');

                $this->load->model('t_platform');

                foreach ($data['platform'] as $key => $platform) {

                    if (!is_dir($dir.$platform)) {

                        @mkdir($dir.$platform, DIR_WRITE_MODE);

                    }

                    $path_module = $this->trim_path($data['module_name']);

                    $folder = explode(SLASH, $path_module);

                    if (count($folder) > 1) {

                        $d_module = $dir.$platform;

                        foreach ($folder as $key => $f) {

                            $d_module .= SLASH.$f;

                            if (!is_dir($d_module)) {

                                @mkdir($d_module, DIR_WRITE_MODE);

                            }

                        }

                        $view_file = $d_module.SLASH.$data['view_name'].EXT;

                        $css_file = $d_module.SLASH.$data['view_name'].'_css'.EXT;

                        $js_file = $d_module.SLASH.$data['view_name'].'_js'.EXT;

                    }
                    else {

                        if (!is_dir($dir.$platform.SLASH.$folder[0])) {

                            @mkdir($dir.$platform.SLASH.$folder[0], DIR_WRITE_MODE);

                        }

                        $d_module = $dir.$platform.SLASH.$folder[0];

                        $view_file = $d_module.SLASH.$data['view_name'].EXT;

                        $css_file = $d_module.SLASH.$data['view_name'].'_css'.EXT;

                        $js_file = $d_module.SLASH.$data['view_name'].'_js'.EXT;

                    }

                    $this->response->data[] = array(
                        'file' => $view_file,
                        'platform_key' => $platform,
                        'encode' => base64_encode($view_file),
                        'basename' => basename($view_file)
                    );

                    $this->response->data[] = array(
                        'file' => $js_file,
                        'platform_key' => $platform,
                        'encode' => base64_encode($js_file),
                        'basename' => basename($js_file)
                    );

                    $this->response->data[] = array(
                        'file' => $css_file,
                        'platform_key' => $platform,
                        'encode' => base64_encode($css_file),
                        'basename' => basename($css_file)
                    );

                    if (isset($data['fetch_platform'])) {

                        $view_file_fetch = str_replace($platform, $data['fetch_platform'], $view_file);

                        $css_file_fetch = str_replace($platform, $data['fetch_platform'], $css_file);

                        $js_file_fetch = str_replace($platform, $data['fetch_platform'], $js_file);

                        if (is_file($view_file_fetch)) {

                            $data['content_body'] = $this->read_file_content($view_file_fetch);

                        }

                        if (is_file($css_file_fetch)) {

                            $data['content_css_body'] = $this->read_file_content($css_file_fetch);

                        }

                        if (is_file($view_file_fetch)) {

                            $data['content_js_body'] = $this->read_file_content($js_file_fetch);

                        }

                    }

                    if (!is_file($view_file)) {

                        @file_put_contents($view_file, $data['content_body']);

                    }
                    else {

                        if (isset($data['override_view']) && $data['override_view']) {

                            @file_put_contents($view_file, $data['content_body']);

                        }
                        else {
                            
                            continue;

                        }

                    }

                    if (!is_file($css_file) && isset($data['generate_css']) && $data['generate_css']) {
                         
                        @file_put_contents($css_file, @$data['content_css_body']);

                    }
                    else {

                        if (isset($data['override_suv_view']) && $data['override_suv_view']) {

                            @file_put_contents($css_file, @$data['content_css_body']);

                        }

                    }

                    if (!is_file($js_file) && isset($data['generate_js']) && $data['generate_js']) {
                        
                        @file_put_contents($js_file, @$data['content_js_body']);

                    }
                    else {

                        if (isset($data['override_suv_view'])) {

                            @file_put_contents($js_file, @$data['content_js_body']);

                        }

                    }

                    $platform_data = $this->t_platform->get_data_by_property('*', array(
                            'platform_key' => $platform
                        )
                    );

                    $view_data = array(
                        'view_name' => $data['view_name'],
                        'module_name' => $data['module_name'],
                        'platform_id' => @$platform_data[0]['id']
                    );

                    $insert = (object) $this->t_view->set_data($view_data, 1);

                }

                flash_error(lang('Created'));

            }

        }
        else {

            flash_error(lang('Platform_is_empty_Please_input_data'));

        }

        return $this->response;

    }

    public function generate_language_file($data = null) {

        if ($data != null) {

            if (!isset($data['view_name'])) {

                flash_error(lang('View_name_is_empty_Please_input_data'));

                $this->redirect();

            }

            if (!isset($data['module_name'])) {

                flash_error(lang('Module_name_is_empty_Please_input_data'));

                $this->redirect();

            }

            if (isset($data['platform']) && count($data['platform']) > 0) {

                $lang_datas = $this->t_language->get_data_by_property('*');

                if (count($lang_datas) > 0) {

                    $list_php_lang_file = array();

                    $list_js_lang_file = array();

                    foreach ($data['platform'] as $value_platform) {

                        foreach ($lang_datas as $lang) {
                            
                            $php_lang_file = $lang['lang_folder'] . SLASH . $value_platform . SLASH . $data['module_name'];
                        
                            $js_lang_file = $lang['lang_folder'] . SLASH . $value_platform . SLASH . $data['module_name'];

                            array_push($list_php_lang_file, $php_lang_file);

                            array_push($list_js_lang_file, $js_lang_file);

                        }

                    }

                    if (count($list_php_lang_file) > 0) {
                        
                        foreach ($list_php_lang_file as $value_php_lang_file) {

                            $folder = explode(SLASH, $this->trim_path($value_php_lang_file));

                            if (count($folder) > 1) {

                                $dir_target = APP_PHP_LANG;

                                foreach ($folder as $f) {

                                    $dir_target .= SLASH . $f;

                                    if (!is_dir($dir_target)) {

                                        @mkdir($dir_target, DIR_WRITE_MODE);

                                    }

                                }

                            }
                            else {

                                if (!is_dir(APP_PHP_LANG . SLASH . $folder[0])) {

                                    @mkdir(APP_PHP_LANG . SLASH . $folder[0], DIR_WRITE_MODE);

                                }

                                $dir_target = APP_PHP_LANG . SLASH . $folder[0];

                            }

                            $php_lang_file = $dir_target . SLASH . $data['view_name'] . PHP_SUB_LANG . EXT;

                            if (!is_file($php_lang_file)) {

                                @file_put_contents($php_lang_file, '');

                            }

                        }

                    }

                    if (count($list_js_lang_file) > 0) {
                        
                        foreach ($list_js_lang_file as $value_js_lang_file) {

                            $folder = explode(SLASH, $this->trim_path($value_js_lang_file));

                            if (count($folder) > 1) {

                                $dir_target = JS_LANG_DIR;

                                foreach ($folder as $f) {

                                    $dir_target .= SLASH . $f;

                                    if (!is_dir($dir_target)) {

                                        @mkdir($dir_target, DIR_WRITE_MODE);

                                    }

                                }

                            }
                            else {

                                if (!is_dir(JS_LANG_DIR . SLASH . $folder[0])) {

                                    @mkdir(JS_LANG_DIR . SLASH . $folder[0], DIR_WRITE_MODE);

                                }

                                $dir_target = JS_LANG_DIR . SLASH . $folder[0];

                            }

                            $js_lang_file = $dir_target . SLASH . $data['view_name'] . JS_EXT;

                            if (!is_file($js_lang_file)) {

                                @file_put_contents($js_lang_file, '');

                            }

                        }

                    }

                    flash_success(lang('Created'));

                } else {

                    flash_error(lang('Not_found_language_in_system'));

                }

            } else {

                flash_error(lang('Platform_is_empty_Please_input_data'));

            }

        }
        else {

            flash_error(lang('Data_is_empty_Please_input_data'));

        }
        
        return $this->response;

    }

    public function rename_view_and_language($data = array()) {
        
        if (empty($data)) {
            
            return $this->response;

        } else {

            $this->load->model('t_platform');

            $platform = $this->t_platform->get_data_by_id('*', $data['platform']);

            $target_dir = valid_path(FCPATH);

            $dir_view = APP_VIEW . VIEW_PLATFROM . $platform['platform_key'] . SLASH;

            $this->create_tree_dir($dir_view, $data['module_name']);

            $old_dir_view = $dir_view . $data['old_module_name'];

            $new_dir_view = $dir_view . $data['module_name'];

            $list_file_rename = array(
                [
                    'old_file_name' => $old_dir_view . SLASH . $data['old_view_name'] . EXT,
                    'new_file_name' => $new_dir_view . SLASH . $data['view_name'] . EXT,
                ],
                [
                    'old_file_name' => $old_dir_view . SLASH . $data['old_view_name'] . '_css' . EXT,
                    'new_file_name' => $new_dir_view . SLASH . $data['view_name'] . '_css' . EXT,
                ],
                [
                    'old_file_name' => $old_dir_view . SLASH . $data['old_view_name'] . '_js' . EXT,
                    'new_file_name' => $new_dir_view . SLASH . $data['view_name'] . '_js' . EXT
                ]
            );
            
            $this->load->model('t_language');

            $lang_datas = $this->t_language->get_data_by_property('*');

            if (count($lang_datas) > 0) {

                foreach ($lang_datas as $lang) {

                    $dir_php_lang = APP_PHP_LANG . $lang['lang_folder'] . SLASH . $platform['platform_key'] . SLASH;

                    $old_dir_php_lang = $dir_php_lang . $data['old_module_name'];

                    $new_dir_php_lang = $dir_php_lang . $data['module_name'];
                    
                    array_push($list_file_rename, array(
                        'old_file_name' => $old_dir_php_lang . SLASH . $data['old_view_name'] . PHP_SUB_LANG . EXT,
                        'new_file_name' => $new_dir_php_lang . SLASH . $data['view_name'] . PHP_SUB_LANG . EXT
                    ));

                    $dir_js_lang = JS_LANG_DIR . $lang['lang_folder'] . SLASH . $platform['platform_key'] . SLASH;

                    $old_dir_js_lang = $dir_js_lang . $data['old_module_name'];

                    $new_dir_js_lang = $dir_js_lang . $data['module_name'];
                    
                    array_push($list_file_rename, array(
                        'old_file_name' => $old_dir_js_lang . SLASH . $data['old_view_name'] . JS_EXT,
                        'new_file_name' => $new_dir_js_lang . SLASH . $data['view_name'] . JS_EXT
                    ));

                }

            }

            if (count($list_file_rename) > 0) {

                foreach ($list_file_rename as $key => $file_rename) {

                    if ($key == 0 && !is_file($file_rename['old_file_name'])) {
                        
                        flash_error(lang('View_dose_not_exist'));

                        return $this->response;

                    }

                    if (is_file($file_rename['old_file_name'])) {

                        @copy($file_rename['old_file_name'], $file_rename['new_file_name']);

                        if (is_file($file_rename['new_file_name'])) {

                            @unlink($file_rename['old_file_name']);

                        }
                        
                    }

                }

                $this->response->success = 1;

                $this->response->file_path = base64_encode($list_file_rename[0]['new_file_name']);

            }
            else {

                flash_error(lang('Data_not_found'));

            }

            return $this->response;

        }
        
    }

    public function remove_empty_sub_folders($path) {
        
        $empty = true;
        
        foreach (glob($path . SLASH . "*") as $file) {
            
            if (is_dir($file)) {
                
                if (!$this->remove_empty_sub_folders($file)) {

                    $empty = false;

                }
            
            } else {
                
                $empty = false;
            
            }

        }

        if ($empty) {

            @rmdir($path);

        }
        
        return $empty;

    }

    public function trim_path($path)
    {

        $first = substr($path, 0, 1);

        $last = substr($path, strlen($path) - 1, strlen($path));

        if ($first == SLASH || $first == '\\') {

            $path = substr($path, 1, strlen($path));

        }

        if ($last == SLASH || $last == '\\') {

            $path = substr($path, 0, strlen($path) - 1);

        }

        return $path;

    }

    public function create_tree_dir($current_dir = null, $str_dir = null)
    {

        if (!$current_dir) {

            $current_dir = valid_path(FCPATH);

        }

        $path_module = $this->trim_path($str_dir);

        $folder = explode(SLASH, $path_module);

        if (count($folder) > 1) {

            foreach ($folder as $key => $f) {

                $end_dir = $f;

                if ($key == 0) {

                    $current_dir .= $f;

                }
                else {

                    $current_dir .= SLASH.$f;

                }

                if (!is_dir($current_dir)) {

                    @mkdir($current_dir, DIR_WRITE_MODE);

                }

                if ($key == count($folder) - 1) {

                    return $current_dir;

                }

            }

            return $end_dir;

        }
        else {

            $current_dir .= SLASH.$str_dir;

            if (!is_dir($current_dir)) {

                @mkdir($current_dir, DIR_WRITE_MODE);

            }

            return $str_dir;

        }

    }

    public function get_dir($dir_uri = null, $pattern = '/^[.]/i')
    {

        if (is_dir($dir_uri)) {

            $dir = scandir($dir_uri);

            if (count($dir)) {

                foreach ($dir as $key => $entries) {

                    if (preg_match($pattern , $entries, $matches) || $entries == '.' || $entries == '..'|| $entries == 'index.html'|| $entries == '.php') {

                        unset($dir[$key]);

                    }

                }

            }

            return $dir;

        }

        return null;

    }

    function fetch_key($arr = array())
    {

        $data = array();

        if (count($arr) > 0) {

            foreach ($arr as $key => $ar) {

                $data[$arr[$key]] = $arr[$key];
                
            }

        }

        return $data;

    }

    protected function parse_data_post()
    {

        $data = array();

        foreach ($this->input->post() as $key => $post) {
            
            $data[$key] = $post;

        }

        return $data;

    }

    public function array_intersect($arr1 = array(), $arr2 = array())
    {
        
        foreach ($arr1 as $key => $arr) {
            
            if (!in_array($key, $arr2)) {
                
                unset($arr1[$key]);
                
            }
            
        }
        
        return $arr1;
    }

    function _get_csrf_nonce()
    {
        
        $this->load->helper('string');
        
        $key = random_string('alnum', 8);
        
        $value = random_string('alnum', 20);
        
        $this->session->set_userdata('csrfkey', $key);
        
        $this->session->set_userdata('csrfvalue', $value);
        
        return array(
            $key => $value
        );
        
    }

    function _valid_csrf_nonce()
    {
        
        if ($this->input->post($this->session->userdata('csrfkey')) !== FALSE &&
            $this->input->post($this->session->userdata('csrfkey')) == $this->session->userdata('csrfvalue')) {
            
            return TRUE;
            
        } else {
            
            return FALSE;
            
        }
        
    }

    /**
     * get all controller class in directory application/controllers
     * @return [array] [list controller]
     */
    protected function get_controller_list()
    {

        $dir_control = $this->get_dir(APPPATH.'controllers');

        foreach ($dir_control as $key => $control) {

            $dir = APPPATH.'controllers/'.$control;

            if (is_dir($dir)) {

                $add_control = $this->get_dir($dir);

                if (count($add_control)) {

                    foreach ($add_control as $key => $add) {

                        $add = str_replace(EXT, '', $add);

                        $dir_control[] = ($control.SLASH.$add);

                    }

                }

                unset($dir_control[$key]);

            }
            else {

                $dir_control[$key] = (str_replace(EXT, '', $control));

            }

        }

        return array_filter(array_unique($dir_control));

    }

    /**
     * [parse_fields_table description]
     * @param  [type] $post       [description]
     * @param  [type] $table_name [description]
     * @return [type]             [description]
     */
    protected function parse_fields_table($post, $table_name = null)
    {

        $data = array();

        if ($table_name != null) {

            $fields = $this->db->list_fields($table_name);
                
            $data = $this->array_intersect($post, $fields);

        }

        return $data;

    }

    public function get_all_method_of_class($class='', $type = 1)
    {

        if (file_exists($file = APPPATH . 'controllers/' . $class . EXT)) {

            require_once $file;

            $func = new ReflectionClass($class);

            $methods = array();

            $all_method = array();

            if ($type == 1) {

                $all_method = $func->getMethods();

            }
            else {
                
                $all_method = $func->getMethods(ReflectionMethod::IS_PUBLIC);

            }

            foreach ($all_method as $m) {

                if (strpos($m->name, '_') === 0) {

                    continue;

                }

                if ($m->class == ucfirst($class)) {

                    $methods[] = $m->name;

                }

            }

            return $methods;

        }
        else {

            return array();

        }

    }

    public function get_public_functions($class_name)
    {

        if ($class_name) {

            //$class_control = end(explode('/', $class_name));
            $cl = explode('/', $class_name);
            $class_control = end($cl);

            if ($class_control != $this->router->class) {

                $methods = $this->load->file(APPPATH.'controllers/'.$class_name.EXT);

            }

            $class = new ReflectionClass($class_control);

            $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

            if ($methods) {

                foreach ($methods as $key => $method) {

                    if ($method->name == '__construct' || $method->class != ucfirst($class_control)) {

                        unset($methods[$key]);

                    }
                    else {

                        $methods[$key]->key = null;

                        $methods[$key]->id = null;

                    }

                }

            }

            return $methods;

        }
        else {
            
            return null;

        }
        
    }

    public function get_view($data = array(), $str_path = null)
    {

        $pattern = '/^[.]/i';

        if (is_dir($str_path)) {

            $data = $this->get_dir($str_path, $pattern);

            $data = $this->fetch_key($data);

            if (count($data) > 0) {

                foreach ($data as $key => $dir_path) {

                    $path = $str_path.'/'.$dir_path;

                    if (is_dir($path)) {

                        $data[$key] = $this->get_view($data[$key], $path);

                    }
                    else{

                        $dir[$key] = $dir_path;

                    }

                }

            }

        }

        return $data;

    }

    protected function parser_dir($data = array(), $result = array(), $root = null)
    {

        if (!count($data)) {

            return $result;

        }

        foreach ($data as $key => $dir) {

            $root_dir = array_filter(explode('/', $root));

            $root_dir[] = $key;

            $path = implode('/', $root_dir);

            if (is_dir($path)) {

                $result = $this->parser_dir($dir, $result, $path);

            }
            else {

                if(isset($this->data['key_default'])){

                    if (strpos($root, APPPATH.'views') !== false) {

                        $module = str_replace(APPPATH.'views'.'/'.$this->data['key_default'], null, $root);

                    }
                    elseif (strpos($root, APPPATH.'controllers') !== false) {

                        $module = str_replace(APPPATH.'controllers'.'/'.$this->data['key_default'], null, $root);

                    }
                    elseif (strpos($root, APPPATH.'models') !== false) {
                            
                        $module = str_replace(APPPATH.'models'.'/'.$this->data['key_default'], null, $root);

                    }
                    elseif (strpos($root, 'themes/js_lang') !== false) {
                        
                        $module = str_replace('themes/js_lang'.'/'.$this->data['key_default'], null, $root);

                    }
                    elseif (strpos($root, APPPATH.'language') !== false) {
                            
                        $module = str_replace(APPPATH.'language'.'/'.$this->data['key_default'], null, $root);

                    }

                    if (strpos($root, APPPATH.'views') !== false) {

                        $module = str_replace(APPPATH.'views', null, $root);

                    }
                    elseif (strpos($root, APPPATH.'controllers') !== false) {

                        $module = str_replace(APPPATH.'controllers', null, $root);

                    }
                    elseif (strpos($root, APPPATH.'models') !== false) {
                            
                        $module = str_replace(APPPATH.'models', null, $root);

                    }
                    elseif (strpos($root, FCPATH.'themes/js_lang') !== false) {
                            
                        $module = str_replace(FCPATH.'themes/js_lang', null, $root);

                    }
                    elseif (strpos($root, APPPATH.'language') !== false) {
                            
                        $module = str_replace(APPPATH.'language', null, $root);

                    }
                    
                }
                else {

                    if (strpos($root, APPPATH.'views') !== false) {

                        $module = str_replace(APPPATH.'views', null, $root);

                    }
                    elseif (strpos($root, APPPATH.'controllers') !== false) {

                        $module = str_replace(APPPATH.'controllers', null, $root);

                    }
                    elseif (strpos($root, APPPATH.'models') !== false) {
                            
                        $module = str_replace(APPPATH.'models', null, $root);

                    }
                    elseif (strpos($root, FCPATH.'themes/js_lang') !== false) {
                            
                        $module = str_replace(FCPATH.'themes/js_lang', null, $root);

                    }
                    elseif (strpos($root, APPPATH.'language') !== false) {
                            
                        $module = str_replace(APPPATH.'language', null, $root);

                    }
                    
                }

                $result_data = array(

                    'module' => $module,

                    'file' => $key,

                    'size' => filesize($path),

                    'path' => $path

                );

                array_push($result, $result_data);

            }

        }

        return $result;

    }

    public function force_write_file($file_path=null, $str_content = '')
    {

        if ($file_path !== null) {

            $file_directiry = dirname($file_path);

            $current_directiry = $this->create_tree_dir(null, $file_directiry);

            $current_file = $current_directiry.SLASH.basename($file_path);

            @file_put_contents($current_file, $str_content);

        }

    }

    public function php_check_syntax($url = null)
    {

        if (!is_null($url)) {

            $command = "php -l $url";

            $result = shell_exec($command);

            $flag = strpos($result, 'No syntax errors detected in ');

            if ($flag !== 0) {

                return $result;

            }

            return null;

        }
        else {

            return null;

        }
        
    }

    protected function generate_response_message($success = 0)
    {

        $this->response = (object) array(
            'success' => $success,
            'message' => null,
            'callback_function' => $this->input->post('callback_function'),
            'timeout' => null,
            'reload' => null,
            'redirect' => null,
            'modal' => $this->input->post('modal'),
            'data' => []
        );

    }

    protected function response_message($data = array())
    {

        clear_flashdata();

        clear_messi();

        if (count($data)) {
            
            echo json_encode($this->response); exit();

        }

        echo json_encode($this->response); exit();

    }

    public function referrer()
    {

        if( $this->session->userdata('redirect_back') ) {

            $redirect_url = $this->session->userdata('redirect_back');
            
            $this->session->unset_userdata('redirect_back');

            $this->redirect($redirect_url);

        }

    }

    public function get_referrer()
    {

        return $this->session->userdata('redirect_back');

    }

    public function set_referrer()
    {

        if (strpos($this->uri->uri_string, 'install.php' !== false)) {

            return true;

        }

        $this->load->library('user_agent');  // load user agent library

        if (!in_array($this->uri->rsegments[2], array(
                        'login',
                        'logout',
                        'forgot_password',
                        'activate',
                        'confirm_delete'
                    )
                )
            ) {

            // save the redirect_back data from referral url (where user first was prior to login)
            $this->session->set_userdata('redirect_back', $this->agent->referrer());

        }

    }

    public function set_active_tab()
    {
        
        $action_router = $this->router->class.SLASH.$this->router->method;

        if ($this->uri->uri_string == $action_router) {
            
            $this->load->model('t_router');

            $router = $this->t_router->get_data_by_property('*', array(
                    'router_source' => $action_router,
                    'router_key' => $action_router
                )
            );

            if (count($router)) {

                $tabActive = str_replace('.html', '', $router[0]['router_value']);

            }

        }
        else {

            $tabActive = str_replace('.html', '', $this->uri->uri_string);

        }

        $this->data[$tabActive] = 'active';
    }

    protected function read_file_content($path = '')
    {

        if (is_file($path)) {

            if (is_readable($path)) {
            
                flash_error('');

            }

            $page_content = '';

            $file = fopen($path,"r");

            while(! feof($file)) {

                $page_content .= fgets($file);

            }

            fclose($file);

            return $page_content;

        }

        return null;
    }

}

