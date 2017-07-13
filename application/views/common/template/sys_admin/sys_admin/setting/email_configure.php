<div class="grid_12 grid repair-database panel-padding">
	<legend><?php echo lang('Email_configure'); ?></legend>
	<form action="<?php echo site_url('dev/form_ajax'); ?>" method="POST" role="form" class="ajax validate panel-parent">
		<!-- <input type="hidden"  name="operation_action" value="db_repair_database">
		<input type="hidden"  name="db_validate_action" value="db_check_database">
		<span class="label">Enter your database name to confirm this action</span>
		<div class="form-group">
			<label for=""><?php echo lang('Database_name'); ?></label>
			<input type="text" name="db[default][database]" class="form-control uniform input-long" id="" placeholder="<?php echo placeholder('Database_name'); ?>">
		</div> -->
		<div class="form-group text-right">
			<input type="submit" class="submit-green uniform" name="" value="<?php echo lang('Save_change'); ?>">
		</div>
	</form>
</div>