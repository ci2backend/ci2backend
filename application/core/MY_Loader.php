<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Generic MY_Output for entity class, CI AR.
 * @author PhuTv
 *
 */


class MY_Loader extends CI_Loader {

    var $CI;

    function __construct() {

        parent::__construct();

        $this->CI =& get_instance();

        $this->CI->load = $this;

        if (!isset($this->CI->data['ext_loaded'])) {
            
            $this->CI->data['ext_loaded'] = array();

        }

    }

    public function controller($control='')
    {

        if (file_exists($file = APPPATH . 'controllers/' . $control . EXT)) {

            if (isset($this->CI->{$control})) {
                
                return $this->CI->{$control};

            }

            $current_class = get_class($this->CI);

            if (strtolower($current_class) === strtolower($control)) {

                return $this;

            }
            
            if (!isset($this->CI->{$control})) {

                $this->file('application/controllers/'.$control.EXT, false);

                $this->CI->{$control} = new $control();

            }

            return $this->CI->{$control};

        }
        else {

            show_error('The file '.$file.' not found', 404);

        }

    }

    public function common($str_path = null, $load = false, $data = array())
    {

        $common_data = array_merge($this->CI->data, $data);

        if (isset($common_data['template']) && isset($common_data['platform'])) {
            
            $tmp_path = APP_VIEW.COMMON_VIEW_DIR.VIEW_TEMPLATE
            .$common_data['template'].SLASH.$common_data['platform'].SLASH.$str_path;

            if (is_file($tmp_path.EXT)) {
                
                $str_path = COMMON_VIEW_DIR.VIEW_TEMPLATE
                .$common_data['template'].SLASH.$common_data['platform'].SLASH.$str_path;

            }
            else {

                $str_path = COMMON_VIEW_DIR.$str_path;

                if (!is_file(APP_VIEW.$str_path.EXT)) {

                    return null;

                }

            }

        }

        return $this->view($str_path, $common_data, $load);

    }

    public function template()
    {

        if (isset($this->CI->data['template'])) {

            $json_file = TEMPLATE_DIR.$this->CI->data['template'].'/config.json';

            if (is_file($json_file)) {

                $conf = json_parse($json_file, false);

                if ($conf) {

                    if (isset($conf->dependencies) && count($conf->dependencies)) {

                        $this->dependencies($conf->dependencies, $this->CI->data);

                    }

                    if (isset($conf->js) && count($conf->js)) {

                        $conf->js = (array) $conf->js;

                        if (!isset($this->CI->data['ext_js'])) {
                            
                            $this->CI->data['ext_js'] = array();

                        }

                        foreach ($conf->js as $key => $js) {
                            
                            $js_file = TEMPLATE_DIR.$this->CI->data['template'].SLASH.'js'.SLASH.$js.JS_EXT;
                            
                            $js_path = base_url().TEMPLATE_PATH.$this->CI->data['template'].SLASH.'js'.SLASH.$js.JS_EXT;
                            
                            if (is_file($js_file)) {

                                $conf->js[$key] = $js_path;
                            
                            }

                        }

                        $conf->js = array_values($conf->js);

                        if (count($this->CI->data['ext_js'])) {

                            foreach ($this->CI->data['ext_js'] as $key => $ext_js) {

                                $conf->js[$key] = $ext_js;

                            }

                        }

                        $this->CI->data['ext_js'] = array_filter($conf->js);

                    }

                    if (isset($conf->css) && count($conf->css)) {

                        $conf->css = (array) $conf->css;

                        if (!isset($this->CI->data['ext_css'])) {
                            
                            $this->CI->data['ext_css'] = array();

                        }
                        
                        foreach ($conf->css as $key => $css) {
                            
                            $css_file = TEMPLATE_DIR.$this->CI->data['template'].SLASH.'css'.SLASH.$css.CSS_EXT;
                            
                            $css_path = base_url().TEMPLATE_PATH.$this->CI->data['template'].SLASH.'css'.SLASH.$css.CSS_EXT;
                            
                            if (is_file($css_file)) {

                                $conf->css[$key] = $css_path;
                            
                            }

                        }

                        $conf->css = array_values($conf->css);

                        if (count($this->CI->data['ext_css'])) {

                            foreach ($this->CI->data['ext_css'] as $key => $ext_css) {

                                $conf->css[$key] = $ext_css;

                            }

                        }

                        $this->CI->data['ext_css'] = array_filter($conf->css);

                    }

                }

            }

        }

        if (!isset($this->CI->data['tmpl_menu_loader'])) {
                            
            $this->CI->data['tmpl_menu_loader'] = array();

        }

        $item = @$this->CI->data['template'];

        $this->CI->load->model('t_menu');

        $this->CI->load->model('t_menu_loader');

        $this->CI->t_menu->db->order_by($this->CI->t_menu_loader->table_name.'.priority', 'ASC');

        $this->CI->data['tmpl_menu_loader'] = $this->CI->t_menu->get_menu_by_template($this->CI->t_menu->table_name.'.*', array($this->CI->t_menu_loader->table_name.'.template_key' => $item, 'is_show' => 1));
        
        return $this->CI->data;

    }

    public function dependencies($array_dependencies='', &$data = array())
    {

        if (is_array($array_dependencies)) {

            foreach ($array_dependencies as $key => $dependencies) {

                if (!in_array($dependencies, $data['ext_loaded'])) {

                    $this->extension($dependencies, null, $data);

                }

            }

        }
        else {

            $this->extension($array_dependencies, null, $data);

        }

    }

    /**
     * [extension description]
     * @param  [string]  $ext_name [folder name of extend]
     * @param  boolean $type     [0|1, type = 0 -> load css, type = 1 -> load js]
     * @return [array]            [extend link]
     */
    public function extension($ext_name, $type = null)
    {



        if ($type === 0) {
            
            $type = 'css';

        }
        elseif ($type === 1) {

            $type = 'js';

        }
        elseif ($type === null) {

            $type = 'css';

            $callback = true;

        }

        if (is_array($ext_name)) {

            if (count($ext_name)) {

                foreach ($ext_name as $key => $ext) {

                    $this->extension($ext);

                }

            }

            return true;

        }

        if (is_dir(APP_EXT_DIR.$ext_name)) {

            if (is_file(APP_EXT_DIR.$ext_name.'/config.json')) {

                $ini_array = json_parse(APP_EXT_DIR.$ext_name.'/config.json');

                $type_section = $type;

            }
            else {

                if (is_file(APP_EXT_DIR.$ext_name.'/config.ini')) {

                    $ini_array = parse_ini_file(APP_EXT_DIR.$ext_name.'/config.ini', true);

                    $type_section = $type.'_section';

                }

            }

            if (@$ini_array) {
                
                if (!isset($ini_array[$type_section])) {

                    $ini_array[$type_section] = array();

                }

                if (isset($ini_array['dependencies']) && count($ini_array['dependencies'])) {

                    $this->dependencies($ini_array['dependencies'], $this->CI->data);

                }

                $arr_p = array(

                    $type => array()

                );

                foreach ($ini_array[$type_section] as $key => $type_file) {

                    if (file_exists($type_file)) {

                        $file_assets = $file_assets;

                    }
                    elseif (strpos($type_file, 'http://') || strpos($type_file, 'https://') || strpos($type_file, '//')) {
                        
                        $file_assets = $type_file;

                    }
                    else {

                        $file_current_path = ASSETS.EXTENSIONS.$ext_name.SLASH.$type_file;
                        
                        if (file_exists(FCPATH.$file_current_path)) {

                           $file_assets = base_url($file_current_path);

                        }
                        else {

                            $file_assets = base_url(ASSETS.EXTENSIONS).SLASH.$ext_name.SLASH.$type.SLASH.$type_file;
                        
                        }

                    }

                    $file = pathinfo($file_assets);

                    $new_key = $ext_name . '-'. $file['filename'];
                    
                    if (gettype($key) == 'integer') {

                        $arr_p[$type][$new_key] = $file_assets;

                    }
                    else {

                        $arr_p[$type][$key] = $file_assets;
                    
                    }

                }
                
                if (isset($this->CI->data['ext_'.$type]) && count(@$this->CI->data['ext_'.$type]) > 0) {

                    $this->CI->data['ext_'.$type] = array_merge($this->CI->data['ext_'.$type], $arr_p[$type]);

                }
                else {

                    $this->CI->data['ext_'.$type] = $arr_p[$type];

                }

                if (isset($callback)) {

                    $this->extension($ext_name, 1, $this->CI->data);

                }

                $this->CI->data['ext_loaded'][$ext_name] = @$ini_array['description'];

                array_filter($this->CI->data['ext_loaded']);

                return $arr_p[$type];

            }

        }

    }

    public function assets($link = '')
    {

        if ($link) {

            if (isset($this->CI->data['template'])) {

                $template  = $this->CI->data['template'];

                echo base_url("assets/templates/$template/".$link);

            }
            else {

               echo base_url('assets/'.$link);

            }

        }

    }

}