<div class="grid_12">

	<div class="module">

		<h2 class="text-primary"><span><?php echo lang('Template_detail'); ?>: <?php echo $tmpl['template_name'] ?></span></h2>

		<div class="module-body">

			<div class="grid_8">

				<div class="grid_12">

					<div class="panel-padding grid full-width">

						<legend><?php echo lang('Template_resources') ?></legend>

						<div id="template_source_file">

							<div id="elfinder_template" class="">

					    		<p class="text-center">Folder will generate when create template</p>

							</div>

						</div>

					</div>

				</div>

				<div class="grid_12">

					<div class="panel-padding grid full-width">

						<legend>

							<?php echo lang('Template_common_files') ?>

						</legend>

						<div id="template_source_file">

							<div id="elfinder_common_template" class="">

					    		<p class="text-center">Folder will generate when create common template file</p>

							</div>

						</div>

					</div>

				</div>

				<?php if ($tmpl['is_backend'] == 1): ?>

					<div class="grid_12">

						<div class="panel-padding grid full-width">

							<legend>

								<?php echo lang('Template_settings') ?>

							</legend>

							<div id="template_setting">

								<?php echo form_ajax('templates/template_loader'); ?>

									<input type="hidden" name="template_key" value="<?php echo @$template_key ?>">

									<div class="grid_12 panel-padding grid">

										<div class="grid_12 grid">

											<label for="" style="display: block;"><?php echo lang('Enable_customize_view'); ?> ?</label>

										</div>

										<div class="radio grid_6">
							
											<label>

												<input type="radio" name="enable_customize_view" value="1" <?php if (@$tmpl['enable_customize_view'] == 1) {
												echo 'checked="checked"';
											} ?> class="uniform">

												<?php echo lang('Yes'); ?>

											</label>

										</div>

										<div class="radio grid_6">

											<label>

												<input type="radio" name="enable_customize_view" value="0" <?php if (@$tmpl['enable_customize_view'] == 0) {
												echo 'checked="checked"';
											} ?> class="uniform">

												<?php echo lang('No'); ?>

											</label>

										</div>

										<div class="grid_12 grid customize-view-foller" style="<?php if ($tmpl['enable_customize_view'] == 0): ?>
											<?php echo 'display: none;' ?>
										<?php endif ?>">
											
											<label for="inputCustomizeViewFolder" class=""><?php echo lang('Customize_view_path'); ?>:</label>

											<input type="text" name="customize_view_folder" id="inputCustomizeViewFolder" class="input-long uniform" value="<?php echo $tmpl['customize_view_folder']; ?>">
											
											<br>
											<br>

											<span class="notification n-attention">Đường dẫn thư mục customize view sẽ được tạo trong thư mục application/views/template/<?php echo $tmpl['template_key'] ?>/<?php echo $tmpl['customize_view_folder']; ?></span>

										</div>

									</div>

									<div class="grid_12 grid text-right">

										<input type="submit" class="submit-green uniform pull-right" name="save_template_setting" value="<?php echo lang('Save_change'); ?>">

									</div>

								<?php echo form_close(); ?>

							</div>

						</div>

					</div>

				<?php endif ?>

			</div>

			<div class="grid_4">

				<div class="grid_12">

					<div class="panel-padding grid full-width">

						<legend><?php echo lang('Menu_of_template'); ?></legend>

						<div id="template_loading_file">

							<?php echo form_ajax('templates/template_loader'); ?>
								
								<div class="form-group">

									<input type="hidden" name="template_key" value="<?php echo @$template_key ?>">

	                            	<?php

										if (isset($menus) && count($menus)) {

											foreach ($menus as $key => $menu) {

												if (in_array($menu['id'], $tmpl_menu_list_selected)) {

													$checked = 'checked="checked"';

												}
												else{

													$checked = '';

												}

										?>

												<div class="checkbox grid_6">

													<label>
														
														<input type="checkbox" class="uniform" value="<?php echo $menu['id']; ?>" <?php echo @$checked; ?> name="template_menu_loaded_list[]">
														
														<?php echo lang($menu['title_key']); ?>
													
													</label>

												</div>
												

										<?php

											}

										}

									?>

								</div>

								<div class="grid_12 grid text-right">

									<input type="submit" class="submit-green uniform pull-right" name="save_menu_list" value="<?php echo lang('Save_change'); ?>">

								</div>

							<?php echo form_close(); ?>

						</div>

					</div>

				</div>

				<div class="grid_12">

					<div class="panel-padding grid full-width">

						<legend><?php echo lang('Extension_dependencies'); ?></legend>

						<div id="template_loading_file">

							<?php echo form_ajax('templates/template_loader'); ?>

								<div class="form-group">

									<input type="hidden" name="template_key" value="<?php echo @$template_key ?>">

	                            	<?php

										if (isset($extension) && count($extension)) {

											foreach ($extension as $key => $list) {

												if (in_array($list['extension_key'], @$list_depend)) {

													$checked = 'checked="checked"';

												}
												else {

													$checked = '';

												}

										?>

												<div class="checkbox grid_6">

													<label>
														
														<input type="checkbox" class="uniform" value="<?php echo $list['extension_key']; ?>" <?php echo @$checked; ?> name="template_extension_dependencies_list[]">
														
														<?php echo $list['extension_name']; ?>
													
													</label>

												</div>
												

										<?php

											}

										}

									?>

								</div>

								<div class="grid_12 grid text-right">

									<input type="submit" class="submit-green uniform pull-right" name="save_dependencies_list" value="<?php echo lang('Save_change'); ?>">

								</div>

							<?php echo form_close(); ?>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>