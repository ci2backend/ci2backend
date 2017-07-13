<div class="grid_12 grid panel-padding">

	<legend>

		<?php echo lang('Constant_defined'); ?>

	</legend>

	<div class="grid_8 grid text-left">
		
		<a class="button pull-left" type="button" id="btn_create_constant" href="#">

            <span>

            	<?php echo lang('Create_new'); ?>

            	<img src="<?php echo $this->load->assets('img/plus-small.gif'); ?>" width="12" height="9" alt="">

            </span>

        </a>

	</div>

	<form action="<?php echo site_url('dev/form_ajax'); ?>" method="POST" role="form" class="ajax validate">
		
		<div class="grid_12 grid">

			<table id="myTable" class="tablesorter table table-striped table-hover">

	            <thead>

	                <tr>

	                	<th style="width:5%" class="text-center">

	                    	<input type="checkbox" value="" class="action uniform toggle-selected"/>

	                    </th>

	                    <th class="col-md-5"><?php echo lang('Constant'); ?></th>

	                    <th class="col-md-5"><?php echo lang('Value'); ?></th>

	                    <th class="col-md-2"></th>

	                </tr>

	            </thead>

	            <tbody>

	                <?php

	                if (isset($list_constant) && count($list_constant) > 0) {
	                	
	                	foreach ($list_constant as $keyConstant => $valueConstant) {

	                		echo $this->load->common("setting/item_constant", true, $valueConstant);

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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_contant_define">

	<div class="modal-dialog" role="document">

	    <div class="modal-content">

	    	<?php echo form_ajax('my_constants/create'); ?>

				<div class="modal-header">

			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

			        <h4 class="modal-title"><?php echo lang('Constant_defined'); ?></h4>
	      		
	      		</div>
	      		
	      		<div class="modal-body">

					<input type="hidden" name="constant_id" value="">
			        
			        <div class="form-group">
					
						<label for="input_constant"><?php echo lang('Constant'); ?></label>
					
						<input type="text" class="input-long uniform" id="input_constant" placeholder="<?php echo placeholder('Constant'); ?>" name="constant" value="<?php echo set_value('constant'); ?>">
					
					</div>
					
					<div class="form-group">
						
						<label for="input_value"><?php echo lang('Value'); ?></label>
						
						<input type="text" class="input-long uniform" id="input_value" placeholder="<?php echo placeholder('Value'); ?>" name="value" value="<?php echo set_value('value'); ?>">
					
					</div>
	      		
	      		</div>
	      		
	      		<div class="modal-footer">
			        
			        <input type="submit" class="submit-gray" data-dismiss="modal" name="" value="<?php echo lang('Close'); ?>">
			        
			        <input type="submit" class="submit-green" name="" value="<?php echo lang('save'); ?>">
	      		
	      		</div>

			<?php echo form_close(); ?>

	    </div><!-- /.modal-content -->

	</div><!-- /.modal-dialog -->

</div><!-- /.modal -->