<?php
/**
* 
*/
class Site_map
{

	var $active_index = 0;

	var $breadcrumb = null;

	var $parent = null;

	function __construct() {
		
	}

	public function get_map($key_map)
	{

		$CI =& get_instance();

		$CI->load->library('breadcrumbs');

		$parent = array(

			array('url' => '/users/dashboard', 'value' => 'Admin CPanel'),

			array('url' => '/users/daily', 'value' => 'Traffic Statistics'),

			array('url' => '/users/daily', 'value' => 'Visitors Site'),

			array('url' => '/users/daily', 'value' => ' Storage Upload'),

			array('url' => '/users/daily', 'value' => 'Database'),

			array('url' => '/users/daily', 'value' => 'Email Contact'),

			array('url' => '/users/daily', 'value' => 'Logout'),

		);

		$breadcrumb = array('dashboard' => array(array('url' => '/users/dashboard', 'value' => 'Dashboard', 'parent_index' => 0)),

			'profile' => array(array('url' => '/users/profile', 'value' => 'My Profile', 'parent_index' => 0)),

			'daily' => array(array('url' => '/users/daily', 'value' => 'Daily', 'parent_index' => 1)),

			'weekly' => array(array('url' => '/users/weekly', 'value' => 'Weekly', 'parent_index' => 1)),

			'monthly' => array(array('url' => '/users/monthly', 'value' => 'Monthly', 'parent_index' => 1)),

			'more_year' => array(array('url' => '/users/more_year', 'value' => 'More year ago', 'parent_index' => 1)),

			'visitor_upload' => array(array('url' => '/users/visitor_upload', 'value' => 'Visitors Upload', 'parent_index' => 2)),

			'visitor_download' => array(array('url' => '/users/visitor_download', 'value' => 'Visitors Download', 'parent_index' => 2)),

			'browser' => array(array('url' => '/users/browser', 'value' => 'Browser Statistics', 'parent_index' => 2)),

			'initialize_storage' => array(array('url' => '/users/initialize_storage', 'value' => 'Initializing Storage', 'parent_index' => 3)),

			'db_statistics' => array(array('url' => '/users/db_statistics', 'value' => 'Database Statistics', 'parent_index' => 3)),

			'db_backup' => array(array('url' => '/users/db_backup', 'value' => 'Backup Database', 'parent_index' => 3)),

			'restore_db' => array(array('url' => '/users/restore_db', 'value' => 'Restore Database', 'parent_index' => 3)),

			'db_log_activity' => array(array('url' => '/users/db_log_activity', 'value' => 'History', 'parent_index' => 3)),

			'email_contact' => array(array('url' => '/users/email_contact', 'value' => 'Admin Reply', 'parent_index' => 4)),

			'email_contact_messengers' => array(array('url' => '/users/email_contact_messengers', 'value' => 'Admin Reply', 'parent_index' => 4)),
			 
			'email_contact_messengers' => array(array('url' => '/users/email_contact_messengers', 'value' => 'Email Messengers Contact', 'parent_index' => 3))
			
		);

		$this->active_index = 0;

		$i = 0;

		foreach ($breadcrumb as $key => $value) {

			$i++;

			if ($key_map == $key) {

				$this->active_index = $breadcrumb[$key][0]['url'];

				$bre_parent = $parent[$breadcrumb[$key][0]['parent_index']];

				$this->breadcrumbs->push($bre_parent['value'] , site_url($bre_parent['url']));

		        // add breadcrumbs
		        $this->breadcrumbs->push($breadcrumb[$key][0]['value'] , site_url($breadcrumb[$key][0]['url']));

		        // unshift crumb

		        $this->breadcrumbs->unshift('Home', site_url('/admin') );

		        // output
		        // echo $this->breadcrumbs->show();exit();

				break;

			}

		}

		return $breadcrumb[$key];

	}

	public function get_index()
	{

		return $this->active_index;

	}



}

?>