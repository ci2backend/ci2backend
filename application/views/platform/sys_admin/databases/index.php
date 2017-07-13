<div class="grid_12">

    <div class="module">

        <h2 class="text-primary"><span><?php echo lang('Manage_database') ?></span></h2>
        
        <div class="module-body">

        	<div class="grid_6">

	        	<div class="grid_12">

		        	<div class="panel-padding grid full-width">

		        		<?php echo form_ajax('databases/rename', 'id="rename_db_form"') ?>

		        			<input type="hidden" name="db_old_name" value="<?php echo @$db['default']['database']; ?>">

		        			<legend><?php echo lang('Rename_database'); ?></legend>

						    <div class="form-group">

				    			<input id="db_new_name" placeholder="<?php echo placeholder('Database_name'); ?>" type="text" name="db_new_name" class="input-long uniform" value="">

				    		</div>

				    		<span class="notification n-attention">

				    			<?php echo lang('Rename_database_script_warning'); ?>

				    		</span>

						    <div class="form-group text-right">

				    			<input id="rename_db_input" type="submit" value="<?php echo lang('Change'); ?>" class="submit-green uniform pull-right">

				    		</div>

						<?php echo form_close(); ?>

		            </div>

	            </div>

            </div>

            <div class="grid_6">

	            <div class="grid_12">

		            <div class="panel-padding grid full-width">

		            	<?php echo form_ajax('databases/reset', 'id="reset_database_form"'); ?>
						    
						    <input type="hidden" name="db_collation" value="utf8_general_ci">

						    <input type="hidden" name="callback_function" value="required_login">

						    <legend><?php echo lang('Reset_data_table'); ?></legend>

						    <div class="form-group">
								        
						        <input id="reset_db" type="text" name="db[default][database]" placeholder="<?php echo placeholder('Database_name'); ?>" class="input-long uniform" value=""  data-require="true" data-message="Please input current database name">
						    
						    </div>

							<span class="notification n-attention"><?php echo lang('Repair_database_by_default_script_warning'); ?></span>
						    
						    <div class="form-group text-right">

						    	<input id="rename_prefix_input" type="submit" value="<?php echo lang('Change'); ?>" class="submit-green uniform pull-right">

						    </div>

						<?php echo form_close(); ?>

		            </div>

	            </div>

            </div>

        </div>

    </div>

</div>