<div class="grid_12">

    <div class="module card style-default-bright">

        <h2 class="text-primary"><span><?php echo lang('Manage_model') ?></span></h2>
            
        <div class="module-body card-body">

            <div class="module-table-body">

                <form action="javascript:void(0);">

                	<div class="grid_12 col-lg-12">

						<div class="table-responsive">
			        
			                <table id="myTable" class="tablesorter table table-striped table-hover">

			                    <thead>

			                        <tr>

			                            <th style="width:5%" class="text-center"><input type="checkbox" value="" class="file_name action uniform toggle-selected"/></th>

			                            <th style="width:20%" class="text-center">View File</th>

			                            <th style="width:21%" class="text-center"><?php echo lang('Module') ?></th>

			                            <th style="width:21%" class="text-center">Table Installed</th>

			                            <th style="width:13%" class="text-center"><?php echo lang('Size') ?></th>

			                            <th style="width:15%" class="text-center"><?php echo lang('table_option'); ?></th>

			                        </tr>

			                    </thead>

			                    <tbody>

			                        <?php 
			                        	if (count(@$file_list) > 0) {

			                        		foreach ($file_list as $key => $file) {

			                        			if ($file['file'] == 'config_model.ini') {

			                        				continue;

			                        			}
			                        ?>

			                        <tr data-target="<?php echo base64_encode($file['path']); ?>">

			                            <td class="align-center">

			                            	<input type="checkbox" value="" class="file_name action uniform"/>

			                            </td>

			                            <td><a target="_blank" href="<?php echo site_url('models/edit').'/'.base64_encode($file['path']); ?>"><?php echo $file['file']; ?></a></td>

			                            <td><?php echo $file['module']; ?></td>

			                            <td><?php echo $file['table']; ?></td>

			                            <td><?php echo $file['size']; ?></td>

			                            <td>

			                                <?php

										    	$dataAction = array(
										    		'update' => array(
														'class' => 'update_action',
														'href' => site_url('models/edit').'/'.base64_encode($file['path']),
														'target' => '',
														'title' => '',
														'data-original-title' => '',
														'data-target' => '',
														'data-toggle' => '',
														'style' => 'display: inline-block;',
													),
													'delete' => array(
														'class' => 'delete_action',
														'href' => site_url('models/delete').'/'.base64_encode($file['path']),
														'target' => '',
														'title' => '',
														'data-original-title' => '',
														'data-target' => array(
															'target' => '',
															'control' => 'models',
															'file' => base64_encode($file['path'])
														),
														'data-toggle' => 'confirmation',
														'style' => 'display: inline-block;'
													)
												);

												if ((isset($file['allow_delete']) && $file['allow_delete']) || $this->ion_auth->is_admin()) {

	                                                $dataAction['delete'] = array(
														'class' => 'delete_action',
														'href' => site_url('models/delete').'/'.base64_encode($file['path']),
														'target' => '',
														'title' => '',
														'data-original-title' => '',
														'data-target' => array(
															'target' => '',
															'control' => 'models',
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