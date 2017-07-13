<?php
/**
* FolderFinder
*/
class FolderFinder
{

	var $connector;
	var $options = array(
		// 'debug' => true,
		'roots' => array(
			array(
				'driver'        =>  'LocalFileSystem',           // driver for accessing file system (REQUIRED)
				'systemRoot'    =>  null,
				'path'          =>  'assets/extensions/uniform',                 // path to files (REQUIRED)
				'URL'           =>  'assets/extensions/uniform', // URL to files (REQUIRED)
				'uploadDeny'    =>  array('all'),                // All Mimetypes not allowed to upload
				'uploadAllow'   =>  array(
										'image',
										'text/plain',
										'inode/x-empty',
						        		'text/html',
						        		'application/xhtml+xml',
						        		'text/javascript',
						        		'application/javascript',
						        		'text/json',
						        		'application/json',
						        		'text/x-php',
						        		'application/x-php',
						        		'text/css',
						        		'text/xml',
				                        'application/docbook+xml',
				                        'application/xml'
									),// Mimetype `image` and `text/plain` allowed to upload
				'uploadOrder'   => 	array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
				'accessControl' => 	'access',                     // disable and hide dot starting files (OPTIONAL)
				"defaults"    => array(
				    "read"        => true,
				    "write"       => true,
				    "rm"          => true
				),
			)
		)
	);

	function __construct($options = null)
	{

		if ($options) {

			$this->setOption();

		}
		
	}

	function setOption($options)
	{
		$this->options = $options;
	}

	function setDirectory($value='')
	{
		$this->options['roots'][0]['URL'] = $value;
	}

	function setPath($value='')
	{
		$this->options['roots'][0]['path'] = $value;
	}

	function init()
	{

		if ($this->options) {

			$_GET['elFinderOptions'] = $this->options;

			// elFinder autoload
			require 'FolderFinder/php/autoload.php';

			$this->connector = require("FolderFinder/php/connector.handle.php");

		}

	}

	function run()
	{

		if ($this->connector) {

			return $this->connector->run();

		}

	}
}
?>