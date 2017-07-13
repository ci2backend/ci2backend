<div class="panel-padding full-width grid_12 grid">

	<legend>Change language</legend>

        <div class="grid_12 grid">

        	<?php echo form_ajax('users/change_language'); ?>

        		<div class="form-group grid_6">
				   	
			      	<label for="lang_folder"><?php echo lang('Choose_a_language'); ?> :</label>

				    <select name="lang_folder" id="lang_folder" class="input-medium uniform">

				    	<?php

				    		if (isset($languages) && count($languages)) {

				    			foreach ($languages as $key => $row) {
				    			
				    		?>

				    				<?php if ($row['lang_folder'] == $user['lang_folder']): ?>

				    					<option selected value="<?php echo @$row['lang_folder']; ?>"><?php echo @$row['lang_display']; ?></option>

				    				<?php else: ?>

				    					<option value="<?php echo @$row['lang_folder']; ?>"><?php echo @$row['lang_display']; ?></option>

				    				<?php endif ?>

				    		<?php

				    			}

				    		}

				    	?>

				    </select>

			   	</div>

        	<?php echo form_close(); ?>

        </div>

</div>