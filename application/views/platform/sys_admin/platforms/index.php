<div class="grid_12">

    <div class="module">

        <h2 class="text-primary"><span><?php echo lang('Platforms') ?></span></h2>
            
        <div class="module-body">

            <div class="module-table-body-no-background">

                <form action="javascript:void(0);">

                	<div class="grid_12">

	                	<span class="notification n-attention"><?php echo lang('Platform_key_detected_by_Detect_class_in_the_folder_application_libraries_Please_dont_change_it'); ?></span>

	                </div>

                	<div class="grid_12">

						<div class="table-responsive">

			                <table id="myTable" class="tablesorter table table-striped table-hover">

			                    <thead>

			                        <tr>

			                            <!-- <th style="width:20%" class="text-center"><?php echo lang('Platform_key'); ?></th> -->

			                            <th style="width:20%" class="text-center"><?php echo lang('Platform_name') ?></th>

			                            <th style="width:45%" class="text-left"><?php echo lang('Description') ?></th>

			                            <th style="width:15%" class="text-center"><?php echo lang('table_option'); ?></th>

			                        </tr>

			                    </thead>

			                    <tbody>

			                        <?php

			                        	if (count(@$platforms) > 0) {

			                        		foreach ($platforms as $key => $platform) {

			                        ?>

						                        <tr data-target="<?php echo @$platform['id']; ?>">

						                            <!-- <td><a target="_blank" href="#"><?php echo @$platform['platform_key']; ?></a></td> -->

						                            <td><?php echo @$platform['platform_name']; ?></td>

						                            <td><?php echo @$platform['description']; ?></td>

						                            <td>

						                                <div class="radio">
						                                	
						                                	<label>
						                                		
						                                		<input type="radio" name="is_default" class="uniform" id="input" value="<?php echo @$platform['platform_key']; ?>" <?php if ($platform['is_default']) {
							                                		echo ' checked="checked"';
							                                	} ?>>
							                                	
						                                	</label>
						                                	
						                                </div>

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