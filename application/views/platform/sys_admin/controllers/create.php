<div class="grid_12">

    <div class="module card style-default-bright">

         <h2 class="text-primary"><span><?php echo lang('Create_new_controller'); ?></span></h2>
            
         <div class="module-body card-body">

            <form role="form" id="create_controller" class="ajax validate" action="<?php echo site_url('dev/form_ajax') ?>" method="post" style="margin: 0 auto;">

			   	<div class="grid_12 grid">

			   		<div class="form-group input-large">

			   			<label class="grid_2" for="controller_name"><?php echo lang('Controller_name') ?> :</label>

				      	<input type="text" id="controller_name" placeholder="<?php echo placeholder('Controller_name') ?>" name="controller_name" class="input-medium uniform">

				      	<input type="hidden" value="controllers" class="input-medium" name="controls">

				      	<input type="hidden" value="create" class="input-medium" name="operation_action">

				      	<input type="hidden" value="0" class="input-medium" name="extends">

				        <span class=""><?php echo lang('Eg') ?>: user, user_controller, ...</span>

				   	</div>

				   	<div class="form-group input-large">
			   	
				      	<label class="grid_2" for="platform"><?php echo lang('Platform_default'); ?> : </label>

					    <select name="platform" id="platform" class="input-short uniform">

					    	<?php

					    		if (isset($platforms) && count($platforms)) {

					    			foreach ($platforms as $key => $plat) {
					    			
					    		?>

					    			<option value="<?php echo @$plat['platform_key']; ?>"><?php echo @$plat['platform_name']; ?></option>

					    		<?php

					    			}

					    		}

					    	?>

					    </select>

				   	</div>

				   	<div class="form-group input-large">
			   	
				      	<label class="grid_2" for="template"><?php echo lang('Template_default'); ?> : </label>

					    <select name="template_key" id="template" class="input-short uniform">

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

				   	<div class="grid_12">

	                    <ul>

	                        <li>

	                        	<label>

	                        		<input type="checkbox" class="uniform" checked name="crud" value="1"> <?php echo sprintf(lang('Create_s_with_empty_function'), '<a target="_blank" href="https://en.wikipedia.org/wiki/Create,_read,_update_and_delete" title="Create, read, update and delete">CRUD</a>'); ?>  ?

	                        	</label>
	                        
	                        </li>

	                    </ul>

	                </div>

			   	</div>

			   	<div class="grid_12">

			   		<div class="form-group pad-bot-10">

				   		<fieldset class="text-right">

							<input class="submit-green ajax_action uniform" type="submit" value="<?php echo lang('Create'); ?>" data-set='{"url":"index.php/dev/generate_controller", "form_id":"create_controller"}'>

							<a class="submit-gray uniform" type="button" href="<?php echo site_url($this->router->class); ?>" role="button"><?php echo lang('Back'); ?></a>
							
						</fieldset>

					</div>

			   	</div>

            </form>
             
         </div> <!-- End .module-body -->

    </div> <!-- End .module -->

</div>