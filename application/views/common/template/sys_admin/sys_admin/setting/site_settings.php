<div class="grid_6">

	<div class="panel-padding grid full-width">

		<?php echo form_ajax('dev/default_controller'); ?>
			
			<div class="grid_12 grid">

				<legend><?php echo lang('Platform_settings'); ?></legend>

				<div class="form-group">
					
					<label for="input" class="col-md-5 grid_5 control-label"><?php echo lang('Default_controller'); ?>:</label>
					
					<div class="col-md-7 grid_7">

						<select name="route[default_controller]" id="default_controller" class="uniform grid_12" required="required">
						
							<?php

								if (isset($controllers) && count($controllers)) {

									foreach ($controllers as $key => $control) {

										if ($control == $route['default_controller']) {

											$selected = 'selected';

										}
										else {

											$selected = '';

										}

										if ($selected != '') {

											?>

												<option selected value="<?php echo base64_encode(@$control); ?>"><?php echo @$control ?></option>
											
											<?php

										}
										else {

											?>

												<option value="<?php echo base64_encode(@$control); ?>"><?php echo @$control ?></option>
											
											<?php

										}
									
									}

								}

							?>
							
						</select>

					</div>

				</div>

			</div>

			<div class="grid grid_12">

				<span class="notification n-attention"><?php echo lang('Default_controller_warning'); ?></span>

			</div>

			<div class="grid form-group text-right">

				<input class="submit-green uniform" type="submit" value="<?php echo lang('Save_change'); ?>">

			</div>
			
		<?php echo form_close(); ?>

	</div>

	<div class="panel-padding grid full-width">

		<?php echo form_ajax('dev/save_settings'); ?>

			<div class="site-settings">

				<div class="grid_12 grid">

					<legend><?php echo lang('General_settings'); ?></legend>

					<div class="radio grid_6">
						
						<label>

							<input type="radio" name="settings[MULTI_PLATFORM]" value="1" <?php if (@$settings['MULTI_PLATFORM'] == 1) {
							echo 'checked="checked"';
						} ?> class="uniform">

							<?php echo lang('Enable_multi_platform'); ?>

						</label>

					</div>

					<div class="radio grid_6">

						<label>

							<input type="radio" name="settings[MULTI_PLATFORM]" value="0" <?php if (@$settings['MULTI_PLATFORM'] == 0) {
							echo 'checked="checked"';
						} ?> class="uniform">

							<?php echo lang('Always_use_desktop'); ?>

						</label>

					</div>

				</div>

			</div>

			<div class="grid grid_12 form-group text-right">

				<input class="submit-green uniform" type="submit" value="<?php echo lang('Save_change'); ?>">

			</div>

		<?php echo form_close(); ?>

	</div>

	<div class="panel-padding grid full-width">

		<?php echo form_ajax('dev/save_settings'); ?>

			<div class="site-settings">

				<div class="grid_12 grid">

					<legend><?php echo lang('Production_settings'); ?></legend>

					<div class="radio grid_6">

						<label>

							<input type="radio" name="settings[ENABLE_PRODUCTION]" value="1" <?php if (@$settings['ENABLE_PRODUCTION'] == 1) {
								echo 'checked="checked"';
							} ?> class="uniform">

							<?php echo lang('Enable_production_mode'); ?>

						</label>

					</div>

					<div class="radio grid_6">

						<label>

							<input type="radio" name="settings[ENABLE_PRODUCTION]" value="0" <?php if (@$settings['ENABLE_PRODUCTION'] == 0) {
								echo 'checked="checked"';
							} ?> class="uniform">

							<?php echo lang('Enable_development_mode'); ?>

						</label>

					</div>

				</div>

			</div>

			<div class="grid grid_12 form-group text-right">

				<input class="submit-green uniform" type="submit" value="<?php echo lang('Save_change'); ?>">

			</div>

		<?php echo form_close(); ?>

	</div>

</div>

<div class="grid_6">

	<div class="panel-padding grid full-width">

		<?php echo form_ajax('dev/save_settings'); ?>

			<div class="grid_12 grid">

				<legend><?php echo lang('Authenticate_settings'); ?></legend>

				<div class="checkbox">

					<label>

						<input type="checkbox" name="settings[ENABLE_AUTHENTICATION]" value="1" <?php if (@$settings['ENABLE_AUTHENTICATION'] == 1) {
							echo 'checked="checked"';
						} ?> class="uniform">

						<?php echo lang('Always_authenticate'); ?>

					</label>

				</div>

			</div>

			<div class="grid form-group text-right">

				<input class="submit-green uniform" type="submit" value="<?php echo lang('Save_change'); ?>">

			</div>

		<?php echo form_close(); ?>

	</div>

	<div class="panel-padding grid full-width">

		<?php echo form_ajax('dev/save_settings'); ?>

			<div class="site-settings">

				<div class="grid_12 grid">

					<legend><?php echo lang('For_the_developer'); ?></legend>

					<div class="form-group">

						<div class="grid_12 grid row">
							
							<label for="inputTemplates" class="grid_6 control-label"><?php echo lang('Template_default'); ?>:</label>
							
							<div class="grid_6 grid">
								
								<select name="settings[DEVELOPER_TEMPLATE]" id="inputTemplates" class="uniform grid_12" required="required">
									<?php

										if (isset($templates) && count($templates)) {

											foreach ($templates as $key => $tmpl) {

												if (!$tmpl['is_backend']) {
													
													continue;

												}

									?>
												<option <?php if (@$settings['DEVELOPER_TEMPLATE'] == $tmpl['template_key']) {
													echo 'selected="selected"';
												} ?> value="<?php echo @$tmpl['template_key']; ?>"><?php echo @$tmpl['template_name']; ?></option>
									<?php

											}

										}

									?>
								</select>

							</div>
						</div>

						<div class="grid_12 grid row">
							
							<label for="inputPlatforms" class="grid_6"><?php echo lang('Platform_default'); ?>:</label>
							
							<div class="grid_6 grid">
								
								<select name="settings[DEVELOPER_PLATFORM]" id="inputPlatforms" class="uniform grid_12" required="required">
									<?php

										if (isset($platforms)) {

											foreach ($platforms as $key => $plat) {

									?>
												<option <?php if (@$settings['DEVELOPER_PLATFORM'] == $plat['platform_key']) {
													echo 'selected="selected"';
												} ?> value="<?php echo @$plat['platform_key']; ?>"><?php echo @$plat['platform_name']; ?></option>
									<?php

											}

										}

									?>
								</select>

							</div>
						</div>

						<div class="grid_12 grid row">
							
							<label class="grid_12">
								
								<?php echo lang('Automatic_creation_of_css_and_js_files_is_missing_when_loading_interface', 'settings[AUTO_GENERATE_ASSEST_FILE]'); ?>

							</label>

							<div class="grid_12 grid">

								<div class="radio grid_12">

									<label class="grid_6">

										<input type="radio" name="settings[AUTO_GENERATE_ASSEST_FILE]" value="1" <?php if (@$settings['AUTO_GENERATE_ASSEST_FILE'] == 1) {
											echo 'checked="checked"';
										} ?> class="uniform">

										Yes

									</label class="grid_6">

									<label>

										<input type="radio" name="settings[AUTO_GENERATE_ASSEST_FILE]" value="0" <?php if (@$settings['AUTO_GENERATE_ASSEST_FILE'] == 0) {
											echo 'checked="checked"';
										} ?> class="uniform">
										No
									</label>

								</div>

							</div>

						</div>

						<div class="grid_12 grid row">
							
							<labe class="grid_12">

								<?php echo lang('Automatically_creates_the_missing_PHP_language_file_when_loading_the_interface', 'settings[AUTO_GENERATE_LANGUAGE_FILE]'); ?>

							</label>

							<div class="grid_12 grid">

								<div class="radio grid_12">

									<label class="grid_6">

										<input type="radio" name="settings[AUTO_GENERATE_LANGUAGE_FILE]" value="1" <?php if (@$settings['AUTO_GENERATE_LANGUAGE_FILE'] == 1) {
											echo 'checked="checked"';
										} ?> class="uniform">

										Yes

									</label class="grid_6">

									<label>

										<input type="radio" name="settings[AUTO_GENERATE_LANGUAGE_FILE]" value="0" <?php if (@$settings['AUTO_GENERATE_LANGUAGE_FILE'] == 0) {
											echo 'checked="checked"';
										} ?> class="uniform">
										No

									</label>

								</div>

							</div>
							

						</div>

						<div class="grid_12 grid row">
							
							<label class="grid_12">

								<?php echo lang('Automatically_render_interface_for_action_in_controller', 'settings[AUTO_LOAD_VIEW]'); ?>

							</label>

							<div class="grid_12 grid">

								<div class="radio grid_12">

									<label class="grid_6">

										<input type="radio" name="settings[AUTO_LOAD_VIEW]" value="1" <?php if (@$settings['AUTO_LOAD_VIEW'] == 1) {
											echo 'checked="checked"';
										} ?> class="uniform">

										Yes

									</label class="grid_6">

									<label>

										<input type="radio" name="settings[AUTO_LOAD_VIEW]" value="0" <?php if (@$settings['AUTO_LOAD_VIEW'] == 0) {
											echo 'checked="checked"';
										} ?> class="uniform">
										No

									</label>

								</div>

							</div>


						</div>

					</div>

				</div>

			</div>

			<div class="grid form-group text-right">

				<input class="submit-green uniform" type="submit" value="<?php echo lang('Save_change'); ?>">

			</div>

		<?php echo form_close(); ?>

	</div>

</div>