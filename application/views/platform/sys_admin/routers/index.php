<div class="grid_12 clo-lg-12">

    <div class="module card style-default-bright">

		<h2 class="text-primary"><span><?php echo lang('manage_router'); ?></span></h2>
        
        <div class="module-body card-body">

        	<div class="module-table-body-no-background">

            	<?php echo form_ajax('routers/create'); ?>

            		<div class="grid_12 col-lg-12">

						<div class="table-responsive">

		            		<input type="hidden" name="callback_function" value="update_router">

		            		<div class="grid_8" style="padding-bottom: 10px;">

		            			<div class="form-group">
		            				
		            				<div class="grid_8">

		            					<div class="form-group">
		            						
		            						<label for="input" class="grid_2 control-label"><?php echo lang('Controllers'); ?>:</label>
		            						
		            						<div class="grid_10">

		            							<select name="controllers" id="inputControl" class="input-long onchange_this uniform" required="required">
		            						
				            						<?php

														if (isset($controllers) && count($controllers)) {

															foreach ($controllers as $key => $control) {

																if ($control == $control_default) {

																	$selected = 'selected';

																}
																else {

																	$selected = '';

																}

																if ($selected != '') {

																	?>

																		<option selected value="<?php echo base64_encode(@$control) ?>"><?php echo $control ?></option>
																	
																	<?php

																}
																else {

																	?>

																		<option value="<?php echo base64_encode(@$control) ?>"><?php echo $control ?></option>
																	
																	<?php

																}
															
															}

														}

													?>

													<option <?php if ($control_default == 'all'): ?>

														<?php echo 'selected' ?>

													<?php endif ?> value="all"><?php echo lang('All'); ?></option>

				            					</select>

		            						</div>

		            					</div>

		            				</div>

		            				<div class="grid_4 col-lg-4">

							            <input style="margin-right: 10px;" id="save_data" class="button submit-green uniform pull-right" type="submit" name="" value="<?php echo lang('save_data'); ?>">
							            
							            <input style="margin-right: 10px;" id="add_new_router" class="button submit-green uniform pull-right" type="button" name="" value="<?php echo lang('add_new'); ?>">

		            				</div>

		            			</div>

		            		</div>

		            		<table id="myTable" class="tablesorter table table-striped table-hover">

			                    <thead>

			                        <tr>

			                            <th style="width:5%" class="text-center">

			                            	<input type="checkbox" value="" class="action uniform toggle-selected"/>

			                            </th>

			                            <th style="width:27%" class="text-center"><?php echo lang('router_key'); ?></th>

			                            <th style="width:27%" class="text-center"><?php echo lang('router_parametric'); ?></th>

			                            <th style="width:27%" class="text-center"><?php echo lang('router_value'); ?></th>

			                            <th style="width:9%" class="text-center"><?php echo lang('table_option'); ?></th>

			                        </tr>

			                    </thead>

			                    <tbody>

			                        <?php

			                        	$route = (object) array();

				                		$route->is_hidden = 'zero-opacity hidden-element';

				                		$parent = (array) $routers;


			                        	if (count(@$routers) > 0) {

			                        		foreach ($routers as $key => $route) {
			                        			
			                        ?>

					                        <?php

					                        	$route->key = $key;

					                        	$route->total_rows = count($parent);

					                        	$this->data['route'] = $route;

					                        	echo $this->load->common("router/router_row");

					                        ?>

			                        <?php
			                        		}
			                        	}
			                        	else {
			                       	?>
			                       			<?php

			                       				$token = MY_Controller::call_static_func('generate_token');

					                        	$this->data['route'] = (object) array(
					                        		'key' => -1,
					                        		'id' => $last_insert_id + 1,
					                        		'temporary' => $token
					                        	);

					                        	echo $this->load->common("router/router_row");

					                        ?>
			                        <?php
			                        	}
			                        ?>
			                        
			                    </tbody>

			                </table>

			                <table id="table_temporary" class="tablesorter table table-striped table-hover" style="opacity: 0;">
			                	
			                	<thead>

			                        <tr>

			                            <th style="width:5%" class="text-center">

			                            	<input type="checkbox" value="" class="action uniform toggle-selected"/>

			                            </th>

			                            <th style="width:27%" class="text-center"><?php echo lang('router_key'); ?></th>

			                            <th style="width:27%" class="text-center"><?php echo lang('router_parametric'); ?></th>

			                            <th style="width:27%" class="text-center"><?php echo lang('router_value'); ?></th>

			                            <th style="width:9%" class="text-center"><?php echo lang('table_option'); ?></th>

			                        </tr>

			                    </thead>
			                	<tbody>

			                		<?php

			                			$route = (object) array();

				                		$route->id = $last_insert_id + 1;

				                		$route->temporary = 'temporary_row';

				                    	$this->data['route'] = $route;

				                    	echo $this->load->common("router/router_row");

				                    ?>
			                	</tbody>

			                </table>

	                	</div>

	                </div>

            	<?php echo form_close(); ?>

            	<?php echo $this->load->common("table/pagination"); ?>

                <?php echo $this->load->common("table/table-apply"); ?>

            </div>

        </div>

	</div>

</div>