<div class="grid_12">

	<div class="module">

		<h2 class="text-primary"><span>Menu</span></h2>

		<div class="module-body">
            <div class="grid_12 col-lg-12">

                <div class="table-responsive">

        			<table id="myTable" class="tablesorter table table-striped table-hover">

                        <thead>

                            <tr>

                                <th style="width:5%" class="force-text-center">

                                    <input type="checkbox" class="action uniform toggle-selected" />

                                </th>

                                <th style="width:20%" class="force-text-center">Title key</th>

                                <th style="width:21%" class="force-text-center">Title</th>

                                <th style="width:13%" class="force-text-center">Router</th>

                                <th style="width:13%" class="force-text-center">Icon</th>

                                <th style="width:13%" class="force-text-center">Description</th>

                                <th style="width:13%" class="force-text-center"><?php echo lang('table_option'); ?></th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            	if (count(@$menus) > 0) {

                            		foreach ($menus as $key => $menu) {
                            ?>

        			                    <tr>

        			                        <td class="align-center">

                                                <input type="checkbox" class="action uniform" />

                                            </td>

        			                        <td><?php echo $menu['title_key']; ?></td>

        			                        <td><?php echo $this->lang->line($menu['title_key']) ?></td>

        			                        <td><?php echo @$menu['action_router']; ?></td>

        			                        <td><?php echo @$menu['icon']; ?></td>

        			                        <td><?php echo @$menu['description']; ?></td>

        			                        <td>

        			                            <a class="delete_user confirmation" data-id="<?php echo $menu['id']; ?>" href="<?php echo my_base_url('auth/delete_user/'.$menu['id']);?>">

        			                            	<img src="<?php echo base_url(TEMPLATE_PATH.@$template);?>/img/cross-on-white.gif" width="16" height="16" alt="published" />

        			                            </a>

        			                            <a href="<?php echo my_base_url('menu/edit').'/'.$menu['id'];?>">

        			                            	<img src="<?php echo base_url(TEMPLATE_PATH.@$template);?>/img/pencil.gif" width="16" height="16" alt="edit" />

        			                            </a>

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

            <?php echo $this->load->common("table/pagination"); ?>

            <?php echo $this->load->common("table/table-apply"); ?>

		</div>

	</div>

</div>