<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";

$route['404_override'] = '';

include 'database.php';

if (isset($db)) {

	$connect = @mysqli_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password']);

	if ($connect) {

		$dbname = $db['default']['database'];

		mysqli_query($connect, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

		if (@mysqli_select_db($connect, $dbname)) {
			
			$test_query = "SELECT * FROM `".$db['default']['dbprefix']."routers`";

			$result = mysqli_query($connect, $test_query);

			$tblCnt = 0;

			while($tbl = @mysqli_fetch_array($result)) {

				$key = $tbl['router_key'];

				$link = $tbl['router_value'];

			  	$route[$link] = $key;

			  	$route[urlencode($link)] = $key;

			}

		}

	}

}


/* End of file routes.php */
/* Location: ./application/config/routes.php */