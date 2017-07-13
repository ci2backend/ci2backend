<div class="row grid">

    <div class="grid_12">

        <div class="module">

             <h2 class="text-primary"><span><?php echo lang('Manage_user'); ?></span></h2>
                
             <div class="module-body">

                <form action="javascript:void(0);">

                    <div class="grid_12">

                        <div class="table-responsive">

                            <table id="myTable" class="tablesorter table table-striped table-hover">

                                <thead>

                                    <tr>

                                        <th style="width:5%" class="force-text-center">

                                            <input type="checkbox" class="action uniform toggle-selected" />

                                        </th>

                                        <th style="width:20%" class="force-text-center"><?php echo lang('Full_name'); ?></th>

                                        <th style="width:21%" class="force-text-center"><?php echo lang('Role'); ?></th>

                                        <th style="width:13%" class="force-text-center"><?php echo lang('Create_date'); ?></th>

                                        <th style="width:13%" class="force-text-center"><?php echo lang('Create_by'); ?></th>

                                        <th style="width:13%" class="force-text-center"><?php echo lang('Actively'); ?></th>

                                        <th style="width:15%" class="force-text-center"><?php echo lang('table_option'); ?></th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php 
                                    	if (count(@$user_sys) > 0) {

                                    		foreach ($user_sys as $key => $user) {
                                    ?>

                                    <tr>

                                        <td class="align-center">

                                            <input type="checkbox" class="action uniform" />

                                        </td>

                                        <td><a target="_blank" href="javascript:void(0);"><?php echo $user['first_name'].' '.$user['last_name']; ?></a></td>

                                        <td><?php foreach ($user['groups'] as $group):?>

                                            <?php echo anchor("auth/edit_group/".$group['id'], htmlspecialchars($group['name'], ENT_QUOTES,'UTF-8')) ;?><br />

                                        <?php endforeach?></td>

                                        <td><?php echo date('H:i:s d-m-Y', $user['created_on']); ?></td>

                                        <td><?php echo @$user['CREATED_BY']; ?></td>

                                        <td>
                                            <?php if ($user['active'] == 0): ?>
                                                <a href="<?php echo base_url('auth/activate').'/'.$user['id'].'/'.$user['activation_code'];?>">
                                                    Active
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo base_url('auth/deactivate').'/'.$user['id'];?>">
                                                    Deactive
                                                </a>
                                            <?php endif ?>
                                        </td>

                                        <td>

                                            <?php

                                                $dataAction = array(
                                                    'update' => array(
                                                        'class' => 'update_action',
                                                        'href' => base_url('auth/edit_user').'/'.$user['id'],
                                                        'target' => '',
                                                        'title' => '',
                                                        'data-original-title' => '',
                                                        'data-target' => '',
                                                        'data-toggle' => '',
                                                        'style' => 'display: inline-block;',
                                                    )
                                                );

                                                if ((isset($file['allow_delete']) && $file['allow_delete']) || $this->ion_auth->is_admin()) {

                                                    $dataAction['delete'] = array(
                                                        'class' => 'delete_action confirmation delete_user',
                                                        'href' => base_url('users/delete/'.base64_encode($user['id'])),
                                                        'target' => '',
                                                        'title' => '',
                                                        'data-original-title' => '',
                                                        'data-target' => array(
                                                            'target' => '',
                                                            'control' => 'users',
                                                            'file' => base64_encode($user['id'])
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
                 
             </div> <!-- End .module-body -->

        </div> <!-- End .module -->

    </div>
</div>