<div class="grid_12">

	<div class="module">

		<h2 class="text-primary"><span><?php echo lang('Region_list'); ?></span></h2>

		<div class="module-body">

            <form action="javascript:void(0);">

    			<div class="grid_12 grid">

    				<table id="myTable" class="tablesorter table table-striped table-hover">

                        <thead>

                            <tr>

                                <th style="width:5%" class="text-center">

                                	<input type="checkbox" class="action uniform toggle-selected"/>

                                </th>

                                <th style="width:21%">Language display</th>

                                <th style="width:13%">Folder name</th>

                                <th style="width:15%">Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php 
                            	if (count(@$languages) > 0) {

                            		foreach ($languages as $key => $lang) {

                            ?>

                                        <tr data-target="<?php echo base64_encode($lang['id']); ?>">

                                            <td class="align-center">

                                            	<input type="checkbox" class="action uniform" />

                                            </td>

                                            <td><?php echo $lang['lang_display']; ?></td>

                                            <td><?php echo $lang['lang_folder']; ?></td>

                                            <td>

                                                <?php

                                                    if ((isset($lang['allow_delete']) && $lang['allow_delete']) || $this->ion_auth->is_admin()) {

                                                        $dataAction['delete'] = array(
                                                            'class' => 'delete_action',
                                                            'href' => site_url('languages/delete_region').'/'.base64_encode($lang['id']),
                                                            'target' => '',
                                                            'title' => '',
                                                            'data-original-title' => '',
                                                            'data-target' => array(
                                                                'target' => '',
                                                                'control' => 'languages',
                                                                'file' => base64_encode($lang['id'])
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

            </form>

            <?php echo $this->load->common("table/pagination"); ?>

            <?php echo $this->load->common("table/table-apply"); ?>

		</div>

	</div>

</div>