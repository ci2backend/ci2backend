<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*Ajax controller
*Description: ajax common function
*@author Phu_tv
*/
Class Ajax extends MY_Controller {

	private $extClass;

	function __construct() {

		parent::__construct($extClass = null);

		if (!$this->input->is_ajax_request()) {

			show_error(lang('Not_allowed_access_with_current_method'));

		}

		if ($extClass) {

			$this->{$extClass} = $this->load->controller($extClass, false);

			$this->extClass = $this->{$extClass};

		}
		else {

			$arguments = $this->uri->segments;

			unset($arguments[1]);

			unset($arguments[2]);

			if ( ! is_callable(array($this, $this->router->method))) {

	            throw new InvalidArgumentException(lang('Callback_needs_to_be_a_function'));

	        }
	        else {

	        	$data = call_user_func(array($this, $this->router->method), $arguments);

	            $this->ajax_response($data);

	        }

		}

	}

	public function __call($methodName, $arguments)
    {

    	if ($this->extClass) {

    		if (is_callable(array($this->extClass, $methodName))) {

	            $data = call_user_func(array($this->extClass, $methodName), $arguments);

	            $this->ajax_response($data);

	        }
	        else {

	            $class = get_class($this->extClass);

	            $error = sprintf($this->lang->line('No_callable_method_methodName_at_class_class'), $methodName, $class);

	            throw new \BadMethodCallException($error);

	        }

    	}

    }

    protected function ajax_response($data = '')
    {

    	if ($data) {

    		$this->response_message($data);

    	}
    	else{

    		$this->response_message($this->response);

    	}

    }

	public function index()
	{

		return $this->response;

	}

	protected function load_method_by_control_name($control='')
	{

		$control = $control ? $control[3] : $this->uri->segments(3);

		$control = is_array($control) ? $control[3] : $control;

		if ($control) {

			$data = $this->get_all_method_of_class($control, 0);

	        if(($key = array_search('__construct', $data)) !== false) {
	        	
			    unset($data[$key]);
			    
			}

			$this->response->data['controller'] = $control;

			$this->response->data['action'] = $data;

		}

		$this->response->success = 1;

	}

}