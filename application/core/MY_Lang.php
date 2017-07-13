<?php
Class MY_Lang extends CI_Lang
{
    
    var $language = array();
    
    var $structure = array();
    
    var $CI;
    
    /**
     * List of loaded language files
     *
     * @var array
     */
    var $is_loaded = array();
    
    function __construct()
    {
        log_message('debug', "Language Class Initialized");
    }
    
    function load($langfile = '', $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '')
    {
        $langfile = str_replace('.php', '', $langfile);
        
        if ($add_suffix == TRUE) {
            $langfile = str_replace('_lang.', '', $langfile) . '_lang';
        }
        
        $langfile .= '.php';
        
        if (in_array($langfile, $this->is_loaded, TRUE)) {
            return;
        }
        
        $config =& get_config();
        
        if ($idiom == '') {
            $deft_lang = (!isset($config['language'])) ? 'english' : $config['language'];
            $idiom     = ($deft_lang == '') ? 'english' : $deft_lang;
        }
        
        // Determine where the language file is and load it
        if ($alt_path != '' && file_exists($alt_path . 'language/' . $idiom . '/' . $langfile)) {
            include($alt_path . 'language/' . $idiom . '/' . $langfile);
        } else {
            $found = FALSE;
            
            foreach (get_instance()->load->get_package_paths(TRUE) as $package_path) {
                if (file_exists($package_path . 'language/' . $idiom . '/' . $langfile)) {
                    include($package_path . 'language/' . $idiom . '/' . $langfile);
                    $found = TRUE;
                    break;
                }
            }
            
            if ($found !== TRUE) {
                $this->CI =& get_instance();
                $platform    = @$this->CI->data['platform'];
                $lang_folder = @$this->CI->data['lang_folder'];
                if (isset($this->CI->data['platform'])) {
                    $lang_path = APP_PHP_LANG . $this->CI->data['lang_folder'] . SLASH . $platform . SLASH . $langfile;
                    if (is_file($lang_path)) {
                        include($lang_path);
                    }
                } else {
                    show_error('Unable to load the requested language file: language/' . $idiom . '/' . $langfile);
                }
            }
        }
        
        
        if (!isset($lang)) {
            log_message('error', 'Language file contains no data: language/' . $idiom . '/' . $langfile);
            return;
        }
        
        if ($return == TRUE) {
            return $lang;
        }
        
        $this->is_loaded[]          = $langfile;
        $languages                  = array_merge($this->language, $lang);
        $this->language             = $languages;
        $this->structure[$langfile] = $lang;
        unset($lang);
        
        log_message('debug', 'Language file loaded: language/' . $idiom . '/' . $langfile);
        return TRUE;
    }
    
}