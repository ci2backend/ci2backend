<div class="grid_12 grid panel-padding">
	
	<?php echo form_ajax('dev/system_configure'); ?>

		<div class="grid_6 grid">

			<legend><?php echo lang('Configure_system'); ?></legend>

			<input type="hidden"  name="operation_action" value="system_configure">

			<div class="row grid">

				<div class="grid_6">

					<label for=""><?php echo lang('Base_URL'); ?></label>

					<input type="text" value="<?php echo @$config['base_url']; ?>" name="config[base_url]" class="input-long extra uniform" id="charset" placeholder="<?php echo lang('Base_URL'); ?>">
				
				</div>

				<div class="grid_6">

					<label for=""><?php echo lang('Default_language'); ?></label>

						<select name="config[language]" id="language" class="input-long extra uniform" required="required">
							
							<?php

									if (isset($languages) && count($languages)) {

										foreach ($languages as $key => $lang) {

											if ($lang['lang_folder'] == $config['language']) {

												$selected = 'selected';

											}
											else {

												$selected = '';

											}
											
											if ($selected != '') {

												?>

													<option selected value="<?php echo @$lang['lang_folder'] ?>"><?php echo @$lang['lang_display'] ?></option>
												
												<?php

											}
											else {

												?>

													<option value="<?php echo @$lang['lang_folder'] ?>"><?php echo @$lang['lang_display'] ?></option>
												
												<?php

											}
										
										}

									}

								?>
							
						</select>

				</div>

			</div>

			<div class="row grid">

				<div class="grid_6">

					<label for=""><?php echo lang('Charset') ?></label>

					<input type="text" value="<?php echo @$config['charset']; ?>" name="config[charset]" class="input-long extra uniform" id="charset" placeholder="<?php echo lang('Charset') ?>">
				
				</div>

				<div class="grid_6">

					<label for=""><?php echo lang('Enable_hooks'); ?></label>

					<select name="config[enable_hooks]" id="language" class="input-long extra uniform" required="required">
						
						<?php

							foreach (array('FALSE', 'TRUE') as $key => $hook) {

								if ($key == $config['enable_hooks']) {

									$selected = 'selected';

								}
								else {

									$selected = '';

								}
								
								if ($selected != '') {

									?>

										<option selected value="<?php echo @$hook; ?>"><?php echo @$hook; ?></option>
									
									<?php

								}
								else {

									?>

										<option value="<?php echo @$hook; ?>"><?php echo @$hook; ?></option>
									
									<?php

								}
							
							}

						?>
						
					</select>

				</div>

			</div>

			<div class="row grid">

				<div class="grid_12">

					<label for=""><?php echo lang('Permitted_uri_chars'); ?></label>

					<input type="text" value="<?php echo @$config['permitted_uri_chars']; ?>" name="config[permitted_uri_chars]" class="input-long extra uniform" id="permitted_uri_chars" placeholder="<?php echo lang('Permitted_uri_chars') ?>">
				
				</div>

			</div>

			<div class="row grid">

				<div class="grid_6">

					<label for=""><?php echo lang('Set_log_level'); ?></label>

					<select name="config[log_threshold]" id="log_threshold" class="input-long extra uniform" required="required">
						
						<?php

						$log_threshold_arr = array(
							0 => 'Disables logging, Error logging TURNED OFF',
							1 => 'Error Messages (including PHP errors)',
							2 => 'Debug Messages',
							3 => 'Informational Messages',
							4 => 'All Messages'
						);

							foreach ($log_threshold_arr as $key => $log) {

								if ($key == $config['log_threshold']) {

									$selected = 'selected';

								}
								else {

									$selected = '';

								}
								
								if ($selected != '') {

									?>

										<option selected value="<?php echo @$key; ?>"><?php echo @$log; ?></option>
									
									<?php

								}
								else {

									?>

										<option value="<?php echo @$key; ?>"><?php echo @$log; ?></option>
									
									<?php

								}
							
							}

						?>
						
					</select>

				</div>

				<div class="grid_6">

					<label for=""><?php echo lang('Log_file'); ?></label>

					<input type="text" value="<?php echo @$config['log_path']; ?>" name="config[log_path]" class="input-long extra uniform" id="log_path" placeholder="<?php echo lang('Log_file') ?>">
				
				</div>

			</div>

		</div>

		<div class="grid_6 grid">

			<legend><?php echo lang('Session_setting'); ?></legend>

			<div class="row grid">

				<div class="grid_6">

					<label for=""><?php echo lang('Session_cookie_name'); ?></label>

					<input type="text" value="<?php echo @$config['sess_cookie_name']; ?>" name="config[sess_cookie_name]" class="input-long extra uniform" id="sess_cookie_name" placeholder="<?php echo lang('Session_cookie_name'); ?>">
				
				</div>

				<div class="grid_6">

					<label for=""><?php echo lang('Session_expiration'); ?></label>

					<input type="text" value="<?php echo @$config['sess_expiration']; ?>" name="config[sess_expiration]" class="input-long extra uniform" id="sess_expiration" placeholder="<?php echo lang('Session_expiration'); ?>">
				
				</div>

			</div>

			<div class="row grid">

				<div class="grid_6">

					<label for=""><?php echo lang('Session_expire_on_close'); ?></label>

					<select name="config[sess_expire_on_close]" id="sess_expire_on_close" class="input-long extra uniform" required="required">
						
						<?php

							foreach (array('FALSE', 'TRUE') as $key => $hook) {

								if ($key == $config['sess_expire_on_close']) {

									$selected = 'selected';

								}
								else {

									$selected = '';

								}
								
								if ($selected != '') {

									?>

										<option selected value="<?php echo @$hook; ?>"><?php echo @$hook; ?></option>
									
									<?php

								}
								else {

									?>

										<option value="<?php echo @$hook; ?>"><?php echo @$hook; ?></option>
									
									<?php

								}
							
							}

						?>
						
					</select>

				</div>

				<div class="grid_6">

					<label for=""><?php echo lang('Session_encrypt_cookie'); ?></label>

					<select name="config[sess_encrypt_cookie]" id="sess_encrypt_cookie" class="input-long extra uniform" required="required">
						
						<?php

							foreach (array('FALSE', 'TRUE') as $key => $hook) {

								if ($key == $config['sess_encrypt_cookie']) {

									$selected = 'selected';

								}
								else {

									$selected = '';

								}
								
								if ($selected != '') {

									?>

										<option selected value="<?php echo @$hook; ?>"><?php echo @$hook; ?></option>
									
									<?php

								}
								else {

									?>

										<option value="<?php echo @$hook; ?>"><?php echo @$hook; ?></option>
									
									<?php

								}
							
							}

						?>
						
					</select>

				</div>

			</div>

			<div class="row grid">

				<div class="grid_6">

					<label for=""><?php echo lang('Session_use_database'); ?></label>

					<select name="config[sess_use_database]" id="sess_use_database" class="input-long extra uniform" required="required">
						
						<?php

							foreach (array('FALSE', 'TRUE') as $key => $hook) {

								if ($key == $config['sess_use_database']) {

									$selected = 'selected';

								}
								else {

									$selected = '';

								}
								
								if ($selected != '') {

									?>

										<option selected value="<?php echo @$hook; ?>"><?php echo @$hook; ?></option>
									
									<?php

								}
								else {

									?>

										<option value="<?php echo @$hook; ?>"><?php echo @$hook; ?></option>
									
									<?php

								}
							
							}

						?>
						
					</select>

				</div>

				<div class="grid_6">

					<label for=""><?php echo lang('Session_table_name'); ?></label>

					<input type="text" value="<?php echo @$config['sess_table_name']; ?>" name="config[sess_table_name]" class="input-long extra uniform" id="charset" placeholder="<?php echo lang('Session_table_name'); ?>">
				
				</div>

			</div>

			<div class="row grid">

				<div class="grid_6">

					<label for=""><?php echo lang('Session_match_IP'); ?></label>

					<select name="config[sess_match_ip]" id="sess_match_ip" class="input-long extra uniform" required="required">
						
						<?php

							foreach (array('FALSE', 'TRUE') as $key => $hook) {

								if ($key == $config['sess_match_ip']) {

									$selected = 'selected';

								}
								else {

									$selected = '';

								}
								
								if ($selected != '') {

									?>

										<option selected value="<?php echo @$hook; ?>"><?php echo @$hook; ?></option>
									
									<?php

								}
								else {

									?>

										<option value="<?php echo @$hook; ?>"><?php echo @$hook; ?></option>
									
									<?php

								}
							
							}

						?>
						
					</select>

				</div>

				<div class="grid_6">

					<label for=""><?php echo lang('Session_match_Useragent'); ?></label>

					<select name="config[sess_match_useragent]" id="sess_match_useragent" class="input-long extra uniform" required="required">
						
						<?php

							foreach (array('FALSE', 'TRUE') as $key => $hook) {

								if ($key == $config['sess_match_useragent']) {

									$selected = 'selected';

								}
								else {

									$selected = '';

								}
								
								if ($selected != '') {

									?>

										<option selected value="<?php echo @$hook; ?>"><?php echo @$hook; ?></option>
									
									<?php

								}
								else {

									?>

										<option value="<?php echo @$hook; ?>"><?php echo @$hook; ?></option>
									
									<?php

								}
							
							}

						?>
						
					</select>

				</div>

			</div>

			<div class="row grid">

				<div class="grid_12">

					<label for=""><?php echo lang('Session_time_to_update'); ?></label>

					<input type="text" value="<?php echo @$config['sess_time_to_update']; ?>" name="config[sess_time_to_update]" class="input-long extra uniform" id="sess_time_to_update" placeholder="<?php echo lang('Session_time_to_update'); ?>">
				
				</div>

			</div>

			<div class="row grid">

				<div class="grid_12 text-right">

					<input type="submit" class="submit-green uniform" name="" value="<?php echo lang('Save_changes'); ?>">

				</div>

			</div>

		</div>

	</form>

</div>