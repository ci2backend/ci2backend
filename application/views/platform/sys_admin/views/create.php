<div class="grid_12">

    <div class="module">

    	<h2 class="text-primary"><span><?php echo lang('Generate_view_in_system'); ?></span></h2>
        
        <div class="module-body">

        	<?php echo form_ajax('views/create', 'role="form" id="generate_view_form"'); ?>

            	<div class="form-group grid_6">

            		<span class="grid_12 grid">Only content html. Eg: <?php echo htmlentities('<div class="content"> ... </div>'); ?>, ...</span>
            		
            		<textarea name="content_body" style="display: none;" id="content_body"></textarea>
                    
                    <pre id="editor"><?php if (isset($page_content)) {
	                    	
	                    	echo htmlentities($page_content);

	                    }
	                    else {
	                    	
	                    	echo htmlentities($this->load->common('sys_content_module', true), ENT_QUOTES);

	                    } ?>

	                </pre>

            	</div>
            	
            	<div class="form-group grid_6">

            		<div class="grid_12">

					   	<div class="form-group grid_6">

					   		<p>

			                    <label for="module_name" class="block"><?php echo lang('Module_name'); ?></label>

			                    <input type="text" class="input-long uniform" id="module_name" placeholder="<?php echo placeholder('Module_name'); ?>" name="module_name">

			                    </br></br><span><?php echo lang('Eg'); ?>: user or user/login , ...</span>

			                </p>

					   	</div>

					   	<div class="form-group grid_6">

				   			<p>

						      	<label for="view_name" class="block"><?php echo lang('View_name'); ?></label>

						      	<input type="text" class="input-long uniform" id="view_name" placeholder="<?php echo placeholder('View_name'); ?>" name="view_name">

						        </br></br><span><?php echo lang('Eg'); ?>: company_view, ...</span>

					        </p>

					   	</div>

				   	</div>

            		<div class="grid_12">

		            	<div class="form-group grid_6">
				   	
					      	<label for="template_content"><?php echo lang('choose_a_template'); ?></label>

						    <select name="template" id="template_content" class="input-medium uniform">

						    	<?php

						    		if (isset($templates) && count($templates)) {

						    			foreach ($templates as $key => $templ) {
						    			
						    		?>

						    			<option value='<?php echo @$templ['page_content_default']; ?>'><?php echo @$templ['template_name']; ?></option>

						    		<?php

						    			}

						    		}

						    	?>

						    </select>

					   	</div>

		            	<div class="form-group grid_6">
				   	
					      	<label for="platform"><?php echo lang('choose_a_platform'); ?></label>

						    <?php

					    		if (isset($platforms) && count($platforms)) {

					    			foreach ($platforms as $key => $plat) {
					    			
					    		?>

					    			<div class="checkbox">

										<label>
											
											<input type="checkbox" class="uniform" value="<?php echo @$plat['platform_key']; ?>" <?php echo @$checked; ?> name="platform[]">
											
											<?php echo @$plat['platform_name']; ?>
										
										</label>

									</div>

					    		<?php

					    			}

					    		}

					    	?>

					   	</div>

				   	</div>

				   	<div class="grid_12">
					   	<div class="grid_6">
					   		<div class="checkbox">
					   			<label>
					   				<input type="checkbox" name="generate_css" value="1" checked="checked" class="uniform">
					   				Generate _css.php customize file ?
					   			</label>
					   		</div>
					   	</div>

					   	<div class="grid_6">
					   		<div class="checkbox">
					   			<label>
					   				<input type="checkbox" name="generate_js" value="1" checked="checked" class="uniform">
					   				Generate _js.php customize file ?
					   			</label>
					   		</div>
					   	</div>
				   	</div>
				   	<div class="grid_12">
					   	<div class="grid_6">
					   		<div class="checkbox">
					   			<label>
					   				<input type="checkbox" name="override_view" value="1" checked="checked" class="uniform">
					   				Override view file if it already existed ?
					   			</label>
					   		</div>
					   	</div>

					   	<div class="grid_6">
					   		<div class="checkbox">
					   			<label>
					   				<input type="checkbox" name="override_sub_view" value="1" checked="checked" class="uniform">
					   				Override _js.php and _css.php file if they already exist ?
					   			</label>
					   		</div>
					   	</div>
				   	</div>

				</div>

				<div class="grid_12 grid text-right">

				   	<div class="pad-bot-10">

						<input class="submit-green uniform" type="submit" value="<?php echo lang('Create_page'); ?>">

						<a type="button" class="btn uniform" href="<?php echo site_url('views/index'); ?>"><?php echo lang('Back'); ?></a>

					</div>

				</div>

            <?php echo form_close(); ?>
             
        </div> <!-- End .module-body -->

    </div> <!-- End .module -->

</div>