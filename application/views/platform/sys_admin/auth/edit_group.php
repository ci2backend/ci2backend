<div class="grid_12">

    <div class="module">

        <h2 class="text-primary"><span><?php echo lang('edit_group_heading');?></span></h2>
        
        <div class="module-body">

			<?php echo form_open(current_url(), 'class="ajax validate"');?>

				<div class="grid_12 col-lg-12">

					<div class="table-responsive">

						<p><?php echo lang('edit_group_subheading');?></p>

						<div id="infoMessage"><?php echo $message;?></div>

				      	<p>

				            <?php echo lang('edit_group_name_label', 'group_name');?> <br />

				            <?php echo form_input($group_name);?>

				      	</p>

				      	<p>

				            <?php echo lang('edit_group_desc_label', 'description');?> <br />

				            <?php echo form_input($group_description);?>
				            
				      	</p>

				      	<p><?php echo form_submit('submit', lang('edit_group_submit_btn'), 'class="submit-green uniform"');?></p>

				     </div>

				</div>

			<?php echo form_close();?>

		</div>

	</div>

</div>