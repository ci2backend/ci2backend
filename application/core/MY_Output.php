<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Generic MY_Output for entity class, CI AR.
 * @author PhuTv
 *
 */
class MY_Output extends CI_Output {
	public function __construct() {

		parent::__construct();

	}

    public function nocache()
    {

        $this->set_header('Cache-Control: no-cache');

    	// Set header for iframe
    	$this->set_header('P3P: CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

    }

}