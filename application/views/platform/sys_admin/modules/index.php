<div class="grid_12">

	<div class="module">

		<h2 class="text-primary"><span>Dashboard Menu</span></h2>

		<div class="module-body">

			<form class="form" role="form">

                <div class="grid_12 col-lg-12">

                    <div class="table-responsive">
			
        				<table id="myTable" class="tablesorter table table-striped table-hover">

                            <thead>

                                <tr>

                                    <th style="width:5%">#</th>

                                    <th style="width:20%">Title</th>

                                    <th style="width:21%">Link</th>

                                    <th style="width:13%">Icon</th>

                                    <th style="width:15%">Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php 
                                	if (count(@$menus) > 0) {

                                		foreach ($menus as $key => $menu) {

                                ?>

                                <tr data-target="">

                                    <td class="align-center"><?php echo @$key + 1; ?></td>

                                    <td><a target="_blank" href="<?php echo site_url('dev/edit_view'); ?>"><?php echo @$menu['title_key']; ?></a></td>

                                    <td><?php echo @$menu['action']; ?></td>

                                    <td><img width="32" src="<?php echo base_url(TEMPLATE_PATH.$template.SLASH.'img/'.@$menu['icon']); ?>" alt="<?php echo @$menu['description']; ?>"></td>

                                    <td>

                                        <input type="checkbox" class="action uniform"/>

                                        <a style="display: inline-block" class="delete_action" data-target='{"target":"_self","control":"views", "file":""}' data-toggle="confirmation" data-original-title="" title="">

                                        	<img src="<?php echo base_url(TEMPLATE_PATH.@$template);?>/img/cross-on-white.gif" alt="published">

                                        </a>

                                        <a target="_blank" href="<?php echo site_url('dev/edit_view');?>">

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

			</form>

		</div>

	</div>

</div>