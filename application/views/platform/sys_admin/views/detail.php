<div class="grid_12">

	<div class="module">

		<h2 class="text-primary"><span><?php echo lang('View_detail'); ?> : <?php echo $view_origin['view_name'].EXT; ?></span></h2>

		<div class="module-body">

			<div class="grid_12">

				<?php if (isset($platforms) && count($platforms)): ?>

					<div role="tabpanel">
						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">

							<?php foreach ($platforms as $key => $platform): ?>

								<li role="presentation" class="<?php if ($key == 0): ?>
									<?php echo 'active' ?>
								<?php endif ?>">

									<a href="#<?php echo $platform['platform_key'] ?>" aria-controls="home" role="tab" data-toggle="tab"><?php echo $platform['platform_name'] ?></a>

								</li>

							<?php endforeach ?>

						</ul>
					
						<!-- Tab panes -->
						<div class="tab-content">

							<?php foreach ($platforms as $key => $platform): ?>

								<div role="tabpanel" class="tab-pane <?php if ($key == 0): ?>
										<?php echo 'active'; ?>
									<?php endif ?>" id="<?php echo $platform['platform_key'] ?>">
									
									<div class="grid_12 grid">

										<legend><?php echo $platform['view_files']['view_file']; ?></legend>

										<?php if (isset($platform['view_files']['view_file']) && is_file($platform['view_files']['view_file'])): ?>

											<div class="grid_4 text-center" id="view_<?php echo $platform['platform_key']; ?>">

												<?php foreach ($platform['view_files'] as $key => $view_file): ?>

													<?php if (is_file($view_file)): ?>

														<a target="_blank" href="<?php echo site_url('views/edit').'/'.base64_encode($view_file) ?>" title="<?php echo $view_file; ?>" class="detail-view text-center">

															<?php echo basename($view_file); ?>

														</a>
														
													<?php endif ?>
													
												<?php endforeach ?>

												<span class="label label-default inline-block text-center">View file</span>

											</div>

										<?php else: ?>

											<div class="grid_4 text-center" id="view_<?php echo $platform['platform_key']; ?>">

												<span class="label label-warning"><?php echo lang('File_not_found'); ?></span>

												<div class="grid_12 grid" style="min-height: 166px;">

													<a class="btn btn-primary" data-toggle="modal" href='#modal-<?php echo $platform['platform_key'].'-'.basename($platform['view_files']['view_file'], EXT); ?>'>Fetch or create file</a>

												</div>
												
												<div class="modal fade" id="modal-<?php echo $platform['platform_key'].'-'.basename($platform['view_files']['view_file'], EXT); ?>">
													
													<div class="modal-dialog">
														
														<div class="modal-content">
															
															<div class="modal-header">
																
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																
																<h4 class="modal-title"><?php echo lang('Fecth_or_Create_new_view_files'); ?></h4>
															
															</div>

															<div class="modal-body inline-block full-width">

																<?php echo form_ajax('views/create', 'id="form-'.$platform['platform_key'].'-'.basename($platform['view_files']['view_file'], EXT).'" class="form-horizontal border inline-block full-width"'); ?>

																	<div class="grid_12 grid text-left">
				   	
																      	<label for="platform"><?php echo lang('Fetching_view_content_from') ?>:</label>

																	    <?php

																    		if (isset($platforms) && count($platforms)) {

																    			foreach ($platforms as $key => $plat) {
																    			
																    		?>

																	    		<?php if (is_file($plat['view_files']['view_file'])): ?>

																	    			<div class="checkbox">

																						<label>
																							
																							<input type="radio" class="uniform" value="<?php echo @$plat['platform_key']; ?>" name="fetch_platform">
																							
																							<?php echo @$plat['platform_name']; ?>
																						
																						</label>

																					</div>

																				<?php endif ?>

																    		<?php

																    			}

																    		}

																    	?>

																   	</div>

																   	<div class="grid_12 grid text-left">

																   		<label for=""><?php echo lang('Create_base_file'); ?></label>

																   		<div class="checkbox">

																			<label>
																				
																				<input type="radio" class="uniform" checked="checked" value="0" name="fetch_platform">
																				
																				<?php echo lang('Create_new_file'); ?>
																			
																			</label>

																		</div>

																		<div class="checkbox">

																			<label>
																				
																				<input type="radio" class="uniform" checked="checked" value="0" name="fetch_platform">
																				
																				<?php echo lang('with_content_from_template'); ?>
																			
																			</label>

																		</div>

																		<select name="template" id="template" class="input-medium uniform pull-right">

																	    	<?php

																	    		if (isset($templates) && count($templates)) {

																	    			foreach ($templates as $key => $templ) {
																	    			
																	    		?>

																	    			<option value="<?php echo @$templ['template_key']; ?>"><?php echo @$templ['template_name']; ?></option>

																	    		<?php

																	    			}

																	    		}

																	    	?>

																	    </select>

																   	</div>

																	<input type="hidden" name="view_name" value="<?php echo @$view_origin['view_name']; ?>">
																	
																	<input type="hidden" name="generate_css" value="1">

																	<input type="hidden" name="generate_js" value="1">

																	<input type="hidden" name="content_body" value="">

																	<input type="hidden" name="module_name" value="<?php echo @$view_origin['module_name']; ?>">
																	
																	<input type="hidden" name="platform[]" value="<?php echo @$platform['platform_key']; ?>">

																	<input type="hidden" name="callback_function" value="update_view">

																<?php echo form_close(); ?>
																
															</div>

															<div class="modal-footer">
																
																<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('Close'); ?></button>
																
																<button type="submit" class="btn btn-primary submit-form" data-form-target="#form-<?php echo $platform['platform_key'].'-'.basename($platform['view_files']['view_file'], EXT); ?>"><?php echo lang('Create'); ?></button>
															
															</div>

														</div>

													</div>

												</div>

												<span class="label label-default inline-block text-center">View file</span>

											</div>

										<?php endif ?>

										<?php if (isset($platform['php_lang_files']) && count($platform['php_lang_files'])): ?>

											<div class="grid_4 text-center">

												<?php foreach ($platform['php_lang_files'] as $key => $php_lang): ?>

													<?php if (count($php_lang)): ?>

														<?php foreach ($php_lang as $key_file => $php_file): ?>
															
															<?php if (is_file($php_file)): ?>

																<a style="position: relative;" target="_blank" href="<?php echo site_url('languages/compare').'/'.base64_encode($php_file) ?>" title="<?php echo $php_file; ?>" class="detail-view text-center">

																	<?php echo basename($php_file); ?>

																	<span class="label label-info" style="position: absolute; bottom: 0; left: 30%;;"><?php echo $key_file; ?></span>

																</a>
																
															<?php endif ?>

														<?php endforeach ?>

													<?php else: ?>

														<span class="label label-warning"><?php echo lang('File_not_found'); ?></span>

														<?php echo form_ajax('languages/create', 'class="generate" id="create_language"'); ?>

															<button type="submit" class="btn btn-default"><?php echo lang('Create_now'); ?> ?</button>

														<?php echo form_close(); ?>
														
													<?php endif ?>
													
												<?php endforeach ?>

												<span class="label label-default inline-block text-center">PHP language file</span>

											</div>

										<?php else: ?>

											<div class="grid_4 text-center">

												<span class="label label-warning"><?php echo lang('File_not_found'); ?></span>

												<?php echo form_ajax('languages/create', 'class="generate" id="create_language"'); ?>

													<button type="submit" class="btn btn-default"><?php echo lang('Create_now'); ?> ?</button>

												<?php echo form_close(); ?>

												<span class="label label-default inline-block text-center">PHP language file</span>

											</div>

										<?php endif ?>

										<?php if (isset($platform['js_lang_files']) && count($platform['js_lang_files'])): ?>

											<div class="grid_4 text-center">

												<?php foreach ($platform['js_lang_files'] as $key => $js_lang): ?>

													<?php if (count($js_lang)): ?>

														<?php foreach ($js_lang as $key_file => $js_file): ?>
															
															<?php if (is_file($js_file)): ?>

																<a style="position: relative;" target="_blank" href="<?php echo site_url('views/edit').'/'.base64_encode($js_file) ?>" title="<?php echo $js_file; ?>" class="detail-view text-center">

																	<?php echo basename($js_file); ?>

																	<span class="label label-info" style="position: absolute; bottom: 0; left: 30%;;"><?php echo $key_file; ?></span>

																</a>
																
															<?php endif ?>

														<?php endforeach ?>

													<?php else: ?>

														<span class="label label-warning"><?php echo lang('File_not_found'); ?></span>

														<form action="<?php echo site_url('dev/form_ajax'); ?>" class="ajax validate generate" method="post" accept-charset="utf-8">

															<button type="submit" class="btn btn-default"><?php echo lang('Create_now'); ?> ?</button>

														</form>

													<?php endif ?>
													
												<?php endforeach ?>

												<span class="label label-default inline-block text-center">Javascript language file</span>

											</div>
											
										<?php else: ?>

											<div class="grid_4 text-center">

												<span class="label label-warning"><?php echo lang('File_not_found'); ?></span>

												<form action="<?php echo site_url('dev/form_ajax'); ?>" class="ajax validate generate" method="post" accept-charset="utf-8">

													<button type="submit" class="btn btn-default"><?php echo lang('Create_now'); ?> ?</button>

												</form>

												<span class="label label-default inline-block text-center">Javascript language file</span>

											</div>

										<?php endif ?>

									</div>

								</div>

							<?php endforeach ?>

						</div>

					</div>

				<?php endif ?>

			</div>

		</div>

	</div>

</div>