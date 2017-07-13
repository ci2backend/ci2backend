<div class="modal fade" id="modal-import_extension">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?php echo lang('Import_an_extension'); ?></h4>
			</div>
			<div class="modal-body grid_12 full-width inline-block">
				<div class="grid_12 grid" id="dropzone-extension">
					<form action="/file-upload" class="dropzone">
					  <div class="fallback">
					    <input name="file" type="file"/>
					  </div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>

<div class="module">

	<h2 class="text-primary"><span><?php echo lang('Extensions') ?></span></h2>

	<div class="module-body">

        <div class="module-table-body-no-background">

        	<div role="tabpanel" class="grid">
        		<!-- Nav tabs -->
        		<ul class="nav nav-tabs" role="tablist">
        			
        			<li role="presentation" class="<?php echo @$local_extension; ?>">
        				
        				<a data-target="#local_extension" aria-controls="local_extension" role="tab" data-toggle="tab">Local extension</a>
        			
        			</li>

        			<li role="presentation" class="<?php echo @$new_extension; ?>">
        				
        				<a data-target="#new_extension" aria-controls="new_extension" role="tab" data-toggle="tab"><?php echo lang('Create_new'); ?> extension</a>
        			
        			</li>

        		</ul>
        	
        		<!-- Tab panes -->
        		<div class="tab-content">

        			<div role="tabpanel" class="tab-pane <?php echo @$local_extension ?>" id="local_extension">

        				<form action="javascript:void(0);">

		                	<div class="grid_12 col-lg-12 grid">

								<div class="table-responsive">

									<div class="grid_8 grid">

										<a class="button pull-left" type="button" data-toggle="modal" href="#modal-import_extension" id="">

		                                    <span>

		                                    	<?php echo lang('Import_an_extension'); ?>

		                                    	<img src="<?php echo $this->load->assets('img/plus-small.gif'); ?>" width="12" height="9" alt="">

		                                    </span>

		                                </a>

									</div>

					                <table id="myTable" class="tablesorter table table-striped table-hover">

					                    <thead>

					                        <tr>

					                            <th style="width:5%" class="text-center" data-sorter="false">

					                            	<input type="checkbox" class="action uniform toggle-selected"/>

					                            </th>

					                            <th style="width:20%" class="text-center"><?php echo lang('Extension_name'); ?></th>

					                            <th style="width:21%" class="text-center"><?php echo lang('Create_date') ?></th>

					                            <th style="width:15%" class="text-center" data-sorter="false"><?php echo lang('table_option'); ?></th>

					                        </tr>

					                    </thead>

					                    <tbody>

					                        <?php

					                        	if (count(@$extensions) > 0) {

					                        		foreach ($extensions as $key => $extension) {

					                        			
					                        ?>

								                        <tr data-target="<?php echo @substr($extension['module'], 1, strlen($extension['module'])).'/'.@$extension['file'];; ?>">

								                            <td class="align-center">

								                            	<input type="checkbox" class="action uniform"/>

								                            </td>

								                            <td><a href="<?php echo site_url('extensions/detail').'/'.$extension['extension_key']; ?>" title="<?php echo @$extension['description']; ?>"><?php echo @$extension['extension_name']; ?></a></td>

								                            <td><?php echo @$extension['create_date']; ?></td>

								                            <td>

								                                <?php

							                            		$id = $extension['id'];

														    	$dataAction = array(
														    		'update' => array(
																		'class' => 'update_action',
																		'href' => site_url('extensions/edit').'/'.$extension['id'],
																		'target' => '',
																		'title' => '',
																		'data-original-title' => '',
																		'data-target' => '',
																		'data-toggle' => '',
																		'style' => 'display: inline-block;',
																		'data-update' => $id
																	)
																);

																if ($extension['allow_delete'] == 1) {

																	$dataAction['delete'] = array(
																		'class' => 'delete_action',
																		'href' => 'javascript:void(0);',
																		'target' => '',
																		'title' => '',
																		'data-original-title' => '',
																		'data-target' => array(
																			'target' => $id,
																			'control' => 'extensions',
																			'file' => $id
																		),
																		'data-toggle' => 'confirmation',
																		'style' => 'display: inline-block;'
																	);

																}

																$dataAction['export'] = array(
																	'class' => 'export',
																	'href' => 'javascript:void(0);',
																	'target' => '_blank',
																	'title' => '',
																	'data-original-title' => '',
																	'data-target' => array(
																		'target' => '',
																		'control' => 'extensions',
																		'action' => 'download',
																		'extension_key' => $extension['extension_key']
																	),
																	'style' => 'display: inline-block;'
																);

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

        			</div>

        			<div role="tabpanel" class="tab-pane <?php echo @$new_extension ?>" id="new_extension">

        				<div class="grid_12 grid">

            				<?php echo form_ajax('extensions/create', 'id="createExtension"'); ?>

            				<input type="hidden" name="callback_function" value="generate_folder">
							    
							    <div class="grid_5 grid">

							    	<div class="form-group grid">

								      	<label for="inputExtensionName" class="grid_4"><?php echo lang('Extension_name'); ?></label>
								      	
								      	<div class="grid_8">

								          <input type="text" class="form-control" name="extension_name" id="inputExtensionName" placeholder="<?php echo placeholder('Extension_name'); ?>">
								          	
								          	<span class="help-block">

										        <?php echo lang('Use_to_searching_extension'); ?>

										    </span>

								      	</div>

								    </div>

								    <div class="form-group grid">

								      	<label for="inputExtensionKey" class="grid_4"><?php echo lang('Extension_key'); ?></label>
								      	
								      	<div class="grid_8">
								          	
								          	<input type="text" class="form-control" name="extension_key"  id="inputExtensionKey" placeholder="<?php echo placeholder('Extension_key'); ?>">
								          	
								          	<span class="help-block">
										        
										        <?php echo lang('Use_to_create_folder_name'); ?>

										    </span>

								      	</div>

								    </div>

								    <div class="form-group grid">

								      	<label for="inputDescription" class="grid_4"><?php echo lang('Description') ?></label>
								      	
								      	<div class="grid_8">
								          	
								          	<textarea name="description" id="inputDescription"  class="form-control" rows="3" maxlength="300"></textarea>
								          	
								          	<span class="help-block">

									        	<?php echo sprintf(lang('No_more_than_s_words'), 300); ?>

									      	</span>

								      </div>

								    </div>

								    <div class="form-group grid">

									    <div class="grid_12">

									    	<input type="submit" class="submit-green pull-right" name="" value="<?php echo lang('Create'); ?>">
									    
									    </div>
								    
								    </div>

							    </div>

							    <div class="grid_7 border">

							    	<div id="elfinder_extension">
							    		
							    		<p class="text-center"><?php echo lang('Folder_will_generate_when_create_extension'); ?></p>
									
									</div>

							    </div>

							<?php echo form_close(); ?>

        				</div>

        			</div>

        		</div>

        	</div>

            <div style="clear: both"></div>

        </div> <!-- End .module-table-body -->

	</div>

</div>