<?php

if (isset($_POST['setup-system-success'])) {
	@unlink('install.php');
	$dirPath = getcwd().'/setup';
    deleteDirectory($dirPath);
	header("Location: index.php");
}

function deleteDirectory($dirPath)
{
	if (is_dir($dirPath)) {
        $objects = scandir($dirPath);
        foreach ($objects as $object) {
            if ($object != "." && $object !="..") {
                if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
                    deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
                } else {
                    unlink($dirPath . DIRECTORY_SEPARATOR . $object);
                }
            }
        }
	    reset($objects);
	    rmdir($dirPath);
	}
}
if (isset($_POST['setup-system'])) {
	$responseData = array(
		'error' => 0,
		'message' => array()
	);
	if (isset($_POST['db'])) {
		error_reporting(0);
		$server = @$_POST['db']['default']['hostname'];
		$username = @$_POST['db']['default']['username'];
		$password = @$_POST['db']['default']['password'];
		$dbname = @$_POST['db']['default']['database'];
		$db = new mysqli($server, $username, $password, $dbname);
		if (mysqli_connect_errno()) {
			$responseData['error'] = 1;
			array_push($responseData['message'], array(
				'title' => 'Database connection',
				'type' => 'danger',
				'content' => "Database connect fail. Please check your information"
			));
			echo json_encode($responseData); exit();
		}
		else {
			array_push($responseData['message'], array(
				'title' => 'Database connection',
				'type' => 'success',
				'content' => "Database connection successfully"
			));
		}
	}
	$success = 0;
	if (detectCGI() == false && isset($_POST['global']['htaccess']['value']) && $_POST['global']['htaccess']['value'] == 1) {
		$result = file_put_contents('../.htaccess', @file_get_contents('../.htaccess.default')); /* over write original with changes made */
		if ($result) {
			array_push($responseData['message'], array(
				'title' => 'Create .htaccess file',
				'type' => 'success',
				'content' => "Create .htaccess file successfully"
			));
		}
		else{
			array_push($responseData['message'], array(
				'title' => 'Create .htaccess file',
				'type' => 'warning',
				'content' => "Can't create .htaccess file"
			));
		}
	}
	if (isset($_POST['global'])) {
		if (detectCGI() == false && isset($_POST['global']['htpassword']['value']) && $_POST['global']['htpassword']['value'] == 1) {
			@file_put_contents('../.htpasswd', $_POST['global']['htpassword']['content']); /* over write original with changes made */
			if (is_file(('../.htpasswd'))) {
				array_push($responseData['message'], "Create .htpasswd file successfully");
				$result = file_put_contents('../.htaccess', @file_get_contents('../.htaccess.default')."\n ".'AuthType Basic'."\n".'AuthName "Restricted Access"'."\n".'AuthUserFile .htpasswd');
				if ($result) {
					array_push($responseData['message'], array(
						'title' => 'Update .htaccess file',
						'type' => 'success',
						'content' => "Update .htaccess file successfully"
					));
				}
				else{
					array_push($responseData['message'], array(
						'title' => 'Update .htaccess file',
						'type' => 'warning',
						'content' => "Can't update .htaccess file"
					));
				}
			}
			else{
				array_push($responseData['message'], array(
					'title' => 'Write .htpasswd file',
					'type' => 'warning',
					'content' => "Can't create .htpasswd file"
				));
			}
		}
	}
	if (isset($_POST['db'])) {
		$folder = "../application/config/";
		$originalFile = $folder."database.default.php"; /* original file */
		$sourceFile = $folder."database.php"; /* original file */
		$haystack = @file(($originalFile)); /* put contents into an array */
		foreach ($_POST['db']['default'] as $key => $db) {
			$replace = '$db[\'default\'][\''.$key.'\'] = ';
			$replaceWith = $replace . '\'\'';
			$replaceBy = $replace . '\''.$db.'\'';
			for($i=0;$i<count($haystack);$i++) {
				$haystack[$i] = str_ireplace($replaceWith, $replaceBy, $haystack[$i]); /* case insensitive replacement */
			}
		}
		$content = implode("", $haystack); /* put array into one variable with newline as delimiter */
		$dir_writable = substr((int)sprintf('%o', fileperms($folder)), -4) >= 774 ? "true" : "false";
		if ($dir_writable) {
			@file_put_contents(($sourceFile), $content); /* over write original with changes made */
			$success++;
			array_push($responseData['message'], array(
					'title' => 'Write database file',
					'type' => 'success',
					'content' => "Save database config successfully"
				));
		}
		else {
			$responseData['error'] = 1;
			array_push($responseData['message'], array(
				'title' => 'Write database file',
				'type' => 'warning',
				'content' => "Permission denied. ". $folder ."  must writable!!!"
			));
		}
	}
	if (isset($_POST['config'])) {
		$folder = "../application/config/";
		$originalFile = $folder."config.default.php"; /* original file */
		$sourceFile = $folder."config.php"; /* original file */
		$haystack = @file(($originalFile)); /* put contents into an array */

		foreach ($_POST['config'] as $key => $config) {
			$replace = '$config[\''.$key.'\']'."\t".'= ';
			$replaceWith = $replace . '\'\'';
			$replaceBy = $replace . '\''.$config.'\'';
			for($i=0;$i<count($haystack);$i++) {
				$haystack[$i] = str_ireplace($replaceWith, $replaceBy, $haystack[$i]); /* case insensitive replacement */
			}
		}

		$content = implode("\n", $haystack); /* put array into one variable with newline as delimiter */
		$dir_writable = substr((int)sprintf('%o', fileperms($folder)), -4) >= 774 ? "true" : "false";
		if ($dir_writable) {
			@file_put_contents(($sourceFile), $content); /* over write original with changes made */
			$success++;
			if (is_file(($sourceFile))) {
				array_push($responseData['message'], array(
					'title' => 'Create system config',
					'type' => 'success',
					'content' => "Save system config successfully"
				));
			}
			else {
				array_push($responseData['message'], array(
					'title' => 'Create system config',
					'type' => 'warning',
					'content' => "Can't create system config file".$sourceFile
				));
			}
		}
		else {
			array_push($responseData['message'], array(
				'title' => 'Create system config',
				'type' => 'warning',
				'content' => "Permission denied. ". $folder ."  must writable!!!"
			));
		}
	}
	
	@file_put_contents('../index.php', @file_get_contents('../index.default.php'));
	$server = @$_POST['db']['default']['hostname'];
	$username = @$_POST['db']['default']['username'];
	$password = @$_POST['db']['default']['password'];
	$dbname = @$_POST['db']['default']['database'];
	$dbprefix = @$_POST['db']['default']['dbprefix'];
	$db = new mysqli($server, $username, $password, $dbname);
	if (isset($db)) {
		$sql = "SHOW TABLES FROM $dbname";
		$result = $db->query($sql);
		if ($result && $result->num_rows) {
			$drop = "DROP DATABASE $dbname;";
			$create = " CREATE DATABASE $dbname;";
			$result_drop = $db->query($drop);
			$result_create = $db->query($create);
			if ($result_create && $result_drop) {
				importSQL($db, '../database/base-database.sql', $responseData['message']);
				importSQL($db, '../database/change_scripts.sql', $responseData['message']);
			}
		}
		else {
			importSQL($db, '../database/base-database.sql', $responseData['message']);
			importSQL($db, '../database/change_scripts.sql', $responseData['message']);
		}
		if (isset($dbprefix) && $dbprefix != '') {
			$sql = "SHOW TABLES FROM $dbname";
			$result = $db->query($sql);
			if ($result && $result->num_rows) {
				/* fetch object array */
			    while ($row = $result->fetch_row()) {
			        $old_name = $row[0];
			        $new_name = $dbprefix . '_' . $row[0];
					$str ="RENAME TABLE $old_name TO $new_name;";
					$db->query($str);
			    }
			    /* free result set */
			    $result->close();
			}
		}
	}
	echo json_encode($responseData); exit();
}

function importSQL($connect, $filename='', &$message)
{
	// Temporary variable, used to store current query
	$templine = '';
	// Read in entire file
	$lines = file(($filename));
	// Loop through each line
	foreach ($lines as $line) {
		// Skip it if it's a comment
		if (substr($line, 0, 2) == '--' || $line == '')
		    continue;

		// Add this line to the current segment
		$templine .= $line;
		// If it has a semicolon at the end, it's the end of the query
		if (substr(trim($line), -1, 1) == ';') {
		    // Perform the query
		    mysqli_query($connect, $templine) or array_push($message, array(
		    	'title' => 'Execute SQL command',
		    	'type' => 'danger',
		    	'content' => ('Error performing query \'<strong style="word-wrap: break-word;">' . $templine . '\': ' . mysql_error() . '<br /><br />')
		    ));
		    // Reset temp variable to empty
		    $templine = '';
		}
	}
}
function generateRandomString($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function hostname(){
    $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
	if ($_SERVER["SERVER_PORT"] != "80") {
	    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} 
	else {
	    $pageURL .= $_SERVER["SERVER_NAME"];
	}
	return $pageURL;
}

function detectCGI() {

	if (strpos(PHP_SAPI, 'cgi') !== FALSE) {
		
	    return true;
	    
	} else {

	    return false;
	    
	}

}

?>