<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Input extends CI_Input
{
    
    /**
     * Variables
     * 
     */
    
    protected $delete;
    protected $put;
    protected $post;
    
    // --------------------------------------------------------------------
    
    /**
     * Constructor
     * 
     */
    function __construct()
    {
        log_message('debug', "MY_Input Class Initialized");
        
        parent::__construct();
        
        //get request type or override type
        if ($this->server('REQUEST_METHOD') == 'DELETE' || $this->server('HTTP_X_HTTP_METHOD_OVERRIDE') == 'DELETE') {
            $this->delete = file_get_contents('php://input');
            //parse and clean request
            $this->_parse_request($this->delete);
            
        } elseif ($this->server('REQUEST_METHOD') == 'PUT' || $this->server('HTTP_X_HTTP_METHOD_OVERRIDE') == 'PUT') {
            $this->put = file_get_contents('php://input');
            //parse and clean request
            $this->_parse_request($this->put);
        } elseif ($this->server('REQUEST_METHOD') == 'POST' || $this->server('HTTP_X_HTTP_METHOD_OVERRIDE') == 'POST') {
            $this->post = file_get_contents('php://input');
            $this->_parse_request($this->post);
        }
    }
    // --------------------------------------------------------------------
    /**
     * Check server method
     *
     * @access    public
     * @param    string
     * @return    bool
     */
    function is($post = 'post') {

        switch ($post) {
            case 'post':
                return $this->server('REQUEST_METHOD') == 'POST';
                break;
            case 'get':
                return $this->server('REQUEST_METHOD') == 'GET';
                break;
            default:
                return false;
                break;
        }

    }
    /**
     * Fetch an item from the POST JSON array
     *
     * @access    public
     * @param    string
     * @param    bool
     * @return    string
     */
    function post_json($index = NULL, $xss_clean = FALSE)
    {
        // Check if a field has been provided
        if ($index === NULL AND !empty($this->post)) {
            $post = array();
            
            // Loop through the full put array and return it
            foreach (array_keys($this->post) as $key) {
                $post[$key] = $this->_fetch_from_array($this->post, $key, $xss_clean);
            }
            return $post;
        }
        
        return $this->_fetch_from_array($this->post, $index, $xss_clean);
    }
    
    
    // --------------------------------------------------------------------
    
    
    /**
     * Fetch an item from the PUT array
     *
     * @access    public
     * @param    string
     * @param    bool
     * @return    string
     */
    function put($index = NULL, $xss_clean = FALSE)
    {
        // Check if a field has been provided
        if ($index === NULL AND !empty($this->put)) {
            $put = array();
            
            // Loop through the full put array and return it
            foreach (array_keys($this->put) as $key) {
                $put[$key] = $this->_fetch_from_array($this->put, $key, $xss_clean);
            }
            return $put;
        }
        
        return $this->_fetch_from_array($this->put, $index, $xss_clean);
    }
    
    
    // --------------------------------------------------------------------
    
    /**
     * Fetch an item from the DELETE array
     *
     * @access    public
     * @param    string
     * @param    bool
     * @return    string
     */
    function delete($index = NULL, $xss_clean = FALSE)
    {
        // Check if a field has been provided
        if ($index === NULL AND !empty($this->delete)) {
            $delete = array();
            
            // Loop through the full delete array and return it
            foreach (array_keys($this->delete) as $key) {
                $delete[$key] = $this->_fetch_from_array($this->delete, $key, $xss_clean);
            }
            return $delete;
        }
        
        return $this->_fetch_from_array($this->delete, $index, $xss_clean);
    }
    
    
    // --------------------------------------------------------------------
    
    /**
     * Extend Sanitize Data
     *
     * @access    private
     * @return    void
     */
    private function _sanitize_request(&$data)
    {
        //convert object to array
        $object = $data;
        $data   = array();
        
        //clean put variables
        foreach ($object as $key => $val) {
            if (!is_object($val))
                $data[$this->_clean_input_keys($key)] = $this->_clean_input_data($val);
        }
        
        log_message('debug', "Global PUT and DELETE data sanitized");
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Parse json request
     *
     * @access    private
     * @return    void
     */
    private function _parse_request(&$array)
    {
        //for now only json :(, will add more as they come up
        if ($this->server('CONTENT_TYPE') == "application/json" || $this->server('CONTENT_TYPE') == "application/json; charset=UTF-8") {
            $array = json_decode($array);
        } else {
            parse_str($array, $array);
        }
        
        $this->_sanitize_request($array);
    }
    
    // --------------------------------------------------------------------
    
}
// END MY_Input Class

/* End of file MY_Input.php */
/* Location: ./application/core/MY_Input.php */