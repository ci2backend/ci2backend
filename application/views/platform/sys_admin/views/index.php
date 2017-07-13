<div class="grid_12">

    <div class="module">

        <h2 class="text-primary"><span><?php echo lang('Manage_view') ?></span></h2>
            
        <div class="module-body">

            <div class="module-table-body-no-background">

                <form action="javascript:void(0);">

                	<div class="grid_12">

						<div class="table-responsive">

							<div class="grid_8" style="padding-bottom: 10px;">

		                		<div class="grid_9">

		                			<!-- Table records filtering -->
							        <?php echo @$this->lang->line('filter_platform'); ?>:
							        	
							        <select class="input-medium onchange_this uniform">

							            <?php if (isset($platforms) && count($platforms)) {

							            	foreach ($platforms as $key => $plat) {

							            ?>

							            <option value="<?php echo $plat['platform_key'] ?>" <?php if ($plat['platform_key'] == $key_default) {

							            	echo 'selected="selected"';

							            } ?>> <?php echo @$plat['platform_name']; ?></option>

							            <?php

							            	}

							            } ?>

							        </select>
							        
		                		</div>
		                		
		                	</div>

			                <table id="myTable" class="tablesorter table table-striped table-hover">

			                    <thead>

			                        <tr>

			                            <th style="width:5%" class="text-center">

			                            	<input type="checkbox" class="action uniform toggle-selected"/>

			                            </th>

			                            <th style="width:20%" class="text-center"><?php echo lang('File_name'); ?></th>

			                            <th style="width:21%" class="text-center"><?php echo lang('Directory') ?></th>

			                            <th style="width:13%" class="text-center"><?php echo lang('Size') ?></th>

			                            <th style="width:15%" class="text-center"><?php echo lang('table_option'); ?></th>

			                        </tr>

			                    </thead>

			                    <tbody>

			                        <?php

			                        	if (count(@$file_list) > 0) {

			                        		foreach ($file_list as $key => $file) {

			                        			$is_preview = true;

			                        			if (substr($file['file'], -8) == '_css.php') {

			                        				$is_preview = false;

			                        				continue;

			                        			}
			                        			elseif (substr($file['file'], -7) == '_js.php') {

			                        				$is_preview = false;

			                        				continue;

			                        			}
			                        			elseif (substr($file['file'], -7) == 'tpl.php') {

			                        				$is_preview = false;

			                        				continue;

			                        			}
			                        			else {

			                        				$is_preview = true;

			                        			}
			                        ?>

			                        <tr data-target="<?php echo base64_encode($file['path']); ?>">

			                            <td class="align-center">

			                            	<input type="checkbox" class="action uniform"/>

			                            </td>

			                            <td><a href="<?php echo site_url('views/detail').'/'.$file['id']; ?>"><?php echo @$file['file']; ?></a></td>

			                            <td><?php echo @str_replace(SLASH.VIEW_PLATFROM, '', $file['module']); ?></td>

			                            <td><?php echo @$file['size']; ?></td>

			                            <td>

			                            	<?php

										    	$dataAction = array(
										    		'update' => array(
														'class' => 'update_action',
														'href' => site_url('views/edit').'/'.base64_encode($file['path']).'/'.$file['id'],
														'target' => '',
														'title' => '',
														'data-original-title' => '',
														'data-target' => '',
														'data-toggle' => '',
														'style' => 'display: inline-block;',
													),
													'preview' => array(
														'class' => 'preview',
														'href' => site_url('views/preview').'/'.base64_encode($file['path']).'/'.$key_default,
														'target' => '',
														'title' => ''
													)
												);

												if ((isset($file['allow_delete']) && $file['allow_delete']) || $this->ion_auth->is_admin()) {

	                                                $dataAction['delete'] = array(
														'class' => 'delete_action',
														'href' => site_url('views/delete').'/'.base64_encode($file['path']),
														'target' => '',
														'title' => '',
														'data-original-title' => '',
														'data-target' => array(
															'target' => '',
															'control' => 'views',
															'file' => base64_encode($file['path'])
														),
														'data-toggle' => 'confirmation',
														'style' => 'display: inline-block;'
													);
	                                                
	                                            }

												$data['table_action'] = $dataAction;

										    	echo $this->load->common("table/table_action", true, $data);

										    ?>

			                            </td>

			                        </tr>

			                        <?php
			                        		}
			                        	}
			                        ?>
			                        
			                    </tbody>

			                </table>

			            </div>

		            </div>

                </form>

                <?php echo $this->load->common("table/pagination"); ?>

                <?php echo $this->load->common("table/table-apply"); ?>

                <div style="clear: both"></div>

            </div> <!-- End .module-table-body -->
             
        </div> <!-- End .module-body -->

    </div> <!-- End .module -->

</div>