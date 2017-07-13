<div class="grid_12">

	<div class="module">

		<h2 class="text-primary"><span><?php echo lang('Access_right_setting'); ?></span></h2>

		<div class="module-body">

			<?php if (isset($access_right) && count($access_right)): ?>

				<form action="javascript:void(0);">

	            	<div class="grid_12">

						<div class="grid_3 grid">

	            			<!-- Table records filtering -->
					        <?php echo @$this->lang->line('Controllers'); ?>:
					        	
					        <select class="input-long onchange_this reload uniform chosen-select">

					            <?php if (isset($controllers) && count($controllers)) {

					            	foreach ($controllers as $key => $item) {

					            ?>

					            <option value="<?php echo site_url("users/access_right").SLASH.base64_encode($item); ?>" <?php if ($item == $control_default) {

					            	echo 'selected="selected"';

					            } ?>> <?php echo @$item; ?></option>

					            <?php

					            	}

					            } ?>

					            <option value="<?php echo site_url("users/access_right/all"); ?>" <?php if ($control_default == 'all') {

					            	echo 'selected="selected"';

					            } ?>> <?php echo lang('All'); ?></option>

					        </select>
				        
	        			</div>

						<div class="grid_5 grid">

	        				<a  title="<?php echo lang('Fetch_all_access_right'); ?>" class="button pull-right" type="button" href="<?php echo site_url('users/access_right/all/1');?>">

	                            <span>

	                                <?php echo lang('All_access_right'); ?>

	                                <img src="<?php echo $this->load->assets('img/reset.png'); ?>" width="12" height="12" alt="">

	                            </span>

	                        </a>

	        				<a  title="<?php echo lang('Fetch_access_right_for_this_controller'); ?>" class="button pull-right" style="margin-right: 10px;" type="button" href="<?php echo site_url('users/access_right/'.base64_encode($control_default).'/1');?>">

	                            <span>

	                                <?php echo lang('Current_access_right'); ?>

	                                <img src="<?php echo $this->load->assets('img/reset.png'); ?>" width="12" height="12" alt="">

	                            </span>

	                        </a>

	                        <a id="truncate_all_access_right" title="<?php echo lang('Fetch_access_right_for_this_controller'); ?>" class="button pull-right" style="margin-right: 10px;" type="button" href="<?php echo site_url('users/access_right/'.base64_encode($control_default).'/0/1');?>">

	                            <span>

	                                <?php echo lang('Truncate'); ?>

	                                <img src="<?php echo $this->load->assets('img/cross-on-white.gif'); ?>" width="12" height="12" alt="">

	                            </span>

	                        </a>

	        			</div>

	    				<table id="myTable" class="tablesorter table table-striped table-hover">

		                    <thead>

		                        <tr>

		                            <th style="width:20%" class="text-center"><?php echo lang('Function_nane'); ?></th>

		                            <th style="width:20%" class="text-center"><?php echo lang('Login_required'); ?></th>
		                            
		                            <th style="width:20%" class="text-center"><?php echo 'Allow access to groups'; ?></th>

		                        </tr>

		                    </thead>

		                    <tbody>

		                        <?php

	                        		foreach ($access_right as $key => $row) {

		                        ?>

				                        <tr data-target="<?php echo base64_encode($row['access_right_id']); ?>">

				                            <td><?php if ($control_default == 'all'): ?>
				                            	
				                            	<?php echo $row['control']; ?> / <?php echo $row['action']; ?>

				                            <?php else: ?>

				                            	<?php echo $row['action']; ?>

				                            <?php endif ?></td>

				                            <td>

				                            	<div class="radio">

				                                	<label>

				                                		<input type="checkbox" name="require_login" class="uniform" value="<?php echo @$row['access_right_id']; ?>" <?php if ($row['require_login']) {
					                                		echo ' checked="checked"';
					                                	} ?>>

				                                	</label>

				                                </div>

				                            </td>

				                            <td>

				                            	<div class="text-left">

				                            		<?php if (isset($row['groups']) && count($row['groups'])): ?>
				                            		
					                            		<?php foreach ($row['groups'] as $group):?>

					                            			<?php if ($group['name'] == $admin_group): ?>

					                            				<?php $disabled = 'disabled="disabled"'; ?>

					                            			<?php else: ?>

					                            				<?php $disabled = ''; ?>

					                            			<?php endif ?>

					                            			<div class="checkbox">

					                            				<label class="full-width inline-block">

					                            					<input type="checkbox" <?php echo @$disabled; ?> data-access-right-id="<?php echo $row['access_right_id']; ?>" name="enable_access_right[]" value="<?php echo $group['id']; ?>" <?php if ($group['enable']): ?>
					                            						
					                            						<?php echo 'checked="checked"'; ?>

					                            					<?php endif ?>>

					                            					<?php echo $group['name']; ?>

					                            				</label>

					                            			</div>

				                                        <?php endforeach?>

					                            	<?php endif ?>

				                            	</div>

				                            </td>

				                        </tr>

		                        <?php

		                        	}

		                        ?>
		                        
		                    </tbody>

		                </table>

		            </div>

	            </form>

            	<?php echo $this->load->common("table/pagination"); ?>

            <?php else: ?>

            	<div class="grid_12">

					<span class="notification n-attention">

	    				You have not set permissions yet, click the "<?php echo lang('All_access_right'); ?>" button to get started

	    				<a  title="<?php echo lang('Fetch_all_access_right'); ?>" class="button pull-right" type="button" href="<?php echo site_url('users/access_right/all/1');?>">

                            <span>

                                <?php echo lang('All_access_right'); ?>

                                <img src="<?php echo $this->load->assets('img/reset.png'); ?>" width="12" height="12" alt="">

                            </span>

                        </a>

	    			</span>

				</div>
				
			<?php endif ?>

            <div style="clear: both"></div>

		</div>

	</div>

</div>