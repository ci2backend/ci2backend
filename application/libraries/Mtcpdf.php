<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  	
  	if (ini_set('allow_url_include','off')) 
  	{
    	ini_set('allow_url_include','on');
	}
  	

  	// include(base_url().'assets/tcpdf/tcpdf.php');
   //  clearstatcache();
   //  var_dump(file_exists(base_url().'assets/tcpdf/tcpdf.php'));exit();

    class Mtcpdf
    {
	     function __construct()
	     {
          $this->__autoload();
	     }
	    

      function __autoload() 
      { 
        if(file_exists(base_url().'assets/tcpdf/tcpdf.php')) 
        {
            include_once(base_url().'assets/tcpdf/tcpdf.php'); 
        } 
        else 
        {
            include_once('assets/tcpdf/tcpdf.php');
        }
      }


    }

