<div class="grid_12">

    <div class="module">

        <h2 class="text-primary"><span>Generate Model In System</span></h2>
            
        <div class="module-body">

            <form role="form" id="create_model" class="ajax validate" action="<?php echo site_url('dev/form_ajax') ?>" method="post" style="margin: 0 auto;">

			   	<div class="grid_12 grid">
			   		
				   	<div class="form-group">

			   			<p>

					      	<label for="model_name">Model name</label>

					      	<input type="text" id="model_name" placeholder="Enter view name" name="model_name" class="uniform input-medium">

					        <span>Eg: user, user_model, t_user, ...</span>

					        <input type="hidden" value="create" class="input-medium uniform" name="operation_action">

					        <input type="hidden" value="models" class="input-medium uniform" name="controls">

				        </p>

				   	</div>

				   	<div class="form-group">

			   			<p>

			   				<label>Table name</label>

					      	<select name="table_name" class="input-short chosen-select uniform">

					      		<option value="">Select a table</option>

					      		<?php

					      			if (count(@$tables)) {

					      				foreach ($tables as $key => $tab) {


					      		?>

					      					<option value="<?php echo $tab; ?>"><?php echo $tab; ?></option>

					      		<?php

					      				}

					      			}

					      		?>
					      		
					      	</select>

				        </p>

				   	</div>

				   	<div class="form-group">

				   		<div class="checkbox checkbox-styled">

							<label>

								<input type="checkbox" class="uniform" value="" id="cb1" checked="checked" name="base_query">

								<span> Create Base Query ?</span>

							</label>

						</div>

					</div>

				   	<div class="form-group pad-bot-10 text-right">

				   		<fieldset>

							<input class="submit-green ajax_action uniform" type="submit" value="Create model now" data-set='{"url":"index.php/dev/generate_model", "form_id":"create_module"}'>

							<input class="submit-gray uniform" type="reset" value="Cancel">

						</fieldset>

					</div>

				</div>

            </form>
             
         </div> <!-- End .module-body -->

    </div> <!-- End .module -->

</div>