<div class="grid_6 grid panel-padding">

	<form action="<?php echo site_url('dev/form_ajax'); ?>" method="POST" role="form" class="ajax validate">
		
		<div class="grid_12 grid">

			<legend><?php echo lang('Database_connection_setting'); ?></legend>
		
			<input type="hidden"  name="operation_action" value="change_db_connection">

			<input type="hidden"  name="before_operation_action" value="db_check_connection">

			<div class="row grid">

				<div class="grid_6">

					<label for=""><?php echo lang('Host_name'); ?></label>
					
					<input type="text" value="<?php echo @$db['default']['hostname'] ?>" name="db[default][hostname]" class="extra input-long uniform" id="hostname" placeholder="<?php echo placeholder('Host_name'); ?>">
				
				</div>
			
				<div class="grid_6">

					<label for=""><?php echo lang('Username'); ?></label>
					
					<input type="text" value="<?php echo @$db['default']['username'] ?>" name="db[default][username]" class="extra input-long uniform" id="username" placeholder="<?php echo placeholder('Username'); ?>">
				
				</div>

			</div>

			<div class="row grid">

				<div class="grid_6">

					<label for=""><?php echo lang('Password'); ?></label>

					<input type="password" value="<?php echo @$db['default']['password'] ?>" name="db[default][password]" class="extra input-long uniform" id="password" placeholder="<?php echo placeholder('Password'); ?>">
				
				</div>

				<div class="grid_6">

					<label for=""><?php echo lang('Database_name'); ?></label>

					<input type="text" value="<?php echo @$db['default']['database'] ?>" name="db[default][database]" class="extra input-long uniform" id="database" placeholder="<?php echo placeholder('Database_name'); ?>">
				
				</div>

			</div>

			<div class="row grid">

				<div class="grid_6">

					<label for=""><?php echo lang('Database_driver'); ?></label>

					<select  name="db[default][dbdriver]" id="database-driver" class="extra input-medium uniform" required="required">
						<?php
							foreach ($dbdriver as $key => $driver) {
						?>
								<option <?php if ($driver == $db['default']['dbdriver']) {
									echo "selected";
								} ?> value="<?php echo $driver; ?>"><?php echo $driver; ?></option>
						<?php
							}
						?>
					</select>
					
				</div>

				<div class="grid_6">
					<label for=""><?php echo lang('Table_prefix'); ?></label>
					<input type="text" value="<?php echo @$db['default']['dbprefix'] ?>" name="db[default][dbprefix]" class="extra input-long uniform" id="dbprefix" placeholder="<?php echo placeholder('Table_prefix'); ?>">
				</div>

			</div>
		
			<div class="text-right pull-right">

				<input type="submit" class="submit-green uniform" name="" value="<?php echo lang('Save_changes'); ?>">
				
			</div>

		</div>

	</form>

</div>

<div class="grid_6 grid panel-padding">

	<form action="<?php echo site_url('dev/form_ajax'); ?>" method="POST" role="form" class="ajax validate">
		
		<div class="grid_12 grid">

			<legend><?php echo lang('Database_info'); ?></legend>

		</div>

	</form>

</div>