<?php
	include_once 'setup/processing.php';
?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Codeigniter Backend System Setting</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="./assets/extensions/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="./assets/extensions/bootstrap/dist/css/bootstrap-theme.css">
		<link rel="stylesheet" href="./assets/extensions/uniform/css/themes/default/css/uniform.default.css">
		<link rel="stylesheet" href="setup/css/customize.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="setup/lib/lib/html5shiv.min.js"></script>
			<script src="setup/lib/lib/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>

		<?php if (isset($_GET['success']) && $_GET['success'] == 2){
			?>
			<div class="container">
				<div class="row">
					<h3 class="center"> Setting Codeigniter Backend system successfully</h3>
					Setup folder should be deleting
					<form action="install.php" method="post" accept-charset="utf-8">
						<legend>Confirmation setting</legend>
				 		<input type="hidden" name="setup-system-success" id="input" class="form-control" value="1">
				 		<a href="index.php" title="Skip delete install folder">Skip delete</a>
				 		<button type="submit" class="btn btn-primary pull-right">Finish</button>
					</form>
				</div>
			</div>
			<?php
		}
		else {

			?>
			<div class="container">

				<h2 class="center"> <img width="50" src="./setup/img/setup-gear.png" alt=""> Codeigniter Backend System Setting</h2>

				<h4 class="panel-body bg-info text-center">Welcome to the initial setting page of Codeigniter Backend System!</h4>

				<div class="panel panel-primary">

				    <div class="panel-heading">

				        <h3 class="panel-title">Required components</h3>

				    </div>

				    <div class="panel-body">

				    	<ul class="list-unstyled">

						<?php

							$enabledPhpModule = apache_get_modules();

							$modRewrite = in_array('mod_rewrite', $enabledPhpModule);

							$check = array(
								// check PHP required version
								array(
									'type' => 'version',
									'name' => phpversion(), 
									'value' => version_compare(phpversion(), '5.1.6'), 
								),
								// check PHP required modules
								array(
									'type' => 'module',
									'name' => 'mod_rewrite', 
									'value' => $modRewrite, 
								),
								array(
									'type' => 'module',
									'name' => 'mod_php5', 
									'value' => in_array('mod_php5', $enabledPhpModule), 
								),
								array(
									'type' => 'module',
									'name' => 'mod_ssl', 
									'value' => extension_loaded('openssl'), 
								),
								array(
									'type' => 'module',
									'name' => 'php_mbstring', 
									'value' => extension_loaded('mbstring'), 
								),
								//check folder permission
								array(
									'type' => 'directory',
									'name' => 'root', 
									'value' => is_writable('./'), 
								),
								array(
									'type' => 'directory',
									'name' => '/temp', 
									'value' => is_writable('./temp'), 
								),
								array(
									'type' => 'directory',
									'name' => '/database', 
									'value' => is_writable('./database'), 
								),
								array(
									'type' => 'directory',
									'name' => '/application/config', 
									'value' => is_writable('./application/config'), 
								)
							);

							foreach ($check as $checkKey => $checkValue) {

								if ($checkValue['type'] == 'version') {

									if ($checkValue['value'] >= 0) {

										echo '<li class="col-sm-6"><p class="text-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Your version of PHP is <strong>'.$checkValue['name'].'</strong>. The required PHP version is 5.1.6 or higher.</p></li>';

									} else {

										echo '<li class="col-sm-6"><p class="text-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Your version of PHP is <strong>'.$checkValue['name'].'</strong>. The required PHP version is 5.1.6 or higher.</p></li>';

									}

								} elseif ($checkValue['type'] == 'module') {

									if ($checkValue['value']) {

										echo '<li class="col-sm-6"><p class="text-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Module <strong>'.$checkValue['name'].'</strong> is enabled.</p></li>';

									} else {

										echo '<li class="col-sm-6"><p class="text-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Module <strong>'.$checkValue['name'].'</strong> is disabled.</p></li>';

									}

								} else {

									if ($checkValue['value']) {

										echo '<li class="col-sm-6"><p class="text-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> The <strong>'.$checkValue['name'].'</strong> directory is writable.</p></li>';

									} else {

										echo '<li class="col-sm-6"><p class="text-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> The <strong>'.$checkValue['name'].'</strong> directory is not writable.</p></li>';

									}

								}

							}

						?>

						</ul>

					</div>

				</div>

				<div class="panel panel-primary">

				    <div class="panel-heading">

				        <h3 class="panel-title">General setting</h3>

				    </div>

				    <div class="panel-body">
			 	
					 	<form action="install.php" id="installForm" method="POST" role="form" name="setup-system-form">

					 		<div class="row">

					 			<div class="col-sm-6">

					 				<legend>Site</legend>

						 			<div class="col-md-8">
						 				
						 				

								 		<input type="hidden" name="setup-system" id="input" class="form-control" value="1">
								 		<div class="panel-body">
									 		<div class="form-group">
									 			<label for="">Base URL: </label>
									 			<input type="text" name="config[base_url]" value="<?php echo @$_POST['config']['base_url']?$_POST['config']['base_url']:hostname(); ?>" class="form-control uniform" id="" placeholder="Enter base url">
									 		</div>

									 		<div class="form-group">
									 			<label for="">Encryption key: </label>
									 			<input type="text" name="config[encryption_key]" value="<?php echo @$_POST['config']['encryption_key']?$_POST['config']['encryption_key']:generateRandomString(); ?>" class="form-control uniform" id="" placeholder="Enter your key">
									 		</div>
								 		</div>

						 			</div>

						 			<legend>Security</legend>

						 			<div class="col-md-8">
						 					
						 				

						 				<?php 

						 					if (!$modRewrite) {

						 						echo '<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> <strong>mod_rewrite</strong> module needs to be enabled to use these options below</p>';

						 					}

						 				?>
						 				
						 				<fieldset <?php echo $modRewrite ? '' : 'disabled'; ?> >
						 					
									 		<div class="form-group">
									 			<div class="checkbox">
									 				<label>
									 					<input type="checkbox" name="global[htaccess][value]" value="1">
									 					Enable .htaccess
									 				</label>
									 			</div>
									 		</div>

									 		<div class="form-group">
									 			<div class="checkbox">
									 				<label>
									 					<input type="checkbox" name="global[htpassword][value]" value="1">
									 					Enable .htpassword (Enter content encrypt code)
									 				</label>
									 			</div>
									 			<div class="panel-body">
									 			<textarea name="global[htpassword][content]" class="form-control custom-control"></textarea>
									 		</div>
									 		</div>
								 		</fieldset>

						 			</div>

						 		</div>

					 			<div class="col-sm-6">
					 				
					 				<legend>Database</legend>

					 				<div class="col-sm-8">

						 				<div class="panel-body">

									 		<div class="form-group">
									 			<label for="">Host name: </label>
									 			<input type="text" name="db[default][hostname]" value="<?php echo @$_POST['db']['default']['hostname']; ?>" class="form-control" id="" placeholder="Enter host name">
									 		</div>

									 		<div class="form-group">
									 			<label for="">Username: </label>
									 			<input type="text" name="db[default][username]" value="<?php echo @$_POST['db']['default']['username']; ?>" class="form-control" id="" placeholder="Enter username">
									 		</div>

									 		<div class="form-group">
									 			<label for="">Password: </label>
									 			<input type="password" name="db[default][password]" value="<?php echo @$_POST['db']['default']['password']; ?>" class="form-control" id="password" placeholder="Enter Password">
									 		</div>

									 		<div class="form-group">
									 			<label for="">Confirm Password: </label>
									 			<input type="password" name="db[default][confirmPassword]" value="" class="form-control" id="configPassword" placeholder="Enter Confirm Password">
									 		</div>
									 		
									 		<div class="form-group">
									 			<label for="">Database name: </label>
									 			<input type="text" name="db[default][database]" value="<?php echo @$db['default']['database']; ?>" class="form-control" id="" placeholder="Enter database name">
									 		</div>

								 		</div>

							 		</div>

					 			</div>

					 		</div>

					 		<div class="col-xs-12 col-md-12 col-lg-12 text-right">

					 			<button type="submit" class="btn btn-primary">Install</button>

					 		</div>

					 	</form>

					</div>

				</div>

			</div>
			<?php
		}?>
		<div class="modal fade" id="error-handle">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		        <h4 class="modal-title">Install status</h4>
		      </div>
		      <div class="modal-body">
		      	<div class="alert alert-danger">
		      		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		      		<strong>Title!</strong> Alert body ...
		      	</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <a href="install.php?success=2" class="btn btn-primary" title="OK, Go to site">OK, Go to site</a>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!-- jQuery -->
		<script src="./assets/extensions/jquery/dist/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="./assets/extensions/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="./assets/extensions/jquery-validation/dist/jquery.validate.js"></script>
		<script src="./assets/extensions/uniform/jquery.uniform.js"></script>
		<script src="./assets/extensions/uniform/js/script.js"></script>
		<script src="setup/js/install.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	</body>
</html>

