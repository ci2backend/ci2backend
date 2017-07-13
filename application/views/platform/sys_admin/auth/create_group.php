<div class="grid_12">

    <div class="module">

        <h2 class="text-primary"><span><?php echo lang('create_group_heading');?></span></h2>
        
        <div class="module-body">

        	<div class="panel-padding grid_4 grid full-with">

				<?php echo form_ajax('auth/create_group');?>

					<div class="grid_12">

						<span class="notification n-attention grid_12 small">

							<?php echo lang('create_group_subheading');?>

						</span>

				      	<div class="grid_12 grid">
				      		
					        <?php echo lang('create_group_name_label', 'group_name');?> <br />

					        <?php echo form_input($group_name);?>

					    </div>

					    <div class="grid_12 grid">

					        <?php echo lang('create_group_desc_label', 'description');?> <br />

					        <?php echo form_input($description);?>

					    </div>

				      	<div class="grid_12 grid">
				      	
				      		<?php echo form_submit('submit', lang('create_group_submit_btn'), 'class="submit-green uniform"');?>

				      	</div>

					</div>

				<?php echo form_close();?>

			</div>

			<div class="panel-padding grid_8 grid full-with">

				<legend><?php echo lang('List_group') ?></legend>

				<form action="javascript:void(0);">

	                <div class="grid_12 grid">

	                    <div class="table-responsive">

	                        <table id="myTable" class="table table-striped table-hover">

	                            <thead>

	                                <tr>

	                                    <th style="width:5%" class="text-center">

	                                        <input type="checkbox" class="action uniform toggle-selected" />

	                                    </th>

	                                    <th style="width:20%" class="text-center"><?php echo lang('Group_name') ?></th>

	                                    <th style="width:21%" class="text-center"><?php echo lang('Group_description'); ?></th>

	                                    <th style="width:15%" class="text-center">
	                                        
	                                        <?php echo lang('table_option'); ?>

	                                    </th>

	                                </tr>

	                            </thead>

	                            <tbody class="tablesorter">

	                                <?php

	                                    if (count(@$groups) > 0) {

	                                        foreach ($groups as $key => $group) {

	                                ?>

	                                <tr data-target="<?php echo $group['id'] ?>">

	                                    <td class="align-center">

	                                        <input type="checkbox" class="action uniform" />

	                                    </td>

	                                    <td><?php echo @$group['name']; ?></td>

	                                    <td><?php echo @$group['id']; ?></td>

	                                    <td>

	                                        <?php

	                                            $dataAction = array(
	                                                'update' => array(
	                                                    'class' => 'update_action',
	                                                    'href' => site_url('auth/edit_group').'/'.$group['id'],
	                                                    'target' => '',
	                                                    'title' => '',
	                                                    'data-original-title' => '',
	                                                    'data-target' => '',
	                                                    'data-toggle' => '',
	                                                    'style' => 'display: inline-block;',
	                                                )
	                                            );

	                                            if ((isset($group['allow_delete']) && $group['allow_delete']) || $this->ion_auth->is_admin()) {

	                                                $dataAction['delete'] = array(
	                                                    'class' => 'delete_action',
	                                                    'href' => site_url('auth/delete_group').'/'.$group['id'],
	                                                    'target' => '',
	                                                    'title' => '',
	                                                    'data-original-title' => '',
	                                                    'data-target' => array(
	                                                        'target' => '',
	                                                        'control' => 'auth',
	                                                        'file' => $group['id']
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

			</div>

		</div>

	</div>

</div>