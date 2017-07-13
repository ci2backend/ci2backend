<div class="grid_12">

    <div class="module">

    	<h2 class="text-primary"><span><?php echo lang('Edit_view'); ?> : <?php if (isset($file_view)) {

			echo $file_view;

		}
        ?></span></h2>
        
        <div class="module-body">

        	<div class="grid_12 grid">

	        	<div role="tabpanel">
	        		<!-- Nav tabs -->
	        		<ul class="nav nav-tabs" role="tablist">

	        			<li role="presentation" class="active">

	        				<a href="#edit_content" aria-controls="edit_content" role="tab" data-toggle="tab"><?php echo lang('Edit_content_view'); ?></a>
	        			
	        			</li>

	        			<li role="presentation">

	        				<a href="#views_infomation" aria-controls="views_infomation" role="tab" data-toggle="tab"><?php echo lang('View_information'); ?></a>
	        			
	        			</li>

	        		</ul>
	        	
	        		<!-- Tab panes -->
	        		<div class="tab-content inline-block">

	        			<div role="tabpanel" class="tab-pane grid active" id="edit_content">

	        				<?php echo form_ajax('views/edit', 'role="form" id="edit_view_form"'); ?>

	        					<div class="form-group grid_12">

				            		<span class="grid_12 grid"><?php echo lang('Only_content_html') ?>. <?php echo lang('Eg') ?>: <?php echo htmlentities('<div class="content"> ... </div>'); ?>, ...</span>
				            		
				            		<textarea name="content_body" style="display: none;" id="content_body"></textarea>
				                    
				                    <pre id="editor"><?php if (isset($page_content)) {
					                    	
					                    	echo htmlentities($page_content, ENT_QUOTES);

					                    }
					                    else {
					                    	
					                    	echo htmlentities($this->load->common('sys_content_module', true), ENT_QUOTES);

					                    } ?>

					                </pre>

					                <div class="grid_12 text-right" style="margin-top: 25px;">

									   	<div class="pad-bot-10">

									   		<input type="hidden" name="file_path" value="<?php echo $file_path; ?>">

											<input class="submit-green uniform" type="submit" value="<?php echo lang('Save_change'); ?>">

											<a type="button" class="btn uniform" href="<?php echo site_url('views/index'); ?>"><?php echo lang('Back'); ?></a>

										</div>

									</div>

				            	</div>

	        				<?php echo form_close(); ?>

	        			</div>

	        			<div role="tabpanel" class="tab-pane grid" id="views_infomation">

	        				<?php echo form_ajax('views/edit', 'role="form" id="generate_view_form"'); ?>

	        					<div class="form-group grid_12 grid">

				            		<div class="grid_6">

									   	<div class="form-group">

									   		<label for="module_name" class="block"><?php echo lang('Module_name'); ?></label>

						                    <input type="text" class="input-long uniform" id="module_name" placeholder="<?php echo placeholder('Module_name'); ?>" name="module_name" value="<?php echo @$view_row['module_name']; ?>">

						                    </br></br><span><?php echo lang('Eg'); ?>: user or user/login , ...</span>

									   	</div>

									   	<div class="form-group">

								   			<label for="view_name" class="block"><?php echo lang('View_name'); ?></label>

									      	<input type="text" class="input-long uniform" id="view_name" placeholder="<?php echo placeholder('View_name'); ?>" name="view_name" value="<?php echo @$view_row['view_name']; ?>">

									        </br></br><span><?php echo lang('Eg'); ?>: company_view, ...</span>

									   	</div>

								   	</div>

								   	<div class="grid_6">

									   	Fetch content from

								   	</div>

					                <div class="grid_12 text-right" style="margin-top: 25px;">

									   	<div class="pad-bot-10">

									   		<input type="hidden" name="update_info" value="">

									   		<input type="hidden" name="file_path" value="<?php echo $file_path; ?>">

									   		<input type="hidden" name="view_id" value="<?php echo @$view_row['id']; ?>">

											<input class="submit-green uniform" type="submit" value="<?php echo lang('Save_change'); ?>">

											<a type="button" class="btn uniform" href="<?php echo site_url('views/index'); ?>"><?php echo lang('Back'); ?></a>

										</div>

									</div>

								</div>

	        				<?php echo form_close(); ?>

	        			</div>

	        		</div>

	        	</div>

        	</div>
             
        </div> <!-- End .module-body -->

    </div> <!-- End .module -->

</div>