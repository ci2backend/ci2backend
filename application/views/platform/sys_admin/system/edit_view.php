<div class="grid_12">

    <div class="module card">

		<h2 class="text-primary">
			<span><?php echo lang('Edit_content') ?> <?php echo lang('file') ?> : <?php if (isset($file_view)) {

				echo $file_view;

			}
	        ?>
		        <a id="ace_settings_menu" target="_blank" href="javascript:void(0);" style="margin-right: 10px;float: right;">

		        	<img src="<?php echo base_url(TEMPLATE_PATH.$template); ?>/img/settings16x16.png" width="16" height="16" alt="edit">
		        	
		        	<?php echo lang('Settings'); ?>

		        </a>
		        
		    </span>

		</h2>
        
         <div class="module-body">

            <form role="form" id="edit_view_form" action="<?php echo site_url($this->router->class.'/'.$this->router->method) ?>" method="post" style="margin: 0 auto;" class="ajax validate">

            	<div class="grid_12 grid">

	            	<div class="form-group form-long">

	            		<p style="width: 100%;">

	            			<input type="hidden" name="file_path" value="<?php if (isset($file_view)) {

					         	echo $file_view;

					         }
					         ?>">

					        <textarea name="content_body" style="display: none;" id="content_body"></textarea>

	            			<div style="position: relative;" id="editor_content">

								<pre id="editor"><?php if (isset($page_content)) {
			                    	
				                    	echo '<pre>'.htmlentities(trim($page_content), ENT_QUOTES, "UTF-8").'</pre>';

				                    }
				                    else{

				                    	echo $this->lang->line('empty_page');

				                    } ?>

				                </pre>

							</div>

		                </p>

	            	</div>

				   	<div class="form-group pad-bot-10">

				   		<fieldset style="float: right;">

							<input class="submit-green uniform" type="submit" value="<?php echo lang('Complete_edit'); ?>" name="edit_view_submit">
							
						</fieldset>

					</div>

				</div>

            </form>
             
         </div> <!-- End .module-body -->

    </div> <!-- End .module -->

</div>