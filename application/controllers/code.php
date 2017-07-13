<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Code extends MY_Controller
{

	public function __construct() {

		parent::__construct();

		$this->load->extension(array('bootstrap3', 'font-awesome4.5'));

	}

	public function eval_php()
	{

		error_reporting(-1);

		ini_set('display_errors', 'on');

		header('Content-Type: text/html; charset=utf-8');

		if (isset($_POST['code']) === true) {

		    $code = (string) $_POST['code'];

		    $mode = (string) $_POST['mode'];

		    // remove PHP start and end tags
		    $code = preg_replace('/^<\?php(.*)(\?>)?$/s', '$1', $code);

		    $code = trim($code);

		    // output buffered evaluation
		    ob_start();

		    eval($code);

		    $buffer = ob_get_clean();

		    // error handling
		    $error = error_get_last();

		    if($error > 0) {

		        // errors contains: type, message, file, line
		        // now we add the error "type" as "error" with a friendly error name
		        $error['error'] = $this->getErrorName($error['type']);

		        $jsonError = json_encode($error, true);
		        /* Send the error
		           - name as text/html (to the codemirror-result area)
		           - array as json via header
		         */
		        echo strtoupper($error['error']);

		        header('Z-Error: '. $jsonError);

		    } else {

		        echo $buffer;

		    }

		}

	}

	function getErrorName($errorInt) {

	    $errortypes = array(
	        E_ERROR           => 'error',
	        E_WARNING         => 'warning',
	        E_PARSE           => 'parsing error',
	        E_NOTICE          => 'notice',
	        E_CORE_ERROR      => 'core error',
	        E_CORE_WARNING    => 'core warning',
	        E_COMPILE_ERROR   => 'compile error',
	        E_COMPILE_WARNING => 'compile warning',
	        E_USER_ERROR      => 'user error',
	        E_USER_WARNING    => 'user warning',
	        E_USER_NOTICE     => 'user notice'
	    );

	    return $errortypes[$errorInt];

	}

	/**
	 * Fetch and display records
	 * @return void
	 */
	public function index() {

		$this->render($this->data['platform'], 'code/upload_view');

	}

	/**
	 * Insert or update a record
	 * @param int $id Defaults to NULL
	 * @return void
	 */
	public function edit($id = NULL) {

	}

	/**
	 * Delete a record
	 * @param int $id
	 * @return void
	 */
	public function delete($id) {

	}

}